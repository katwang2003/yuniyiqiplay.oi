<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
<link rel="icon" href="/public/img/logo.png">
<link rel="stylesheet" type="text/css" href="/public/cm.css"/>
<script src="/public/jq.js"></script>
<title><?php  echo $title;?></title>
 

<style type="text/css">
.rsbbg{position:fixed;z-index:998;background-color:#000;width:100%;height:100%;left:0px;top:0px;opacity:0.4;}	
.rsb{display:none;background-color:#fff;z-index:999;position:fixed;top:50%;left:50%;width:300px;margin-left:-150px;border-radius:7px;}
.rsb1{margin:20px 10px  20px 10px;line-height:28px;text-align:center;}
.rsb2{border-top:1px solid #dedede;text-align:center;margin-bottom:8px;}
.rsb2 a{display:inline-block;color:#595f77;height:45px;line-height:45px;width:100%;font-size:18px;font-weight: bold;}
</style>
<script type="text/javascript">
function rs(str){
$(".rsb,.rsbbg").remove();
$("body").append("<div class='rsb'><div class='rsb1'>"+str+"</div><div class='rsb2'><a href='#'>好的</a></div></div><div class='rsbbg'></div>");
var hhh=-parseInt($(".rsb").height())/2;
$(".rsb").css("margin-top",hhh+"px");
$(".rsb").show();

}

$(document).ready(function(){
$(document).on("click",".rsb2 a",function(){
$(".rsb,.rsbbg").remove();
return false;
});

 

});


</script>

</head>
<body  >

	

