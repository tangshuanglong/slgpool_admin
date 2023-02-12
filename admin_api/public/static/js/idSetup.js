
    // 上传图片到服务器并预览
    function uploadImg(fileId, imgId) {
        $('#' + fileId).change(function () {
            var $img = $('#' + imgId);
            var size = this.files[0].size;
            if (!this.files || !this.files[0]) {
                return;
            }
            if (size > (1024*300)){
                $.Huimodalalert('图片太大，应在300K以下', 2000);
                return;
            }
            readFile(this, 1,function(data) {
                getToken(data, function(json) {
                  var img_path = $('#domain').val();
                  $img.parent().html("<img id='" + imgId + "' class='qr_code_path' src="+img_path+json.key+">");
                   $.Huimodalalert('上传成功', 2000);
                }, $img.attr('id'));
            })
        });
    }

    function readFile(input,changSize,callback){
        var file = input.files[0];
        var size = input.files[0].size;
        if(!/image\/\w+/.test(file.type)){
            $.Huimodalalert('请确保文件为图像类型', 2000);
            return false;
        }
        //判断是否图片，在移动端由于浏览器对调用file类型处理不同，虽然加了accept = 'image/*'，但是还要再次判断
        var reader = new FileReader();
        reader.readAsDataURL(file);//转化成base64数据类型
        reader.onload = function(e){
            if(changSize==1){
                callback(this.result);
            }else {
                var scale = 0;
                if(size>(1024*1024*5)){
                    scale = 0.1;
                }else if(size<(1024*1024*5) && size>(1024*1024*3)){
                    scale = 0.25;
                }else if(size>(1024*1024*2) && size<(1024*1024*3)){
                    scale = 0.35;
                }else if(size>(1024*1024) && size<(1024*1024*2)){
                    scale = 0.45;
                }else if(size>(1024*512) && size<(1024*1024)){
                    scale = 0.55;
                }else if(size>(1024*256) && size<(1024*512)){
                    scale = 0.65;
                }else if(size>(1024*80) && size<(1024*256)) {
                    scale = 0.75;
                }else {
                    scale = 1;
                }
                drawToCanvas(this.result, scale, changSize);
            }
        }
    }


    // canvas预览图片 生成base64
    function drawToCanvas(imgData,changSize,callback){
        var img = new Image;
        img.src = imgData;
        var type=(imgData.split(';base64')[0]).split('data:')[1];
        img.onload = function(){
            //必须onload之后再画
            var imgW=this.width*changSize,imgH=this.height*changSize;
            var cvs=document.createElement("canvas");
            cvs.width=imgW;
            cvs.height=imgH;
            var ctx = cvs.getContext('2d');
            ctx.drawImage(img,0,0,imgW,imgH);
            callback(cvs.toDataURL(type,changSize));//获取canvas base64数据
        }
    }

    // 获取token
    function getToken(imgDta,callback,type){
        $.ajax({
            // url: '/api/qiniu_upload/gettokenTest',
            url: '/api/qiniu_upload/get_token',
            type: 'post',
            data: {
                'type': type || ''
            },
            dataType: 'json',
            success: function(data) {
              console.log(data);
                if(data.code == 0) {
                    put64(imgDta, data.body.upToken, callback);
                } else {
                    $.Huimodalalert(data.msg, 2000);
                }
            }
        })
    }

    // 千牛上传
    function put64(base64, upToken, callback) {
        var pic = base64.split('base64,')[1];
        var url = "https://upload-z2.qiniup.com/putb64/-1"; //1 修改上传域名
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange=function(){
        if (xhr.readyState==4){
            var json=JSON.parse(xhr.responseText);
            callback(json)
        }
        };
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/octet-stream");
        xhr.setRequestHeader("Authorization", 'UpToken '+upToken);
        xhr.send(pic);
    }
