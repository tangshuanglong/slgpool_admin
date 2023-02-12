<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/admin/index" class="maincolor">管理员管理</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($data['action'] == 'add'): echo '添加管理员'; ?><?php else: echo '编辑管理员' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
            <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <input type="password" name="password" style="display:none">
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">账号：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="text" id="account" name="account" class="input-text" value="<?php if (isset($data['role_user']['account']) && ! empty($data['role_user']['account'])): echo $data['role_user']['account']; endif; ?>" autocomplete="off" placeholder="账号">
                    </div>
                </div>
                <?php if ($data['action'] == 'edit'): ?>
                    <input type="hidden" name="id" value="<?php if (isset($data['role_user']['id']) && ! empty($data['role_user']['id'])): echo $data['role_user']['id']; endif; ?>">
                <?php else: ?>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">密码：</label>
                    <div class="formControls col-xs-3 col-sm-5">
                        <input type="password" id="password" name="password" class="input-text" autocomplete="off">
                    </div>
                </div>
                <?php endif; ?>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">类型：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <select name="admin_type" id="admin_type" class="select" size="1" style="height: 35px">
                            <option value="0" <?php if(isset($data['role_user']['admin_type']) && $data['role_user']['admin_type'] === '0'){echo 'selected=selected';}?>>普通管理员</option>
                            <option value="1" <?php if(isset($data['role_user']['admin_type']) && $data['role_user']['admin_type'] === '1'){echo 'selected=selected';}?>>超级管理员</option>
                        </select>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">所属角色：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-5">
                        <?php foreach($data['role'] as $value): ?>
                        <div class="check-box">
                            <input name="role_id[]" type="checkbox" value="<?php echo $value['role_id']?>"
                                <?php if(isset($data['role_user']['role_all_id']) && !empty($data['role_user']['role_all_id'])):?>
                                   <?php foreach($data['role_user']['role_all_id'] as $val):?>
                                   <?php if($val === $value['role_id']):?>
                                   checked="checked"
                                   <?php endif; ?>
                                   <?php endforeach;?>
                                <?php endif; ?>
                                   >
                            <label><?php echo $value['role_name']?></label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-1">
                        <input type="hidden" name="action" value="<?php echo $data['action']; ?>">

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
                url: '/admin/do_form',
                data: curform.serialize(),
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    console.log(e)
                    if (e.code != 0) {
                        $.Huimodalalert(e.msg, 5000)
                    } else {
                        $.Huimodalalert(e.msg, 3000);
                        setTimeout(function() {
                            location.href = '/admin/index';
                        }, 3100);
                    }
                }
            });
            return false;
        }
    });
});
</script>
