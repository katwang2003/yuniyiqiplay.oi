<?php 
if(!isset($type)){exit();}
$this->nologin();
if(isset($_SESSION["wx"]) and $_SESSION["wx"]!=""){
header("location:/");
exit();
}


$this->showhd("绑定微信号");




?>
<style type="text/css">
.gg{height:40px;position:fixed;width:100%;left:0px;text-indent:10px;top:0px;background-color:#fff;border-bottom:1px solid #f1f1f1;z-index:33;color:red;line-height:40px;}
.gg a{line-height:40px;display:inline-block;height:40px;}
.gg span{font-weight:bold;}
.ggar{float:right;margin-right:8px;}
.ggar img{width:24px;height:24px;margin-top:8px;}
.ggal{float:left;margin-left:8px;}
</style>
<div style="height:41px;"></div>
<div class='gg'>
出于安全考虑，请绑定您的微信号。

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
.insos img{width:250px;height:250px;}
 
 
 </Style>  

<Div class='acbox2 acboxh'><Div class='acbox21'><Div class='acbox22'>

<div class="insos">步骤：①扫码关注公众号②在公众号内发送口令“1”或“验证码”</div>
<div class="insos"><img src='/public/img/erweima.jpg'/></div>

<div class="intel"><input id='nn' value=''  placeholder='请输入验证码'/></div>
<Div class='acbox221'><a href='#' class='acok'>确认验证码</a></Div>


<Script>
	$(function(){


 
$(".acok").click(function(){
 
 
  
$.post("/index.php",{"api":"user","api2":"mkwx","id":$("#nn").val()},function(json){
rs(json[1]);
if(json[0]==1 ){	
ref=document.referrer;
if(ref.startsWith("http://<?php echo $_SERVER["SERVER_NAME"]; ?>/?type=user")){
location.href='/';
}else if(ref.startsWith("http://<?php echo $_SERVER["SERVER_NAME"]; ?>/")){
location.href=ref;
}else{
 location.href='/';   
}
}
},"json");
return false;
});




	});


</Script>


<div></div></Div>	

