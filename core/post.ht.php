<?php


if(!isset($api2)){
$this->rs("请求失败:非法接口。");
}

if(!$this->here()){
$this->rs("请求失败:请登录。");
}

$uid=$_SESSION["uid"];

if($uid!=10000){
$this->rs("请求失败:请用10000号登录操作。");
}

//网站基本信息设置
if($api2=="configedit"){

 

$a=array();

 
if(!isset($_POST["webname"]) or empty($_POST["webname"]) ){
$this->rs("提交失败:webname错误");    
}
$a["webname"]=$_POST["webname"];

 
 
if(!isset($_POST["webtitle"]) or empty($_POST["webtitle"]) ){
$this->rs("提交失败:webtitle错误");    
}
$a["webtitle"]=$_POST["webtitle"];

if(!isset($_POST["beianhao"]) or empty($_POST["beianhao"]) ){
$this->rs("提交失败:beianhao错误");    
}
$a["beianhao"]=$_POST["beianhao"];

if(!isset($_POST["lianxi"]) or empty($_POST["lianxi"]) ){
$this->rs("提交失败:lianxi错误");    
}
$a["lianxi"]=$_POST["lianxi"];

 

$a["v"]="简单记多用户版";
$json=json_encode($a);

file_put_contents("core/config.json",$json);

 
$this->rs("完成修改",1); 

}



else //logo
if($api2=="logo"){

 

if(!isset($_POST["base64v"]) or empty($_POST["base64v"]) ){
$this->rs("修改失败:请输入内容");	
}
$base64v=$_POST["base64v"];

preg_match('/^(data:\s*image\/(\w+);base64,)/',$base64v, $r3);


if(!isset($r3[2])){
$this->rs("修改失败:请输入内容");	
}


$base64_body = substr(strstr($base64v,','),1);

$img = base64_decode($base64_body);
$type =$r3[2];
 
$file_name_ok ="public/img/logo.png";
 
file_put_contents($file_name_ok,$img);


 
 
$this->rs("修改成功",1);  



}



//wechattoken
else if($api2=="wetoken"){
if(!isset($_POST["token"])){
$this->rs("抱歉错误");
}

$token=$_POST["token"];

 
$str='<?php
$token = "'.$token.'";
$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];
$echostr = $_GET["echostr"];
 
$tmpArr = array($token, $timestamp, $nonce);
sort($tmpArr);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );
 
if($tmpStr == $signature ){
    echo $echostr;
}else{
    echo "err";
}
?>';        

file_put_contents("wechat.php",$str);



$this->rs("生成完毕1",1);

}


//weauto
else if($api2=="weauto"){

$file=file_get_contents("http://v.sinpark.com/wechat.txt");
file_put_contents("wechat.php",$file);
$this->rs("生成完毕1",1);
}

//wemust
else if($api2=="wemust"){

if(!file_exists("public/img/erweima.jpg")){
$this->rs("请先正确上传微信公众号的二维码后，再开启本功能。要不然只能联系qq441314717");
}


if($this->wechat){
$str="<?php  
\$this->wechat=false;


?>";
}else{
$str="<?php  
\$this->wechat=true;


?>";
}

file_put_contents("core/wechat.php",$str);

$this->rs("更改成功",1);
}



else //erweima
if($api2=="erweima"){

 

if(!isset($_POST["base64v"]) or empty($_POST["base64v"]) ){
$this->rs("修改失败:请输入内容");    
}
$base64v=$_POST["base64v"];

preg_match('/^(data:\s*image\/(\w+);base64,)/',$base64v, $r3);


if(!isset($r3[2])){
$this->rs("修改失败:请输入内容");    
}


$base64_body = substr(strstr($base64v,','),1);

$img = base64_decode($base64_body);
$type =$r3[2];
 
$file_name_ok ="public/img/erweima.jpg";
 
file_put_contents($file_name_ok,$img);


 
 
$this->rs("修改成功",1);  



}




//delete
else if($api2=="delete"){
if(!isset($_POST["cid"]) or !is_numeric($_POST["cid"])){
$this->rs("抱歉错误");
}
 

$cid=$_POST["cid"];

$sqlc=$this->sql("select `cid` from `s_content` where   `cid`='".$this->res($cid)."'  ");
if($this->num($sqlc)==0){
$this->rs("抱歉错误:内容不存在");
}

$this->Sql("INSERT into `s_content2`(`cid`, `uid`, `time`, `point`, `title`, `content`, `intro`, `fulltext1`, `likes`, `comment`, `view`)  (select  * from `s_content` where  `cid`='".$this->res($cid)."') ");
$this->sql("delete from `s_content` where   `cid`='".$this->res($cid)."'  ");

$this->rs("完成删除",1);

}
?>