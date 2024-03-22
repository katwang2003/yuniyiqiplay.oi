<?php  


include "core/sys.php";
$s=new sys();




 if(isset($_POST["api"])){
$api=$_POST["api"];

if($api=="editmysql"){



if(!isset($_POST["host"]) or empty($_POST["host"]) ){
$s->rs("修改失败:请输入host");  
}
 
$host=$_POST["host"];

if(!isset($_POST["dbname"]) or empty($_POST["dbname"]) ){
$s->rs("修改失败:请输入dbname");  
}
 
$dbname=$_POST["dbname"];


if(!isset($_POST["username"]) or empty($_POST["username"]) ){
$s->rs("修改失败:请输入username");  
}
 
$username=$_POST["username"];

if(!isset($_POST["password"]) or empty($_POST["password"]) ){
$s->rs("修改失败:请输入password");  
}
 
$password=$_POST["password"];


$str='<?php



$this->host="'.$host.'";
$this->dbname="'.$dbname.'";
$this->username="'.$username.'";
$this->password="'.$password.'";

?>';

 
file_put_contents("core/config.php", $str);

 $s->rs("完成修改",1);  

}


if($api=="mysqltb"){
$sql=file_get_contents("http://v.sinpark.com/sql.txt");
$sqls=explode(";",$sql);
  
foreach ($sqls as $k => $v) {
$s->sql($v);
}
 $s->rs("完成创建",1); 
}



else  if($api=="adduser"){

if(!isset($_POST["un"]) or empty($_POST["un"]) ){
$s->rs("提交失败:账号错误");  
}
$un=$_POST["un"];


if(!preg_match('/^[a-z0-9A-Z]{3,20}+$/',$un) ){
$s->rs("注册失败:账号格式错误:3位以上数字或字母不区分大小写");	
}

 
if(!isset($_POST["pw"]) or empty($_POST["pw"]) ){
$s->rs("提交失败:密码错误");  
}
$pw=md5("sinpark".md5($_POST["pw"]));


 
 

$s->sql("INSERT INTO `s_user`(`uid`, `username`, `password`, `time`, `nickname`) VALUES ('10000','".$s->res($un)."','".$s->res($pw)."','".time()."','".$s->res(md5($un))."')");
$s->rs("完成",1); 


}

exit();
}

$s->showhd("轻论坛 V1.2安装程序");
?>

<style>
	
.welcome{margin:10px;background:#fff;padding:10px;border-radius:8px;line-height:25px;}
.acbox2{width:100%;z-index:34;margin-top:10px;}
.acbox21{margin:9px auto;}
.acbox22{margin:10px;padding:0px 10px 10px 10px; background-color:#fff;border-radius:10px;}
.acbox221{height:50px;}
.acbox221 a{display:inline-block;height:30px;line-height:30px;margin-top:10px;border-radius:5px;color:#fff;font-size:18px;font-weight:bold;padding:0px 8px 0px 8px;}
.acbox221 .accl{background-color:#515151;float:left;}
.acbox221 .acok{background-color:#d4237a;float:left;}
.acbox221 .acok2{background-color:green;float:left;}
.intype{line-height:40px;}
.intel{border-radius:5px;border:1px solid #999999;margin:5px 1px 0px 1px;height:35px;background-color:#fff;padding-left:5px;padding-right:5px;}
.intel input{border:0px;padding:0px;width:100%;background-color:#fff;padding-bottom:10px;padding-top:10px;height:15px;}
.insos{color:red;line-height:30px;}
 
 
</style>
<Div class='welcome'>
欢迎来到轻论坛多用户版,多用户版与普通轻论坛的不同之处，在于他支持多人创作，从而使得你的网站有更多的可能性。1.0已经可以使用了，不过，存在大量的工作还没完成，但是已经可以使用了。我会在后续版本中完善还没完成的工作。<a href='https://sinpark.com/a/54.html'>使用协议</a>遇到困难请加qq2378709675或手机号18060066375 （只要我有看到）
</Div>


<Div class='welcome'>
<?php  
 
$con=mysql_connect($s->host,$s->username,$s->password);
if(!$con){
?>

没有正常连上数据库请按下方表格要求做好配置工作。


<Div class='acbox2 acboxh'><Div class='acbox21'><Div class='acbox22'>

<div class="insos">配置mysql账号信息</div>  
<div class="intel"><input id='host'  placeholder='数据库地址' value='localhost'/></div>
<div class="intel"><input id='dbname'  placeholder='数据库名'/></div> 
<div class="intel"><input id='username'  placeholder='数据库用户名'/></div> 
<div class="intel"><input id='password'  placeholder='数据库密码'/></div> 

  
<Div class='acbox221'><a href='#' class='acok  editmysql'>确认修改</a></Div>

 
<div></div></Div>   

<script>
$(function(){



$(".editmysql").click(function(){
 

$.post("/install.php",{"api":"editmysql","host":$("#host").val(),"dbname":$("#dbname").val(),"username":$("#username").val(),"password":$("#password").val()},function(json){
if(json[0]==1){
location.reload(); 
}else{
rs(json[1]);
}
},"json");
return false;
});


});
</script>
<?php
}else{
echo "数据库已连接";

}
?>

</Div>



<Div class='welcome'>
<?php  
if(!$con){
echo "请先配置数据库";
}else{
echo "数据库已连接。";
$aa=array("s_clikes","s_comlikes","s_comment","s_content","s_content2","s_cview","s_follow","s_keyword","s_msgbd","s_msguu","s_user","s_userip","s_wcoin");
$sql=$s->Sql("show tables");
$num=0;
while($r=$s->row($sql)){
$haveapi=array_search($r[0],$aa);
if($haveapi===false){ 


}else{
$num=$num+1;
}
}

if(count($aa)!=$num and $num>0){
echo "<br/>数据表创建存在异常";
}else if(count($aa)==$num){
echo "<br/>数据表创建已成功";
}else if($num==0){
echo "<br/>JDJ plus 的数据表固定前缀s_
<Div class='acbox221'><a href='#' class='acok  mysqltb'>创建数据表</a></Div>";

echo '<script>
$(function(){



$(".mysqltb").click(function(){
 

$.post("/install.php",{"api":"mysqltb"},function(json){
if(json[0]==1){
location.reload(); 
}else{
rs(json[1]);
}
},"json");
return false;
});


});
</script>
  ';
}




}
?>
</div>
 

<div class='welcome'>
<?php  
if(count($aa)==$num){
$sql=$s->sql("select `uid` from `s_user` where  `uid`=10000 ");	
$num=$s->num($sql);
if($num==1){
echo "已经创建了超管账号<a href='/?type=user&type2=login'>立即登录</a>,安装工作已经完成，请删除根目录下的install.php";
}else{
?>
<Div class='acbox2 acboxh'><Div class='acbox21'><Div class='acbox22'>

<div class="insos">创建超管账号</div>  
<div class="intel"><input id='un'  placeholder='用户名'/></div> 
<div class="intel"><input id='pw'  placeholder='密码'/></div> 

  
<Div class='acbox221'><a href='#' class='acok  adduser'>确认修改</a></Div>




<div></div></Div>   
<script>
$(function(){



$(".adduser").click(function(){
 

$.post("/install.php",{"api":"adduser","un":$("#un").val(),"pw":$("#pw").val()},function(json){
if(json[0]==1){
location.reload() ; 
}else{
rs(json[1]);
}
},"json");
return false;
});


});
</script>


<?php 

}
}else {

echo "请先创建数据表";
}

?>	


</div>