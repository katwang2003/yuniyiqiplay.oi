<?php 
 if(!isset($type)){exit();}
 
$this->showhd("发布内容");
 
 

 
?>
 
 
<style type="text/css">
.gg{height:40px;position:fixed;width:100%;left:0px;text-indent:10px;top:0px;background-color:#fff;border-bottom:1px solid #f1f1f1;z-index:33;box-shadow: #b9bcbc 0px 8px 8px -8px;}
.gg a{line-height:40px;display:inline-block;height:40px;cursor:pointer;}
.gg span{font-weight:bold;}
.ggar{float:right;margin-right:18px;width:34px;position:relative;}
.ggar img{width:24px;height:24px;margin-top:8px;}
.ggal{float:left;margin-left:8px;}
body{background-color:#fff;}
.file{height:35px;position:absolute;top:0px;left:0px;opacity:0;cursor:pointer;}
.file input {font-size:100px;cursor:pointer;}
</style>
<div style="height:41px;"></div>
<div class='gg'>
<a href='/?type=user&type2=wo' class='ggal'>管理内容</a>

<a href='#' class='ggar unlink'><img src='/public/img/unlink.png'/></a>
<a href='#' class='ggar link'><img src='/public/img/link.png'/></a>
<a href='#' class='ggar xigua'><img src='/public/img/xigua.png'/></a>
<a href='#' class='ggar'><img src='/public/img/shopgoodpic.png'/><div class="file"><input type="file" /></div></a>
</div>
 
 <script>
 

$(function(){

$(".link").click(function(){
var url = window.prompt("请在编辑器里输入文本再选中再点添加链接", '');
if(url!="" && url!=null){
document.execCommand("CreateLink","false",url);
} 
return false;
});

$(".unlink").click(function(){
 
document.execCommand("unLink"); 
return false;
});



$(".xigua").click(function(){
    $("#editable").focus();
var url = window.prompt("视频inframe链接(推荐用bilibili)", '');
if(url!="" && url!=null){
insertHtmlAtCaret('<iframe width="100%" height="60%" style="min-height:350px;"  src="'+url+'"  scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe>');
}
return false;
});


 
});


 
</script> 


<script src="/public/localResizeIMG.js" type="text/javascript"></script>
<script src="/public/mobileBUGFix.mini.js" type="text/javascript"></script>
 

<Style>

    
.acbox2{width:100%;z-index:34;margin-top:10px;}
.acbox21{margin:9px auto;}
.acbox22{margin:10px;padding:0px 10px 10px 10px; background-color:#fff;border-radius:10px;}
.acbox221{height:50px;}
.acbox221 a{display:inline-block;height:40px;line-height:40px;margin-top:10px;border-radius:5px;color:#fff;font-size:18px;font-weight:bold;width:90px;text-align: center;}  
.acbox221 span{height:40px;line-height:40px;color:#fc5531;}
.acbox221 .accl{background-color:#515151;float:left;}
.acbox221 .acok{background-color:#fc5531;float:right;}
.acbox221 .acok2{background-color:green;float:left;}
.intype{line-height:40px;}
.intel{border-radius:5px;border:1px solid #999999;margin:5px 1px 0px 1px;height:35px;background-color:#fff;padding-left:5px;padding-right:5px;}
.intel input{border:0px;padding:0px;width:100%;background-color:#fff;padding-bottom:10px;padding-top:10px;height:15px;}
.insos{color:red;line-height:30px;}
 
 
 
 
#editable{border-radius:5px;border:1px solid #999999;margin:5px 1px 0px 1px;background-color:#fff;padding:5px;line-height:30px;min-height:210px;background-color:#fff;}
#editable p{margin-top:5px;}
#editable img{width:150px;}


 
 
 </Style>  
 
 


 


<Div class='acbox2 acboxh'><Div class='acbox21'><Div class='acbox22'>
<div class="intel"><input id='title'  placeholder='标题' value=''/></div>
  
<div id="editable" contenteditable="true"  ><div>
    <br>
  </div></div>
<Div class='acbox221'><a href='#' class='acok  pb'>确认发布</a></Div>




<div></div></Div>   


 
<script type="text/javascript">
$(function(){


$(".pb").click(function(){
 

$.post("/index.php",{"api":"pb","api2":"contentadd","title":$("#title").val(),"content":$("#editable").html()},function(json){
if(json[0]==1){
$("#editable").html("<div>"+
    "<br>"+
  "</div>");
$("#title").val("");
rs("<a href='/?type=v&cid="+json[1]+"'>查看文章</a>");
}else{
rs(json[1]);
}
},"json");
return false;
});



});

 

    var  base64v;
$('input:file').localResizeIMG({
             width: 360,
             quality: 0.8,
             success: function (result) {
             var img = new Image();
             base64v=img.src = result.base64;
             $("#editable").focus();
             insertHtmlAtCaret("<div class='imgs'><img src='"+base64v+"'/></div>");
            
             }

});
var  base64;

window.onload=function() {
    function paste_img(e) {
    debugger;
        if ( e.clipboardData.items ) {
        // google-chrome 
            ele = e.clipboardData.items
            for (var i = 0; i < ele.length; ++i) {

              
                if ( ele[i].kind == 'file' && ele[i].type.indexOf('image/') !== -1 ) {
                    var blob = ele[i].getAsFile();

                    var isImg=(blob&&1)||-1;
                    var reader=new FileReader();
                    if(isImg>=0){
                     //将文件读取为 DataURL
                    reader.readAsDataURL(blob);
                    }

                    reader.onload=function(event){
                    base64=event.target.result;
                 
                    dealImage(base64, 600, useImg);
                       
              
                    } 
               
                   
                 } 

            }
        } else {
            alert('non-chrome');
        }
    }
    document.getElementById('editable').onpaste=function(e){    
     ele2 = e.clipboardData.items ; 
     var  el=ele2.length;
     if(el==1 && ele2[0].type.indexOf('image/') !== -1){
      paste_img(event);return false;  
     }
     if(el==2 && ele2[1].type.indexOf('image/') !== -1){
      paste_img(event);return false;  
     }
 
    
        }


}

 
 


function dealImage(base64, w, callback) {
                var newImage = new Image();
                var quality = 0.8;    //压缩系数0-1之间
                newImage.src = base64;
                newImage.setAttribute("crossOrigin", 'Anonymous');  //url为外域时需要
                var imgWidth, imgHeight;
                newImage.onload = function () {
                    //imgWidth = 500;
                    if(this.width>500){
                    imgWidth = 500;
                    imgHeight =(500/this.width)*this.height;
                    }else{
                    imgWidth = this.width;
                    imgHeight = this.height;   
                    }

                    
                    //imgHeight = 500;
                    var canvas = document.createElement("canvas");
                    var ctx = canvas.getContext("2d");
                    if (Math.max(imgWidth, imgHeight) > w) {
                        if (imgWidth > imgHeight) {
                            canvas.width = w;
                            canvas.height = w * imgHeight / imgWidth;
                        } else {
                            canvas.height = w;
                            canvas.width = w * imgWidth / imgHeight;
                        }
                    } else {
                        canvas.width = imgWidth;
                        canvas.height = imgHeight;
                        quality = 0.8;
                    }
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    ctx.drawImage(this, 0, 0, canvas.width, canvas.height);
                    var base64 = canvas.toDataURL("image/jpeg", quality); //压缩语句
                    // 如想确保图片压缩到自己想要的尺寸,如要求在50-150kb之间，请加以下语句，quality初始值根据情况自定
                    // while (base64.length / 1024 > 150) {
                    //  quality -= 0.01;
                    //  base64 = canvas.toDataURL("image/jpeg", quality);
                    // }
                    // 防止最后一次压缩低于最低尺寸，只要quality递减合理，无需考虑
                    // while (base64.length / 1024 < 50) {
                    //  quality += 0.001;
                    //  base64 = canvas.toDataURL("image/jpeg", quality);
                    // }
                    callback(base64);//必须通过回调函数返回，否则无法及时拿到该值
                }
            }
function useImg(base64) {
        base64v= base64;
      

        insertHtmlAtCaret("<div class='imgs'><img src='"+base64v+"'/></div>");
}






function insertHtmlAtCaret(html) {

var sel, range;

if (window.getSelection) {

// IE9 and non-IE

sel = window.getSelection();

if (sel.getRangeAt && sel.rangeCount) {

range = sel.getRangeAt(0);

range.deleteContents();

// Range.createContextualFragment() would be useful here but is

// non-standard and not supported in all browsers (IE9, for one)

var el = document.createElement("div");

el.innerHTML = html;

var frag = document.createDocumentFragment(), node, lastNode;

while ((node = el.firstChild)) {

lastNode = frag.appendChild(node);

}

range.insertNode(frag);

// Preserve the selection

if (lastNode) {

range = range.cloneRange();

range.setStartAfter(lastNode);

range.collapse(true);

sel.removeAllRanges();

sel.addRange(range);

}

}

} else if (document.selection && document.selection.type != "Control") {

// IE < 9

document.selection.createRange().pasteHTML(html);

}

}
 
 
</script>


 