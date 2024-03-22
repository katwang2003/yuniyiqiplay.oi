<?php  


if(!isset($api2)){
$this->rs("请求失败:非法接口。");
}
 

//统计

if($api2=="tj"){
 

if(!isset($_SESSION["uiid"]) and  !isset($_SESSION["uid"])){
$dowhat="未登录用户";
$this->useripdo($dowhat);
}else if(isset($_SESSION["uiid"]) and  !isset($_SESSION["uid"])){
$this->sql("update  `s_userip` set  `lasttime`='".time()."'  where `uiid`='".$_SESSION["uiid"]."'  ");
}else if(isset($_SESSION["uid"])){
$this->sql("update  `s_user` set  `lasttime`='".time()."'  where `uid`='".$_SESSION["uid"]."'  ");
}

 

}
 


else //reg
if($api2=="reg"){
 


if(!isset($_POST["un"]) or empty($_POST["un"]) ){
$this->rs("注册失败:账号错误");	
}
$un=$_POST["un"];
if(!preg_match('/^[a-z0-9A-Z]{3,20}+$/',$un) ){
$this->rs("注册失败:账号格式错误:3位以上数字或字母不区分大小写");	
}


if($this->wechat){

if(!isset($_POST["id"]) or !is_numeric($_POST["id"])){
$this->rs("抱歉错误");
}

$id=$_POST["id"];

$slll=$this->Sql("select  `dowhat` from `s_userip` where `uiid`='".$this->res($id)."' and `time`>='".(time()-1800)."' and `dowhat` like '公众号绑定%' limit 0,1");

if($this->num($slll)==0){
$this->rs("抱歉错误:无效验证码，请重新扫码获取");
} 
$r=$this->row($slll);

$wx=str_replace("公众号绑定", "",$r[0]);

}


if(!isset($_POST["pw"]) or empty($_POST["pw"]) ){
$this->rs("注册失败:请设置密码");	
}
$pw=md5("sinpark".md5($_POST["pw"]));

$ip=$this->getIP();

$sql=$this->Sql("select `uiid` from `s_userip` where `ip`='".$this->res($ip)."' and  `dowhat`='注册账号' limit 0,5");
if($this->num($sql)>=3){
$this->rs("注册失败:该IP已被暂停注册账号");	
}

$sql=$this->Sql("select `uid` from `s_user` where `username`='".$this->res($un)."'");
if($this->num($sql)>0){
$this->rs("注册失败:该用户名已被使用");	
}
if(!isset($wx)){
$this->sql("INSERT INTO `s_user`( `username`, `password`, `time`, `nickname`) VALUES ('".$this->res($un)."','".$this->res($pw)."','".time()."','".$this->res(md5($un))."')");
}else{
$this->sql("INSERT INTO `s_user`( `username`, `password`, `time`, `nickname`,`wx`) VALUES ('".$this->res($un)."','".$this->res($pw)."','".time()."','".$this->res(md5($un))."','".$this->res($wx)."')");
$this->sql("delete from `s_userip` where `id`='".$this->res($id)."' ");
$_SESSION["wx"]=$wx;
}

$_SESSION["uid"]=mysql_insert_id();

$this->sql("update  `s_user` set `fuid`='".$_SESSION["uid"]."' where `uid`='".$_SESSION["uid"]."'");
$dowhat="注册账号";
$this->useripdo($dowhat,$_SESSION["uid"]);

$this->rs("注册成功",1);	
}





else //login
if($api2=="login"){
 


if(!isset($_POST["un"]) or empty($_POST["un"]) ){
$this->rs("登录失败:账号错误");	
}
$un=$_POST["un"];
if(!preg_match('/^[a-z0-9A-Z]{3,20}+$/',$un) ){
$this->rs("登录失败:账号格式错误:3位以上数字或字母");	
}



if(!isset($_POST["pw"]) or empty($_POST["pw"]) ){
$this->rs("登录失败:请设置密码");	
}
$pw=md5("sinpark".md5($_POST["pw"]));



$sql=$this->Sql("select `ban`,`coin` from `s_user` where `username`='".$this->res($un)."'");
if($this->num($sql)==0){
$this->rs("登录失败:该用户不存在");	
}

$r22=$this->row($sql);
if($r22["ban"]==1){
$this->rs("登录失败:该用户已被封"); 
}
if($r22["coin"]<0){
$this->rs("登录失败:该用户存在恶意行为被系统自动封锁了。"); 
}


$sql2=$this->Sql("select `uid`,`wx` from `s_user` where `username`='".$this->res($un)."'  and `password`='".$this->res($pw)."' limit 0,1  ");
if($this->num($sql2)==0){
$this->rs("登录失败:密码错误");	
}

 
$r=$this->row($sql2);
$_SESSION["uid"]=$r[0];
$_SESSION["wx"]=$r[1];
$this->useripdo("登录网站",$_SESSION["uid"]);
$this->rs("登录成功",1);	
}





