<?php

namespace App\Http\Controllers;
use App\Events\OrderReviewed;
use App\Http\Models\Enum\OrderEnum;
use App\Http\Models\ProductSku;
use App\Http\Requests\CrowdFundingOrderRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Models\UserAddress;
use App\Http\Models\Order;
use App\Http\Requests\SendReviewRequest;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Exceptions\InvalidRequestException;
use App\Exceptions\CouponCodeUnavailableException;
use App\Http\Models\CouponCode;
use App\Http\Requests\ApplyRefundRequest;
use Carbon\Carbon;
class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()
            // 使用 with 方法预加载，避免N + 1问题
            ->with(['items.product', 'items.productSku'])
            ->where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('orders.index', ['orders' => $orders]);
    }

    public function show(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        return view('orders.show', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }
    /*public function store(OrderRequest $request)
    {*/
    public function store(OrderRequest $request, OrderService $orderService){

      //  dd($request);exit;
        $user  = $request->user();
        $address = UserAddress::find($request->input('address_id'));
        $coupon  = null;

        // 如果用户提交了优惠码
        if ($code = $request->input('coupon_code')) {
            $coupon = CouponCode::where('code', $code)->first();
            if (!$coupon) {
                throw new CouponCodeUnavailableException('优惠券不存在');
            }
        }
        // 参数中加入 $coupon 变量
        return $orderService->store($user, $address, $request->input('remark'), $request->input('items'), $coupon);
        /* // 开启一个数据库事务
         $order = \DB::transaction(function () use ($user, $request) {
             $address = UserAddress::find($request->input('address_id'));
             // 更新此地址的最后使用时间
             $address->update(['last_used_at' => Carbon::now()]);
             // 创建一个订单
             $order   = new Order([
                 'address'      => [ // 将地址信息放入订单中
                     'address'       => $address->full_address,
                     'zip'           => $address->zip,
                     'contact_name'  => $address->contact_name,
                     'contact_phone' => $address->contact_phone,
                 ],
                 'remark'       => $request->input('remark'),
                 'total_amount' => 0,
             ]);
             // 订单关联到当前用户
             $order->user()->associate($user);
             // 写入数据库
             $order->save();

             $totalAmount = 0;
             $items       = $request->input('items');
             // 遍历用户提交的 SKU
             foreach ($items as $data) {
                 $sku  = ProductSku::find($data['sku_id']);
                 // 创建一个 OrderItem 并直接与当前订单关联
                 $item = $order->items()->make([
                     'amount' => $data['amount'],
                     'price'  => $sku->price,
                 ]);
                 $totalAmount += $sku->price * $data['amount'];
                 if ($sku->decreaseStock($data['amount']) <= 0) {
                     throw new InvalidRequestException('该商品库存不足');
                 }
                 $item->product()->associate($sku->product_id);
                 $item->productSku()->associate($sku);
                 $item->save();
             }

             // 更新订单总金额
             $order->update(['total_amount' => $totalAmount]);

             // 将下单的商品从购物车中移除
             $skuIds = collect($items)->pluck('sku_id');
             $user->cartItems()->whereIn('product_sku_id', $skuIds)->delete();

             return $order;
         });
         dispatch(new CloseOrder($order, config('app.order_ttl')));
         return $order;*/
    }


    public function received(Order $order, Request $request)
    {
        $this->authorize('own', $order);
        // 判断订单的发货状态是否为已发货
        if ($order->ship_status !== OrderEnum::SHIP_STATUS_DELIVERED) {
            throw new InvalidRequestException('发货状态不正确');
        }

        // 更新发货状态为已收到
        $order->update(['ship_status' => OrderEnum::SHIP_STATUS_RECEIVED]);

        // 返回原页面
        return redirect()->back();
    }

    public function review(Order $order)
    {
        // 校验权限
        $this->authorize('own', $order);
        // 判断是否已经支付
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可评价');
        }
        // 使用 load 方法加载关联数据，避免 N + 1 性能问题
        return view('orders.review', ['order' => $order->load(['items.productSku', 'items.product'])]);
    }

    public function sendReview(Order $order, SendReviewRequest $request)
    {
        // 校验权限
        $this->authorize('own', $order);
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可评价');
        }
        // 判断是否已经评价
        if ($order->reviewed) {
            throw new InvalidRequestException('该订单已评价，不可重复提交');
        }
        $reviews = $request->input('reviews');
        // 开启事务
        \DB::transaction(function () use ($reviews, $order) {
            // 遍历用户提交的数据
            foreach ($reviews as $review) {
                $orderItem = $order->items()->find($review['id']);
                // 保存评分和评价
                $orderItem->update([
                    'rating'      => $review['rating'],
                    'review'      => $review['review'],
                    'reviewed_at' => Carbon::now(),
                ]);
            }
            // 将订单标记为已评价
            $order->update(['reviewed' => true]);
            event(new OrderReviewed($order));
        });

        return redirect()->back();
    }

    //提交退款申请
    public function applyRefund(Order $order, ApplyRefundRequest $request)
    {
        // 校验订单是否属于当前用户
        $this->authorize('own', $order);
        // 判断订单是否已付款
        if (!$order->paid_at) {
            throw new InvalidRequestException('该订单未支付，不可退款');
        }
        // 众筹订单不允许申请退款
        if ($order->type === OrderEnum::TYPE_CROWDFUNDING) {
            throw new InvalidRequestException('众筹订单不支持退款');
        }
        // 判断订单退款状态是否正确
        if ($order->refund_status !== OrderEnum::REFUND_STATUS_PENDING) {
            throw new InvalidRequestException('该订单已经申请过退款，请勿重复申请');
        }
        // 将用户输入的退款理由放到订单的 extra 字段中
        $extra                  = $order->extra ?: [];
        $extra['refund_reason'] = $request->input('reason');
        // 将订单退款状态改为已申请退款
        $order->update([
            'refund_status' => OrderEnum::REFUND_STATUS_APPLIED,
            'extra'         => $extra,
        ]);

        return $order;
    }

    // 创建一个新的方法用于接受众筹商品下单请求
    public function crowdfunding(CrowdFundingOrderRequest  $request, OrderService $orderService)
    {
        $user    = $request->user();
        $sku     = ProductSku::find($request->input('sku_id'));
        $address = UserAddress::find($request->input('address_id'));
        $amount  = $request->input('amount');

        return $orderService->crowdfunding($user, $address, $sku, $amount);
    }
}
