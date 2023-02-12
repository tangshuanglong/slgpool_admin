
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/trade/index.html" class="maincolor">币币交易</a> <span class="c-999 en">&gt;</span><span class="c-666">交易记录</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="formControls col-xs-1 col-sm-1 col-sm-offset-6" style="padding: 0;text-align:right">
                        <span class="select-box">
                            <select class="select" size="1" name="order_type" id="order_type">
                                <option value="">请选择订单类型</option>
                                <?php foreach ($order_types as $item): ?>
                                <option value="<?php echo $item['type'] ?>" <?php if ($order_type == $item['type']): echo 'selected'; endif; ?>><?php echo $item['type_name_cn'] ?></option>
                                <?php endforeach; ?>
                            </select>   
                        </span>
                    </div>
                    <div class="formControls col-xs-2 col-sm-2">
                        <input type="text" id="key" name="trade_sn" class="input-text" autocomplete="off" value="<?php if (! empty($trade_sn)): echo $trade_sn; endif; ?>" placeholder="请根据单号">
                    </div>
                    <div class="formControls col-xs-2 col-sm-2">
                        <input type="text" id="key" name="uid" class="input-text" autocomplete="off" value="<?php if (! empty($uid)): echo $uid; endif; ?>" placeholder="用户ID搜索">
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>交易单号</th>
                    <th>交易用户[UID]</th>
                    <th>订单类型</th>
                    <th>交易类型</th>
                    <th>币种</th>
                    <th>价格类型</th>
                    <th>交易数量</th>
                    <th>用户可用余额</th>
                    <th>用户冻结余额</th>
                    <th>用户总余额</th>
                    <th>时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $key => $item): ?>
                <tr>
                    <td><?php echo $item['trade_sn'] ?></td>
                    <td><a href="/user?uid=<?php echo $item['uid'] ?>"><?php echo $item['uid'] ?></a></td>
                    <td><?php echo $item['trade_order_type'] ?></td>
                    <td><?php echo $item['trade_type'] ?></td>
                    <td><?php echo $item['coin_type'] ?></td>
                    <td><?php echo $item['price_type'] ?></td>
                    <td><?php echo $item['trade_coin_amount'] ?> <?php echo strtoupper($item['trade_coin_type']) ?></td>
                    <td><?php echo $item['user_coin_available_balance'] ?> <?php echo strtoupper($item['trade_coin_type']) ?></td>
                    <td><?php echo $item['user_coin_frozen_blance'] ?> <?php echo strtoupper($item['trade_coin_type']) ?></td>
                    <td><?php echo $item['user_coin_total_balance'] ?> <?php echo strtoupper($item['trade_coin_type']) ?></td>
                    <td><?php echo $item['create_time'] ?></td>
                    <td></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <?php echo $page_view ?>
		</article>
	</div>
</section>