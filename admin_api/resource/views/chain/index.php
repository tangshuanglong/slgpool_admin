
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/coin/index" class="maincolor">币种管理</a> <span class="c-999 en">&gt;</span><a href="/chain/index" class="maincolor">公链列表</a> </nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="col-xs-2 col-sm-2">
                        <a href="/chain/add" class="btn btn-success radius">添加公链</a>
                    </div>
                    <div class="formControls col-xs-2 col-sm-2 col-sm-offset-7">
                        <input type="text" id="key" name="key" class="input-text" autocomplete="off" <?php if (! empty($key)): echo 'value="' . $key . '"'; endif; ?> placeholder="请根据公链名称搜索">
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>公链名</th>
                    <th>热钱包</th>
                    <th>冷钱包</th>
                    <th>区块确认数</th>
                    <th>是否基于石墨烯技术</th>
                    <th>是否匿名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['chain_name'] ?></td>
                    <td><?php echo $item['system_hot_wallet'] ?></td>
                    <td><?php echo $item['system_cold_wallet'] ?></td>
                    <td><?php echo $item['confirmation_time'] ?></td>
                    <td><?php echo $item['is_graphene'] ? '是' : '否'; ?></td>
                    <td><?php echo $item['is_anonymous'] ? '是' : '否'; ?></td>
                    <td>
                        <a href="/chain/edit/<?php echo $item['id'] ?>" class="btn btn-primary-outline radius">编辑</a>
                        <a href="/coin_token/index/?chain_id=<?php echo $item['id'] ?>" class="btn btn-primary-outline radius">查看token</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <?php echo $data['page_view'] ?>
		</article>
	</div>
</section>
