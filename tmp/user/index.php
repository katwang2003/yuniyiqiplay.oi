<?php 
if(!isset($type)){exit();}
 
if(!isset($_GET["uid"]) or !is_numeric($_GET["uid"])){
header("HTTP/1.1 404 Not Found");
include "404.html";
exit();
}
$uid=$_GET["uid"];


$sql=$this->Sql("select  `s_user`.`uid`,`s_user`.`nickname`,`face`,`follow`,`followed` from  `s_user`  where `uid`='".$this->res($uid)."' limit 0,1");
if($this->num($sql)==0){
header("HTTP/1.1 404 Not Found");
include "404.html";
exit();
}
$u=$this->row2($sql);

$this->showhd($u["nickname"]);
 
 
$pn=1;
if(isset($_GET["pn"]) and is_numeric($_GET["pn"]) and $_GET["pn"]>=1 and $_GET["pn"]<=9999999999){
$pn=$_GET["pn"];
}
 
$p=15;
$pnno=($pn-1)*$p;
 $url="/?type=user&uid=".$uid."&";
 
//亲密度
$this->qinmidu($u["uid"]);


$g=0;
if($this->here()){
$fsql=$this->sql("SELECT * FROM `s_follow` where `uid`='".$_SESSION["uid"]."' and `uid2`='".$this->res($uid)."' ");
if($this->num($fsql)==1){
$g=1;
}
}
?>
 
 

 <Style>
