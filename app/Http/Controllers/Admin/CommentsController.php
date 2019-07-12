<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CommentsController extends Controller{
    /**
     * 资讯列表页面
     */
    public function commentShow(){
        return view('admin/comments/cimmentshow');
    }
    /**
     *
     */
    public function feedbackList(){
        return view('admin/comments/feedbacklist');
    }
}