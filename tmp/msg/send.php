<?php
if(!isset($type)){exit();}
$this->nologin();
 
$uid=$_SESSION["uid"];

if(!isset($_GET["uid2"]) or !is_numeric($_GET["uid2"])){
header("location:/?type=msg");
exit();
}
$uid2=$_GET["uid2"];

$sql=$this->Sql("select  `s_user`.`uid`,`s_user`.`nickname`,`s_user`.`face` from  `s_user`  where `uid`='".$this->res($uid2)."' limit 0,1");
if($this->num($sql)==0){
header("location:/?type=msg");
exit();
}
$u2=$this->row2($sql);



$sql2=$this->Sql("select  `s_user`.`uid`,`s_user`.`nickname`,`s_user`.`face` from  `s_user`  where `uid`='".$this->res($uid)."' limit 0,1");
$u=$this->row2($sql2);


$this->showhd("发送消息");


$sql=$this->Sql("select  * from  `s_msguu`  where `uid`='".$this->res($uid)."' and `fromuid`='".$this->res($uid2)."'");
if($this->num($sql)==0){
$this->Sql("INSERT INTO `s_msguu`(`uid`, `fromuid`, `time`) VALUES ('".$this->res($uid)."','".$this->res($uid2)."','".time()."')");
}



$sql2=$this->Sql("select  * from  `s_msguu`  where `uid`='".$this->res($uid2)."' and `fromuid`='".$this->res($uid)."'");
if($this->num($sql2)==0){
$this->Sql("INSERT INTO `s_msguu`(`uid`, `fromuid`, `time`) VALUES ('".$this->res($uid2)."','".$this->res($uid)."','".time()."')");
}

?>


