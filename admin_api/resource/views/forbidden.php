
<section class="Hui-article-box">
	<div class="Hui-article">
            <div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">
            <h4>Not Forbidden</h4>
            <p>ErrorCode: <?php echo $data['code']; ?></p>
            <p>Message: <?php echo $data['msg']; ?></p>
            </div>
	</div>
</section>
<!--_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript">
    $(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	})});
	//连接ws
	var websocket_url = 'ws://47.75.186.197:8090';
    try {
        //ws = new ReconnectingWebSocket(websocket_url, 'chat'); //连接服务器
        var ws = new WebSocket(websocket_url, 'chat');
        ws.onopen = function (event) {
            console.log("已经与服务器建立了连接");
            var pong = {pong:0};
            setInterval(function(){
                ws.send(JSON.stringify(pong));
            },30000);
            var uid = "<?php echo $data['common_info']['user']['id']; ?>";
            var userInfo = {t: 'u', id: uid, data: ''};
            ws.send(JSON.stringify(userInfo));
        };
        ws.onmessage = function (event) {
            // console.log("接收到服务器发送的数据：\r\n" + event.data);

            try {
                var obj = JSON.parse(event.data);
                if(typeof(obj) != 'object') {
                    return;
                }
            } catch(e) {
                console.log(event.data)
                return;
            }
            if(obj.type == 'lock_amount'){
                var content = '<p>用户：'+ obj.data.real_name + '(' + obj.data.invite_id + ')</p><p>' + obj.message + '</p>';
                layer.msg(content, {
                    icon: 1,
                    time: 3000 //2秒关闭（如果不配置，默认是3秒）
                });
            }

        };
        ws.onclose = function (event) {
            console.log("已经与服务器断开连接");
        };
        ws.onerror = function (event) {
            console.log("WebSocket异常！");
        };
    } catch (ex) {
        alert('网络通讯不畅，请尝试刷新页面后重试！');
    }
</script>
<!--/请在上方写此页面业务相关的脚本-->

<!--/_footer /作为公共模版分离出去-->
</body>
</html>
