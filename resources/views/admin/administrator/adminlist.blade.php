<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
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
    <title>管理员列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 管理员管理 <span class="c-gray en">&gt;</span> 管理员列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c">
        <form action="adminlist" method="get">
            日期范围：
            <input type="text" value="<?php echo $search['old_time']?>" name="old_time" onfocus="WdatePicker({ maxDate:'#F{$dp.$D(\'datemax\')||\'%y-%M-%d\'}' })" id="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" value="<?php echo $search['new_time']?>" name="new_time" onfocus="WdatePicker({ minDate:'#F{$dp.$D(\'datemin\')}',maxDate:'%y-%M-%d' })" id="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" value="<?php echo $search['user']?>" class="input-text" style="width:250px" placeholder="输入管理员名称" id="" name="user">
            <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
        </form>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" class="btn btn-danger radius remove"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加管理员','adminadd','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加管理员</a></span> <span class="r">共有数据：<strong><?php echo $count?></strong> 条</span> </div>
    <table class="table table-border table-bordered table-bg">
        <thead>
        <tr>
            <th scope="col" colspan="9">员工列表</th>
        </tr>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="40">ID</th>
            <th width="150">登录名</th>
            <th width="90">手机</th>
            <th width="150">邮箱</th>
            <th>角色</th>
            <th width="130">加入时间</th>
            <th width="100">是否已启用</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($admin as $k => $v){?>
        <tr class="text-c">
            <td><input type="checkbox" value="<?php echo $v['id']?>" name="box" class="box"></td>
            <td><?php echo $v['id']?></td>
            <td><?php echo $v['user']?></td>
            <td><?php echo $v['tel']?></td>
            <td><?php echo $v['e_mail']?></td>
            <td><?php echo $v['role_name']?></td>
            <td><?php echo $v['time']?></td>
            <td class="td-status">
                <?php if ($v['state'] == 1){?>
                    <span class="label label-success radius">已启用</span>
                <?php }elseif ($v['state'] == 0){ ?>
                    <span class="label label-default radius">已禁用</span>
                <?php }?>
            </td>
            <td class="td-manage">
                    <?php if ($v['state'] == 1){?>
                        <a style="text-decoration:none" onClick="admin_stop(this,'<?php echo $v['id']?>')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>
                    <?php }elseif ($v['state'] == 0){ ?>
                        <a onClick="admin_start(this,'<?php echo $v['id']?>')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>
                    <?php } ?>
                <a title="编辑" href="javascript:;" onclick="admin_edit('管理员编辑','adminsave?id=<?php echo $v['id']?>','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                <a title="删除" href="javascript:;" onclick="admin_del(this,'<?php echo $v['id']?>')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    /*
        参数解释：
        title	标题
        url		请求的url
        id		需要操作的数据id
        w		弹出层宽度（缺省调默认值）
        h		弹出层高度（缺省调默认值）
    */
    /*管理员-增加*/
    function admin_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-批量删除*/
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
        var admin_id = id.substr(1);
        if (admin_id != '') {
            layer.confirm('确认要删除吗？', function (index) {
                $.get('admindel', {id: admin_id}, function (data) {
                    if (data == 1) {
                        layer.msg('已删除!', {icon: 1, time: 1000});
                        history.go(0);
                    }
                },'json')
            })
        }else{
            alert('请选择要删除的选项');
        }
    });
    /*管理员-删除*/
    function admin_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'GET',
                url: 'admindel',
                data:{id:id},
                dataType: 'json',
                success: function(data){
                    if (data == 1){
                        $(obj).parents("tr").remove();
                        layer.msg('已删除!',{icon:1,time:1000});
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*管理员-编辑*/
    function admin_edit(title,url,id,w,h){
        layer_show(title,url,w,h);
    }
    /*管理员-停用*/
    function admin_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type: 'GET',
                url: 'pole',
                data: {id:id},
                dataType: 'json',
                success: function(data){
                    if (data.state == 1){
                        $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,'+data.id+')" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
                        $(obj).remove();
                        layer.msg('已停用!',{icon: 5,time:1000});
                    }
                },
            });
        });
    }

    /*管理员-启用*/
    function admin_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……
            $.ajax({
                type: 'GET',
                url: 'pole',
                data: {id:id},
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    if (data.state == 1){
                        $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,'+data.id+')" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
                        $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
                        $(obj).remove();
                        layer.msg('已启用!', {icon: 6,time:1000});
                    }
                },
            });
        });
    }
</script>
</body>
</html>