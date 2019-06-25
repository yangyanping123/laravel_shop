<?php

namespace App\Http\Controllers\Api;

use App\Http\Models\Admin;
use App\Http\Requests\Api\AdminRequest;
use App\Http\Resources\Api\AdminResource;
use App\Jobs\Api\SaveLastTokenJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AdminController extends ApiController
{
    public function index(){
        //3/0;
        $users = Admin::paginate(3);
        //return $this->success($users); //直接返回
        return AdminResource::collection($users); //以资源的形式返回

    }

    //返回单一用户
    public function show(Admin $user){
        // 3/0;
        //return $this->success($user); //直接返回
        return $this->success(new AdminResource($user));//以资源的形式返回
    }

    //用户注册
    public function store(AdminRequest $request){
        Admin::create($request->all());
        return  $this->setStatusCode(200)->success("用户注册成功");
    }
//用户登录
    public function login(Request $request){
        //获取当前守护的名称
        $present_guard =Auth::getDefaultDriver();
        $token=Auth::claims(['guard'=>$present_guard])->attempt(['name'=>$request->name,'password'=>$request->password]);
        if($token) {
            $user = Auth::user();
            if ($user->last_token) {
                try{
                    Auth::setToken($user->last_token)->invalidate();
                }catch (TokenExpiredException $e){
                    //因为让一个过期的token再失效，会抛出异常，所以我们捕捉异常，不需要做任何处理
                }
            }
            SaveLastTokenJob::dispatch($user,$token);
            return $this->setStatusCode(201)->success(['token' => 'bearer ' . $token]);
        }
        return $this->failed('账号或密码错误',400);
    }

    public function logout(){
        Auth::logout();
        return $this->success('退出成功...');
    }
    //返回当前登录用户信息
    public function info(){
        $user = Auth::user();
        return $this->success(new AdminResource($user));
    }
}
