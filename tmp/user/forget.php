<?php 
if(!isset($type)){exit();}
$this->showhd("忘记密码");
session_destroy();


 
?>


 
<Style>
.logo{height:55px;line-height:50px;font-size:17px;font-weight:bold;vertical-align:middle;background-color:#fff;position:fixed;left:0px;width:100%;top:0px;z-index:55;box-shadow: #b9bcbc 0px 8px 8px -8px;text-align:center;}
.logo #logo{display:inline-block;height:55px;line-height:55px;color:#777;margin-left:8px;}
#logo span{display:inline-block;height:50px;line-height:55px;width:50px;border-radius:25px;margin-right:5px;margin-left:10px;border:0px;}
 .logo img{vertical-align:middle;height:50px;border-radius:25px;}
</Style>
<div style='height:50px;'></div>
<div class='logo'><a  id='logo' href='<?php echo $this->cfg["url"];  ?>'><span><img src='/public/img/logo.png'/></span><?php echo $this->cfg["logoname"];  ?></a>
</div>

<style type="text/css">
.nft a,.nfa a{color:#fff;}
.nfa{color:#fff;font-size:12px;}
.nft{color:#fff;font-size:12px;}
.hdd{line-height:50px;text-align:center;}
.hdd a{color:red;font-size:16px;font-weight: bold;text-decoration:underline;} 
.input{border-radius:5px;border:1px solid #999999;margin:15px 15px 0px 15px;height:35px;background-color:#fff;padding-left:5px;padding-right:5px;}
.input input{border:0px;padding:0px;width:100%;background-color:#fff;padding-bottom:10px;padding-top:10px;height:15px;}
  
.submit{padding:15px;}
.submit .a1{float:right;background-color:#FF534D;color:#fff;font-size:14px;border-radius:5px;height:35px;line-height:35px;display:inline-block;width:45%;text-align:center;}
.submit .a2{float:left; color:#07c160;font-size:14px;border-radius:5px;height:35px;line-height:35px;display:inline-block;width:45%;text-align:center;}
  
.rgk{font-weight:bold;}

.bd{margin:25px auto;width:100%;z-index:11;}     
.form{background-color:#fff;max-width:320px;margin:0px auto;border-radius:5px;} 
.forgt{text-align:center;line-height:36px;color:#999;font-size:12px;}
.forgt a{color:#FF534D;margin-left:5px;margin-right:5px;font-size:12px;}
.fnlogin{display:inline-block;width:35px;height:35px;position:fixed;top:50%;left:50%;margin-left:143px;margin-top:-143px;z-index:222;}
.fnlogin img{width:100%;height:100%;}
.hdlogo{text-align:center;padding-top:20px;}
.mmmm{line-height:28px;}
.mmmm img{max-width:55%;float:left;margin-right:5px;}
</style>

<div class='bd'>
<form class='form'>		
<div class='hdd'>(<?php if(!$this->wechat){  echo "由于本站未开启微信绑定，无法提供找回账号服务"; }else{ echo "找回账号";} ?>)</div>	
<div class="input input1"><input id='uid'  placeholder='账号'/></div>
<div class="input input1"><input id='pw' type='password' placeholder='新密码'/></div>
<?php if($this->wechat){ ?>
<div class="mmmm"><img  src='/public/img/erweima.jpg'/>请用微信扫码关注公众号后，发送口令“1”或“验证码”给公众号。</div>
<div class="input input1"><input id='id'  placeholder='验证码'/></div>
<?php } ?>
<div class="submit"><a href="/?type=user&type2=login" class="a2">立即登录</a><a href="#" class="a1 login">找回密码</a><input type='submit' class='login' value='登陆' style='display:none;'/></div> 
<div class="forgt"><a href='/?type=user&type2=reg'>免费注册</a></div>
</form>
</div>
 

<script type="text/javascript">
$(function(){

$("#password").focus(function(){
$(this).attr("type","password");	
});
  
//登录
$(".login").click(function(){
 
if($("#uid").val()=="" || $("#pw").val()==""){
rs("请输入账号密码！");
}else{
$.post("/index.php",{api:"user",api2:"forget",un:$("#uid").val(),pw:$("#pw").val(),id:$("#id").val()},function(json){
 
if(json[0]==1 ){	
ref=document.referrer;
if(ref.startsWith("http://<?php echo $_SERVER["SERVER_NAME"]; ?>/?type=user")){
location.href='/';
}else if(ref.startsWith("http://<?php echo $_SERVER["SERVER_NAME"]; ?>/")){
location.href=ref;
}else{
 location.href='/';   
}


}else{
rs(json[1]);
}
},"json");
}
return false;	
});	

 

});
</script>



 