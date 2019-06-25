<?php

use App\Http\Controllers\Controller;
use App\Http\Models\Wx_Users;
use Log;
class IndexController extends Controller
{
    public $app;

    public function __construct()
    {
        $this->app = app('wechat.official_account');
    }

    public function index()
    {
        $app = app('wechat.official_account');
        $app->server->push(function ($message) {
            switch ($message['MsgType']) {
                case 'event':
                    return $this->receiveEvent($message);
                    break;
                case 'text':
                    return '收到文字消息';
                    break;
                case 'image':
                case 'voice':
                case 'video':
                case 'location':
                case 'link':
                case 'file':
                default:
                    return '收到其它消息';
                    break;
            }
        });
        return $app->server->serve();
    }


    /**
     * 关注和取消关注 数据落地
     * @param $obj
     * @return string
     */
    private function receiveEvent($obj)
    {
        $wx_users = new Wx_Users();
        switch ($obj['Event']) {
            case  'subscribe': //关注 写表
                $content = "欢迎关注我的测试账号！";
                $openid = $obj['FromUserName'];
                //判断是不是带参数的二维码
                if (empty($obj['EventKey'])) {
                    $groupid = str_replace("qrscene_", "", $obj['EventKey']);
                } else {
                    $groupid = 0;
                }
                Log::info("subscribe user is:" . $openid);
                $user = $this->app->user->get($openid);
                $count = $wx_users->where('openid', $user['openid'])->count();
                if ($count > 0) {
                    $data = [
                        'subscribe' => 1,
                        'updated_at' => date('Y-m-d H:i:s', time()),
                        'subscribe_time' => $user['subscribe_time'],
                    ];
                    $result = $wx_users->where('openid', $user['openid'])->update($data);
                } else {
                    Log::info(json_encode($user));
                    $data = [
                        'openid' => $user['openid'],
                        'nickname' => $user['nickname'],
                        'subscribe' => $user['subscribe'],
                        'sex' => $user['sex'],
                        'language' => $user['language'],
                        'city' => !empty($user['city']) ? $user['city'] : '0',
                        'province' => !empty($user['province']) ? $user['province'] : '0',
                        'country' => !empty($user['country']) ? $user['country'] : '0',
                        'headimgurl' => $user['headimgurl'],
                        'subscribe_time' => $user['subscribe_time'],
                        'remark' => !empty($user['remark']) ? $user['remark'] : "0",
                        'groupid' => $groupid,
                        'subscribe_scene' => $user['subscribe_scene'],
                        'qr_scene' => !empty($user['qr_scene']) ? $user['qr_scene'] : '0',
                        'qr_scene_str' => !empty($user['qr_scene_str']) ? $user['qr_scene_str'] : '0',
                        'tagid_list' => !empty($user['tagid_list']) ? $user['tagid_list'] : '0',
                        'created_at' => date('Y-m-d H:i:s', time()),
                        'updated_at' => date('Y-m-d H:i:s', time()),
                        'unionid' => !empty($user['unionid']) ? $user['unionid'] : '0'
                    ];

                    // Log::info(json_encode($data));
                    $result = $wx_users->insert($data);
                }
                return $content;
                break;
            case "unsubscribe": //取消关注 更新状态
                Log::info("unsubscribe User is:" . $obj['FromUserName']);
                $data = [
                    'subscribe' => 0,
                    'updated_at' => date('Y-m-d H:i:s', time()),

                ];
                $result = $wx_users->where('openid', $obj['FromUserName'])->update($data);
                $content = "取消关注";
                return $content;
                break;
        }
    }
}