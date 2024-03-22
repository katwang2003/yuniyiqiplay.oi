<?php  
include "core/sys.php";
$s=new sys();


if($s->dbname=="数据库名"){
header("location:install.php");
exit();
}




if($_SERVER["REQUEST_METHOD"] == "POST"){
 $s->datajc("post");
$apis=array("user","ht","pb","msg");  

   
 
if(!isset($_POST['api'])  or  !preg_match('/^[a-z0-9\.]{1,20}+$/',$_POST['api']) or !isset($_POST['api2'])  or  !preg_match('/^[a-z0-9\-\.]{1,30}+$/',$_POST['api2'])){
$s->rs("请求失败:接口未指明。");
}
$api=$_POST['api'];  
$api2=$_POST['api2'];

$haveapi=array_search($api,$apis);
if($haveapi===false){
$s->rs("请求失败:非法接口。");
}


if($s->here() and $s->wechat and (!isset($_SESSION["wx"]) or $_SESSION["wx"]=="" ) and  $api2!="mkwx"){
$s->rs("出于站点安全考虑。请绑定微信号后再使用本站各项功能。".$api2);
}

 
$s->getpost($api,$api2);


}else if($_SERVER["REQUEST_METHOD"] == "GET"){
$s->datajc("get");

if(!isset($_GET["type"])){
$_GET["type"]="index";
    
}

if(isset($_GET["type"])){
$apis=array("index","user",
"soso","mai","pub","msg","ht","v","comment","weili","shop");

if($s->here() and $s->wechat and (!isset($_SESSION["wx"]) or $_SESSION["wx"]=="" ) and  (!isset($_GET["type2"]) or (isset($_GET["type2"])  and   $_GET["type2"]!="mkwx") )){
header("location:/?type=user&type2=mkwx");
exit();
}


$haveapi=array_search($_GET["type"],$apis);
if($haveapi===false){ 
include "404.html";
}else{
$type=$_GET["type"];
$s->show($type);
}
}else{
$s->show($type);
}
 
}


?>