<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/admin/index" class="maincolor">管理员管理</a> <span class="c-999 en">&gt;</span><span class="c-666">管理员列表</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="col-xs-2 col-sm-2">
                        <a href="/admin/add" class="btn btn-success radius">添加管理员</a>
                    </div>
                    <div class="formControls col-xs-2 col-sm-2 col-sm-offset-7">
                        <input type="text" id="key" name="key" class="input-text" autocomplete="off" <?php if (! empty($data['key'])): echo 'value="' . $data['key'] . '"'; endif; ?> placeholder="请根据账号搜索">
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>账号</th>
                    <th>管理员类型</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="content_list" >
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['account'] ?></td>
                    <td><?php if($item['admin_type'] === '1'){echo '超级管理员'; }else{echo '普通管理员';} ?></td>
                    <td>
                        <a href="/admin/edit/<?php echo $item['id'] ?>" class="btn btn-primary-outline radius">编辑</a>
                        <!--<a href="/admin/delete/<?php echo $item['id'] ?>" class="btn btn-warning-outline radius delete">删除</a>-->
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <?php echo $data['page_view'] ?>
		</article>
	</div>
</section>


