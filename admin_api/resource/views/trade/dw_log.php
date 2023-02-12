
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/trade/index.html" class="maincolor">币币交易</a> <span class="c-999 en">&gt;</span><span class="c-666">充值/提现记录</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form class="mb-15">
                <div class="row cl">
                    <div class="col-xs-11 col-sm-11">
                        <div class="formControls col-xs-1 col-sm-1 col-sm-offset-3">
                            <span class="select-box">
                                <select class="select" size="1" name="coin_type" id="coin_type">
                                    <option value="">请选择币种</option>
                                    <?php foreach ($data['coins'] as $item): ?>
                                    <option value="<?php echo $item['coin_name_en'] ?>" <?php if ($data['coin_type'] == $item['coin_name_en']): echo 'selected'; endif; ?>><?php echo $item['coin_name_en'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </span>
                        </div>
                        <div class="formControls col-xs-1 col-sm-1" style="padding: 0;text-align:right">
                            <span class="select-box">
                                <select class="select" size="1" name="order_type" id="order_type">
                                    <option value="">请选择订单类型</option>
                                    <?php foreach ($data['order_types'] as $item): ?>
                                    <option value="<?php echo $item['type'] ?>" <?php if ($data['order_type'] == $item['type']): echo 'selected'; endif; ?>><?php echo $item['type_name_cn'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </span>
                        </div>
                        <div class="formControls col-xs-2 col-sm-2">
                            <input type="text" id="start_time" name="start_time" class="input-text" <?php if (!empty($data['start_time'])): echo 'value="' . $data['start_time'] . '"'; endif; ?> autocomplete="off" placeholder="活动开始时间">
                        </div>
                        <div class="formControls col-xs-2 col-sm-2">
                            <input type="text" id="end_time" name="end_time" class="input-text" <?php if (!empty($end_time)): echo 'value="' . $data['end_time'] . '"'; endif; ?> autocomplete="off" placeholder="活动结束时间">
                        </div>
                        <div class="formControls col-xs-3 col-sm-3">
                            <input type="text" id="key" name="key" class="input-text" autocomplete="off" <?php if (!empty($key)): echo 'value="' . $key . '"'; endif; ?> placeholder="请根据用户ID、交易单号搜索">
                        </div>
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                    <a href="/trade/dw_log" class="btn btn-primary radius">重置</a>
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>交易单号</th>
                    <th>交易用户[UID]</th>
                    <th>订单类型</th>
                    <th>币种</th>
                    <th>交易数量</th>
                    <th>手续费</th>
                    <th>实际到账数量</th>
                    <th>用户可用余额</th>
                    <th>用户冻结余额</th>
                    <th>用户总余额</th>
                    <th>区块链交易记录</th>
                    <th>状态</th>
                    <th>提现/充值时间</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['info'] as $key => $item): ?>
                <tr>
                    <td></td>
                    <td><a href="/trade/dw_log?key=<?php echo $item['invite_id'] ?>">[<?php echo $item['invite_id'] ?>]</a></td>
                    <td><?php if($item['trade_type_id'] == 3){echo '币币提现';}else{echo '币币充值';} ?></td>
                    <td><?php echo $item['trade_coin_type'] ?></td>
                    <td><?php echo $item['trade_coin_amount'] ?> <?php echo strtoupper($item['trade_coin_type']) ?></td>
                    <td></td>
                    <td></td>
                    <td><?php echo $item['user_coin_available_balance'] ?> <?php echo strtoupper($item['trade_coin_type']) ?></td>
                    <td><?php echo $item['user_coin_frozen_blance'] ?> <?php echo strtoupper($item['trade_coin_type']) ?></td>
                    <td><?php echo $item['user_coin_total_balance'] ?> <?php echo strtoupper($item['trade_coin_type']) ?></td>
                    <td><?php if (! empty($item['tx_url'])): ?><a href="<?php echo $item['tx_url'] ?>">点击查看</a><?php else: echo '无'; endif; ?></td>
                    <td></td>
                    <td><?php echo $item['create_time'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <div class="row cl">
                <div class="col-xs-6 col-sm-6 mt-15">
                    <?php if (! empty($data['coin_type'])): ?><span class="label label-primary radius">充值总量:<?php echo $data['total_buy_amount'] ?> <?php echo strtoupper($data['coin_type']) ?></span><?php endif;?>
                    <span class="label label-primary radius">充值总价:<?php echo $data['total_cny_buy_price'] ?> CNY | <?php echo $data['total_usdt_buy_price'] ?> USDT</span>
                    <?php if (! empty($data['coin_type'])): ?><span class="label label-primary radius">提现总量:<?php echo $data['total_sell_amount'] ?> <?php echo strtoupper($data['coin_type']) ?></span><?php endif;?>
                    <span class="label label-primary radius">提现总价:<?php echo $data['total_cny_sell_price'] ?> CNY | <?php echo $data['total_usdt_sell_price'] ?> USDT</span>
                </div>
                <div class="col-xs-6 col-sm-6">
                    <?php echo $data['page_view'] ?>
                </div>
            </div>
		</article>
	</div>
</section>
<script>
$(function() {
	layui.use('laydate', function(){
    	var laydate = layui.laydate;
		  //执行一个laydate实例
		  laydate.render({
            elem: '#start_time', //指定元素,
            type: 'datetime'
		  });
		  laydate.render({
			elem: '#end_time', //指定元素,
            type: 'datetime'
		  });
         });
});


</script>
