
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/article/index" class="maincolor">文章</a> <span class="c-999 en">&gt;</span><span class="c-666">文章列表</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
        <form class="mb-15">
            <div class="row cl">
                <div class="col-xs-2 col-sm-2">
                    <a href="/article/add" class="btn btn-success radius">添加文章</a>
                </div>
                <div class="formControls col-xs-2 col-sm-2 col-sm-offset-7">
                    <input type="text" id="key" name="key" class="input-text" autocomplete="off" value="<?php if (! empty($data['key'])): echo $data['key']; endif; ?>" placeholder="请根据标题搜索">
                </div>
                <input class="btn btn-primary radius" type="submit" value="搜索">
            </div>
        </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>序号</th>
                    <th>标题</th>
                    <th>文章类型</th>
                    <th>语言类型</th>
                    <th>创建时间</th>
                    <th>是否置顶</th>
                    <th>是否轮播</th>
                    <th>创建人</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['order_num'] ?></td>
                    <td><?php echo $item['title'] ?></td>
                    <td><?php echo $item['type_plain'] ?></td>
                    <td><?php echo $item['lang_name'] ?></td>
                    <td><?php echo $item['create_time'] ?></td>
                    <td class="modify_top" style="cursor:pointer;" top_url="<?php echo '/article/modify_top?id=' . $item['id'].'&is_top='.$item['is_top']; ?>"><span class="label label-<?php echo $item['is_top'] == 0 ? 'default' : 'success'; ?> radius"><?php echo $item['is_top'] == 1 ? '是' : '否' ?></span></td>
                    <td class="modify_carousel" style="cursor:pointer;" carousel_url="<?php echo '/article/modify_carousel?id=' . $item['id'].'&is_carousel='.$item['is_carousel']; ?>"><span class="label label-<?php echo $item['is_carousel'] == 0 ? 'default' : 'success'; ?> radius"><?php echo $item['is_carousel'] == 1 ? '是' : '否' ?></span></td>
                    <td><?php echo $item['nickname'] ?></td>
                    <td><span class="label label-<?php echo $item['status'] == 0 ? 'default' : 'success'; ?> radius"><?php echo $item['status'] == 1 ? '正常' : '隐藏' ?></span></td>
                    <td>
                        <a href="<?php echo '/article/edit/' . $item['id']; ?>" class="btn btn-primary-outline radius">编辑</a>
                        <a href="<?php echo '/article/delete/' . $item['id']; ?>" class="btn btn-primary-outline radius delete">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <?php echo $data['page_view'] ?>
		</article>
	</div>
</section>
<script>
    layui.use(['layer'], function(){
        var layer = layui.layer;
        $('.delete').click(function(e) {
            e.preventDefault();
            var api = $(this).attr('href');
            layer.confirm('删除文章', function(e) {
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
        $('.modify_top').click(function(e) {
            e.preventDefault();
            var top_url = $(this).attr('top_url');
            layer.confirm('修改置顶？', function(e) {
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
        $('.modify_carousel').click(function(e) {
            e.preventDefault();
            var carousel_url = $(this).attr('carousel_url');
            layer.confirm('修改置顶？', function(e) {
                $.ajax({
                    url: carousel_url,
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
