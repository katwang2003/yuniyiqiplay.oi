<?php 

if(!isset($type)){exit();}
$this->nologin();


$this->showhd("切换账号");

 
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
 
 
<style>
.users{margin:10px 10px 0px 10px;border-radius:8px;padding:8px;background-color:#fff;line-height:36px;}    
.userfc{display:inline-block;height:36px;line-height:36px;float:left;color:#444;}
.userfc img{float:left;height:36px;width:36px;border-radius:18px;float:left;margin-right:5px;}
.msg{float:right;display:inline-block;width:60px;text-align:center;height:36px;line-height:36px;color:#5c5757;margin-right:6px;}
.msg img{width:18px;height:18px;vertical-align:middle;margin-right:2px;}
.qiehuan{float:right;display:inline-block;width:60px;text-align:center;height:36px;line-height:36px;color:#000;}
</style> 
<div class='users'  style='color:red;' id='uid'>
<?php if($this->wechat){echo "本站已开启微信号绑定，您<a href='/?type=user&type2=reg'>重新注册账号</a>，通过原来的微信号进行绑定，账号就会归集到一起。";}else{
echo  "本站未开启微信号绑定，暂时无法进行多账号切换。";
} ?>
</div>

<?php if($this->wechat){ 
$sql=$this->sql("select `uid`,`username`,`face`,`nickname` from `s_user` where  `uid`!='".$_SESSION["uid"]."' and `wx`='".$_SESSION["wx"]."' ");

while($r=$this->row2($sql)){
echo "<div class='users'  id='uid".$r["uid"]."'>
<a  class='userfc'><img src='/public/face/".$r["face"]."'/>".$r["nickname"]."</a>
<a href='#' class='qiehuan' uid='".$r["uid"]."'>切换</a>
</div>";
}
?>

<script type="text/javascript">
$(function(){

//qiehuan
$(".qiehuan").click(function(){
var uid=$(this).attr("uid");
$.post("/index.php",{"api":"user","api2":"qiehuan","uid":uid},function(json){
if(json[0]==1){
 location.href="/?type=user&type2=wo";
}else{
rs(json[1]);
}    
},"json");
 


return false;  
});



});	
</script>



<?php

}?>