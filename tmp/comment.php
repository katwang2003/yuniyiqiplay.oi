<?php
if(!isset($type)){exit();}
if(!isset($_GET["cid"]) or !is_numeric($_GET["cid"])){
header("HTTP/1.1 404 Not Found");
include "404.html";
exit();
}
$cid=$_GET["cid"];


$sql=$this->Sql("select  * from  `s_content`  where `cid`='".$this->res($cid)."' limit 0,1");
if($this->num($sql)==0){
header("HTTP/1.1 404 Not Found");
include "404.html";
exit();
}

$a=$this->row2($sql);
$content=$a["content"];
 
$sqlu=$this->Sql("select  `face`,`nickname` from  `s_user`  where `uid`='".$a["uid"]."' limit 0,1");
$u=$this->row2($sqlu);

$this->showhd($a["title"]);

//亲密度
$this->qinmidu($a["uid"]);


$vid=$this->iview($cid); 

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
.ftmn,.copyright{display:none;}
</Style>
<div style='height:50px;'></div>
<div class='logo'><a  id='logo' href='/'><span><img src='/public/img/logo.png'/></span></a>

 
<a class='hmmm' href='/?type2=guan'  style='<?php  if($type2=="guan"){ echo "color:#000"; }  ?>'>关注</a>
<a class='hmmm' href='/?type2=tui' style='<?php  if($type2=="tui"){ echo "color:#000"; }  ?>'>推荐</a>
<a class='hmmm' href='/?type2=pai' style='<?php  if($type2=="pai"){ echo "color:#000"; }  ?>'>排行</a> 
<a href='/?type=soso'  class='sousuo'><img src='/public/img/sousuo1.png'/></a>
 

</div>






<style type="text/css">
.art1{margin:10px auto;border-radius:10px;max-width:1000px;}
.art11{background-color:#fff;margin-left:10px;margin-right:50px;border-radius:10px;padding:10px;}
.art1t{font-size:18px;font-weight:bold;line-height:35px;margin:3px 0px 3px 0px;color:#000;font-weight:bold;}
.art1c{line-height:28px;}
.art1a{font-size:12px;color:#999;line-height:25px;padding-right:60px;} 
.art1a img{height:13px;margin-left:3px;vertical-align: middle;margin-top:-2px;margin-right: 1px;}
.art1c img{border-radius:8px;max-width:500px;width:100%;}
.art1tag{line-height:28px;}    
.art1tag a{margin-right:8px;}
</style>

<div class='art1'><div class='art11'>
<div class='art1a'><?php  echo date("Y年m月d日",$a["time"]);  ?>发布 <img src='/public/img/view.png'/><?php  echo $a["view"]; ?></div>
<div class='art1c'><?php  echo $content;  ?></div>
</div></div>
 

<style>
.cmbox{background-color:#fff;position:fixed;width:100%; border-radius:8px 8px 0px  0px;bottom:0px;left:0px;  z-index: 333; }	
.cmboxtt{text-align:center;line-height:26px;position:relative;height:26px;}  
.cmboxtt a{position:absolute;right:5px;display:inline-block;line-height:26px;height:26px;top:0px;color:#333; }
.cmboxbd{ width:100%; overflow-y:auto;}

.sendbox{width:100%;min-height:75px;position:fixed;left:0px;bottom:0px;background-color:#fff;z-index:55}	
.sendbox2{float:left;width:100%;}
#editable{border-radius:5px;border:1px solid #999999;background-color:#fff;padding:2px;line-height:23px;min-height:50px;background-color:#fff;margin-right:75px;margin-left:10px;}
.cmmt{display:inline-block;float:right;z-index:33;position:absolute;right:10px;width:60px;height:52px;line-height:52px;text-align:center;border-radius:5px;border:1px solid #999999;}   
</style>
<style>
 
.imsg{width:100%;}	
.imsg1{margin-left:10px;margin-right:70px;margin-top:10px;position:relative;}

.iface{float:left;margin-top:0px;margin-left:0px;width:32px;height:32px;border-radius:4px;}
.iface img{width:32px;height:32px;}
.imsg3{float:right;margin-left:-42px;width:100%;}
.imsg31{background-color:#fff;border-radius:8px;padding:8px;line-height:26px;margin-left:42px;}
.imsg312{ color:#999;font-size:12px;}


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
<div class='cmbox'>
<div class='cmboxtt'>
<?php 
$sqlcc=$this->Sql("SELECT count(`coid`) FROM `s_comment` where  `cid`='".$this->res($cid)."'");
$rcc=$this->row($sqlcc);
echo $rcc[0]."条评论";
?>
<A href='/?type=v&cid=<?php echo $cid; ?>'>X</A>
</div>	
<Div class='cmboxbd'>
 

<?php  


$sqlm=$this->sql("SELECT `s_comment`.`uid`, `s_comment`.`time`,  `s_comment`.`comment`,`s_user`.`face` FROM `s_comment` left join `s_user` using(`uid`) WHERE `s_comment`.`cid`='".$this->res($cid)."' order by `s_comment`.`coid` desc limit 0,50");

while($m=$this->row2($sqlm)){
 

echo "<div class='imsg'><div class='imsg1'><div class='demo'></div><div class='imsg3'><div class='imsg31'>
<div class='imsg311'>".$m["comment"]."</div>
<div class='imsg312'>
".date("Y-m-d H:i:s",$m["time"])."
</div>
</div></div>
<div class='iface'><a href='/?type=user&uid=".$m["uid"]."'><img src='/public/face/".$m["face"]."'/></a></div>
</div></div>";
 
 
}

?>

	
 

</Div>	


 

<div class='sendbox'>
<div class='sendbox2'><div id="editable" contenteditable="true"  ></div></div><a href="#" class='cmmt'>评论</a>
</div>



</div>

<script type="text/javascript">
$(function(){


$(".cmbox").height($(window).height()-220);
$(".cmboxbd").height($(".cmbox").height()-101);
$(".cmmt").click(function(){
 

$.post("/index.php",{"api":"pb","api2":"cmt","cmt":$("#editable").html(),"cid":"<?php echo $cid; ?>"},function(json){
if(json[0]==1){
$(".cmboxbd").prepend(json[1]);
$("#editable").html("");
$(".cmboxbd").scrollTop(0);
}else{
rs(json[1]);
}


},"json");
return false;
});


});
</script>
 






   
 


 

 
<?php  
include 'com/ft.php';

?>