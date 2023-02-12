<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/" class="maincolor">首页轮播图片管理</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($action == 'add'): echo '添加图片'; ?><?php else: echo '编辑图片' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <?php echo form_open('/Bannerimg/do_bannerimg', array('class' => "form form-horizontal")) ?>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">排序号：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="order_number" name="order_number" class="input-text" value="<?php if (isset($active) && ! empty($active)): echo $active['order_number']; endif; ?>" autocomplete="off" placeholder="排序号">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">上传pc端图片：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <button type="button" class="layui-btn upload" id="upload_pc" upload_path="./static/images/">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button> 
                        <img width=192 height=40 id="upload_pc_img" <?php if (isset($active) && isset($active['pc_src']) && ! empty($active['pc_src'])): echo "src='".API_BASE_DOMAIN."/static{$active['pc_src']}'"; endif; ?>>
                        <input type="hidden" id="upload_pc_input" name="pc_src" value="<?php if ( isset($active) && isset($active['pc_src']) ){ echo $active['pc_src'];} ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">pc端跳转路径：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="pc_link_href" name="pc_link_href" class="input-text" value="<?php if (isset($active) && ! empty($active)): echo $active['pc_link_href']; endif; ?>" autocomplete="off" placeholder="pc端跳转路径">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">上传wap端图片：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <button type="button" class="layui-btn upload" id="upload_wap" upload_path="./static/img/">
                            <i class="layui-icon">&#xe67c;</i>上传图片
                        </button> 
                        <img width=99 height=40 id="upload_wap_img" <?php if (isset($active) && isset($active['wap_src']) && ! empty($active['wap_src'])): echo "src='".WAP_BASE_DOMAIN."/static{$active['wap_src']}'"; endif; ?>>
                        <input type="hidden" id="upload_wap_input" name="wap_src" value="<?php if ( isset($active) && isset($active['wap_src']) ){ echo $active['wap_src'];} ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">wap端跳转路径：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="wap_link_href" name="wap_link_href" class="input-text" value="<?php if (isset($active) && ! empty($active)): echo $active['wap_link_href']; endif; ?>" autocomplete="off" placeholder="wap端跳转路径">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">状态：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <span class="select-box ">
                          <select class="select" size="1" name="status">
                            <option value="1" 
                            <?php
                            if (isset($active) && ! empty($active)){
                                if($active['status'] == 1){ echo "selected";}
                            }
                            ?> >使用</option>
                            <option value="0"
                            <?php
                            if (isset($active) && ! empty($active)){
                                if($active['status'] != 1){ echo "selected";}
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
                        <input type="text" id="content" name="content" class="input-text" value="<?php if (isset($active) && ! empty($active)): echo $active['content']; endif; ?>" autocomplete="off" placeholder="描述">
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

	layui.use(['layer', 'upload'], function(){
	    var upload = layui.upload;
	    upload.render({
	        elem: '#upload_pc'
	        ,url: '<?php echo API_BASE_DOMAIN ?>/api/service/do_upload_banner_img/'
	        ,field: 'userfile'
	        ,data : {'upload_path':$("#upload_pc").attr('upload_path')}
	        ,done: function(res, index, upload){ //上传后的回调
	            var type = $(this).attr('item').attr('id');
	            $("#"+type+"_img").attr("src","<?php echo API_BASE_DOMAIN."/";?>"+res.data.image_path);
	            $("#"+type+"_input").val(res.data.image_path);
	        } 
	    });  
	});

	layui.use(['layer', 'upload'], function(){
	    var upload = layui.upload;
	    upload.render({
	        elem: '#upload_wap'
	        ,url: '<?php echo API_BASE_DOMAIN ?>/api/service/do_upload_banner_img/'
	        ,field: 'userfile'
	        ,data : {'upload_path':$("#upload_wap").attr('upload_path')}
	        ,done: function(res, index, upload){ //上传后的回调
	        	var type = $(this).attr('item').attr('id');
	            $("#"+type+"_img").attr("src","<?php echo WAP_BASE_DOMAIN."/";?>"+res.data.image_path);
	            $("#"+type+"_input").val(res.data.image_path);
	        } 
	    });  
	});
	
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
            $.ajax({
                url: '/Bannerimg/do_bannerimg',
                data: curform.serialize(),
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    if (e.errcode != 100) {
                        $.Huimodalalert(e.msg, 5000)
                    } else {
                        $.Huimodalalert('成功', 3000);
                        setTimeout(function() {
                            location.href = '/Bannerimg/';
                        }, 3100);
                    }
                }
            });
            return false;
        }
    });
    validform.addRule([
        {
            ele: "#order_number",
            datatype: "n1-3",
            nullmsg: "请输入排序号",
            errormsg: "排序号至少1个字符，最多3个字符"
        },
        {
            ele: "#pc_src_input",
            datatype: "*1-250",
            nullmsg: "请输入pc端路径",
            errormsg: "pc端路径至少6个字符，最多250个字符"
        },
        {
            ele: "#wap_src_input",
            datatype: "*1-250",
            nullmsg: "请输入wap端路径",
            errormsg: "wap端路径至少6个字符，最多250个字符"
        }
    ]);
});
</script>