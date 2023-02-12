
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/coin/index" class="maincolor">币种管理</a> <span class="c-999 en">&gt;</span><a href="/chain/index" class="maincolor">公链列表</a> </nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="col-xs-2 col-sm-2">
                        <a href="/coin_token/add?chain_id=<?php echo $data['chain_id']; ?>" class="btn btn-success radius">添加TOKEN</a>
                    </div>
                    <div class="formControls col-xs-2 col-sm-2 col-sm-offset-7">
                        <input type="text" id="key" name="key" class="input-text" autocomplete="off" <?php if (! empty($data['key'])): echo 'value="' . $data['key'] . '"'; endif; ?> placeholder="请根据公链名称搜索">
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>公链名</th>
                    <th>币种</th>
                    <th>是否主代币</th>
                    <th>系统提现阔值</th>
                    <th>热钱包余额预警值</th>
                    <th>区块链浏览器</th>
                    <th>address/account拼接参数</th>
                    <th>tx拼接参数</th>
                    <th>上架/下架</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['chain_name'] ?></td>
                    <td><?php echo $item['coin_name'] ?></td>
                    <td><?php echo $item['is_main'] ? '是': '否'; ?></td>
                    <td><?php echo $item['withdraw_theshold'] ?></td>
                    <td><?php echo $item['warning_amount'] ?></td>
                    <td><?php echo $item['explorer_url'] ?></td>
                    <td><?php echo $item['explorer_url_parameter_address'] ?></td>
                    <td><?php echo $item['explorer_url_parameter_tx'] ?></td>
                    <td><?php echo $item['cancel_flag'] ? '下架': '上架'; ?></td>
                    <td>
                        <a href="/coin_token/edit/<?php echo $item['id'] ?>" class="btn btn-primary-outline radius">编辑</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <?php echo $data['page_view'] ?>
		</article>
	</div>
</section>