<style type="text/css">
.gg{height:40px;position:fixed;width:100%;left:0px;text-indent:10px;top:0px;background-color:#fff;border-bottom:1px solid #f1f1f1;z-index:33;box-shadow: #b9bcbc 0px 8px 8px -8px;}
.gg a{line-height:40px;display:inline-block;height:40px;cursor:pointer;}
.gg span{font-weight:bold;}
.ggar{float:right;margin-right:18px;width:34px;position:relative;display:none;}
.ggar img{width:24px;height:24px;margin-top:8px;}
.ggal{float:left;margin-left:8px;}
 
.file{height:35px;position:absolute;top:0px;left:0px;opacity:0;cursor:pointer;}
.file input {font-size:100px;cursor:pointer;}
.mmam{display:inline-block;position:absolute;height:40px;line-height:40px;top:0px;right:10px;color:#000;}
.mmam img{width:30px;border-radius:15px;height:30px;vertical-align:middle;margin-right:5px;}
.ftmn,.copyright{display:none;}
</style>  
<div style="height:41px;"></div>
<div class='gg'>
<a href='/?type=msg' class='ggal'>返回</a>


<a href='/?type=user&uid=<?php echo $u2["uid"]; ?>' class='mmam'><img src='/public/face/<?php echo $u2["face"]; ?>'/><?php echo $u2["nickname"]; ?></a>
 
</div> 


<style>
.mymsg{width:100%;}	
.mymsg1{margin-right:10px;margin-left:70px;margin-top:10px;position:relative;}
.myface{float:right;margin-top:0px;margin-right:0px;width:32px;height:32px;border-radius:4px;}
.myface img{width:32px;height:32px;}

.mymsg3{float:left;margin-right:-42px;width:100%;}
.mymsg31{background-color:#DCB36C;border-radius:8px;padding:8px;line-height:26px;margin-right:42px;}
.mymsg312{text-align:right;color:#999;font-size:12px;}

.imsg{width:100%;}	
.imsg1{margin-left:10px;margin-right:70px;margin-top:10px;position:relative;}

.iface{float:left;margin-top:0px;margin-left:0px;width:32px;height:32px;border-radius:4px;}
.iface img{width:32px;height:32px;}
.imsg3{float:right;margin-left:-42px;width:100%;}
.imsg31{background-color:#fff;border-radius:8px;padding:8px;line-height:26px;margin-left:42px;}
.imsg312{text-align:right;color:#999;font-size:12px;}


.demo{ width: 0;
            height: 0;
            border-top: 8px solid transparent;
            border-bottom:8px solid transparent ;
            border-left:8px solid transparent;
            border-right:8px solid #fff  ;position:absolute;top:12px;left:29px;
        } 


.demo2{ width: 0;
            height: 0;
            border-top: 8px solid transparent;
            border-bottom:8px solid transparent ;
            border-left:8px solid #DCB36C ;
            border-right:8px solid transparent;position:absolute;top:12px;right:29px;
        }  

       
</style>

<div class='msgls'>

<?php  


$sqlm=$this->sql("select  `msg`,`fromuid`,`time`,`bdid` from (select  `msg`,`fromuid`,`time`,`bdid` from `s_msgbd` where `uid`='".$uid."' and  ((`fromuid`='".$uid2."' and `touid`='".$uid."') or (`fromuid`='".$uid."' and `touid`='".$uid2."') ) and `readno`=1  order by `bdid` desc limit 0,15 ) as `bd` order by `bd`.`bdid` asc ");

while($m=$this->row2($sqlm)){
if($m["fromuid"]==$uid){
echo "<div class='mymsg'><div class='mymsg1'><div class='demo2'></div>
<div class='mymsg3'><div class='mymsg31'><div class='mymsg311'>".$m["msg"]."</div>
<div class='mymsg312'>
".date("Y-m-d H:i:s",$m["time"])."
</div>
</div></div>
<div class='myface'><img src='/public/face/".$u["face"]."'/></div>
</div></div>";
}else{

echo "<div class='imsg'><div class='imsg1'><div class='demo'></div><div class='imsg3'><div class='imsg31'>
<div class='imsg311'>".$m["msg"]."</div>
<div class='imsg312'>
".date("Y-m-d H:i:s",$m["time"])."
</div>
</div></div>
<div class='iface'><img src='/public/face/".$u2["face"]."'/></div>
</div></div>";

}





}

?>

	

	








</div>

<div style="height:30px;"></div>

<style>
.sendbox{width:100%;min-height:75px;position:fixed;left:0px;bottom:0px;background-color:#fff;z-index:55}	
.sendbox2{float:left;width:100%;}
#editable{border-radius:5px;border:1px solid #999999;background-color:#fff;padding:2px;line-height:23px;min-height:50px;background-color:#fff;margin-right:75px;margin-left:10px;}
.send{display:inline-block;float:right;z-index:33;position:absolute;right:10px;width:60px;height:52px;line-height:52px;text-align:center;border-radius:5px;border:1px solid #999999;}
</style>

<div class='sendbox'>
<div class='sendbox2'><div id="editable" contenteditable="true"  ></div></div><a href="#" class='send'>发送</a>
</div>


<script type="text/javascript">
 


$(document).ready(function(){


setTimeout(function(){
$(window).scrollTop($(document).height());	
},500);



 
$(".send").click(function(){
 

$.post("/index.php",{"api":"msg","api2":"send","msg":$("#editable").html(),"uid2":"<?php echo $uid2; ?>"},function(json){
if(json[0]==1){
$(".msgls").append(json[1]);
$("#editable").html("");
$(window).scrollTop($(document).height());
}else{
rs(json[1]);
}


},"json");
return false;
});




getmsg();




});



function  getmsg(){
$.post("/index.php",{"api":"msg","api2":"getmsg","uid2":"<?php echo $uid2; ?>"},function(json){
if(json[0]==1){
$(".msgls").append(json[1]);
$(window).scrollTop($(document).height());
setTimeout(function(){
getmsg(); 	
},400);
}else{
setTimeout(function(){
getmsg(); 	
},4000);
}
},"json");
}

</script>