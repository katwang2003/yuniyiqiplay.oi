<?php 
 
if(!isset($type)){exit();}

$this->showhd($this->cfg["webname"]."-".$this->cfg["webtitle"]);
 
$type2='tui';
if(isset($_GET["type2"])){
if($_GET["type2"]=="tui" or  $_GET["type2"]=="guan" or  $_GET["type2"]=="jin" or  $_GET["type2"]=="pai"){
$type2=$_GET["type2"];
}
}

 

?>
<Style>
.logo{height:55px;line-height:50px;font-size:17px;font-weight:bold;vertical-align:middle;background-color:#fff;position:fixed;left:0px;width:100%;top:0px;z-index:55;box-shadow: #b9bcbc 0px 8px 8px -8px;}
.logo #logo{display:inline-block;height:55px;line-height:50px;color:#777;float:left;}
#logo span{display:inline-block;height:50px;width:50px;border-radius:25px;margin-right:5px;margin-left:10px;border:0px;}
.logo img{vertical-align:middle;height:50px;border-radius:25px;}
#qq{float:right;margin-right:10px;font-size:20px;}
.sousuo{height:32px;width:32px;float:right;margin-top:11px;margin-right: 8px;background:#fff;display:inline-block;}
.sousuo img{height:32px;width:32px;}
.hmmm{display:inline-block;height:55px;line-height:55px;float:left;color:#777;font-size:20px;font-weight:bold;margin-left:10px;width:60px;text-align:center;}
</Style>
<div style='height:50px;'></div>
<div class='logo'><a  id='logo' href='/'><span><img src='/public/img/logo.png'/></span></a>

<a class='hmmm' href='/?type2=guan'  style='<?php  if($type2=="guan"){ echo "color:#06A17E"; }  ?>'>关注</a>
<a class='hmmm' href='/?type2=tui' style='<?php  if($type2=="tui"){ echo "color:#06A17E"; }  ?>'>推荐</a>
<a class='hmmm' href='/?type2=pai' style='<?php  if($type2=="pai"){ echo "color:#06A17E"; }  ?>'>排行</a> 
<a href='/?type=soso'  class='sousuo'><img src='/public/img/sousuo1.png'/></a>
 


</div>
 
 
<?php  

 
if(isset($_GET["type2"])){
$apis2=array("tui","pai","guan");
$haveapi2=array_search($_GET["type2"],$apis2);
if($haveapi2===false){ 
include "404.html";
}else{
$type2=$_GET["type2"];
$this->show2($type2,$type);
}
}else{
$this->show2($type2,$type);
}




?>
 






<?php  

 
include 'com/ft.php';

?>