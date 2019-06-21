<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\UserResource;
use Illuminate\Http\Request;
use App\Http\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Jobs\Api\SaveLastTokenJob;
class UserController extends ApiController
{
    //返回集合
    public function index(){
        //3/0;
        $users = User::paginate(3);
        //return $this->success($users); //直接返回
        return UserResource::collection($users); //以资源的形式返回

    }
    //返回单一用户
    public function show(User $user){
       // 3/0;
        //return $this->success($user); //直接返回
        return $this->success(new UserResource($user));//以资源的形式返回
    }

    //用户注册
    public function store(UserRequest $request){
         User::create($request->all());
        return  $this->setStatusCode(200)->success("用户注册成功");
    }
    //用户登录
    public function login(Request $request){
        $token=Auth::claims(['guard'=>'api'])->attempt(['name'=>$request->name,'password'=>$request->password]);
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

    //退出
    public function logout(){
        Auth::logout();
        return $this->success('退出成功...');
    }
    //返回当前登录用户信息
    public function info(){
        $user = Auth::user();
        return $this->success(new UserResource($user));
    }
}
