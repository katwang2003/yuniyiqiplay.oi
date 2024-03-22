<?php  
if(!isset($type)){exit();}
$this->nologin();
$type2="index";
  

if(isset($_GET["type2"])){
$apis2=array("index");
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




 

 