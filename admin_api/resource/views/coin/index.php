
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/coin/index" class="maincolor">币种管理</a> <span class="c-999 en">&gt;</span><span class="c-666">币种列表</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="col-xs-2 col-sm-2">
                        <a href="/coin/add" class="btn btn-success radius">添加币种</a>
                    </div>
                    <div class="formControls col-xs-2 col-sm-2 col-sm-offset-7">
                        <input type="text" id="key" name="key" class="input-text" autocomplete="off" <?php if (! empty($key)): echo 'value="' . $key . '"'; endif; ?> placeholder="请根据币种名称搜索">
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>币种名称(中文)</th>
                    <th>币种名称(英文)</th>
                    <th>币种名称(缩写)</th>
                    <th>交易区</th>
                    <th>USDT默认价格</th>
                    <th>BTC默认价格</th>
                    <th>ETH默认价格</th>
                    <th>总发行量</th>
                    <th>存量</th></th>
                    <th>最小充值数量</th></th>
                    <th>最小提币数量</th></th>
                    <th>最大提币数量</th></th>
                    <th>提现手续费</th></th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td><?php echo $item['coin_name_cn'] ?></td>
                    <td><?php echo $item['coin_name_en_complete'] ?></td>
                    <td><?php echo $item['coin_name_en'] ?></td>
                    <td></td>
                    <td> USDT</td>
                    <td> BTC</td>
                    <td> ETH</td>
                    <td><?php echo $item['total_public_number'] ?></td>
                    <td><?php echo $item['inventory'] ?></td>
                    <td><?php echo $item['min_deposit'] ?> <?php echo strtoupper($item['coin_name_en']) ?></td>
                    <td><?php echo $item['min_withdraw'] ?> <?php echo strtoupper($item['coin_name_en']) ?></td>
                    <td><?php echo $item['max_withdraw'] ?> <?php echo strtoupper($item['coin_name_en']) ?></td>
                    <td><?php echo $item['withdraw_fee'] ?></td>
                    <td>
                        <a href="/coin/edit/<?php echo $item['coin_id'] ?>" class="btn btn-primary-outline radius">编辑</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <?php echo $data['page_view'] ?>
		</article>
	</div>
</section>
