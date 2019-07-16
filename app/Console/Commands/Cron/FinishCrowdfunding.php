<?php

namespace App\Console\Commands\Cron;
use App\Http\Models\CrowdfundingProduct;
use App\Http\Models\Enum\CrowdfundingProductEnum;
use App\Http\Models\Enum\OrderEnum;
use App\Http\Models\Order;
use App\Jobs\RefundCrowdfundingOrders;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class FinishCrowdfunding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:finish-crowdfunding';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '结束众筹';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        CrowdfundingProduct::query()
            // 众筹结束时间早于当前时间
            ->where('end_at', '<=', Carbon::now())
            // 众筹状态为众筹中
            ->where('status', CrowdfundingProductEnum::STATUS_FUNDING)
            ->get()
            ->each(function (CrowdfundingProduct $crowdfunding) {
                // 如果众筹目标金额大于实际众筹金额
                if ($crowdfunding->target_amount > $crowdfunding->total_amount) {
                    // 调用众筹失败逻辑
                    $this->crowdfundingFailed($crowdfunding);
                } else {
                    // 否则调用众筹成功逻辑
                    $this->crowdfundingSucceed($crowdfunding);
                }
            });
    }

    protected function crowdfundingSucceed(CrowdfundingProduct $crowdfunding)
    {
        // 只需将众筹状态改为众筹成功即可
        $crowdfunding->update([
            'status' => CrowdfundingProductEnum::STATUS_SUCCESS,
        ]);
    }

    protected function crowdfundingFailed(CrowdfundingProduct $crowdfunding)
    {
        // 将众筹状态改为众筹失败
        $crowdfunding->update([
            'status' => CrowdfundingProductEnum::STATUS_FAIL,
        ]);

        /*
        $orderService = app(OrderService::class);
        // 查询出所有参与了此众筹的订单
        Order::query()
            // 订单类型为众筹商品订单
            ->where('type', OrderEnum::TYPE_CROWDFUNDING)
            // 已支付的订单
            ->whereNotNull('paid_at')
            ->whereHas('items', function ($query) use ($crowdfunding) {
                // 包含了当前商品
                $query->where('product_id', $crowdfunding->product_id);
            })
            ->get()
            ->each(function (Order $order)  use($orderService){
                //结束定时任务的时候 调用退款逻辑
                $orderService->refundOrder($order);
            });

        */

        //把定时任务中的失败退款逻辑改为触发这个异步任务
        dispatch(new RefundCrowdfundingOrders($crowdfunding));
    }
}
