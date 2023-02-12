<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/coin/index" class="maincolor">币种管理</a> <span class="c-999 en">&gt;</span><a href="/chain/index" class="maincolor">公链列表</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($data['action'] == 'add'): echo '添加公链'; ?><?php else: echo '编辑公链' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
      <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">公链名：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="chain_name" name="chain_name" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['chain_name']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">热钱包地址/账户名：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="system_hot_wallet" name="system_hot_wallet" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['system_hot_wallet']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">冷钱包地址/账户名：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="system_cold_wallet" name="system_cold_wallet" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['system_cold_wallet']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">区块确认数：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="confirmation_time" name="confirmation_time" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['confirmation_time']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否基于石墨烯技术：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="is_graphene" id="is_graphene">
                                <option value=1 <?php if (isset($data['info']) && ! empty($data['info']) && $data['info']['is_graphene'] == 1): echo 'selected'; endif; ?>>是</option>
                                <option value=0 <?php if (isset($data['info']) && ! empty($data['info']) && $data['info']['is_graphene'] == 0): echo 'selected'; endif; ?>>否</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否匿名：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="is_anonymous" id="is_anonymous">
                                <option value=1 <?php if (isset($data['info']) && ! empty($data['info']) && $data['info']['is_anonymous'] == 1): echo 'selected'; endif; ?>>是</option>
                                <option value=0 <?php if (isset($data['info']) && ! empty($data['info']) && $data['info']['is_anonymous'] == 0): echo 'selected'; endif; ?>>否</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-1">
                        <input type="hidden" name="action" value="<?php echo $data['action']; ?>">
                        <?php if ($data['action'] == 'edit'): ?>
                        <input type="hidden" name="id" value="<?php echo $data['info']['id'] ?>">
                        <?php endif; ?>
                        <input class="btn btn-primary radius" type="submit" value="提交">
                    </div>
                </div>
            </form>
		</article>
	</div>
</section>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/static/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script>
$(function() {
    var validform = $('form').Validform({
        datatype: {
            regex_price: function(gets, obj ,curform, regxp){
                return /^([1-9]\d*|[0]?)(\.\d*)?$/.test(gets);
            },
        },
        postonce: true,
        beforeSubmit: function(curform) {
            $.ajax({
                url: '/chain/do_chain',
                data: curform.serialize(),
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    console.log(e)
                    if (e.code != 0) {
                        $.Huimodalalert(e.msg, 3000)
                    } else {
                        $.Huimodalalert('成功', 3000);
                        setTimeout(function() {
                            location.href = '/chain/index';
                        }, 3100);
                    }
                }
            });
            return false;
        }
    });
});
</script>