else //添加face
if($api2=="facemake"){

 if(!$this->here()){
$this->rs("请求失败:请登录。");
}

$uid=$_SESSION["uid"];


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
$face=md5($base64v).".".$type;
$file_name_ok ="public/face/".md5($base64v).".".$type;
 
file_put_contents($file_name_ok,$img);



$this->Sql("update `s_user` set `face`='".$this->res($face)."' where `uid`='".$uid."' ");

 
$this->rs("修改成功",1);  



}



else //添加nn
if($api2=="nickname"){

  if(!$this->here()){
$this->rs("请求失败:请登录。");
}

$uid=$_SESSION["uid"];

if(!isset($_POST["nn"]) or empty($_POST["nn"]) ){
$this->rs("修改失败:请输入昵称");	
}
$nn=$_POST["nn"];

if(!preg_match('/^[a-zA-Z0-9\x{4e00}-\x{9fa5}]+$/u',$nn)){
$this->rs("修改失败:请输入中文英文或数字");
}
 
$sql=$this->sql("select `uid` from `s_user` where `nickname`='".$this->res($nn)."'  and  `uid`!='".$uid."'");

if($this->num($sql)>0){
$this->rs("修改失败:昵称已被使用");
}
$this->Sql("update `s_user` set `nickname`='".$this->res($nn)."' where `uid`='".$uid."' ");

  
$this->rs("修改成功",1);  



}





else //添加关注
if($api2=="follow"){

if(!$this->here()){
$this->rs("请求失败:请<A href='/?type=user&type2=login'>登录</a>。");
}

$uid=$_SESSION["uid"];


if(!isset($_POST["uid2"]) or !is_numeric($_POST["uid2"])){
$this->rs("抱歉错误");
}

$uid2=$_POST["uid2"];

if($uid==$uid2){
$this->rs("抱歉:自己不能关注自己");
}



$sql=$this->sql("select `uid` from `s_user` where `uid`='".$this->res($uid2)."'");

if($this->num($sql)==0){
$this->rs("抱歉:不存在该用户");
}


$sql=$this->sql("select `fid` from `s_follow` where  `uid`='".$uid."' and  `uid2`='".$this->res($uid2)."'");


if($this->num($sql)==0){
$this->sql("INSERT INTO `s_follow`( `uid`, `time`, `uid2`) VALUES ('".$uid."','".time()."','".$this->res($uid2)."')");
$this->Sql("update  `s_user` set `followed`=`followed`+1 where `uid`='".$uid2."' ");
$this->Sql("update  `s_user` set `follow`=`follow`+1 where `uid`='".$uid."' ");

$this->rs("成功关注",1);
}


$this->rs("抱歉:已关注");

}



else //取消关注
if($api2=="followend"){

if(!$this->here()){
$this->rs("请求失败:请<A href='/?type=user&type2=login'>登录</a>。");
}

$uid=$_SESSION["uid"];


if(!isset($_POST["uid2"]) or !is_numeric($_POST["uid2"])){
$this->rs("抱歉错误");
}

$uid2=$_POST["uid2"];

if($uid==$uid2){
$this->rs("抱歉:自己不能取消关注自己");
}



$sql=$this->sql("select `uid` from `s_user` where `uid`='".$this->res($uid2)."'");

if($this->num($sql)==0){
$this->rs("抱歉:不存在该用户");
}


$sql=$this->sql("select `fid` from `s_follow` where  `uid`='".$uid."' and  `uid2`='".$this->res($uid2)."'");


if($this->num($sql)==1){
$this->sql("delete  from `s_follow` where  `uid`='".$uid."' and  `uid2`='".$this->res($uid2)."'");
$this->Sql("update  `s_user` set `followed`=`followed`-1 where `uid`='".$uid2."' ");
$this->Sql("update  `s_user` set `follow`=`follow`-1 where `uid`='".$uid."' ");

$this->rs("成功取关",1);
}


$this->rs("抱歉:未关注");

}




