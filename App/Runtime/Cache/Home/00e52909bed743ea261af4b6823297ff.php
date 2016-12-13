<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>宾客邀请</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/marry/Public/Home/css/bootstrap.min.css">
    <link rel="stylesheet" href="/marry/Public/Home/css/style.css">
    <script src="/marry/Public/Home/js/jquery-1.10.2.min.js"></script>
    <script src="/marry/Public/Home/js/bootstrap.min.js"></script>

</head>
<body>
<div class="main_box">
    <div class="top_header">
        <div class="header_title" style="">
            <a href="/marry/index.php/Home/Index/index"  class='art_active'>宾客邀请</a>
            <a href="/marry/index.php/Home/Index/qiandao" >宾客签到</a>
            <div class="head_right">
                <span class="btn btn-xs btn-warning" id="refresh">刷新页面</span>
                <span class="btn btn-xs btn-info" data-toggle="modal" data-target="#addUser">添加宾客</span>
            </div>
        </div>
    </div>
    <div class="container action">
        <input type="hidden" value="/marry/index.php/Home/Index/index" name="hide_url" id="hide_url">
        <div class="form-group">
            <form action="/marry/index.php/Home/Index" method="post">
            <div class="input-group">
                <input type="text" class="form-control search_name" name="name" placeholder="输入名字查询">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="submit" id="search">搜索</button>
                </span>
            </div><!-- /input-group -->
            </form>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="form-group">
                    <select name="cancomming" id="sel_comming" class="form-control">
                        <option value="-1">按照状态查看</option>
                        <?php if(is_array($can_comming)): $i = 0; $__LIST__ = $can_comming;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if(($_GET['cancomming'] != '') and ($key == $_GET['cancomming'])): ?><option value="<?php echo ($key); ?>" selected><?php echo ($item); ?></option>
                            <?php else: ?>
                                <option value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="form-group">
                    <select name="type" id="sel_type" class="form-control">
                        <option value="-1">按照关系查看</option>
                        <?php if(is_array($tongxue_type)): $i = 0; $__LIST__ = $tongxue_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i; if(($_GET['type'] != '') and ($key == $_GET['type'])): ?><option value="<?php echo ($key); ?>" selected><?php echo ($item); ?></option>
                                <?php else: ?>
                                <option value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
        </div>

    </div>
    <div class="user_list">
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>名字</th>
                <th>电话</th>
                <th>关系</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr class="one_row">
                    <td><?php echo ($row['name']); ?></td>
                    <td><?php echo ($row['mobile']); ?></td>
                    <td><?php echo ($tongxue_type[$row['type']]); ?></td>
                    <td class="comming" data-status="<?php echo ($row['cancomming']); ?>"><?php echo ($can_comming[$row['cancomming']]); ?></td>
                    <td>
                        <span class="btn btn-xs btn-info edit_user" data-id="<?php echo ($row['id']); ?>" data-url="/marry/index.php/Home/Index/getUser">修&nbsp;&nbsp;改</span>
                        <span class="btn btn-xs btn-danger del_user" data-id="<?php echo ($row['id']); ?>" data-url="/marry/index.php/Home/Index/delUser">移&nbsp;&nbsp;除</span>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="/marry/index.php/Home/Index/addUser" id="add_user_form" data-reurl="/marry/index.php/Home/Index/index">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">添加宾客</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name_put" placeholder="请输入名字">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="mobile" id="mobile_put" placeholder="请输入电话">
                    </div>
                    <div class="row" style="margin-bottom: 15px;overflow: hidden">
                        <div class="col-xs-6">
                            <select name="type" id="type_put" class="form-control">
                                <option value="-1">选择关系</option>
                                <?php if(is_array($tongxue_type)): $i = 0; $__LIST__ = $tongxue_type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                       <div class="col-xs-6">
                           <select name="cancomming" id="comming_put" class="form-control">
                               <option value="-1">选择状态</option>
                               <?php if(is_array($can_comming)): $i = 0; $__LIST__ = $can_comming;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($item); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                           </select>
                       </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary sure_add">确认添加</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal -->
</div>

<!-- 模态框（Modal） -->
<div class="modal fade" id="editUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="/marry/index.php/Home/Index/editUser" id="edit_user_form" data-reurl="/marry/index.php/Home/Index/index">
    <input type="hidden" name="id" value="" id="hide_edit_user_id">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">编辑宾客</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary sure_edit_user">确定修改</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
    </form>
</div>


<script src="/marry/Public/Home/js/style.js"></script>
</body>
</html>