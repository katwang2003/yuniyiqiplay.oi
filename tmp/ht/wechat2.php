<?php 

if(!isset($type)){exit();}
$this->nologin();


$this->showhd("微信公众号服务器配置接口文件生成");

 
?>
<style type="text/css">
.gg{height:40px;position:fixed;width:100%;left:0px;text-indent:10px;top:0px;background-color:#fff;border-bottom:1px solid #f1f1f1;z-index:33;}
.gg a{line-height:40px;display:inline-block;height:40px;}
.gg span{font-weight:bold;}
.ggar{float:right;margin-right:8px;}
.ggar img{width:24px;height:24px;margin-top:8px;}
.ggal{float:left;margin-left:8px;}
.copyright{display:none;}
</style>
<div style="height:41px;"></div>
<div class='gg'>
<a href='<?php if($_SESSION["uid"]==10000){echo "/?type=ht";}else{echo "/?type=user&type2=config";}  ?>' class='ggal'>返回</a>

 </div>
 

 
 

<Style>

 	
.acbox2{width:100%;z-index:34;margin-top:0px;}
.acbox21{margin:9px auto;}
.acbox22{margin:10px;padding:0px 10px 10px 10px; background-color:#fff;border-radius:10px;}
.acbox221{height:50px;}
.acbox221 a{display:inline-block;height:30px;line-height:30px;margin-top:10px;border-radius:5px;color:#fff;font-size:18px;font-weight:bold;padding:0px 8px 0px 8px;}
.acbox221 .acok2{background-color:#515151;float:left;}
.acbox221 .acok{background-color:#d4237a;float:left;}
.intype{line-height:40px;}
.intel{border-radius:5px;border:1px solid #999999;margin:5px 1px 0px 1px;height:35px;background-color:#fff;padding-left:5px;padding-right:5px;}
.intel input{border:0px;padding:0px;width:100%;background-color:#fff;padding-bottom:10px;padding-top:10px;height:15px;}
.insos{color:red;line-height:30px;}
 
 


.inpic{min-height:35px; position:relative;}
.pictxt{line-height:35px;margin-left:36px;text-align:center;}
.pictxt span{color:red;}
.pictxt img{vertical-align:middle;}
.file{height:99px;position:absolute;top:0px;left:0px;opacity:0;width:100%;}
.file input {font-size:100px;}
#sex{line-height:50px;}



 
.mmm2{width:100%;float:left;}
.mmm21{background-color:#f1f1f1;}


.mmm221{border:1px solid #dedede;border-radius: 8px;padding:8px;margin:8px 8px 0px 8px;background-color:#fff;}


.face{text-align:center;} 
.face img{height:64px;width:64px;border-radius:32px;}
 </Style>  





<div class='mmm'>
 

<div class='mmm2'>
<div class='mmm21'>


<Div class='acbox2 acboxh'><Div class='acbox21'><Div class='acbox22'>
 
<?php if(file_exists("wechat.php")){ echo "<span style='color:red;'>接口文件已生成</span>如果您已经在公众号后台设置好了，请生成功能性文件<br/>目前远程服务器提供的功能性文件仅支持个人公众号的自动回复。如有其他需求，请联系qq441314717";} ?>
 
<Div class='acbox221'><a href='#' class='acok'>下载（或更新）功能性文件</a></Div>


<Script>
	$(function(){


 
$(".acok").click(function(){
 
 
$.post("/index.php",{"api":"ht","api2":"weauto"},function(json){
rs(json[1]);
 
},"json");
return false;
});




	});


</Script>


<div></div></Div>	



 <div class='mmm'>
 

<div class='mmm2'>
<div class='mmm21'>
<Div class='acbox2 acboxh'><Div class='acbox21'><Div class='acbox22'>


微信官方后台给的是jpg格式，仅支持jpg格式，请注意
<div class="inpic">
<Div class='face'><img src='/public/img/erweima.jpg?<?php echo time(); ?>'/></Div>
<div class='pictxt'><img src='/public/img/shopgoodpic.png'/>更换二维码</div>
<div class="file"><input type="file" /></div>
</div>	
<Script>
 
$(document).ready(function(){ 

$(".file input").change(function () {
        img2Base64(this, function (data) {
            $('.face img').attr('src', data);
            $.post("/index.php",{"api":"ht","api2":"erweima","base64v":data},function(json){
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



强制绑定公众号 
<?php if($this->wechat){ echo "当前状态<span style='color:red;'>开启中</span>开启后，注册用户会被要求提供验证码，已注册用户登录时也会被要求提供验证码";}else{
echo "当前状态<span style='color:red;'>关闭中</span>";	
} ?>
 
<Div class='acbox221'><a href='#' class='acok2'>更改状态</a></Div>


<Script>
	$(function(){


 
$(".acok2").click(function(){
 
 
$.post("/index.php",{"api":"ht","api2":"wemust"},function(json){
rs(json[1]);
if(json[0]==1){
location.reload();
}
},"json");
return false;
});




	});


</Script>


<div></div></Div>	
