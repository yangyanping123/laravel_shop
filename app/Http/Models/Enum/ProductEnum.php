<?php
namespace App\Http\Models\Enum;
class ProductEnum{

    const TYPE_NORMAL = 'normal';
    const TYPE_CROWDFUNDING = 'crowdfunding';
    public static $typeMap = [
        self::TYPE_NORMAL  => '普通商品',
        self::TYPE_CROWDFUNDING => '众筹商品',
    ];
}