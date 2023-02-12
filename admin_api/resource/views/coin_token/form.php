<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/coin/index" class="maincolor">币种管理</a> <span class="c-999 en">&gt;</span><a href="/coin_token/index?chain_id=<?php echo $chain_id?>" class="maincolor">TOKEN列表</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($action == 'add'): echo '添加公链'; ?><?php else: echo '编辑公链' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
        <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">公链：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="chain_id" id="chain_id">
                                <option value="" <?php echo $action == 'add' ? 'selected' : ''; ?>>请选择类型</option>
                                <?php foreach ($chains as $item): ?>
                                <option value="<?php echo $item['id'] ?>" <?php if (isset($chain_id) && $chain_id == $item['id']): echo 'selected'; endif; ?>><?php echo $item['chain_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">币种：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="coin_name" id="coin_name">
                                <option value="" <?php echo $action == 'add' ? 'selected' : ''; ?>>请选择币种</option>
                                <?php foreach ($coins as $item): ?>
                                <option value="<?php echo $item['coin_name_en'] ?>" <?php if (isset($token) && $token['coin_name'] == $item['coin_name_en']): echo 'selected'; endif; ?>><?php echo $item['coin_name_en'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否主代币：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="is_main" id="is_main">
                                <option value=1 <?php if (isset($token) && ! empty($token) && $token['is_main'] == 1): echo 'selected'; endif; ?>>是</option>
                                <option value=0 <?php if (isset($token) && ! empty($token) && $token['is_main'] == 0): echo 'selected'; endif; ?>>否</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否上架：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="cancel_flag" id="cancel_flag">
                                <option value=0 <?php if (isset($token) && ! empty($token) && $token['cancel_flag'] == 0): echo 'selected'; endif; ?>>上架</option>
                                <option value=1 <?php if (isset($token) && ! empty($token) && $token['cancel_flag'] == 1): echo 'selected'; endif; ?>>下架</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">系统提现阔值：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="withdraw_theshold" name="withdraw_theshold" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['withdraw_theshold']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">热钱包余额预警值：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="warning_amount" name="warning_amount" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['warning_amount']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>

              <div class="row cl">
                <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">最小充值数量：</label>
                <div class="formControls col-xs-3 col-sm-5">
                  <input type="text" id="min_deposit" name="min_deposit" class="input-text" autocomplete="off" placeholder="" value="<?php if (isset($coin) && ! empty($coin)): echo $coin['min_deposit']; endif; ?>" datatype="n">
                </div>
              </div>
              <div class="row cl">
                <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">最小提币数量：</label>
                <div class="formControls col-xs-3 col-sm-5">
                  <input type="text" id="min_withdraw" name="min_withdraw" class="input-text" autocomplete="off" placeholder="" value="<?php if (isset($coin) && ! empty($coin)): echo $coin['min_withdraw']; endif; ?>" datatype="n">
                </div>
              </div>
              <div class="row cl">
                <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">最大提币数量：</label>
                <div class="formControls col-xs-3 col-sm-5">
                  <input type="text" id="max_withdraw" name="max_withdraw" class="input-text" autocomplete="off" placeholder="" value="<?php if (isset($coin) && ! empty($coin)): echo $coin['max_withdraw']; endif; ?>" datatype="n">
                </div>
              </div>

                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">区块链浏览器：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="explorer_url" name="explorer_url" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['explorer_url']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">address/account拼接参数：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="explorer_url_parameter_address" name="explorer_url_parameter_address" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['explorer_url_parameter_address']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">tx拼接参数：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="explorer_url_parameter_tx" name="explorer_url_parameter_tx" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['explorer_url_parameter_tx']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">区块号(可选)：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="next_start_sequence" name="next_start_sequence" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['next_start_sequence']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">合约地址(可选)：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="contract_address" name="contract_address" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['contract_address']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">ABI CODE(可选)：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <textarea id="contract_abi" name="contract_abi" autocomplete="off" placeholder=""><?php if (isset($token) && ! empty($token)): echo $token['contract_abi']; endif; ?></textarea>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">精度(可选)：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="decimals" name="decimals" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['decimals']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">Omnilayer property id(可选)：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="property_id" name="property_id" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['property_id']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">资产ID(可选)：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="asset_id" name="asset_id" class="input-text" value="<?php if (isset($token) && ! empty($token)): echo $token['asset_id']; endif; ?>" autocomplete="off" placeholder="">
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-1">
                        <input type="hidden" name="action" value="<?php echo $action; ?>">
                        <?php if ($action == 'edit'): ?>
                        <input type="hidden" name="id" value="<?php echo $id ?>">
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
                url: '/coin_token/do_token',
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
                            location.href = '/coin_token/index/?chain_id=<?php echo $chain_id ?>';
                        }, 3100);
                    }
                }
            });
            return false;
        }
    });
});
</script>
