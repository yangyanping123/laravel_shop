<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Horizon\Horizon;
use App\Http\Models\Installment;
use App\Policies\InstallmentPolicy;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
           Installment::class => InstallmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // 使用 Gate::guessPolicyNamesUsing 方法来自定义策略文件的寻找逻辑
        Gate::guessPolicyNamesUsing(function ($class) {
            // class_basename 是 Laravel 提供的一个辅助函数，可以获取类的简短名称
            // 例如传入 \App\Models\User 会返回 User
            return '\\App\\Policies\\'.class_basename($class).'Policy';
        });

        Horizon::auth(function($request){
            if(env('APP_ENV','local') =='local'){
                return true;
            }else{
                $get_ip=$request->getClientIp();
                $can_ip=env('HORIZON_IP','192.168.0.125');
           return $get_ip == $can_ip;
       }
        });
    }
}
