
<link href="/static/bootstrap/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" charset="utf-8" src="/static/lib/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/static/lib/ueditor/ueditor.all.min.js"></script>
<script type="text/javascript" src="/static/lib/ueditor/lang/zh-cn/zh-cn.js"></script>

<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/article/index" class="maincolor">文章管理</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($data['action'] == 'add'): echo '添加文章'; ?><?php else: echo '编辑文章' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
		<article class="cl pd-20">
      <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">标题：</label>
                    <div class="formControls col-xs-4 col-sm-7">
                        <input type="text" id="title" name="title" class="input-text" autocomplete="off" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['title']; endif;?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">标题是否红色：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-7">
                        <div class="check-box">
                            <input name="is_red" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['is_red'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">标题是否加粗：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-7">
                        <div class="check-box">
                            <input name="is_bold" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['is_bold'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">文章类型：</label>
                    <div class="formControls col-xs-4 col-sm-7">
                        <span class="select-box">
                            <select class="select" size="1" name="type" id="type">
                                <option value="" <?php echo $data['action'] == 'add' ? 'selected' : ''; ?>>请选择文章类型</option>
                                <?php foreach ($data['types'] as $item): ?>
                                <option value="<?php echo $item['type_code'] ?>" <?php if (isset($data['info']) && $data['info']['type'] == $item['type_code']): echo 'selected'; endif; ?>><?php echo $item['type_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">语言类型：</label>
                    <div class="formControls col-xs-4 col-sm-7">
                        <span class="select-box">
                            <select class="select" size="1" name="lang_type" id="type">
                                <option value="" <?php echo $action == 'add' ? 'selected' : ''; ?>>请选择语言类型</option>
                                <?php foreach ($data['langs'] as $item): ?>
                                <option value="<?php echo $item['type_code'] ?>" <?php if (isset($data['info']) && $data['info']['lang_type'] == $item['type_code']): echo 'selected'; endif; ?>><?php echo $item['type_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">发布日期：</label>
                    <div class="input-group date form_time col-md-7" data-date="<?php if (isset($data['info'])): echo $data['info']['create_time']; endif; ?>"  data-link-field="dtp_input3">
                        <input class="form-control" name='create_time' size="16" type="text" value="<?php if (isset($data['info'])): echo $data['info']['create_time']; endif; ?>" readonly>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                        <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">是否显示：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-7">
                        <div class="check-box">
                            <input name="status" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['status'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">是否置顶：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-7">
                        <div class="check-box">
                            <input name="is_top" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['is_top'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">是否轮播：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-7">
                        <div class="check-box">
                            <input name="is_carousel" <?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['is_carousel'] == 1 ? 'checked' : ''; else: echo 'checked'; endif; ?> type="checkbox">
                        </div>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">排序：</label>
                    <div class="formControls skin-minimal col-xs-3 col-sm-7">
                        <input type="text" id="order_num" name="order_num" class="input-text" autocomplete="off" value="<?php if (isset($data['info']) && ! empty($data['info'])): echo $data['info']['order_num']; endif;?>">
                    </div>
                </div>
                <div class="row cl">
                  <label class="form-label col-xs-4 col-sm-3 col-md-1 col-lg-1">内容：</label>
                  <div class="col-xs-4 col-sm-7">
                    <script id="content" name="content" type="text/plain">
                              <?php if (isset($data['info'])): echo $data['info']['content']; endif; ?>
                            </script>
                  </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-1">
                        <input type="hidden" name="action" value="<?php echo $data['action']; ?>">
                        <?php if ($data['action'] == 'edit'): ?>
                        <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
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
<script type="text/javascript" src="/static/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="/static/bootstrap/js/locales/bootstrap-datetimepicker.zh-CN.js" charset="UTF-8"></script>
<script>
$(function() {
    var ue = UE.getEditor('content', {
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

    var validform = $('form').Validform({
        datatype: {
            'regex_price': function(gets, obj ,curform, regxp){
                return /^([1-9]\d*|[0]?)(\.\d*)?$/.test(gets);
            },
        },
        postonce: true,
        beforeSubmit: function(curform) {
            $.ajax({
                url: '/article/do_article',
                data: curform.serialize(),
                type: 'post',
                dataType: 'json',
                success: function(e) {
                    console.log(e)
                    if (e.code != 0) {
                        $.Huimodalalert(e.msg, 3000)
                    } else {
                        setTimeout(function() {
                            location.href = '/article/index';
                        }, 1000);
                    }
                }
            });
            return false;
        }
    });
    // validform.addRule([
    //     {
    //         ele: "#title",
    //         datatype: "*",
    //         nullmsg: "请输入标题",
    //         errormsg: "请输入标题"
    //     },
    //     {
    //         ele: "[name='content']",
    //         datatype: "*",
    //         nullmsg: "请输入内容",
    //         errormsg: "请输入内容"
    //     },
    //     {
    //         ele: "[name='type']",
    //         datatype: "*",
    //         nullmsg: "请选择文章类型",
    //         errormsg: "请选择文章类型"
    //     }
    // ]);
});
</script>
