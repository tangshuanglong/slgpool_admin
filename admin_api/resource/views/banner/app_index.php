<style>
    .img_class{
        max-width: 100px;
        max-height: 35px;
    }
</style>
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/banner/app_index" class="maincolor">首页轮播图片管理</a> <span class="c-999 en">&gt;</span><span class="c-666">APP图片列表</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="col-xs-2 col-sm-2">
                        <a href="/banner/app_add" class="btn btn-success radius">添加轮播图片</a>
                    </div>
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>排序号</th>
                    <th>app端图片</th>
                    <th>app端跳转路径</th>
                    <th>语言类型</th>
                    <th>状态</th>
                    <th>描述</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data['info'])): ?>
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['order_number'] ?></td>
                    <td class="imgs<?php echo $key ?>"><?php if(!empty($item['img_src'])):?><img src="<?php echo $item['img_src'] ?>" class="img_class"><?php endif;?></td>
                    <td><?php echo $item['link_href'] ?></td>
                    <td><?php echo $item['type_name'] ?></td>
                    <td>
                    <?php
                    if($item['status'] == 1){
                        echo "<span class='badge badge-success radius'>使用</span>";
                    }else{
                        echo "<span class='badge badge-warning radius'>停用</span>";
                    }
                    ?>
                    </td>
                    <td><?php echo $item['content'] ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$item['create_time']) ?></td>
                    <td>
                        <a href="/banner/app_edit/<?php echo $item['id'] ?>" class="btn btn-primary-outline radius">编辑</a>
                        <a href="javascript:void(0)" onclick="del_confirm(<?php echo $item['id'] ?>, '<?php echo $item['lang_type'] ?>' )" class="btn btn-danger-outline radius">删除</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php endif;?>
            </tbody>
            </table>
            <?php echo $data['page_view'] ?>
		</article>
	</div>
</section>
<script>
    function del_confirm(id, lang_type){
    	layer.confirm('真的删除吗?', function(index){
    		$.ajax({
                url: '/banner/app_delete',
                data: {"id":id, "lang_type":lang_type},
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    if (e.code != 0) {
                        $.Huimodalalert(e.msg, 3000)
                    } else {
                        $.Huimodalalert('删除成功', 1000);
                        setTimeout(function() {
                            location.href = '/banner/app_index';
                        }, 3100);
                    }
                }
            });
            layer.close(index);
          });
    }
    var len = <?php echo count($data['info']); ?>;
    for (var i = 0; i < len; i++) {
        layer.photos({
            photos: '.imgs' + i,
            shade: '#fff'
            ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机（请注意，3.0之前的版本用shift参数）
        });
    }
</script>
