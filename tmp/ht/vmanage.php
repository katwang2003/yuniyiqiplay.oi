<?php 
if(!isset($type)){exit();}
$this->nologin();
$this->showhd("我");
 
 
$pn=1;
if(isset($_GET["pn"]) and is_numeric($_GET["pn"]) and $_GET["pn"]>=1 and $_GET["pn"]<=9999999999){
$pn=$_GET["pn"];
}
 
$p=15;
$pnno=($pn-1)*$p;
$url="/?type=ht&type2=vmanage&";
 

 
?>
 
 
<style type="text/css">
.gg{height:40px;position:fixed;width:100%;left:0px;text-indent:10px;top:0px;background-color:#fff;border-bottom:1px solid #f1f1f1;z-index:33;}
.gg a{line-height:40px;display:inline-block;height:40px;}
.gg span{font-weight:bold;}
.ggar{float:right;margin-right:8px;}
.ggar img{width:24px;height:24px;margin-top:8px;}
.ggal{float:left;margin-left:8px;}
</style>
<div style="height:41px;"></div>
<div class='gg'>
<a href='/?type=ht' class='ggal'>返回管理员后台首页</a>

 
</div>

 



<style type="text/css">
.art{margin:10px 10px 0px 10px;border-radius:8px;background-color:#fff;padding:8px;box-shadow: #b9bcbc 0px 8px 8px -8px;}
.artt{line-height:30px;color:#333;font-size:16px;font-weight:bold;} 
.artc{height:52px;line-height:26px;color:#888;overflow: hidden;
  text-overflow: ellipsis;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;}    
 


.picsbx1{float:left;max-width:120px;margin-right:10px;}
.picsbx1 img{max-width:120px;width:100%;border-radius:10px;}


.user{line-height:45px;}
.user img{width:32px;height:32px;vertical-align:middle;border-radius:16px;margin-right:4px;}
.user a{color:#555;}


.arttm{border-top:1px solid #dedede;margin-top:5px;}
.arttm a{display:inline-block;width:25%;float:left;height:35px;line-height:35px;text-align:center;font-size: 12px;color:#777;}
.arttm img{width:20px;height:20px;vertical-align:middle;margin-right:4px;margin-top:-2px;}
.delete{color:red;}
</style>
 

<?php  
 
$asql=$this->Sql("select  `s_content`.*  from   `s_content`        order  by   `s_content`.`cid`   desc   limit ".$pnno.",".($p+1));
$lnum=$this->num($asql);  
$t=1; 
while($a=$this->row2($asql)){
    if($t<=$p){  
$str="";
$str2=$a["intro"];
if(preg_match("/picsbx1/",$a["intro"])){
$str=$a["intro"];
$str2="";
}


$likepng="like";




echo "<div class='art' id='cid".$a["cid"]."'>
 
<a href='/?type=v&cid=".$a["cid"]."'><div>
".$str."
<div class='artt'>".$a["title"]."</div>".$str2."
</div></a>
<div class='arttm'>
<a href='/?type=v&cid=".$a["cid"]."' class='view'><img src='/public/img/view.png'/>".$a["view"]."</a>
<a href='#' class='like cid".$a["cid"]."' cid='".$a["cid"]."'><img src='/public/img/".$likepng.".png'/><span>".$a["likes"]."</span></a>
<a href='/?type=comment&cid=".$a["cid"]."'><img src='/public/img/comment.png'/>".$a["comment"]."</a>
<a href='#' class='delete' cid='".$a["cid"]."'>删除</a>
</div>
</div>";

 


}
$t++;

}
 

?>
 

<script>
$(function(){


$(".delete").click(function(){
var cid=$(this).attr("cid");
$.post("/index.php",{"api":"ht","api2":"delete","cid":cid},function(json){
if(json[0]==1){
$("#cid"+cid).remove(); 
}else{
rs(json[1]);
}
},"json");
return false;
});

 


}); 



</script>



<Style>
.pn{text-align:center;margin-bottom:20px;margin-top:10px;}
.pn a{display:inline-block;font-size:30px;height:30px;line-height:30px;padding-left:6px;padding-right:6px;background-color:#f1f1f1;color:#000;margin-left:5px;margin-right:5px;border-radius:8px;}
</Style>
<div class='pn'>
<?php 

if($pn>1){
echo "<a  href='".$url."pn=".($pn-1)."'>上一页←</a>"; 
}
if($lnum>$p){
echo "<a   href='".$url."pn=".($pn+1)."'>→下一页</a>";  
}

?>
</div>