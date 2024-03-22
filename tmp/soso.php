<?php 
 if(!isset($type)){exit();}
$this->showhd("搜索中....");
 


 
$url="/?type=soso&";
$km=0;
if(isset($_GET["k"]) and !empty($_GET["k"])){
$k=$_GET["k"];
$k=preg_replace("/\s(?=\s)/","\\1",trim($k));
preg_match_all('/[a-zA-Z0-9\s\x{4e00}-\x{9fa5}]/u', $k, $kkk);
if(count($kkk[0])>0){
$km=1;
$ag="";
foreach ($kkk[0] as $k => $v) {
if(preg_match('/^[\x{4e00}-\x{9fa5}]+$/u',$v)){
$ag=$ag." ".str_replace('"','',str_replace('"\\','',json_encode($v)))." "; 
}else{
$ag=$ag.$v;  
}
}
$url="/?type=soso&k=".urlencode($k)."&";
$k=implode("", $kkk[0]);
if($this->here()){
$this->sql("INSERT INTO `s_keyword`(`uid`, `time`, `keyword`) VALUES ('".$_SESSION["uid"]."','".time()."','".$this->res($k)."')");
$this->sql("update `s_user` set `keywords`= concat('".$this->res($ag)."',`keywords`)  where  `uid`='".$_SESSION["uid"]."'  ");
}else{
$this->sql("INSERT INTO `s_keyword`(`uiid`, `time`, `keyword`) VALUES ('".$_SESSION["uiid"]."','".time()."','".$this->res($k)."')");    
}
}
}



$pn=1;
if(isset($_GET["pn"]) and is_numeric($_GET["pn"]) and $_GET["pn"]>=1 and $_GET["pn"]<=9999999999){
$pn=$_GET["pn"];
}
 
$p=15;
$pnno=($pn-1)*$p;
 
 


 
?>

 
 <Style>
.logo{height:55px;line-height:50px;font-size:17px;font-weight:bold;vertical-align:middle;background-color:#fff;position:fixed;left:0px;width:100%;top:0px;z-index:55;box-shadow: #b9bcbc 0px 8px 8px -8px;}
.logo #logo{display:inline-block;height:55px;line-height:50px;color:#777;}
#logo span{display:inline-block;height:50px;width:50px;border-radius:25px;margin-right:5px;margin-left:10px;border:0px;}
.logo img{vertical-align:middle;height:50px;border-radius:25px;}
#qq{float:right;margin-right:10px;font-size:20px;}
.sousuo{height:55px;width:100%;z-index:33;position:absolute;top:0px;right: 0px;background:#fff;}
 
    
div.search1 {margin:4px 8px 4px 4px;height:47px;}
.search1input1{margin-right:60px;margin-left:2px;}
.search1input{margin-right:-42px;width:100%;}
.search1 form{position: relative;width:100%-4px;margin: 0 auto;padding:0px;border: 2px solid #c4c7ce;border-radius: 5px;height:43px;}
.search1  input, .search1 button {border: none;outline: none;}
.search1  input {width: 100%;height: 42px;padding: 0px;}
.search1  button {height: 44px; width: 42px;cursor: pointer;position: absolute;}
/*搜索框1*/
.bar7 {background: #fff;}
.search1 form:focus-within {border: 2px solid #4e6ef2;}
 
.bar7 input {background: transparent;top: 0;right: 0;}
.bar7 button {background: #4e6ef2;border-radius: 0;width: 60px;top: 0px;right: 0px;}
.bar7 button:before {content: "搜索";font-size: 12px;color: #fff;}
             
         
</style>
<div style='height:50px;'></div>
<div class='logo'> 


<div class='sousuo'>
	
<div class="search1 bar7">
        <form action='/'>
            <div class='search1input'><div class='search1input1'><input type='hidden' name ='type' value='soso'/><input name='k' type="text" value='<?php if(isset($km) &&$km==1){ echo  htmlspecialchars($_GET["k"], ENT_QUOTES);}?>' placeholder="请输入您要搜索的内容..."></div></div>
            <button type="submit"></button>
        </form>
    </div>

</div>


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
.arttm a{display:inline-block;width:33%;float:left;height:35px;line-height:35px;text-align:center;font-size: 12px;color:#777;}
.arttm img{width:20px;height:20px;vertical-align:middle;margin-right:4px;margin-top:-2px;}
.view{}
</style>
 

<?php  


$likes="";
$likes1="";
if($this->here()){
$likes="left join `s_clikes` on(`s_content`.`cid`=`s_clikes`.`cid` and `s_clikes`.`uid`='".$_SESSION["uid"]."')";
$likes1=",ifnull(`s_clikes`.`lid`,0) as `lid` ";
}
$order="";
if($km==1){
$mc=",MATCH (`s_content`.`fulltext1`) AGAINST ('".$ag."') as `mc`";
$order="`mc` desc,";
}
$asql=$this->Sql("select  `s_content`.*,`s_user`.`nickname`,`s_user`.`face`".$likes1."".$mc."  from   `s_content` left join `s_user` using(`uid`)  ".$likes."  order  by  ".$order."`s_content`.`cid` desc  limit ".$pnno.",".($p+1));
 
$lnum=$this->num($asql);
if($lnum===0){
echo "暂无资源";
} 
$t=1;
while($a=$this->row2($asql)){
 if($t<=$p){   
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
  
 

$t++;

}

 

 

?>

<script>
$(function(){


$(".like").click(function(){
var cid=$(this).attr("cid");
$.post("/index.php",{"api":"pb","api2":"clikes","cid":cid},function(json){
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

<?php  
include 'com/ft.php';

?>