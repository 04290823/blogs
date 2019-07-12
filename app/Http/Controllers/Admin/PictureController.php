<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PictureController extends Controller{
    /**
     * 图片管理页面
     */
    public function imageShow(){
        return view('admin/picture/imageshow');
    }
}