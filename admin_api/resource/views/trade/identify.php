
<section class="Hui-article-box">
	<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/trade/index.html" class="maincolor">币币交易</a> <span class="c-999 en">&gt;</span><span class="c-666">币币交易审核</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
        <form class="mb-15">
                <div class="row cl">
                    <div class="col-xs-11 col-sm-11">
                        <div class="formControls col-xs-1 col-sm-1 col-sm-offset-3">
                            <span class="select-box">
                                <select class="select" size="1" name="coin_type" id="coin_type">
                                    <option value="">请选择币种</option>
                                    <?php foreach ($coins as $item): ?>
                                    <option value="<?php echo $item['coin_name_en'] ?>" <?php if ($coin_type == $item['coin_name_en']): echo 'selected'; endif; ?>><?php echo $item['coin_name_en'] ?></option>
                                    <?php endforeach; ?>
                                </select>   
                            </span>
                        </div>
                        <div class="formControls col-xs-1 col-sm-1">
                            <span class="select-box">
                                <select class="select" size="1" name="type" id="type">
                                    <option value="">请选择审核状态</option>
                                    <?php foreach ($types as $k => $item): ?>
                                    <option value="<?php echo $k ?>" <?php if ($type == $k): echo 'selected'; endif; ?>><?php echo $item ?></option>
                                    <?php endforeach; ?>
                                </select>   
                            </span>
                        </div>
                        <div class="formControls col-xs-2 col-sm-2">
                            <input type="text" id="start_time" name="start_time" class="input-text" <?php if (! empty($start_time)): echo 'value="' . $start_time . '"'; endif; ?> autocomplete="off" placeholder="活动开始时间">
                        </div>
                        <div class="formControls col-xs-2 col-sm-2">
                            <input type="text" id="end_time" name="end_time" class="input-text" <?php if (! empty($end_time)): echo 'value="' . $end_time . '"'; endif; ?> autocomplete="off" placeholder="活动结束时间">
                        </div>
                        <div class="formControls col-xs-3 col-sm-3">
                            <input type="text" id="key" name="key" class="input-text" autocomplete="off" <?php if (! empty($key)): echo 'value="' . $key . '"'; endif; ?> placeholder="请根据用户ID、用户名、交易单号搜索">
                        </div>
                    </div>
                    <input class="btn btn-primary radius" type="submit" value="搜索">
                    <a href="/trade/identify" class="btn btn-primary radius">重置</a>
                </div>
            </form>
            <table class="table table-border table-bordered table-hover">
            <thead>
                <tr>
                    <th>交易单号</th>
                    <th>交易用户[用户ID]</th>
                    <th>币种</th>
                    <th>提币数量</th>
                    <th>手续费</th>
                    <th>实际到账数量</th>
                    <th style="width:400px;">提币地址/用户id</th>
                    <th style="width:400px;">Memo</th>
                    <th>提币类型</th>
                    <th>状态</th>
                    <th>区块链交易记录</th>
                    <th>提币时间</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($list as $key => $item): ?>
                <tr>
                    <td><?php echo $item['withdraw_number'] ?></td>
                    <td><a href="/user/index?uid=<?php echo $item['uid'] ?>"><?php echo $item['real_name'] ?>[<?php echo $item['uid'] ?>]</a></td>
                    <td><?php echo strtoupper($item['coin_type']) ?></td>
                    <td><?php echo $item['coin_amount'] ?> <?php echo strtoupper($item['coin_type']) ?></td>
                    <td><?php echo $item['trade_handling_fee'] ?> <?php echo strtoupper($item['coin_type']) ?></td>
                    <td><?php echo $item['coin_actual_amount'] ?> <?php echo strtoupper($item['coin_type']) ?></td>
                    <?php if($item['withdraw_type'] == 10):?>
                        <td><?php echo $item['coin_address'] ?></td>
                    <?php else:?>
                        <td><a href="/user/index?uid=<?php echo $item['coin_address'] ?>"><?php echo $item['coin_address'] ?></a></td>
                    <?php endif;?>
                    <td><?php echo $item['memo'] ?></td>
                    <td><?php if($item['withdraw_type'] == 10){echo '站外';}else{echo '站内';} ?></td>
                    <td><span class="label label-<?php if($item['status'] == 100){echo 'default';}elseif($item['status'] == 400){echo 'warning';}else{echo $item['status'] == 250 ||  $item['status'] == 410? 'danger' : 'success';} ?> radius"><?php echo $item['status_name'] ?></span></td>
                    <td><?php if (! empty($item['tx_url'])): ?><a href="<?php echo $item['tx_url'] ?>">点击查看</a><?php else: echo '无'; endif; ?></td>
                    <td><?php echo $item['create_time'] ?></td>
                    <td>
                        <?php if ($item['status'] == 100): ?>
                        <a href="/trade/do_identify/<?php echo $item['id'] . '/pass'?>" class="btn btn-primary-outline radius pass-confirm pass">通过</a>
                        <a href="/trade/do_identify/<?php echo $item['id'] . '/nopass'?>" class="btn btn-primary-outline radius pass-confirm nopass">不通过</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
            <?php echo $page_view ?>
		</article>
	</div>
</section>
<script>
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
    layui.use(['layer'], function(){
        
        $('.pass-confirm').click(function (e) {
            var that = $(this);
            e.preventDefault();
            var is_pass = $(this).hasClass('pass');
            var tips_text = is_pass ? '确定通过吗?' : '确定不通过吗?';
            layer.confirm(tips_text, function (e) {
                var api = that.attr('href');
                var data = {};              
                $.ajax({
                    url: api,
                    dataType: 'json',
                    type: 'get',
                    success: function (data) {
                        console.log(data)
                        if (data.errcode == 100) {
                            layer.msg('成功', {
                                    icon: 1,
                                    time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                }, function(){
                                    location.href = location.href;
                                });   
                        }else{
                            layer.msg(data.msg, {
                                    icon: 1,
                                    time: 1000 //2秒关闭（如果不配置，默认是3秒）
                                }, function(){
                                    location.href = location.href;
                                });  
                        }
                    }
                })
            });
        });
    })

</script>