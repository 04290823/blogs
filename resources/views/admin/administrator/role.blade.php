<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="lib/html5shiv.js"></script>
    <script type="text/javascript" src="lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>角色管理</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 角色管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray"> <span class="l"> <a href="javascript:;" class="btn btn-danger radius remove"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a class="btn btn-primary radius" href="javascript:;" onclick="admin_role_add('添加角色','roleadd','800')"><i class="Hui-iconfont">&#xe600;</i> 添加角色</a> </span> <span class="r">共有数据：<strong><?php echo $count?></strong> 条</span> </div>
    <table class="table table-border table-bordered table-hover table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="6">角色管理</th>
        </tr>
        <tr class="text-c">
            <th width="25"><input type="checkbox" value="" name=""></th>
            <th width="40">ID</th>
            <th width="200">角色名</th>
            <th>用户列表</th>
            <th width="300">描述</th>
            <th width="70">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($data as $k=>$v){
                echo "<tr class='text-c{$v['role_id']}'>";
                echo "<td><input type='checkbox' value='{$v['role_id']}' name='box' class='box'></td>
                      <td>{$v['role_id']}</td>
                      <td>{$v['role_name']}</td>";
                echo "<td>";
                foreach ($v['user'] as $key=>$value){
                    echo "<a href='#'>{$value->user},</a>";
                }
                echo "</td>";
                echo "<td>{$v['describe']}</td>";
                echo "<td class='f-14'>
                          <a title='编辑' href='javascript:;' onclick=\"admin_role_edit('角色编辑','rolesave?id={$v['role_id']}')\" style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a>
                          <a title='删除' href='javascript:;' onclick=\"admin_role_del(this,{$v['role_id']})\" class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6e2;</i></a>
                      </td>";
                echo '</tr>';
            }
        ?>


        </tbody>
    </table>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    /*管理员-角色-添加*/
    function admin_role_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-角色-编辑*/
    function admin_role_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-角色-批量删除*/
    $(document).on('click','.remove',function () {
        var str = document.getElementsByName('box');
        var id = '';
        //获取到要删除的id
        for (var i = 0;i < str.length;i++){
            if(str[i].checked == true){
                id += ','+str[i].value;
            }
        }
        //截取id前面的逗号
        var role_id = id.substr(1);
        if (role_id != '') {
            layer.confirm('角色删除须谨慎，确认要删除吗？', function (index) {
                $.get('roledel', {id: role_id}, function (data) {
                    if (data == 1) {
                        layer.msg('已删除!', {icon: 1, time: 1000});
                        history.go(0);
                    }
                })
            })
        }else{
            alert('请选择要删除的选项');
        }
    });
    /*管理员-角色-删除*/
    function admin_role_del(obj,id){
        layer.confirm('角色删除须谨慎，确认要删除吗？',function(index){
            $.ajax({
                type: 'GET',
                url: 'roledel',
                data: {id:id},
                dataType: 'json',
                success: function(data){
                    if (data == 1){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }else{
                        layer.msg('删除失败!',{icon:1,time:1000});
                    }

                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }
</script>
</body>
</html>