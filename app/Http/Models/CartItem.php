<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['amount'];
    public $timestamps = false;


    //购物车属于哪个用户
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //购物车中的商品
    public function productSku()
    {
        return $this->belongsTo(ProductSku::class);
    }
}
