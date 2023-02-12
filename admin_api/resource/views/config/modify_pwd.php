<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/" class="maincolor">设置</a> <span class="c-999 en">&gt;</span><span class="c-666">修改密码</span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
        <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">旧密码：</label>
                    <div class="formControls col-xs-2 col-sm-2">
                        <input type="password" id="pwd1" name="pwd1" class="input-text" autocomplete="off">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">新密码：</label>
                    <div class="formControls col-xs-2 col-sm-2">
                        <input type="password" id="pwd2" name="pwd2" class="input-text" autocomplete="off">
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-1">
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
        datatype: {},
        postonce: true,
        beforeSubmit: function(curform) {
            $.ajax({
                url: location.href,
                data: curform.serialize(),
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    if (e.code != 0) {
                        $.Huimodalalert(e.msg, 5000)
                    } else {
                        $.Huimodalalert('成功', 3000);
                        // setTimeout(function() {
                        //     location.href = '/';
                        // }, 3100);
                    }
                }
            });
            return false;
        }
    });
});
</script>
