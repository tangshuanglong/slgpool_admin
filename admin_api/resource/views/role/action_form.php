<section class="Hui-article-box">
<nav class="breadcrumb"><i class="Hui-iconfont"></i> <a href="/admin" class="maincolor">首页</a> <span class="c-999 en">&gt;</span><a href="/role/action" class="maincolor">权限列表</a> <span class="c-999 en">&gt;</span><span class="c-666"><?php if ($data['action'] == 'add'): echo '添加权限'; ?><?php else: echo '编辑权限' ?><?php endif; ?></span></nav>
	<div class="Hui-article">
	<article class="cl pd-20">
    <form action="form.php" class="form form-horizontal" method="post" accept-charset="utf-8">
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">权限名：</label>
                    <div class="formControls col-xs-3 col-sm-6">
                        <input type="text" id="action_name" name="action_name" class="input-text" value="<?php if (isset($data['info']['action_name']) && ! empty($data['info']['action_name'])): echo $data['info']['action_name']; endif; ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">权限url(/控制器/方法)：</label>
                    <div class="formControls col-xs-3 col-sm-6">
                        <input type="text" id="action_url" name="action_url" class="input-text" value="<?php if (isset($data['info']['action_url']) && ! empty($data['info']['action_url'])): echo $data['info']['action_url']; endif; ?>">
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">层级：</label>
                    <div class="formControls col-xs-3 col-sm-6">
                        <select name="label" id="label" class="select" size="1" style="height: 35px">
                            <option value="0">请选择</option>
                            <option value="1">第一层</option>
                            <option value="2">第二层</option>
                            <option value="3">第三层</option>
                        </select>
                    </div>
                </div>
                <div class="row cl">
                    <label class="form-label col-xs-3 col-sm-3 col-md-1 col-lg-1">父级权限名：</label>
                    <div class="formControls col-xs-3 col-sm-6">
                        <select name="parent_id" id="parent_id" class="select" size="1" style="height: 35px" disabled="true">
                        </select>
                    </div>
                </div>
                <div class="row cl">
                    <div class="col-xs-8 col-sm-9 col-xs-offset-3 col-sm-offset-3 col-md-offset-1">
                        <input type="hidden" name="action" value="<?php echo $data['action']; ?>">
                        <?php if ($data['action'] == 'edit'): ?>
                        <input type="hidden" name="action_id" value="<?php echo $data['info']['action_id'] ?>">
                        <?php endif; ?>
                        <input class="btn btn-primary radius" type="submit" id="submit" value="提交">
                    </div>
                </div>
            </form>
	</article>
	</div>
</section>
<script>
    $(function () {
        var label = <?php echo isset($data['info']['label']) ? $data['info']['label'] : '0';?>;
        $("#label").find("option[value='" + label +"']").prop('selected', true);
        get_label(label);

        var validform = $('form').Validform({
            beforeSubmit: function(curform) {
                var submit = $("#submit");
                $.ajax({
                    url: '/role/do_action_form',
                    data: curform.serialize(),
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function() {
                        submit.prop('disabled', true);
                    },
                    success: function(e) {
                        if (e.code != 0) {
                            $.Huimodalalert(e.msg, 3000)
                        } else {
                            $.Huimodalalert(e.msg, 1000);
                            setTimeout(function() {
                                location.href = '/role/action';
                            }, 1000);
                        }
                    },
                    complete: function() {
                       submit.prop('disabled', false);
                    }
                });
                return false;
            }
        });

        $("#label").change(function(){
            var val = $(this).val();
            get_label(val);
        });

        function get_label(label){
            var parent_obj = $("#parent_id");
            if(label == '0'){
                parent_obj.empty();
                parent_obj.prop('disabled', true);
                return;
            }
            var parent_id = <?php echo isset($data['info']['parent_id']) ? $data['info']['parent_id'] : 'null';?>;
            $.ajax({
                url: '/role/get_label/' + label,
                type: 'get',
                dataType: 'json',
                success: function(json){
                    console.log(json.body.length);
                    if(json.body.length != 0 && json.body.length != undefined){
                        var list = json.body;
                        var len = list.length;
                        parent_obj.prop('disabled', false);
                        parent_obj.empty();
                        for(var i = 0; i < len; i++){
                            if(list[i]['action_id'] == parent_id){
                                parent_obj.append("<option value=" + list[i]['action_id'] +" selected=selected>" + list[i]['action_name'] + "</option>");
                            } else {
                                parent_obj.append("<option value=" + list[i]['action_id'] +">" + list[i]['action_name'] + "</option>");
                            }
                        }
                    }else{
                        parent_obj.prop('disabled', false);
                        parent_obj.empty();
                        parent_obj.append("<option value='0'>无</option>");
                    }
                }
            });
        }
    })
</script>
