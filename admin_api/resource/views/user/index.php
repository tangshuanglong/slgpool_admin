
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/user/index" class="maincolor">用户管理</a> <span class="c-999 en">&gt;</span><span class="c-666">用户列表</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="formControls col-xs-2 col-sm-2 col-sm-offset-1">
                      <input type="text" id="uid" name="uid" class="input-text" autocomplete="off" value="<?php if (! empty($data['uid'])): echo $data['uid']; endif; ?>" placeholder="请根据用户ID搜索">
                    </div>
                    <div class="formControls col-xs-2 col-sm-2">
                      <input type="text" id="invitor_uid" name="invitor_uid" class="input-text" autocomplete="off" value="<?php if (! empty($data['invitor_uid'])): echo $data['invitor_uid']; endif; ?>" placeholder="请根据推荐人推荐ID搜索">
                    </div>
                    <div class="formControls col-xs-2 col-sm-2">
                        <span class="select-box">
                            <select class="select" size="1" name="type" id="type">
                                <option value="">请选择用户类型</option>
                                <option <?php if ($data['type'] == 1): echo 'selected'; endif; ?> value="1">今天注册用户</option>
                                <option <?php if ($data['type'] == 2): echo 'selected'; endif; ?> value="2">在线用户</option>
                            </select>
                        </span>
                    </div>
                    <div class="formControls col-xs-2 col-sm-2">
                        <input type="text" id="key" name="key" class="input-text" autocomplete="off" value="<?php if (! empty($data['key'])): echo $data['key']; endif; ?>" placeholder="请根据账号搜索">
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                    <a href="/user/index" class="btn btn-primary radius">重置</a>
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>用户ID</th>
                    <th>手机</th>
                    <th>邮箱</th>
                    <th>推荐人ID</th>
                    <th>推荐总数</th>
                    <th>有效推荐总数</th>
                    <th>注册时间</th>
                    <th>在线状态</th>
                    <th>限制登录</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['id'] ?></td>
                    <td><?php echo $item['mobile'] ?></td>
                    <td><?php echo $item['email'] ?></td>
                    <td><?php echo $item['invitor_uid'] ?></td>
                    <td><?php if ($item['invite_total_times']): ?><a style="text-decoration:underline;color:blue;" href="/user?invitor_uid=<?php echo $item['id']; ?>"><?php else: ?><a><?php endif; echo $item['invite_total_times'] ?></a></td>
                    <td><?php echo $item['valid_invite_total_times'] ?></td>
                    <td><?php echo $item['register_time'] ?></td>
                    <td><?php echo $item['login_status'] == 1 ? '<span class="badge badge-success radius">在线</span>' : '<span class="badge badge-error radius">离线</span>' ?></td>
                    <td><?php echo $item['forbidden_login'] == 0 ? '<span class="badge badge-success radius">正常</span>' : '<span class="badge badge-error radius">禁止</span>' ?></td>
                    <td>
                        <a href="<?php echo '/user/modify_forbidden?id=' . $item['id'].'&is_forbidden='.$item['forbidden_login']; ?>" class="modify_forbidden btn btn-warning-outline radius"><?php echo $item['forbidden_login'] == 0 ? "限制登录":"取消限制" ?></a>
                        <a href="/user/wallet/<?php echo $item['id'] ?>" class="btn btn-primary-outline radius">钱包</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>

             <div class="row cl">
                    <div class="col-xs-6 col-sm-6 mt-15">
                        <span class="label label-primary radius">总注册人数:<?php echo $data['total_register'] ?> </span>
                        <span class="label label-primary radius">总推荐人数:<?php echo $data['total_recommend'] ?> </span>
                    </div>
                    <div class="col-xs-6 col-sm-6">
                    <?php echo $data['page_view'] ?>
                    </div>
            </div>
		</article>
	</div>

</section>
<script>
    layui.use(['layer'], function(){
        $('body').on('change', 'select', function(e) {
            if ($(this).val() != '')
            {
                $('[name="remark"]').val($(this).val());
            }
        });
        $('.modify_forbidden').click(function(e) {
            e.preventDefault();
            var top_url = $(this).attr('href');
            layer.confirm('确定修改登录限制？', function(e) {
                $.ajax({
                    url: top_url,
                    type: 'get',
                    success: function (data) {
                        if (data.code == 0) {
                            location.href = location.href;
                        } else {
                            layer.msg(data.msg, {time: 2000});
                        }
                    }
                });
            });
        });
    })

</script>
