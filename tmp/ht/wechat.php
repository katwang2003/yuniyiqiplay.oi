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
.acbox221 .accl{background-color:#515151;float:left;}
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
默认链接http://<?php echo $_SERVER["SERVER_NAME"]; ?>/wechat.php<br/>
<?php if(file_exists("wechat.php")){ echo "<span style='color:red;'>已生成</span>继续生成将替换老的入口文件";} ?>
<div class="intel"><input id='token' value=''  placeholder='输入token'/></div>
<Div class='acbox221'><a href='#' class='acok'>生成接口文件到根目录</a></Div>


<Script>
	$(function(){


 
$(".acok").click(function(){
 
 
$.post("/index.php",{"api":"ht","api2":"wetoken","token":$("#token").val()},function(json){
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



 