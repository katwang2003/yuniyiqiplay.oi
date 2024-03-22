<?php 
if(!isset($type)){exit();}
$this->nologin();



$this->showhd("修改密码");
 


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
.intel:focus-within {border: 1px solid #66;}
.insos{color:red;line-height:30px;}
 
 
.intxt{border-radius:5px;border:1px solid #999999;margin:5px 1px 0px 1px;background-color:#fff;padding-left:5px;padding-right:5px;}
.intxt textarea{border:0px;margin:0px;padding:0px;width:100%;background-color:#fff;line-height:30px;min-height:90px;}

 
 

 
 </Style>  



 

 


<Div class='acbox2 acboxh'><Div class='acbox21'><Div class='acbox22'>
<Div class='insos'>请注意:如果原密码忘了的话,只能由管理员在数据库里改</Div>
<div class="intel"><input id='pw' type='text'  placeholder='原密码'/></div>
<div class="intel"><input id='pw2' type='text' placeholder='新密码'/></div> 
<Div class='acbox221'><a href='#' class='acok'>确认发布</a></Div>

<Script>
	$(function(){

 

$(".acok").click(function(){
 
$.post("/index.php",{"api":"user","api2":"password","pw":$("#pw").val(),"pw2":$("#pw2").val()},function(json){
if(json[0]==1){
location.reload();
}else{
rs(json[1]);
}
},"json");
return false;
});




	});


</Script>


</div></div></Div>	


 



 