.logo{height:55px;line-height:50px;font-size:17px;font-weight:bold;vertical-align:middle;background-color:#fff;position:fixed;left:0px;width:100%;top:0px;z-index:55;box-shadow: #b9bcbc 0px 8px 8px -8px;}
#logoa{display:inline-block;height:55px;line-height:50px;color:#777;float:left;margin-left:8px;}
#logoa span{color:red;}
 
.sousuo{height:32px;line-height:32px;float:right;margin-top:11px;margin-right: 8px;background:#fff;display:inline-block;}
.sousuo img{height:32px;width:32px;}

</Style>
<div style='height:55px;'></div>
<div class='logo'><span  id='logoa'  >关注(<span><?php echo $u["follow"]; ?></span>)</span><span  id='logoa'  >粉丝(<span><?php echo $u["followed"]; ?></span>)</span>
 
 
<?php if($g==1){

echo "<a href='#' class='sousuo qg' uid2='".$uid."'>取关</a>";  
echo  '<script>
$(function(){

//取关
$(".qg").click(function(){
 
$.post("/index.php",{"api":"user","api2":"followend","uid2":"'.$uid.'"},function(json){
if(json[0]==1){
location.reload();
}else{
rs(json[1]);
}    
},"json");
 


return false;  
});

});

</script>';
} ?>

</div>





<style type="text/css">
.art{margin:10px 10px 0px 10px;border-radius:8px;background-color:#fff;padding:8px;box-shadow: #b9bcbc 0px 8px 8px -8px;}
.artt{line-height:30px;color:#333;font-size:16px;font-weight:bold;} 
.artc{height:52px;line-height:26px;color:#888;overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;}    
 


.picsbx1{float:left;max-width:120px;margin-right:10px;}
.picsbx1 img{max-width:120px;width:100%;border-radius:10px;}

.picsbx2{max-height:80px;line-height:80px; vertical-align: middle;}
.picsbx2 img{width:50%;float:left;max-width:200px;vertical-align:middle;}
.picsbx3{max-height:60px;line-height:60px;vertical-align: middle;}
.picsbx3 img{width:33%;float:left;max-width:200px;vertical-align:middle;}



.user{line-height:45px;}
.user img{width:32px;height:32px;vertical-align:middle;border-radius:16px;margin-right:4px;}
.user a{color:#555;}


.arttm{border-top:1px solid #dedede;margin-top:5px;}
.arttm a{display:inline-block;width:33%;float:left;height:35px;line-height:35px;text-align:center;font-size: 12px;color:#777;}
.arttm img{width:20px;height:20px;vertical-align:middle;margin-right:4px;margin-top:-2px;}
.view{}
</style>
 

<?php  
 
$asql=$this->Sql("select  `s_content`.*   from   `s_content`    where `s_content`.`uid`='".$this->res($uid)."'    order  by   `s_content`.`cid`   desc   limit ".$pnno.",".($p+1));
$lnum=$this->num($asql);
$t=1; 
while($a=$this->row2($asql)){
    if($t<=$p){  
$str="";
$str2=$a["intro"];
if(preg_match("/picsbx1/",$a["intro"])){
$str=$a["intro"];
$str2="";
}


$likepng="like";

 

echo "<div class='art'>
<a href='/?type=v&cid=".$a["cid"]."'><div> 
".$str."
<div class='artt'>".$a["title"]."</div>".$str2."
</div></a>
<div class='arttm'>

<a href='#' class='like cid".$a["cid"]."' cid='".$a["cid"]."'><img src='/public/img/".$likepng.".png'/><span>".$a["likes"]."</span></a>
<a href='/?type=comment&cid=".$a["cid"]."'><img src='/public/img/comment.png'/>".$a["comment"]."</a>
<a href='/?type=v&cid=".$a["cid"]."' class='view'><img src='/public/img/view.png'/>".$a["view"]."</a>
</div>
</div>";

 


}
$t++;

}
 

?>
 




<Style>
.pn{text-align:center;margin-bottom:20px;margin-top:10px;}
.pn a{display:inline-block;font-size:30px;height:30px;line-height:30px;padding-left:6px;padding-right:6px;background-color:#f1f1f1;color:#000;margin-left:5px;margin-right:5px;border-radius:8px;}
</Style>
<div class='pn'>
<?php 

if($pn>1){
echo "<a  href='".$url."pn=".($pn-1)."'>上一页←</a>"; 
}
if($lnum>$p){
echo "<a   href='".$url."pn=".($pn+1)."'>→下一页</a>";  
}

?>
</div> 


<style type="text/css">
.rm{position:fixed;z-index:35;bottom:160px;right:10px;width:50px;padding-bottom:8px;}
.rmface{width:50px;height:50px;border-radius:25px;background-color:#fff;}
.rmface img{border-radius:23px;width:46px;height:46px;margin-top:2px;margin-left:2px;}

.follow{background-color:rgb(254,44,85);width:16px;height:16px;display:inline-block;border-radius:8px;color:#fff;font-weight:bold;line-height:16px;text-align:center;font-size: 16px;position:absolute;left:17px;top:42px;}
.rlike{margin-top:15px;display:inline-block;width:50px;text-align:center;color:#777;}
.rlike img{width:40px;}  
.comment{margin-top:15px;display:inline-block;width:50px;text-align:center;color:#777;}
.comment img{width:40px;}  
.share{margin-top:15px;display:inline-block;width:50px;text-align:center;color:#d61f7f;font-size:12px;line-height:22px;}
.share img{width:40px;}  
.shoucang{margin-top:15px;display:inline-block;width:50px;text-align:center;color:#FFA919;font-size:12px;line-height:22px;}
.shoucang img{width:40px;}  
</style>
<div class='rm'>
<div class='rmface'><a href="/?type=user&uid=<?php  echo $uid; ?>"><img src='/public/face/<?php echo $u["face"]; ?>'/></a></div>  
<?php 


if($g==0){
 ?>

<a  href='#' class='follow'  uid='<?php echo $uid; ?>'>+</a>
<?php } ?>


<a  href='/?type=msg&type2=send&uid2=<?php echo $uid; ?>' class='comment'><img src='/public/img/msg.png'/></a>
<a  href='#' class='shoucang'><img src='/public/img/shoucang.png'/><br/>收藏</a>
<a  href='#' class='share'><img src='/public/img/share.png'/><br/>分享</a>
</div>


<script>
$(function(){

// 关注
$(".follow").click(function(){

$.post("/index.php",{"api":"user","api2":"follow","uid2":"<?php echo $uid; ?>"},function(json){
if(json[0]==1){
$(".follow").html("√");
$(".follow").css({"background-color":"#fff","color":"rgb(254,44,85)"});
$(".follow").animate({width:"24px",height:"24px",left:"13px",top:"38px"}).animate({width:"6px",height:"6px",left:"22px",top:"47px"},function(){$(this).remove();});
}else{
rs(json[1]);
}    
},"json");
 


return false;
});



//点赞
$(".like").click(function(){
var cid=$(this).attr("cid");
$.post("/index.php",{"api":"pb","api2":"clikes","cid":cid},function(json){
if(json[0]==1){
$(".cid"+cid+" img").attr("src","/public/img/"+json[1]+".png"); 
var likes=parseInt($(".cid"+cid+" span").html());
if(json[1]=="like"){
$(".cid"+cid+" span").html(likes+1);
}else{
$(".cid"+cid+" span").html(likes-1);  
}
}else{
rs(json[1]);
}
},"json");
return false;
});

 


}); 



</script>

<script type="text/javascript">
  
$(function(){


$(".shoucang").click(function(){
rs("请使用手机浏览器自带收藏功能进行收藏。<br/><img src='https://sinpark.com/erweima.php?url=<?php  echo urlencode("http://".$_SERVER["SERVER_NAME"]."/?type=user&uid=".$uid);?>'/><br/>用手机浏览器扫一扫");
return false;
});

$(".share").click(function(){
rs("请使用手机浏览器自带分享功能进行分享。<br/><img src='https://sinpark.com/erweima.php?url=<?php  ?><?php  echo urlencode("http://".$_SERVER["SERVER_NAME"]."/?type=user&uid=".$uid);?>'/><br/>用手机浏览器扫一扫");
return false;
});

});
</script>