<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Self_;

class role extends Model
{
    protected $table = 'role';
    /**
     * 查询角色表
     */
    public function role_list(){
        //查询角色表
        $date = self::all()->toArray();
        //循环角色
        foreach ($date as $k=>$v){
            //两表查询所对应的用户
            $ur = DB::table('ur')
                ->where('ro_id',$v['role_id'])
                ->join('users','ur.ur_id','users.id')
                ->select(['user'])
                ->get()
                ->toArray();
            //把查出来的用户放入数组当中
            $date[$k]['user'] = $ur;
        }
        return $date;
    }
    /**
     * 查出角色
     */
    public function role(){
        //查询角色表
        $date = self::all(['role_id','role_name'])->toArray();
        return $date;
    }
    /**
     * @param $data
     * @return mixed
     * 查询出此角色拥有什么权限
     */
    public function roleBased($data){
        $role_id = $data['role_id'];
        //查询出此用户拥有什么权限
        $pr = DB::table('pr')->where(['role_id'=>$role_id])->select()->get()->toArray();
        $pr_data = array_column($pr,'per_id');
        return $pr_data;
    }
    /**
     * 删除
     */
    public function del($id){
        $id_all = explode(',',$id);
        $del = DB::table('role')->whereIn('role_id',$id_all)->delete();
        //判断角色是否删除成'ur
        if ($del){
            //删除成功删除掉此角色的权限
            DB::table('pr')->whereIn('role_id',$id_all)->delete();
            DB::table('ur')->whereIn('ro_id',$id_all)->delete();
        }
        return $del;
    }
    /**
     * 编辑
     */
    public function rolesave($id){
        $sel = self::where(['role_id'=>$id])->first();
        return $sel->toArray();
    }
    //角色添加
    public function roleinser($data){
        $role['role_name'] = $data['role_name'];
        $role['describe'] = $data['describe'];

        //角色添加
        $inser = DB::table('role')->insertGetId($role);
        if ($inser){
            foreach ($data['per_id'] as $k=>$v){
                $pr[$k]['role_id'] = $inser;
                $pr[$k]['per_id'] = $v;
            }
            $pr_inser = DB::table('pr')->insert($pr);
            //添加此角色的权限
            if ($pr_inser){
                return 1;
            }else{
                return 0;
            }
        }
    }
    /**
     * 修改角色名称和权限
     */
    public function updat($data){
        //先把要修改的权限删除掉
        $sel_pr = DB::table('pr')->where('role_id',$data['roleId'])->delete();
        if ($sel_pr){
            //删除成功后添加新的权限
            foreach ($data['per_id'] as $k=>$v){
                $pr_save[$k]['role_id'] = $data['roleId'];
                $pr_save[$k]['per_id'] = $v;
            }
            $ins_pr = DB::table('pr')->insert($pr_save);
            return $ins_pr;
        }
    }
}