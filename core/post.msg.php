<?php  

if(!isset($api2)){
$this->rs("请求失败:非法接口。");
}

if(!$this->here()){
$this->rs("请求失败:请<A href='/?type=user&type2=login'>登录</a>。");
}

$uid=$_SESSION["uid"];

$sql2=$this->Sql("select  `s_user`.`uid`,`s_user`.`nickname`,`s_user`.`face` from  `s_user`  where `uid`='".$this->res($uid)."' limit 0,1");
$u=$this->row2($sql2);


//send
if($api2=="send"){

if(!isset($_POST["uid2"]) or !is_numeric($_POST["uid2"])){
$this->rs("抱歉错误");
}

$uid2=$_POST["uid2"];
if($uid==$uid2){
$this->rs("抱歉:不能给自己发");
}


if(!isset($_POST["msg"]) or empty($_POST["msg"]) ){
$this->rs("发送失败:请输入内容");	
}
$msg=$_POST["msg"];
//$msg=htmlspecialchars($msg, ENT_QUOTES);
$msg=strip_tags(str_replace(" ","",$msg),"<div> <br/>");



$sql2=$this->Sql("select  `s_user`.`uid`,`s_user`.`nickname`,`s_user`.`face` from  `s_user`  where `uid`='".$this->res($uid2)."' limit 0,1");

if($this->num($sql2)==0){
$this->rs("发送失败:对方不存在");	
}
$u2=$this->row2($sql2);


$sql=$this->Sql("select  * from  `s_msguu`  where `uid`='".$this->res($uid)."' and `fromuid`='".$this->res($uid2)."'");
if($this->num($sql)==0){
$this->Sql("INSERT INTO `s_msguu`(`uid`, `fromuid`, `time`) VALUES ('".$this->res($uid)."','".$this->res($uid2)."','".time()."')");
}


$sql2=$this->Sql("select  * from  `s_msguu`  where `uid`='".$this->res($uid2)."' and `fromuid`='".$this->res($uid)."'");
if($this->num($sql2)==0){
$this->Sql("INSERT INTO `s_msguu`(`uid`, `fromuid`, `time`) VALUES ('".$this->res($uid2)."','".$this->res($uid)."','".time()."')");
}
$time=time();

$this->sql("INSERT INTO `s_msgbd`(`uid`, `fromuid`, `touid`, `time`, `readno`, `msg`) VALUES ('".$this->res($uid)."','".$this->res($uid)."','".$this->res($uid2)."','".$time."','1','".$this->res($msg)."')");

$this->sql("INSERT INTO `s_msgbd`(`uid`, `fromuid`, `touid`, `time`, `readno`, `msg`) VALUES ('".$this->res($uid2)."','".$this->res($uid)."','".$this->res($uid2)."','".$time."','0','".$this->res($msg)."')");

$str="<div class='mymsg'><div class='mymsg1'>

<div class='demo2'></div>
<div class='mymsg3'><div class='mymsg31'><div class='mymsg311'>".$msg."</div>
<div class='mymsg312'>
".date("Y-m-d H:i:s",$time)."
</div>
</div></div>
<div class='myface'><img src='/public/face/".$u["face"]."'/></div>
</div></div>";

$this->sql("update `s_msguu` set `readno`=`readno`+1,`time`='".$time."' where `uid`='".$this->res($uid2)."' and `fromuid`='".$this->res($uid)."'  ");
$this->rs($str,1);	

}



//getmsg
else if($api2=="getmsg"){

if(!isset($_POST["uid2"]) or !is_numeric($_POST["uid2"])){
$this->rs("抱歉错误");
}
$uid2=$_POST["uid2"];

$sql2=$this->Sql("select  `s_user`.`uid`,`s_user`.`nickname`,`s_user`.`face` from  `s_user`  where `uid`='".$this->res($uid2)."' limit 0,1");
if($this->num($sql2)==0){
$this->rs("接收失败:对方不存在");	
}
$u2=$this->row2($sql2);



$sqlbd=$this->sql("select  `msg`,`fromuid`,`time`,`bdid` from `s_msgbd` where `uid`='".$uid."' and  `fromuid`='".$uid2."' and `touid`='".$uid."'  and `readno`=0  order by `bdid` asc limit 0,1  ");
 
if($this->num($sqlbd)==0){
$this->rs("接收失败:无消息");	
}
$m=$this->row2($sqlbd);

$str="<div class='imsg'><div class='imsg1'><div class='demo'></div><div class='imsg3'><div class='imsg31'>
<div class='imsg311'>".$m["msg"]."</div>
<div class='imsg312'>
".date("Y-m-d H:i:s",$m["time"])."
</div>
</div></div>
<div class='iface'><img src='/public/face/".$u2["face"]."'/></div>
</div></div>";

$this->sql("update `s_msgbd` set `readno`=1 where  `bdid`='".$m["bdid"]."'");
$this->sql("update `s_msguu` set `readno`=`readno`-1 where `uid`='".$this->res($uid)."' and `fromuid`='".$this->res($uid2)."'  ");
$this->rs($str,1);	


}




//getmsg
else if($api2=="msgnum"){

$sql=$this->Sql("SELECT sum(`readno`)  FROM `s_msguu` WHERE `uid` ='".$uid."' ");
$r=$this->row($sql);
if($r[0]==0){
$this->rs("接收失败:无消息");	
}

$this->rs("消息<span>".$r[0]."</span>",1);	

}



//uulist
else if($api2=="uulist"){

$str="";
$lsss="";
$sql2=$this->sql("SELECT `s_msguu`.`fromuid`,`s_msguu`.`readno`,`s_user`.`face`,`s_user`.`nickname` FROM `s_msguu` left join `s_user` on(`s_msguu`.`fromuid`=`s_user`.`uid`) where `s_msguu`.`uid`='".$_SESSION["uid"]."'   order by `s_msguu`.`time` desc limit 0,50  ");

while($uu=$this->row2($sql2)){
$readno="";
if($uu["readno"]>0){
$readno="<span>".$uu["readno"]."</span>";
}

$lsss= $lsss."<A    href='/?type=msg&type2=send&uid2=".$uu["fromuid"]."'><div class='config'><img src='/public/face/".$uu["face"]."'/>".$uu["nickname"]."
".$readno."
</div></A>";

$str=$str.$readno;


}

if(!isset($_SESSION["md5"])){
$_SESSION["md5"]=md5($str);
$this->rs($lsss,1);	
}else if($_SESSION["md5"]!=md5($str)){
$_SESSION["md5"]=md5($str);
$this->rs($lsss,1);	

}




$this->rs("无变化");	




}

?>