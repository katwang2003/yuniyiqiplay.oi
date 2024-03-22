<?php 
if(!isset($type)){exit();}
$this->showhd("留言");
 
 
 
 
?>
<Style>
.logo{height:55px;line-height:50px;font-size:17px;font-weight:bold;vertical-align:middle;background-color:#fff;position:fixed;left:0px;width:100%;top:0px;z-index:55;box-shadow: #b9bcbc 0px 8px 8px -8px;}
.logo #logo{display:inline-block;height:55px;line-height:50px;color:#777;float:left;margin-left:8px;}
#logo span{display:inline-block;height:50px;width:50px;border-radius:25px;margin-right:5px;margin-left:10px;border:0px;}
.logo img{vertical-align:middle;height:50px;border-radius:25px;}
#qq{float:right;margin-right:10px;font-size:20px;}
.sousuo{height:55px;width:35%;z-index:33;position:absolute;top:0px;right: 0px;background:#fff;}
 
</Style>
<div style='height:50px;'></div>
<div class='logo'><a  id='logo' href='/?type=msg'>消息</a>
 
 

</div>
 
<style>
.config{margin:10px 10px 0px 10px;border-radius:8px;padding:8px;line-height:32px;height:32px;background-color:#fff;position:relative;}  
.config img{height:32px;width:32px;margin-right:8px;vertical-align:middle;}
.config span{height:20px;border-radius:10px;padding:0px 5px 0px 5px;position:absolute;top:14px;line-height:20px;right:10px;background-color:red;color:#fff;font-weight:bold;}
</style>  
<Div class='uulist'>
<?php  
$str="";

$sql2=$this->sql("SELECT `s_msguu`.`fromuid`,`s_msguu`.`readno`,`s_user`.`face`,`s_user`.`nickname` FROM `s_msguu` left join `s_user` on(`s_msguu`.`fromuid`=`s_user`.`uid`) where `s_msguu`.`uid`='".$_SESSION["uid"]."'   order by `s_msguu`.`time` desc limit 0,50  ");

while($uu=$this->row2($sql2)){
$readno="";
if($uu["readno"]>0){
$readno="<span>".$uu["readno"]."</span>";
}

echo "<A    href='/?type=msg&type2=send&uid2=".$uu["fromuid"]."'><div class='config'><img src='/public/face/".$uu["face"]."'/>".$uu["nickname"]."
".$readno."
</div></A>";

$str=$str.$readno;


}

$_SESSION["md5"]=md5($str);


?>

</Div>
<script type="text/javascript">
    

$(function(){

uulist();
});

function  uulist(){
$.post("/index.php",{"api":"msg","api2":"uulist" },function(json){
if(json[0]==1){
$(".uulist").html(json[1]);
setTimeout(function(){
uulist();   
},800);
}else{
setTimeout(function(){
uulist();   
},5000);
}
},"json");

}
</script>
