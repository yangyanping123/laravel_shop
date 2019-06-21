<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class Wx_Menu extends  Model{

    use ModelTree, AdminBuilder;

    protected $table = 'wx_menu';
    protected $fillable = ['name', 'links','listorder','wx_type','wx_key','display'];

    public function getAll()
    {
        $data = $this->orderBy('id','desc')->select(['name','id'])->get();
        $selectOption = [];
        foreach ($data as $option){
            $selectOption[$option->id] = $option->name;
        }

        return $selectOption;
    }
}