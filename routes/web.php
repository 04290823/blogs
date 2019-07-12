<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//前台页面
Route::group(['namespace'=>'proscenium'],function (){
    Route::get('/','BlogController@home')->name('home');
});
//后台登录
Route::get('admin','Admin\AdminController@admin');
/**
 * 后台控制
 */
Route::group(['namespace'=>'admin'],function (){
    //主页
    Route::get('welcome',function (){
        return view('admin/welcome');
    });
    //登录提交
    Route::post('login','AdminController@login');
    //后台管理页面
    Route::get('show','IndexController@show')->name('show')->middleware('token');
    Route::get('skip','AdminController@skip')->name('skip');
    //退出
    Route::get('exit','AdminController@quit')->name('quit');
    //资讯管理
    Route::group(['namepace'=>'article'],function (){
        Route::get('articleshow','ArticleController@articleShow')->name('articleShow');
        Route::get('articleadd','ArticleController@articleAdd')->name('articleAdd');
    });
    //图片管理
    Route::group(['namepace'=>'picture'],function (){
        Route::get('imageshow','PictureController@imageShow')->name('imageShow');
    });
    //评论管理
    Route::group(['namepace'=>'comments'],function (){
        Route::get('commentshow','CommentsController@commentShow')->name('commentShow');
        Route::get('feedbacklist','CommentsController@feedbackList')->name('feedbackList');
    });
    //管理员管理
    Route::group(['namepace'=>'administrator'],function (){
        //角色管理
        Route::get('role','AdministratorController@role')->name('role');
        Route::get('roleadd','AdministratorController@roleAdd')->name('roleAdd');
        Route::post('roleinser','AdministratorController@roleInser')->name('roleInser');
        Route::get('rolesave','AdministratorController@roleSave')->name('roleSave');
        Route::post('roleupdate','AdministratorController@roleUpdate')->name('roleUpdate');
        Route::get('roledel','AdministratorController@roleDel')->name('roleDel');
        //管理员列表
        Route::get('adminlist','AdministratorController@adminList')->name('adminList');
        Route::get('adminadd','AdministratorController@adminAdd')->name('adminAdd');
        Route::post('adminins','AdministratorController@adminIns')->name('adminIns');
        Route::get('adminsave','AdministratorController@adminSave')->name('adminSave');
        Route::post('adminupd','AdministratorController@adminUpd')->name('adminUpd');
        Route::get('admindel','AdministratorController@adminDel')->name('adminDel');
        Route::get('pole','AdministratorController@pole')->name('pole');
        Route::get('permission','AdministratorController@permission')->name('permission');
        Route::get('permissiondel','AdministratorController@permissionDel')->name('permissionDel');
    });
});

//404报错页面
Route::get('404', function () {
    return view('404');
});