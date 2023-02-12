<style>
    .qr_file{
        display:none;
    }
    .qr-code-img{
        width:350px;
        height:200px;
        border: 1px #ccc solid;
        text-align: center;
        vertical-align: middle;
        display: table-cell;
        cursor: pointer;
    }
    .upfile-btn{
        display:inline-block;
    }
    .qr_code_path{
        max-width: 100%;
        max-height: 100%;
    }
</style>

<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/banner/pc_index" class="maincolor">首页轮播图片管理</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($data['action'] == 'add'): echo '添加PC图片'; ?><?php else: echo '编辑PC图片' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
        <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">排序号：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="order_number" name="order_number" class="input-text" value="<?php if (isset($data['info']['order_number']) && ! empty($data['info']['order_number'])): echo $data['info']['order_number']; endif; ?>" autocomplete="off" placeholder="排序号">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">pc端图片：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input name="file" id="pc_file" class="qr_file" type="file"/>
                        <div class="pc-upfile-btn qr-code-img">
                            <?php if(isset($data['info']['img_src']) && ! empty($data['info']['img_src'])):?>
                                <img id="pc_src" class="qr_code_path" src="<?php echo $data['info']['img_src']; ?>">
                            <?php else: ?>
                            <img id="pc_src" class="qr_code_path" src="">
                            <div class="pc-upfile-btn">点击上传图片</div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">pc端跳转路径：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="pc_link_href" name="pc_link_href" class="input-text" value="<?php if (isset($data['info']['link_href']) && ! empty($data['info']['link_href'])): echo $data['info']['link_href']; endif; ?>" autocomplete="off" placeholder="pc端跳转路径">
                    </div>
                </div>
                 <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">语言类型：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box">
                            <select class="select" size="1" name="lang_type" id="type">
                                <option value="" <?php echo $data['action'] == 'add' ? 'selected' : ''; ?>>请选择语言类型</option>
                                <?php foreach ($data['langs'] as $item): ?>
                                <option value="<?php echo $item['type_code'] ?>" <?php if (isset($data['info']['lang_type']) && $data['info']['lang_type'] == $item['type_code']): echo 'selected'; endif; ?>><?php echo $item['type_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">状态：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box ">
                          <select class="select" size="1" name="status">
                            <option value="1"
                            <?php
                            if (isset($data['info']['status']) && ! empty($data['info']['status'])){
                                if($data['info']['status'] == 1){ echo "selected";}
                            }
                            ?> >使用</option>
                            <option value="0"
                            <?php
                            if (isset($data['info']['status']) && ! empty($data['info']['status'])){
                                if($data['info']['status'] != 1){ echo "selected";}
                            }
                            ?>
                            >停用</option>
                          </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">描述：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="content" name="content" class="input-text" value="<?php if (isset($data['info']['content']) && ! empty($data['info']['content'])): echo $data['info']['content']; endif; ?>" autocomplete="off" placeholder="描述">
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-1">
                        <input type="hidden" name="action" value="<?php echo $data['action']; ?>">
                        <?php if ($data['action'] == 'edit'): ?>
                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
                        <?php endif; ?>
                        <input class="hidden" name="domain" id="domain" value="<?php if (isset($data['info']['domain']) && ! empty($data['info']['domain'])): echo $data['info']['domain']; endif; ?>">
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
<script src="/static/js/idSetup.js"></script>
<script>
$(function() {
    $(".pc-upfile-btn").click(function(){
        $("#pc_file").click();
    });
    uploadImg("pc_file","pc_src");

    var validform = $('form').Validform({
        datatype: {
            'regex_price': function(gets, obj ,curform, regxp){
                return /^([1-9]\d*|[0]?)(\.\d*)?$/.test(gets);
            },
            'regex_en_short': function(gets, obj ,curform, regxp){
                return /^([A-Za-z_])+$/.test(gets);
            },
        },
        postonce: true,
        beforeSubmit: function(curform) {
            var pc_src = $("#pc_src").attr('src');
            $.ajax({
                url: '/banner/pc_do_banner',
                data: curform.serialize() + "&img_src=" + pc_src,
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    if (e.code != 0) {
                        $.Huimodalalert(e.msg, 3000)
                    } else {
                        $.Huimodalalert(e.msg, 3000);
                        setTimeout(function() {
                            location.href = '/banner/pc_index';
                        }, 3100);
                    }
                }
            });
            return false;
        }
    });
//    validform.addRule([
//        {
//            ele: "#order_number",
//            datatype: "n1-3",
//            nullmsg: "请输入排序号",
//            errormsg: "排序号至少1个字符，最多3个字符"
//        },
//        {
//            ele: "#pc_src",
//            datatype: "*1-250",
//            nullmsg: "请输入pc端路径",
//            errormsg: "pc端路径至少6个字符，最多250个字符"
//        },
//        {
//            ele: "#wap_src",
//            datatype: "*1-250",
//            nullmsg: "请输入wap端路径",
//            errormsg: "wap端路径至少6个字符，最多250个字符"
//        }
//    ]);
});
</script>
