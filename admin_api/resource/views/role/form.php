<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/role/index" class="maincolor">角色管理</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($data['action'] == 'add'): echo '添加角色'; ?><?php else: echo '编辑角色' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
	<article class="cl pd-20">
            <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">角色名称：</label>
                    <div class="formControls col-xs-3 col-sm-6">
                        <input type="text" id="role_name" name="role_name" class="input-text" value="<?php if (isset($data['role']['role_name']) && ! empty($data['role']['role_name'])): echo $data['role']['role_name']; endif; ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">角色权限：</label>
                    <div class="formControls col-xs-3 col-sm-6">
                        <?php if(isset($data['info']['first']) && !empty($data['info']['first'])): ?>
                        <?php foreach($data['info']['first'] as $value):?>
                        <div class="checkbox" style="margin-bottom:5px;">
                            <label>
                                |—
                                <input class="first-Class" type="checkbox" value="<?php echo $value['action_id']; ?>" name="action_id[]" <?php if(isset($data['auth_id']) && in_array($value['action_id'], $data['auth_id'])):?>checked="checked"<?php endif; ?>> <?php echo $value['action_name']; ?>
                            </label>
                            <?php if(isset($value['second']) && !empty($value['second'])): ?>
                            <?php foreach($value['second'] as $val): ?>
                            <div class="checkbox" style="margin:5px 50px">
                                <label>
                                    |——
                                    <input class="second-Class" type="checkbox" value="<?php echo $val['action_id']; ?>" name="action_id[]" <?php if(isset($data['auth_id']) && in_array($val['action_id'], $data['auth_id'])):?>checked="checked"<?php endif; ?>> <?php echo $val['action_name']; ?>
                                </label>

                                <?php if(isset($val['third']) && !empty($val['third'])): ?>
                                <?php foreach($val['third'] as $v): ?>
                                <div class="checkbox-inline" style="margin:5px 50px" class="isoption">
                                    <label style="margin-right: 20px; float: left;">
                                        |———
                                        <input class="third-Class" type="checkbox" value="<?php echo $v['action_id']; ?>" name="action_id[]" <?php if(isset($data['auth_id']) && in_array($v['action_id'], $data['auth_id'])):?>checked="checked"<?php endif; ?>> <?php echo $v['action_name']; ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                                <div style="clear: both;"></div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-1">
                        <input type="hidden" name="action" value="<?php echo $data['action']; ?>">
                        <?php if ($data['action'] == 'edit'): ?>
                        <input type="hidden" name="role_id" value="<?php echo $data['role']['role_id'] ?>">
                        <?php endif; ?>
                        <input class="btn btn-primary radius" type="submit" value="提交">
                    </div>
                </div>
            </form>
	</article>
	</div>
</section>
<script>
    $(function () {
        $('.first-Class').on('click', function () {
        var $secondInput = $(this).parent().parent().find('.second-Class');
        var $thirdInput = $(this).parent().parent().find('.third-Class');
        $secondInput.prop("checked", $(this).is(':checked'));
        $thirdInput.prop("checked", $(this).is(':checked'));
        })
        $('.second-Class').on('click', function () {
        var $thirdInput = $(this).parent().parent().find('.third-Class');
        $thirdInput.prop("checked", $(this).is(':checked'));

        var $firstInput = $(this).parent().parent().parent().find('.first-Class');
        var $secondInputs = $(this).parent().parent().parent().find('.second-Class');
        checked($secondInputs, $firstInput);
        })
        $('.third-Class').on('click', function () {
        var $firstInput = $(this).parent().parent().parent().parent().find('.first-Class');
        var $secondInput = $(this).parent().parent().parent().find('.second-Class');
        var $thirdInputs = $(this).parent().parent().find('.third-Class');
        checked($thirdInputs, $secondInput);
        checked($secondInput, $firstInput);
        })

        function checked($childen, $parent) {
        var count = 0;
        $childen.each(function (index, value) {
        if ($(value).is(':checked')) {
        $parent.prop('checked', true);
        } else {
        count++;
        }
        })
        // if (count == $childen.length) {
        // $parent.prop('checked', false);
        // }
        }

        var validform = $('form').Validform({
            beforeSubmit: function(curform) {
                $.ajax({
                    url: '/role/do_form',
                    data: curform.serialize(),
                    type: 'post',
                    dataType: 'json',
                    success: function(e) {
                        console.log(e)
                        if (e.code != 0) {
                            $.Huimodalalert(e.msg, 3000)
                        } else {
                            $.Huimodalalert(e.msg, 1500);
                            setTimeout(function() {
                                location.href = '/role/index';
                            }, 1500);
                        }
                    }
                });
                return false;
            }
        });
    })
</script>
