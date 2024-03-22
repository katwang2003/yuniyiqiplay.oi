<?php 
if(!isset($type)){exit();}


$this->showhd("网站基本信息设置");




?>
<style type="text/css">
.gg{height:40px;position:fixed;width:100%;left:0px;text-indent:10px;top:0px;background-color:#fff;border-bottom:1px solid #f1f1f1;z-index:33;}
.gg a{line-height:40px;display:inline-block;height:40px;}
.gg span{font-weight:bold;}
.ggar{float:right;margin-right:8px;}
.ggar img{width:24px;height:24px;margin-top:8px;}
.ggal{float:left;margin-left:8px;}
</style>
<div style="height:41px;"></div>
<div class='gg'>
<a href='/?type=ht' class='ggal'>返回管理员后台首页</a>

 
</div>
 

 

 

<Style>

 	
.acbox12{width:100%;z-index:34;margin-top:10px;background-color:#fff;}
.acbox121{max-width:1000px;margin:9px auto;width:100%;}
.acbox122{margin:10px;padding:0px 10px 10px 10px; background-color:#fff;border-radius:10px;}
.acbox1221{height:50px;}
.acbox1221 a{display:inline-block;height:30px;line-height:30px;margin-top:10px;border-radius:5px;color:#fff;font-size:18px;font-weight:bold;text-align:center;min-width:120px;}
.acbox1221 .accl1{background-color:#515151;float:left;}
.acbox1221 .addqq1,.acbox1221 .acok12{background-color:#d4237a;float:left;}
.acbox12 .intel{border-radius:5px;border:1px solid #999999;margin:5px 1px 0px 1px;height:35px;background-color:#fff;padding-left:5px;padding-right:5px;}
.acbox12 .intel input{border:0px;padding:0px;width:70%;background-color:#fff;padding-bottom:10px;padding-top:10px;height:15px;}
 
.intxt{border-radius:5px;border:1px solid #999999;margin:5px 1px 0px 1px;background-color:#fff;padding-left:5px;padding-right:5px;}
.intxt textarea{border:0px;margin:0px;padding:0px;width:100%;background-color:#fff;line-height:30px;min-height:90px;}

.inpic{min-height:35px; position:relative;}
.pictxt{line-height:35px;margin-left:36px;text-align:center;}
.pictxt span{color:red;}
.pictxt img{vertical-align:middle;}
.file{height:99px;position:absolute;top:0px;left:0px;opacity:0;width:100%;}
.file input {font-size:100px;}

 .face{text-align:center;} 
.face img{height:64px;width:64px;border-radius:32px;}
 </Style>  



 

 
 
 

<Div class='acbox12 acboxh1 acbox12huo'><Div class='acbox121'><Div class='acbox122'>

<div class="inpic">
<Div class='face'><img src='/public/img/logo.png?<?php echo time(); ?>'/></Div>
<div class='pictxt'><img src='/public/img/shopgoodpic.png'/>更换logo</div>
<div class="file"><input type="file" /></div>
</div>	
<Script>
 
$(document).ready(function(){

$(".file input").change(function () {
        img2Base64(this, function (data) {
            $('.face img').attr('src', data);
            $.post("/index.php",{"api":"ht","api2":"logo","base64v":data},function(json){
rs(json[1]);
},"json");
        });
    });


});

   function img2Base64(input_file, get_data) {
        /*input_file：文件按钮对象*/
        /*get_data: 转换成功后执行的方法*/
        if (typeof (FileReader) === 'undefined') {
            console.log("图片异常")
        } else {
            try {
                /*图片转Base64 核心代码*/
                var file = input_file.files[0];
                //这里我们判断下类型如果不是图片就返回 去掉就可以上传任意文件
                if (!/image\/\w+/.test(file.type)) {
                    console.log("图片img2base64：转化成功");
                    return false;
                }
                var reader = new FileReader();
                reader.onload = function () {
                    get_data(this.result);
                }
                reader.readAsDataURL(file);
            } catch (e) {
                console.log("图片img2base64：转化失败")
                console.log(local_message.E_CODE_0008 + e.toString());
            }
        }
    }
 
</Script> 



<div class="intel">网站名称：<input id='webname'  value='<?php echo  $this->cfg['webname']; ?>'/></div> 
<div class="intel">网站副标题：<input id='webtitle'  value='<?php echo  $this->cfg['webtitle']; ?>'/></div>
<div class="intel">备案号：<input id='beianhao'  value='<?php echo  $this->cfg['beianhao']; ?>'/></div>
<div class="intel">联系方式：<input id='lianxi'  value='<?php echo  $this->cfg['lianxi']; ?>'/></div>
<Div class='acbox1221'><a href='#' class='acok12  configedit'>确认修改</a></Div>



</Div></Div></Div> 



<Script>
	$(function(){

 

$(".configedit").click(function(){
 
$.post("/index.php",{"api":"ht","api2":"configedit","webname":$("#webname").val(),"webtitle":$("#webtitle").val(),"beianhao":$("#beianhao").val(),"lianxi":$("#lianxi").val()},function(json){
if(json[0]==1){
rs(json[1]);
location.reload();
}else{
rs(json[1]);
}
},"json");
return false;
});




	});


</Script>


 