<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class control extends Model
{
    //删除节点
    public function permissiondelDel($id){
        $sel = DB::table('permissions')->where('pid',$id)->first();
        //查询有没有子权限
        if ($sel){
            return 201;
        }else{
            //删除成功
            $del = DB::table('permissions')->where('id',$id)->delete();
            DB::table('pr')->where('per_id',$id)->delete();
            return $del;
        }
    }
    //查询权限
    public function control($user_id){
        //查询出此用户有什么权限
        $per_id = DB::table('ur')
            ->where(['ur_id'=>$user_id])
            ->join('pr','ur.ro_id','pr.role_id')
            ->select('per_id')
            ->get()
            ->toArray();
        //把对象设置成数组
        $permiss = [];
        foreach ($per_id as $v){
            $permiss[] = $v->per_id;
        }
        //查询出对应的管理
        $data = DB::table('permissions')->whereIn('id',$permiss)->select()->get()->toArray();
        $recursion = $this->recursion($data);
        return $recursion;
    }
    //查询用户有什么角色
    public function role($user_id){
        //查询用户有什么角色
        $role = DB::table('ur')
            ->where(['ur_id'=>$user_id])
            ->join('role','ur.ro_id','role.role_id')
            ->first('role_name');
        return $role;
    }
    //查询管理员的个人资料
    public function personal($user_id){
        $personal = DB::table('users')->where(['id'=>$user_id])->first(['name','tel','e_mail','age','sex','city']);
        return $personal;
    }
    //查询管理表递归返回
    public function permission($permissions_name){
        if (empty($permissions_name)){
            $pqct = DB::table('permissions')->select()->get();
        }else{
            $pqct = DB::table('permissions')->where('permissions_name',$permissions_name)->select()->get();
        }
        return $this->recursion($pqct);
    }
    //查询管理表递归返回
    public function pqctAdd(){
        $pqct = DB::table('permissions')->select()->get();
        return $this->recursion($pqct);
    }
    //查询管理表非递归返回
    public function pqct(){
        $pqct = DB::table('permissions')->select(['id','permissions_name','pid'])->get();
        $data = json_decode($pqct,true);
        return $data;
    }
    /**
     * @param $data  数据
     * @param int $pid  父级id
     * @param int $live  几级权限
     * 数组递归方法
     */
    public function arr_recursion($data,$pid=0){
        //定义一个数组变量
        $arr = [];
        //循环数据
        foreach($data as $k=>$v){
            //判断为几级
            if($v['pid'] == $pid){
                $arr[$k] = $v;
                $arr[$k]['sone'] = $this->arr_recursion($data,$v['id']);
            }
        }
        return $arr;
    }
    /**
     * @param $data  数据
     * @param int $pid  父级id
     * @param int $live  几级权限
     * 对象递归方法
     */
    public function recursion($data,$pid=0){
        //定义一个数组
        $arr = [];
        //循环数据
        foreach($data as $k=>$v){
            //判断为几级
            if($v->pid == $pid){
                $arr[$k] = $v;
                $arr[$k]->sone = $this->recursion($data,$v->id);
            }
        }
        return $arr;
    }
}