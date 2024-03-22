<?php  

if(!isset($type)){exit();}
 
$pn=1;
if(isset($_GET["pn"]) and is_numeric($_GET["pn"]) and $_GET["pn"]>=1 and $_GET["pn"]<=9999999999){
$pn=$_GET["pn"];
}


$p=15;
$pnno=($pn-1)*$p;
 $url="/?";
?>




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

.picsbx2{max-height:80px;line-height:80px; vertical-align: middle;}
.picsbx2 img{width:50%;float:left;max-width:200px;vertical-align:middle;}
.picsbx3{max-height:60px;line-height:60px;vertical-align: middle;}
.picsbx3 img{width:33%;float:left;max-width:200px;vertical-align:middle;}


.user{line-height:45px;}
.user img{width:32px;height:32px;vertical-align:middle;border-radius:16px;margin-right:4px;}
.user a{color:#555;}


.arttm{border-top:1px solid #dedede;margin-top:5px;}
.arttm a{display:inline-block;width:33%;float:left;height:35px;line-height:35px;text-align:center;font-size: 12px;color:#777;}
.arttm img{width:20px;height:20px;vertical-align:middle;margin-right:4px;margin-top:-2px;}
.view{}
</style>
 

<?php  
$likes="";
$likes1="";
$order=" order  by  (`s_content`.`view`+`s_content`.`likes`+`s_content`.`comment` ) desc";
if($this->here()){
$likes="left join `s_clikes` on(`s_content`.`cid`=`s_clikes`.`cid` and `s_clikes`.`uid`='".$_SESSION["uid"]."')";
$likes1=",ifnull(`s_clikes`.`lid`,0) as `lid` ";
$sqlkkk=$this->Sql("select `keywords` from  `s_user` where `uid`='".$_SESSION["uid"]."'");
$kkkr=$this->row($sqlkkk);

if($kkkr[0]!=""){
$likes1=$likes1.",MATCH (`s_content`.`fulltext1`) AGAINST ('".$kkkr[0]."') ";  
$order=" order  by  MATCH (`s_content`.`fulltext1`) AGAINST ('".$kkkr[0]."') desc,(`s_content`.`time`+(`s_content`.`view`+`s_content`.`likes`+`s_content`.`comment`)*1000 ) desc";

}

}


if(isset($_SESSION["uid"])){
$likes=$likes."  left  join  `s_cview`   on(`s_content`.`cid`=`s_cview`.`cid` and `s_cview`.`uid`='".$_SESSION["uid"]."')";
$likes1=$likes1.",ifnull(`s_cview`.`vid`,0) as `ooo`";
$order=" order  by  `ooo` asc,MATCH (`s_content`.`fulltext1`) AGAINST ('".$kkkr[0]."') desc,(`s_content`.`time`+(`s_content`.`view`+`s_content`.`likes`+`s_content`.`comment`)*1000 ) desc";
}else if(isset($_SESSION["uiid"])){
$likes=$likes."  left  join  `s_cview`   on(`s_content`.`cid`=`s_cview`.`cid` and `s_cview`.`uiid`='".$_SESSION["uiid"]."')";
$likes1=$likes1.",ifnull(`s_cview`.`vid`,0) as `ooo`";
$order=" order  by  `ooo` asc,(`s_content`.`time`+(`s_content`.`view`+`s_content`.`likes`+`s_content`.`comment` )*1000) desc";
}



$asql=$this->Sql("select  `s_content`.*,`s_user`.`nickname`,`s_user`.`face`".$likes1." from   `s_content` left join `s_user` using(`uid`)  ".$likes."    ".$order."   limit ".$pnno.",".($p+1));
 
$lnum=$this->num($asql);
while($a=$this->row2($asql)){
$str="";
$str2=$a["intro"];
if(preg_match("/picsbx1/",$a["intro"])){
$str=$a["intro"];
$str2="";
}


$likepng="unlike";

if($this->here()){
if($a["lid"]!=0){
$likepng="like";
}
}

echo "<div class='art'>
<Div class='user'><a href='/?type=user&uid=".$a["uid"]."'><img src='/public/face/".$a["face"]."'/>".$a["nickname"]."</a></div>
<a href='/?type=v&cid=".$a["cid"]."'><div>
".$str."
<div class='artt'>".$a["title"]."</div>".$str2."
</div></a>
<div class='arttm'>
<a href='/?type=v&cid=".$a["cid"]."' class='view'><img src='/public/img/view.png'/>".$a["view"]."</a>
<a href='#' class='like cid".$a["cid"]."' cid='".$a["cid"]."'><img src='/public/img/".$likepng.".png'/><span>".$a["likes"]."</span></a>
<a href='/?type=comment&cid=".$a["cid"]."'><img src='/public/img/comment.png'/>".$a["comment"]."</a>
</div>
</div>";

 


}

 

?>

<script>
$(function(){


$(".like").click(function(){
var cid=$(this).attr("cid");
$.post("/post.php",{"api":"pb","api2":"clikes","cid":cid},function(json){
if(json[0]==1){
$(".cid"+cid+" img").attr("src","/public/img/"+json[1]+".png"); 
var likes=parseInt($(".cid"+cid+" span").html());
if(json[1]=="like"){
$(".cid"+cid+" span").html(likes+1);
}else{
$(".cid"+cid+" span").html(likes-1);	
}
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