<?php  
session_set_cookie_params(6*24*3600);
header("Content-Type: text/html; charset=UTF-8");
ini_set('date.timezone','Asia/Shanghai');
session_start(); 
$time=time();

class  sys{
function __construct( ){

$config=file_get_contents("core/config.json");
$this->cfg=json_decode($config,true);


 
 
//数据库配置

include "core/config.php";
include "core/wechat.php";
@$this->tomysql();
}
//连接mysql
function tomysql(){
$conn=mysql_connect($this->host,$this->username,$this->password);
mysql_select_db($this->dbname,$conn);
mysql_set_charset('utf8',$conn);	
}  

//mysql常用操作
 function row($sql){
return mysql_fetch_row($sql);		
}
 function row2($sql){
return mysql_fetch_array($sql,MYSQL_ASSOC);		
}
 function num($sql){
return mysql_num_rows($sql);	
}
  function sql($sql){
return mysql_query($sql);	
}
  function res($str){
return mysql_real_escape_string($str);	
}

 

//备注行为
function userip($str,$f=1){
$this->sql("INSERT INTO `s_userip`( `uid`, `ip`, `session_id`, `REMOTE_PORT`, `HTTP_USER_AGENT`, `time`, `dowhat`) VALUES ('".$_SESSION["uid"]."','".$this->res($this->getIP())."','".session_id()."','".$_SERVER["REMOTE_PORT"]."','".$_SERVER["HTTP_USER_AGENT"]."','".time()."','".$this->res($str)."')"); 
if($f==2){
return mysql_insert_id();
}   
}




function show($type){
include dirname(dirname(__FILE__))."/tmp/".$type.".php";
echo "</body></html>";
}


function show2($type2,$type){
include dirname(dirname(__FILE__))."/tmp/".$type."/".$type2.".php";
echo "</body></html>";
}


function showhd($title){
include "hd.php";
}

function getpost($api,$api2){
include  "post.".$api.'.php';
}

//判断登录
 function here(){
if(isset($_SESSION["uid"])){
return  true;
}else{
return  false;
}
}

//提示登录
 function nologin(){
if(!$this->here()){
echo "<script>location.href='/?type=user&type2=login';</script>";
exit();
}
}



//返回错误信息
function rs($rs1="系统故障",$rs0="0"){
$rs=array();
$rs[0]=$rs0;
$rs[1]=$rs1;
echo json_encode($rs);	
exit();	
}


//mycoin
function mycoin(){
$sql=$this->sql("select `coin` from `s_user` where `uid`='".$_SESSION["uid"]."'");
$r=$this->row2($sql);
return $r["coin"];
}

function usecoin($coin,$reason,$uid){
$this->sql("update  `s_user` set `coin`=(`coin`+".$coin.")  where  `uid`='".$uid."'  ");
$this->sql("INSERT INTO `s_wcoin`( `uid`, `coin`, `time`, `reason`) VALUES ('".$this->res($uid)."','".$this->res($coin)."','".time()."','".$this->res($reason)."')  ");
}



//亲密度
function qinmidu($uid2){
if($this->here()){
$this->sql("update `s_follow` set `qinmidu`=`qinmidu`+1 where `uid`='".$_SESSION["uid"]."' and `uid2`='".$uid2."'");

}
}


//阅读

//iview
function iview($cid){
if($this->here()){
$sql=$this->sql("select `vid` from `s_cview` where  `uid`='".$_SESSION["uid"]."' and  `cid`='".$this->res($cid)."'");
if($this->num($sql)==0){
$this->sql("update `s_content` set `view`=`view`+1 where  `cid`='".$this->res($cid)."'");
$this->sql("INSERT INTO `s_cview`( `uid`, `time`, `cid`) VALUES ('".$_SESSION["uid"]."','".time()."','".$this->res($cid)."')");
return  mysql_insert_id();
}else{
$r=$this->row($sql); 
return  $r[0];
}
}else if(isset($_SESSION["uiid"])){
$sql=$this->sql("select `vid` from `s_cview` where  `uiid`='".$_SESSION["uiid"]."' and  `cid`='".$this->res($cid)."'");
if($this->num($sql)==0){
$this->sql("update `s_content` set `view`=`view`+1 where  `cid`='".$this->res($cid)."'");
$this->sql("INSERT INTO `s_cview`( `uiid`, `time`, `cid`) VALUES ('".$_SESSION["uiid"]."','".time()."','".$this->res($cid)."')");
return  mysql_insert_id();
}else{
$r=$this->row($sql); 
return  $r[0];
}
}else{
 return  0;   
}


}



function getIP(){
    if (getenv("HTTP_CLIENT_IP"))
        $ip = getenv("HTTP_CLIENT_IP");
    else if(getenv("HTTP_X_FORWARDED_FOR"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    else if(getenv("REMOTE_ADDR"))
        $ip = getenv("REMOTE_ADDR");
    else $ip = "Unknow";
    if(preg_match('/^((?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1 -9]?\d))))$/', $ip))
        return $ip;
    else
        return '';
}



function useripdo($dowhat,$uid=0){
$sesion_id=session_id();
$REMOTE_PORT=$_SERVER["REMOTE_PORT"];
$HTTP_USER_AGENT=$_SERVER["HTTP_USER_AGENT"];
$lasttime=$time=time();
$ip=$this->getIP();
$this->sql("INSERT INTO `s_userip`(`uid`,`ip`, `session_id`, `REMOTE_PORT`, `HTTP_USER_AGENT`, `time`, `lasttime`, `dowhat`) VALUES 
    ('".$uid."','".$this->res($ip)."','".$sesion_id."','".$this->res($REMOTE_PORT)."','".$this->res($HTTP_USER_AGENT)."','".$time."','".$lasttime."','".$dowhat."')");    
 
if($dowhat=="未登录用户"){
$_SESSION["uiid"]=mysql_insert_id();
}
}




//数据检测
function datajc($str){
if($str=="post"){
$ssss=$_POST;
}else{
$ssss=$_GET;
}
$mmm=implode(",",$ssss);
$array=array("error_log","phpinfo","scandir","syslog","readlink","stream_socket_server","passthru","exec(","chroot","chgrp","chown","shell_exec","proc_open","proc_get_status","ini_set","ini_alter","ini_restore","pfsockopen","symlink","popen","putenv","fsockopen","eval(","call_user_func","call_user_func_array","create_function","array_walk","array_map","array_filter","usort","ob_start"); 
 
foreach ($array as $k => $v) {
if (substr_count ($mmm,$v) > 0) {
$this->rs("SOS:dont do that!".$v);
}
}




}



}



?>