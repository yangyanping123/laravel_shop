<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\CostaNews;
use App\Jobs\Queue;
class RabbitController extends Controller
{
    public function index()
    {
        $data = CostaNews::get();
        foreach ($data as $item) {
            $this->dispatch(new Queue($item));
        }
        return response()->json(['code'=>0, 'msg'=>"success"]);
    }

}