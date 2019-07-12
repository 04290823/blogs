<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\control;
use App\Models\role;
use App\Models\users;
use Codeception\Util\PathResolver;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class AdministratorController extends Controller{
    /**
     * 管理员列表
     */
    public function adminList(){
        $search = Input::get();
        //管理员列表
        $users = new users();
        $admin = $users->adminList($search);
        $count = count($admin);
        //判断搜索为空给每个值赋值为空
        if (empty($search)){
            $search = [
                'old_time'=>'',
                'new_time'=>'',
                'user'=>'',
            ];
        }
        return view('admin/administrator/adminlist',['admin'=>$admin,'count'=>$count,'search'=>$search]);
    }

    /**
     * 修改状态
     */
    public function pole(){
        $id = Input::get('id');
        $user = new users();
        $pole = $user->pole($id);
        if ($pole){
            echo json_encode([
                'id'=>$id,
                'state'=>1
            ]);
        }
    }

    /**
     * 管理员删除
     */
    public function adminDel(){
        $id = Input::get('id');
        $users = new users();
        $del = $users->del($id);
        //删除成功
        if ($del){
            echo json_encode(1);
        }
    }
    /**
     * 管理员添加页面
     */
    public function adminAdd(){
        $role = new role();
        $data = $role->role();
        return view('admin/administrator/adminadd',['data'=>$data]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 管理员添加
     */
    public function adminIns(){
        $date = Input::post();
        $users = new users();
        $usersAdd = $users->userAdd($date);
        if ($usersAdd){
            return 1;
        }
    }

    /**
     * 管理员修改页面
     */
    public function adminSave(){
        $id = Input::get('id');
        //查询角色
        $role = new role();
        $data = $role->role();
        //查询出默认
        $users = new users();
        $save = $users->saves($id);
        return view('admin/administrator/adminsave',['data'=>$data,'save'=>$save]);
    }
    /**
     * 管理员修改
     */
    public function adminUpd(){
        //接收数据
        $data = Input::post();
        $users = new users();
        //修改管理员的信息和角色
        $save = $users->adminUpd($data);
        if ($save){
            return 1;
        }
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 角色管理
     */
    public function role(){
        $role = new role();
        $data = $role->role_list();
        $count = count($data);
        return view('admin/administrator/role',['data'=>$data,'count'=>$count]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 角色删除
     */
    public function roleDel(){
        $id = Input::get('id');
        $role = new role();
        $del = $role->del($id);
        //判断是否删除成功
        if ($del){
            echo json_encode(1);
        }else{
            echo json_encode(0);
        }
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 角色添加页面
     */
    public function roleAdd(){
        //查询权限
        $control = new control();
        $pqct = $control->pqctAdd();
        return view('admin/administrator/roleadd',['pqct'=>$pqct]);
    }
    /**
     * 角色添加
     */
    public function roleInser(){
        //接收数据
        $data = Input::post();
        $role = new role();
        $roleinser = $role->roleinser($data);
        //成功返回
        if ($roleinser){
            echo json_encode(1);
        }
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|\think\response\View
     * 角色编辑
     */
    public function roleSave(){
        $id = Input::get('id');
        $role = new role();
        //查询出所对应的角色
        $data = $role->rolesave($id);
        //查询出此角色拥有什么权限
        $control = new control();
        $pqct = $control->pqct();

        $roleBased = $role->roleBased($data);
        foreach ($pqct as $k=>$v){
            if (in_array($v['id'],$roleBased)){
                $pqct[$k]['check'] = 1;
            }else{
                $pqct[$k]['check'] = 0;
            }
        }
        //查询权限
        $default = $control->arr_recursion($pqct);
        return view('admin/administrator/rolesave',['data'=>$data,'pqct'=>$default]);
    }
    /**
     * 角色修改
     */
    public function roleUpdate(){
        $data = Input::post();
        $role = new role();
        $updat = $role->updat($data);
        print_r($updat);
    }
    /**
     * 权限管理页面
     */
    public function permission(){
        $permissions_name = Input::get('permissions_name');
        $control = new control();
        $list = $control->permission($permissions_name);
        return view('admin/administrator/permission',['list'=>$list,'permissions_name'=>$permissions_name]);
    }
    /**
     * 权限删除
     */
    public function permissiondel(){
        $id = Input::get('id');
        $control = new control();
        $del = $control->permissiondelDel($id);
        echo json_encode($del);
    }
}