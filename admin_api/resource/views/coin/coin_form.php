<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/coin/index" class="maincolor">币种管理</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($data['action'] == 'add'): echo '添加币种'; ?><?php else: echo '编辑币种' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
      <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">币种名称（中文）：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="coin_name_cn" name="coin_name_cn" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['coin_name_cn']; endif; ?>" autocomplete="off" placeholder="币种名(中文)">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">币种名称（英文）：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="coin_name_en_complete" name="coin_name_en_complete" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['coin_name_en_complete']; endif; ?>" autocomplete="off" placeholder="币种名(英文)">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">币种名称（缩写）：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="coin_name_en" name="coin_name_en" class="input-text" <?php if ($data['action'] == 'edit'): ?>readonly<?php endif; ?> value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['coin_name_en']; endif; ?>" autocomplete="off" placeholder="币种名(英文)">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">USDT默认价格：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="usdt_price" name="usdt_price" class="input-text" autocomplete="off" value="<?php if (isset($data['info']) && ! empty($data['info'])):  endif; ?>" placeholder="USDT默认价格">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">BTC默认价格：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="btc_price" name="btc_price" class="input-text" autocomplete="off" placeholder="BTC默认价格" value="<?php if (isset($data['info']) && ! empty($data['info'])): endif; ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">ETH默认价格：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="eth_price" name="eth_price" class="input-text" autocomplete="off" placeholder="ETH默认价格" value="<?php if (isset($data['info']) && ! empty($data['info'])):  endif; ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">充值状态：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="charge_status" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['charge_status'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">提现状态：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="get_cash_status" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['get_cash_status'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">充缓慢：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="is_deposit_slow" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['is_deposit_slow'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">提缓慢：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="is_withdraw_slow" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['is_withdraw_slow'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">锁仓状态：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="lock_status" <?php   ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否允许与USDT直接币币交易：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="allow_trade_with_usdt" <?php  ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否允许与BTC直接币币交易：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="allow_trade_with_btc" <?php  ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否允许与ETH直接币币交易：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="allow_trade_with_eth" <?php  ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否开启otc交易：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <div class="check-box">
                            <input name="is_otc" <?php  ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">OTC最小交易数量：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="otc_min_amount" name="otc_min_amount" class="input-text" autocomplete="off" placeholder="" value="<?php ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">是否显示：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="show_flag" id="show_flag">
                                <option value=1 <?php if (isset($data['info']) && ! empty($data['info']) && $data['info']['show_flag'] == 1): echo 'selected'; endif; ?>>显示</option>
                                <option value=0 <?php if (isset($data['info']) && ! empty($data['info']) && $data['info']['show_flag'] == 0): echo 'selected'; endif; ?>>不显示</option>
                                <option value=2 <?php if (isset($data['info']) && ! empty($data['info']) && $data['info']['show_flag'] == 2): echo 'selected'; endif; ?>>显示但不交易</option>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">交易区：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="chain_type" id="chain_type">

                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">热钱包阔值：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="theshold_of_hot_wallet" name="theshold_of_hot_wallet" class="input-text" autocomplete="off" placeholder="当低于该阔值需提醒热钱包余额不够" value="<?php  ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">用户冷钱包账户资产阔值：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="theshold_of_transfer" name="theshold_of_transfer" class="input-text" autocomplete="off" placeholder="当高于该阔值时需把当前该钱包所有资产全部转移到总冷钱包" value="<?php  ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">存量：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="inventory" name="inventory" class="input-text" autocomplete="off" placeholder="存量" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['inventory']; else: echo 100000; endif; ?>" datatype="n">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">总发行量：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="total_public_number" name="total_public_number" class="input-text" autocomplete="off" placeholder="总发行量" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['total_public_number']; else: echo 100000; endif; ?>" datatype="n">
                    </div>
                </div>
                <div class="row cl">
                  <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">发行日期：</label>
                  <div class="input-group date form_time col-xs-3 col-sm-5" data-date="<?php if (isset($data['info'])): echo $data['info']['public_date']; endif; ?>"  data-link-field="dtp_input3">
                    <input class="form-control" id="public_date" name='public_date' size="16" type="text" value="<?php if (isset($data['info'])): echo $data['info']['public_date']; endif; ?>" readonly>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                    <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                  </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">官网地址：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="official_website_link" name="official_website_link" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['official_website_link']; endif; ?>" autocomplete="off" placeholder="官网地址">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">钱包地址：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="official_wallet_link" name="official_wallet_link" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['official_wallet_link']; endif; ?>" autocomplete="off" placeholder="钱包地址">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">源码地址：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="source_code_link" name="source_code_link" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['source_code_link']; endif; ?>" autocomplete="off" placeholder="源码地址">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">挖矿地址：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="mining_link" name="mining_link" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['mining_link']; endif; ?>" autocomplete="off" placeholder="挖矿地址">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">论坛地址：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="forum_link" name="forum_link" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['forum_link']; endif; ?>" autocomplete="off" placeholder="论坛地址">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">区块链浏览器地址：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="block_chain_explorer_link" name="block_chain_explorer_link" class="input-text" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['block_chain_explorer_link']; endif; ?>" autocomplete="off" placeholder="区块链浏览器地址">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">简介：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <script name="coin_introduction" type="text/plain" id="myEditor" style="width:1000px;height:240px;"><?php if (isset($data['info'])): echo $data['info']['coin_introduction']; endif; ?></script>
                        <!-- <textarea class="textarea" placeholder="说点什么..." rows="" cols="" id="coin_introduction" name="coin_introduction"><?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['coin_introduction']; endif; ?></textarea> -->
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
<script type="text/javascript" charset="utf-8" src="/static/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/lib/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/static/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/static/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/static/bootstrap/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script>
$(function() {
  $('.form_time').datetimepicker({
    language:  'zh-CN',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    // todayHighlight: 1,
    // startView: 1,
    // minView: 0,
    // maxView: 1,
    // forceParse: 0,
    format: 'yyyy-mm-dd hh:ii:ss',
    viewSelect: 4
  });

  var ue = UE.getEditor('myEditor', {
    toolbars: [[
      'fullscreen', 'source', '|', 'undo', 'redo', '|',
      'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
      'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
      'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
      'directionalityltr', 'directionalityrtl', 'indent', '|',
      'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
      'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
      'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'attachment', 'map', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
      'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
      'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
      'print', 'preview', 'searchreplace', 'help'
    ]],
    autoHeight: true,
    initialFrameHeight: 300
  });

    var validform = $('form').Validform({
        datatype: {
            regex_price: function(gets, obj ,curform, regxp){
                return /^([1-9]\d*|[0]?)(\.\d*)?$/.test(gets);
            },
        },
        postonce: true,
        beforeSubmit: function(curform) {
            $.ajax({
                url: '/coin/do_coin',
                data: curform.serialize(),
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    console.log(e);
                    if (e.code != 0) {
                        $.Huimodalalert(e.msg, 3000)
                    } else {
                        $.Huimodalalert('成功', 3000);
                        setTimeout(function() {
                            location.href = '/coin/index';
                        }, 3100);
                    }
                }
            });
            return false;
        }
    });
    // validform.addRule([
    //     {
    //         ele: "#coin_name_cn",
    //         datatype: "*1-32",
    //         nullmsg: "请输入币种名称（中文）",
    //         errormsg: "币种名称（中文）至少6个字符，最多32个字符"
    //     },
    //     {
    //         ele: "#coin_name_en",
    //         datatype: "*1-32",
    //         nullmsg: "请输入币种名称（英文）",
    //         errormsg: "币种名称（英文）至少6个字符，最多32个字符"
    //     },
    //     {
    //         ele: "#usdt_price",
    //         datatype: "*,regex_price",
    //         nullmsg: "请输入USDT价格",
    //         errormsg: "USDT价格必须为数值"
    //     },
    //     {
    //         ele: "#btc_price",
    //         datatype: "*,regex_price",
    //         nullmsg: "请输入BTC价格",
    //         errormsg: "BTC价格必须为数值"
    //     },
    //     {
    //         ele: "#eth_price",
    //         datatype: "*,regex_price",
    //         nullmsg: "请输入ETH价格",
    //         errormsg: "ETH价格必须为数值"
    //     },
    //     {
    //         ele: "#total_public_number",
    //         datatype: "*,regex_price",
    //         nullmsg: "请输入总发行量",
    //         errormsg: "总发行量必须为数值"
    //     },
    //     {
    //         ele: "#public_date",
    //         datatype: "*",
    //         nullmsg: "请输入发行日期",
    //         errormsg: "请输入发行日期"
    //     },
    //     {
    //         ele: "#min_withdraw_amount",
    //         datatype: "*,regex_price",
    //         nullmsg: "请输入最小提币数量",
    //         errormsg: "最小提币数量必须为数值"
    //     },
    //     {
    //         ele: "#max_withdraw_amount",
    //         datatype: "*,regex_price",
    //         nullmsg: "请输入最大提币数量",
    //         errormsg: "最大提币数量必须为数值"
    //     },
    //     {
    //         ele: "#inventory",
    //         datatype: "*,regex_price",
    //         nullmsg: "请输入存量",
    //         errormsg: "存量必须为数值"
    //     },
    //     {
    //         ele: "#withdraw_handling_fee",
    //         datatype: "*",
    //         nullmsg: "请输入提币费率",
    //         errormsg: "请输入提币费率"
    //     }
    // ]);
});
</script>
