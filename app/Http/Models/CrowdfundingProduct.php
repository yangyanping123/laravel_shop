<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CrowdfundingProduct extends Model
{


    protected $fillable = ['total_amount', 'target_amount', 'user_count', 'status', 'end_at','type'];
    // end_at 会自动转为 Carbon 类型
    protected $dates = ['end_at'];
    // 不需要 created_at 和 updated_at 字段
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 定义一个名为 percent 的访问器，返回当前众筹进度
    public function getPercentAttribute()
    {
        // 已筹金额除以目标金额
        $value = $this->attributes['total_amount'] / $this->attributes['target_amount'];

        return floatval(number_format($value * 100, 2, '.', ''));
    }
}