else //pw
if($api2=="password"){

 if(!$this->here()){
$this->rs("请求失败:请<A href='/?type=user&type2=login'>登录</a>。");
}


$uid=$_SESSION["uid"];

if(!isset($_POST["pw"]) or empty($_POST["pw"]) ){
$this->rs("修改失败:请输入原密码");  
}
 
$pw=md5("sinpark".md5($_POST["pw"]));


$sql=$this->Sql("select `uid` from `s_user` where `uid`='".$uid."' and  `password`='".$this->res($pw)."'"); 
if($this->num($sql)==0){
$s->rs("修改失败:原密码错误");   
}

if(!isset($_POST["pw2"]) or empty($_POST["pw2"]) ){
$this->rs("修改失败:请输入新密码");  
}
 
$pw2=md5("sinpark".md5($_POST["pw2"]));

 
$this->Sql("update  `s_user` set `password`='".$this->res($pw2)."' where `uid`='".$uid."' ");
session_destroy();
$this->rs("修改成功",1);  



}


else //mkwx
if($api2=="mkwx"){

 if(!$this->here()){
$this->rs("请求失败:请<A href='/?type=user&type2=login'>登录</a>。");
}
if(!$this->wechat){
$this->rs("抱歉错误:本站未开启微信号绑定");
}

$uid=$_SESSION["uid"];

if(isset($_SESSION["wx"]) and $_SESSION["wx"]!=""){
$this->rs("抱歉错误:改账号已绑定微信号");
}

if(!isset($_POST["id"]) or !is_numeric($_POST["id"])){
$this->rs("抱歉错误");
}

$id=$_POST["id"];

$slll=$this->Sql("select  `dowhat` from `s_userip` where `uiid`='".$this->res($id)."' and `time`>='".(time()-1800)."' and `dowhat` like '公众号绑定%' limit 0,1");

if($this->num($slll)==0){
$this->rs("抱歉错误:无效验证码，请重新扫码获取");
} 
$r=$this->row($slll);

$wx=str_replace("公众号绑定", "",$r[0]);

$_SESSION["wx"]=$wx;
$this->sql("update  `s_user` set `wx`='".$this->res($wx)."'  where `uid`='".$uid."' ");
$this->sql("delete from `s_userip` where `id`='".$this->res($id)."' ");

$this->rs("成功绑定",1);
}






else //qiehuan
if($api2=="qiehuan"){

if(!$this->here()){
$this->rs("请求失败:请<A href='/?type=user&type2=login'>登录</a>。");
}

$uid=$_SESSION["uid"];

if(!$this->wechat){
$this->rs("抱歉错误:本站未开启微信号绑定");
}


if(!isset($_POST["uid"]) or !is_numeric($_POST["uid"])){
$this->rs("抱歉错误");
}

$uid2=$_POST["uid"];





$sql=$this->sql("select `uid` from `s_user` where `uid`='".$this->res($uid2)."' and `wx`='".$_SESSION["wx"]."'");

if($this->num($sql)==0){
$this->rs("抱歉:查询不到有效用户");
}
$r=$this->row($sql);
$_SESSION["uid"]=$r[0];
 
$this->rs("成功切换",1);
 
}




else //forget
if($api2=="forget"){
 


if(!isset($_POST["un"]) or empty($_POST["un"]) ){
$this->rs("找回失败:账号错误"); 
}
$un=$_POST["un"];
if(!preg_match('/^[a-z0-9A-Z]{3,20}+$/',$un) ){
$this->rs("找回失败:账号格式错误:3位以上数字或字母不区分大小写"); 
}


if(!$this->wechat){
$this->rs("找回失败:本站未开启微信号绑定服务，无法提供找回账号服务。"); 
}

if(!isset($_POST["id"]) or !is_numeric($_POST["id"])){
$this->rs("抱歉错误");
}

$id=$_POST["id"];

$slll=$this->Sql("select  `dowhat` from `s_userip` where `uiid`='".$this->res($id)."' and `time`>='".(time()-1800)."' and `dowhat` like '公众号绑定%' limit 0,1");

if($this->num($slll)==0){
$this->rs("抱歉错误:无效验证码，请重新扫码获取");
} 
$r=$this->row($slll);

$wx=str_replace("公众号绑定", "",$r[0]);

$this->sql("delete from `s_userip` where `id`='".$this->res($id)."' ");


if(!isset($_POST["pw"]) or empty($_POST["pw"]) ){
$this->rs("找回失败:请设置密码");  
}
$pw=md5("sinpark".md5($_POST["pw"]));



$sql=$this->Sql("select `uid`,`wx` from `s_user` where `username`='".$this->res($un)."' and `wx`='".$this->res($wx)."'");
if($this->num($sql)==0){
$this->rs("找回失败:不存在该用户"); 
}
 
$r=$this->row($sql);

$this->sql("update  `s_user` set `password`='".$this->res($pw)."' where `uid`='".$r[0]."'");


$_SESSION["uid"]=$r[0];
$_SESSION["wx"]=$r[1];
$dowhat="找回账号";
$this->useripdo($dowhat,$_SESSION["uid"]);

$this->rs("找回成功",1);  
}

?>