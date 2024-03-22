<?php 
 if(!isset($type)){exit();}
 
$this->showhd("排行");
 
  $sql=$this->sql("select `face`,`nickname`,`followed`,`follow` from `s_user` where `uid`='".$_SESSION["uid"]."'");

$u=$this->row2($sql);


$pn=1;
if(isset($_GET["pn"]) and is_numeric($_GET["pn"]) and $_GET["pn"]>=1 and $_GET["pn"]<=9999999999){
$pn=$_GET["pn"];
}
 
$p=50;
$pnno=($pn-1)*$p;
 
?>
 <style>
.all{margin:10px 10px 0px 10px;}
.users{float:left;width:25%;text-align:center;max-width:120px;}    
.users1{margin:6px;background-color:#fff;border-radius:8px;height:75px;}
.userfc{display:inline-block;line-height:25px;color:#444;font-size:12px;text-align:center;}
.userfc img{height:50px;width:50px;border-radius:25px;}
 
</style> 
<Div class='all'>
<?php  
 

 
$sql2=$this->Sql("SELECT `s_user`.`face`,`s_user`.`uid`,`s_user`.`nickname` FROM   `s_user`  order by `coin` desc,`uid` desc limit ".$pnno.",".($p+1));
$url="/?type2=pai&";

$lnum=$this->num($sql2);

while ($r=$this->row2($sql2) ) {
echo  "<div class='users'><div class='users1'>
<a href='/?type=user&uid=".$r["uid"]."'  class='userfc'><img src='/public/face/".$r["face"]."'/><br/>".$r["nickname"]."</a>

 
</div></div>";
}

?>

</Div>



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
 
 