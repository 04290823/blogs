<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class users extends Model
{
    protected $table = 'users';
    //极点技改
    public function pole($id){
        $sel = DB::table('users')->where('id',$id)->first('state');
        if ($sel->state == 1){
            $pole = DB::table('users')->where('id',$id)->update(['state'=>0]);
        }elseif ($sel->state == 0){
            $pole = DB::table('users')->where('id',$id)->update(['state'=>1]);
        }
//        $sel_data = json_decode($sel,true);
        return $pole;
    }
    //删除
    public function del($id){
        $id_all = explode(',',$id);
        $del = DB::table('users')->whereIn('id',$id_all)->delete();
        DB::table('ur')->whereIn('ur_id',$id_all)->delete();
        return $del;
    }
    //修改的默认
    public function saves($id){
        $ins = DB::table('users')->where('id',$id)->first(['id','user','tel','e_mail','sex']);
        return $ins;
    }
    //管理员修改
    public function adminUpd($data){
        $sel = DB::table('users')
            ->where('user',$data['user'])
            ->where('tel',$data['tel'])
            ->where('e_mail',$data['e_mail'])
            ->where('e_mail',$data['e_mail'])
            ->where('sex',$data['sex'])
            ->first();
        //判断管理员信息有没有被修改
        if (!$sel){
            $admin = [
                'user'=>$data['user'],
                'state'=>'0',
                'tel'=>$data['tel'],
                'e_mail'=>$data['e_mail'],
                'sex'=>$data['sex'],
            ];
            //修改管理员
            $save = DB::table('users')->where('id',$data['id'])->update($admin);
            if ($save){
                $role_save = DB::table('ur')->where('ur_id',$data['id'])->update(['ro_id'=>$data['role_id']]);
                return $role_save;
            }
        }else{
            //管理员信息没有被修改而只改了一个角色
            $save = DB::table('ur')->where('ur_id',$data['id'])->update(['ro_id'=>$data['role_id']]);
            return $save;
        }
    }
    //查询管理员列表
    public function adminList($search){
        //判断搜索的值是不是为空
        if (!empty($search)){
            //查询每个管理员的角色和管理员信息
            $date = DB::table('users')
                ->join('ur','users.id','ur.ur_id')
                ->join('role','ur.ro_id','role.role_id')
                ->whereBetween('time',[$search['old_time'],$search['new_time']])
                ->orWhere('user',$search['user'])
                ->select(['id','user','state','tel','e_mail','time','role_name'])
                ->get();
        }else{
            //查询每个管理员的角色和管理员信息
            $date = DB::table('users')
                ->join('ur','users.id','ur.ur_id')
                ->join('role','ur.ro_id','role.role_id')
                ->select(['id','user','state','tel','e_mail','time','role_name'])
                ->get();
        }
        $date = json_decode($date,true);
        return $date;
    }
    //添加用户和此用户的角色
    public function userAdd($data){
        $sel = DB::table('users')->where('user',$data['user'])->first();
        //判断要添加的用户是否重复
        if (!$sel){
            //添加管理员
            $admin = [
                'user'=>$data['user'],
                'password'=>$data['password'],
                'state'=>'0',
                'tel'=>$data['tel'],
                'e_mail'=>$data['e_mail'],
                'sex'=>$data['sex'],
                'time'=>date('Y-m-d h:i:s',time())
            ];
            $inse = DB::table('users')->insertGetId($admin);
            //添加管理有什么角色
            $ur = [
                'ur_id'=>$inse,
                'ro_id'=>$data['role_id'],
            ];
            $ur_inse = DB::table('ur')->insert($ur);
            //成功返回1
            if ($ur_inse){
                return 1;
            }
        }else{
            return 0;
        }
    }
}