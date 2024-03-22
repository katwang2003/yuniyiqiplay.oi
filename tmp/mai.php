<?php 
 if(!isset($type)){exit();}
$this->nologin();

$this->showhd("人脉");
 
  $sql=$this->sql("select `face`,`nickname`,`followed`,`follow` from `s_user` where `uid`='".$_SESSION["uid"]."'");

$u=$this->row2($sql);


$pn=1;
if(isset($_GET["pn"]) and is_numeric($_GET["pn"]) and $_GET["pn"]>=1 and $_GET["pn"]<=9999999999){
$pn=$_GET["pn"];
}
 
$p=15;
$pnno=($pn-1)*$p;
 
?>
<Style>
.logo{height:55px;line-height:50px;font-size:17px;font-weight:bold;vertical-align:middle;background-color:#fff;position:fixed;left:0px;width:100%;top:0px;z-index:55;box-shadow: #b9bcbc 0px 8px 8px -8px;}
#logoa{display:inline-block;height:55px;line-height:50px;color:#777;float:left;margin-left:8px;}
#logoa span{color:red;}
 
.sousuo{height:32px;width:32px;float:right;margin-top:11px;margin-right: 8px;background:#fff;display:inline-block;}
.sousuo img{height:32px;width:32px;}

</Style>
<div style='height:55px;'></div>
<div class='logo'><a  id='logoa' href='/?type=mai&type2=follow'>关注(<span><?php echo $u["follow"]; ?></span>)</a><a  id='logoa' href='/?type=mai&type2=followed'>粉丝(<span><?php echo $u["followed"]; ?></span>)</a>
 
<a href='/?type=soso'  class='sousuo'><img src='/public/img/sousuo1.png'/></a>

</div>
<style>
.users{margin:10px 10px 0px 10px;border-radius:8px;padding:8px;background-color:#fff;}    
.userfc{display:inline-block;height:36px;line-height:36px;float:left;color:#444;}
.userfc img{float:left;height:36px;width:36px;border-radius:18px;float:left;margin-right:5px;}
.msg{float:right;display:inline-block;width:60px;text-align:center;height:36px;line-height:36px;color:#5c5757;margin-right:6px;}
.msg img{width:18px;height:18px;vertical-align:middle;margin-right:2px;}
.qg{float:right;display:inline-block;width:60px;text-align:center;height:36px;line-height:36px;color:#000;}
</style> 
 
<?php  
$type2="follow";
if(isset($_GET["type2"]) and ($_GET["type2"]=="follow"  or  $_GET["type2"]=="followed") ){

$type2=$_GET["type2"];
}

if($type2=="follow"){
$sql2=$this->Sql("SELECT `s_user`.`face`,`s_user`.`uid`,`s_user`.`nickname` FROM `s_follow`   left join `s_user` on(`s_follow`.`uid2`=`s_user`.`uid`) where `s_follow`.`uid`='".$_SESSION["uid"]."'  limit ".$pnno.",".($p+1));
$url="/?type=mai&type2=follow&";
$lnum=$this->num($sql2);
while ($r=$this->row2($sql2) ) {
 
echo  "<div class='users'  id='uid".$r["uid"]."'>
<a href='/?type=user&uid=".$r["uid"]."'  class='userfc'><img src='/public/face/".$r["face"]."'/>".$r["nickname"]."</a>

<a href='#' class='qg' uid2='".$r["uid"]."'>取关</a>
<a href='/?type=msg&type2=send&uid2=".$r["uid"]."' class='msg'><img src='/public/img/msg.png'/>私信</a>
</div>";
}


}else{
$sql2=$this->Sql("SELECT `s_user`.`face`,`s_user`.`uid`,`s_user`.`nickname` FROM `s_follow`   left join `s_user` on(`s_follow`.`uid`=`s_user`.`uid`) where `s_follow`.`uid2`='".$_SESSION["uid"]."'  limit ".$pnno.",".($p+1));
$lnum=$this->num($sql2);
$url="/?type=mai&type2=followed&";
while ($r=$this->row2($sql2) ) {
 
echo  "<div class='users'  id='uid".$r["uid"]."'>
<a href='/?type=user&uid=".$r["uid"]."'  class='userfc'><img src='/public/face/".$r["face"]."'/>".$r["nickname"]."</a>

 
<a href='/?type=msg&type2=send&uid2=".$r["uid"]."' class='msg'><img src='/public/img/msg.png'/>私信</a>
</div>";
}

} 



?>

<script type="text/javascript">
  
$(function(){

//取关
$(".qg").click(function(){
var uid2=$(this).attr("uid2");
$.post("/index.php",{"api":"user","api2":"followend","uid2":uid2},function(json){
if(json[0]==1){
$("#uid"+uid2).remove();
}else{
rs(json[1]);
}    
},"json");
 


return false;  
});


});

</script>



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

<?php  
include 'com/ft.php';

?>