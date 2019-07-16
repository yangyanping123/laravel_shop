<?php
namespace App\Http\Models\Enum;
class OrderEnum{
    const REFUND_STATUS_PENDING = 'pending';
    const REFUND_STATUS_APPLIED = 'applied';
    const REFUND_STATUS_PROCESSING = 'processing';
    const REFUND_STATUS_SUCCESS = 'success';
    const REFUND_STATUS_FAILED = 'failed';

    const SHIP_STATUS_PENDING = 'pending';
    const SHIP_STATUS_DELIVERED = 'delivered';
    const SHIP_STATUS_RECEIVED = 'received';

    const TYPE_NORMAL = 'normal';
    const TYPE_CROWDFUNDING = 'crowdfunding';
    const TYPE_SECKILL = 'seckill';
    public static $typeMap = [
        self::TYPE_NORMAL => '普通商品订单',
        self::TYPE_CROWDFUNDING => '众筹商品订单',
        self::TYPE_SECKILL => '秒杀商品订单',
    ];


    public static function getRefundStatusName($status){
        switch ($status){
            case self::REFUND_STATUS_PENDING:
                return '未退款';
            case self::REFUND_STATUS_APPLIED:
                return '已申请退款';
            case self::REFUND_STATUS_PROCESSING:
                return '退款中';
            case self::REFUND_STATUS_SUCCESS:
                return '退款成功';
            case self::REFUND_STATUS_FAILED:
                return '退款失败';
            default:
                return '未退款';
        }
    }

    public static function  getShipStatusName ($status)
    {
        switch ($status){
            case self::SHIP_STATUS_PENDING:
                return '未发货';
            case self::SHIP_STATUS_DELIVERED:
                return '已发货';
            case self::SHIP_STATUS_RECEIVED:
                return '已收货';
            default:
                return '未发货';
        }
    }
}