<Style>
.copyright{line-height:25px;text-align:center;color:#888;padding:9px 0px 9px 0px;}
.copyright a{color:#888;}
</Style>
<div class="copyright">
<a href="http://beian.miit.gov.cn"><?php echo  $this->cfg['beianhao']; ?></a>©<a href='https://www.xph666.top' style='color:#1296db'>轻论坛</a>
</div>


<div style='height:70px;'>
</div>
<style type="text/css">
.ftmn{position:fixed;height:70px;width:100%;left:0px;bottom:0px;background-color:#fff;border-top:1px solid #dedede;z-index:333;}
.ftmn1{height:50px;width:100%;}
.ftmn1 a{display:inline-block;width:20%;text-align:center;height:50px;line-height:50px;color:#777;float:left;font-weight:bold;}
 
.free{
  animation: animate 1s linear infinite;
}
 
@keyframes animate {
  0%, 100% {
    text-shadow: -1.5px -1.5px 0 #0ff, 1.5px 1.5px 0 #f00;
  }
  25% {
    text-shadow: 1.5px 1.5px 0 #0ff, -1.5px -1.5px 0 #f00;
  }
  50% {
    text-shadow: 1.5px -1.5px 0 #0ff, 1.5px -1.5px 0 #f00;
  }
  75% {
    text-shadow: -1.5px 1.5px 0 #0ff, -1.5px 1.5px 0 #f00;
  }
}
.pub img{margin-top:10px;}

.msgssssss{position:relative;}
.msgssssss span{height:20px;border-radius:10px;padding:0px 5px 0px 5px;position:absolute;top:3px;line-height:20px;right:5px;background-color:red;color:#fff;font-weight:bold;opacity:0.65;font-size:12px;}
</style>
<div class='ftmn'>
<div class='ftmn1'>
<a href='/'   style="<?php  if($type=="index"){echo "color:#333;";} ?>">首页</a>
<a href='/?type=mai' style="<?php  if($type=="mai"){echo "color:#333;";} ?>">人脉</a>
<a href='/?type=pub'  class='pub'><img src='/public/img/pub.png'/></a>  
<a href='/?type=msg' class='msgssssss' style="<?php  if($type=="msg"){echo "color:#333;";} ?>" >消息</a>
<a href='/?type=user&type2=wo'  style="<?php  if($type=="user"  or $type=="ht"){echo "color:#333;";} ?>">我</a>
</div>  
</div>


<Script>
$(function(){
$.post("/index.php",{api:"user",api2:"tj"});




});

<?php if($this->here()){ ?>

  var sssss
$(function(){

getmsgnum();
});

function  getmsgnum(){
$.post("/index.php",{"api":"msg","api2":"msgnum" },function(json){
if(json[0]==1){
$(".msgssssss").html(json[1]);
setTimeout(function(){
 getmsgnum();   
},10000);
}else{
$(".msgssssss").html("消息");
setTimeout(function(){
 getmsgnum();   
},40000);
}
},"json");

}

<?php } ?>
  
</Script>
