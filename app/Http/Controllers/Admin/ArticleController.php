<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\textType;

class ArticleController extends Controller{
    /**
     * 资讯列表页面
     */
    public function articleShow(){
        return view('admin/article/articleshow');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 添加文章
     */
    public function articleAdd(){
        $text_type = new textType();
        $type_sel = $text_type->text_type();
        return view('admin/article/articleadd',['type'=>$type_sel]);
    }
}