<?php

use Illuminate\Database\Seeder;
use App\Http\Models\CouponCode;
class CouponCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CouponCode::class, 20)->create();
    }
}
