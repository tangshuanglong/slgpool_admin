
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/role/index" class="maincolor">角色管理</a> <span class="c-999 en">&gt;</span><span class="c-666">权限列表</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="col-xs-2 col-sm-2">
                        <a href="/role/add_action" class="btn btn-success radius">添加权限</a>
                    </div>
                    <div class="formControls col-xs-2 col-sm-2 col-sm-offset-7">
                        <input type="text" id="key" name="key" class="input-text" autocomplete="off" <?php if (! empty($data['key'])): echo 'value="' . $data['key'] . '"'; endif; ?> placeholder="请权限名搜索">
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>权限名</th>
                    <th>权限url(/控制器/方法)</th>
                    <th>父级权限名</th>
                    <th>层级</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['action_name'] ?></td>
                    <td><?php echo $item['action_url'] ?></td>
                    <td><?php echo $item['parent_name'] ?></td>
                    <td><?php echo $item['label'] ?></td>
                    <td>
                        <a href="/role/edit_action/<?php echo $item['action_id'] ?>" class="btn btn-primary-outline radius">编辑</a>
                        <a href="/role/delete_action/<?php echo $item['action_id'] ?>" class="btn btn-warning-outline radius delete">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <?php echo $data['page_view'] ?>
		</article>
	</div>
</section>
<script type="text/javascript">
    layui.use(['layer'], function(){
        var layer = layui.layer;
        $('.delete').click(function(e) {
            e.preventDefault();
            var api = $(this).attr('href');
            layer.confirm('删除角色', function(e) {
                $.ajax({
                    url: api,
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
    });
</script>
