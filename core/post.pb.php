<?php  

if(!isset($api2)){
$this->rs("请求失败:非法接口。");
}

if(!$this->here()){
$this->rs("请求失败:请<A href='/?type=user&type2=login'>登录</a>。");
}

$uid=$_SESSION["uid"];




//发布内容
if($api2=="contentadd"){

if(!isset($_POST["title"]) or empty($_POST["title"]) ){
$this->rs("创建失败:请输入标题");	
}
$title=$_POST["title"];
$title=htmlspecialchars($title, ENT_QUOTES);
$title=strip_tags(str_replace("  "," ",$title));


 

if($title==""){
$this->rs("创建失败:请输入标题");
}

 
if(!isset($_POST["content"]) or empty($_POST["content"]) ){
$this->rs("创建失败:请输入内容");	
}
$content=$_POST["content"];


if($content==""){
$this->rs("创建失败:请输入内容");
}



preg_match_all('/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$content,$imgs);
$tu=array();
$tun-1;
if(count($imgs[2])>0){
  
foreach ($imgs[2] as $k => $v) {
if(preg_match('/^(data:\s*image\/(\w+);base64,)/',$v)){
preg_match('/^(data:\s*image\/(\w+);base64,)/',$v, $r3);

$base64_body = substr(strstr($v,','),1);
$img = base64_decode($base64_body);
$type =$r3[2];

$file_name_ok ="public/pic/".md5($v).".".$type;
if($tun<=3){
$tu[]="/".$file_name_ok;
}

$content=str_replace($v, "/".$file_name_ok,$content);
file_put_contents($file_name_ok,$img);
$tun++;
}

}
}

preg_match_all('/<\s*iframe\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i',$content,$iframes);
if(count($iframes[2])>0){
foreach ($iframes[2] as $k => $v) {
$frametxt='<div class="ifrsbx"><iframe width="100%" height="60%" style="min-height:350px;"  src="'.$v.'"  scrolling="no" border="0" frameborder="no" framespacing="0" allowfullscreen="true"></iframe></div>';
break;
}
}

if(!isset($frametxt)){
$tucount=count($tu);
if($tucount>0){
if($tucount>3){
$tucount=3;
}
$tutxt="<div class='picsbx".$tucount."'>";
$t=0;
foreach($tu as $k=>$v){
	if($t==3){break;}
$tutxt=$tutxt."<img src='".$v."'/>";
$t++;	
}
$tutxt=$tutxt."</div>";
}
}

$intro='';
if(isset($frametxt)){
$intro=$frametxt;
}else if(isset($tutxt)){
$intro=$tutxt;
} 


$sa = new cleanHtml;
$sa->allow = array( 'id' );  
$content=strip_tags($content, "<p> <img> <div> <a> <iframe>"); 

$sa->exceptions = array(
        'img' => array( 'src'),
        'a' => array( 'href','target'),
        'iframe'=> array( 'src','width','height','referrerpolicy','scrolling','border','frameborder','framespacing','allowfullscreen','style')
        );

$content = $sa->strip($content); 

$fulltext1=$title.strip_tags($content);

preg_match_all('/([\x{4e00}-\x{9fa5}])/u',$fulltext1,$zw);

$nww=array();

foreach($zw[0] as $k => $v){
$nww[md5($k)]['n']=$v;
$nww[md5($k)]['v']=str_replace('"','',str_replace('"\\','',json_encode($v)));
}

foreach($nww as $k2 => $v2){
$fulltext1=str_replace($v2['n']," ".$v2['v']." ",$fulltext1);

}

$fulltext1=str_replace("  "," ",$fulltext1);




$this->sql("INSERT INTO `s_content`( `uid`, `time`, `title`, `content`, `intro`, `fulltext1`) VALUES ('".$uid."','".time()."','".$this->res($title)."','".$this->res($content)."','".$this->res($intro)."','".$this->res($fulltext1)."')");
$cid=mysql_insert_id();

$this->usecoin(1,"发布内容cid".$cid,$uid);	
$this->rs($cid,1);





}






//给内容点赞

else if($api2=="clikes"){

if(!isset($_POST["cid"]) or !is_numeric($_POST["cid"])){
$this->rs("抱歉错误");
}

$cid=$_POST["cid"];



$sqlc=$this->sql("select `cid` from `s_content` where `cid`='".$this->res($cid)."'");
if($this->num($sqlc)==0){
$this->rs("抱歉错误:内容不存在");
}

$sqll=$this->sql("select `lid` from `s_clikes` where `uid`='".$uid."' and `cid`='".$this->res($cid)."'");
if($this->num($sqll)==0){

$this->sql("INSERT INTO `s_clikes`( `uid`, `time`, `cid`) VALUES ('".$uid."','".time()."','".$this->res($cid)."')");
$this->sql("update `s_content` set `likes`=`likes`+1 where `cid`='".$this->res($cid)."'");
$this->rs("like",1);
}

$this->Sql("DELETE FROM `s_clikes` where `uid`='".$uid."' and `cid`='".$this->res($cid)."'");
$this->sql("update `s_content` set `likes`=`likes`-1 where `cid`='".$this->res($cid)."'");
$this->rs("unlike",1);

}


//delete
else if($api2=="delete"){
if(!isset($_POST["cid"]) or !is_numeric($_POST["cid"])){
$this->rs("抱歉错误");
}
if($this->mycoin()<2){
$this->rs("创建失败:微力不足");	
}

$cid=$_POST["cid"];

$sqlc=$this->sql("select `cid` from `s_content` where `uid`='".$uid."' and `cid`='".$this->res($cid)."'  ");
if($this->num($sqlc)==0){
$this->rs("抱歉错误:内容不存在");
}

$this->Sql("INSERT into `s_content2`(`cid`, `uid`, `time`, `point`, `title`, `content`, `intro`, `fulltext1`, `likes`, `comment`, `view`)  (select  * from `s_content` where `uid`='".$uid."' and `cid`='".$this->res($cid)."') ");
$this->sql("delete from `s_content` where `uid`='".$uid."' and `cid`='".$this->res($cid)."'  ");
$this->usecoin(-2,"删除内容cid".$cid,$uid);
$this->rs("完成删除",1);

}



//评论

else if($api2=="cmt"){

// if($this->mycoin()<10){
// $this->rs("评论失败:微力不足");	
// }


if(!isset($_POST["cid"]) or !is_numeric($_POST["cid"])){
$this->rs("抱歉错误");
}

$cid=$_POST["cid"];

$sqlc=$this->sql("select `cid` from `s_content` where `cid`='".$this->res($cid)."'");
if($this->num($sqlc)==0){
$this->rs("抱歉错误:内容不存在");
}

if(!isset($_POST["cmt"]) or empty($_POST["cmt"]) ){
$this->rs("发送失败:请输入内容");	
}
$cmt=$_POST["cmt"];
//$msg=htmlspecialchars($msg, ENT_QUOTES);
$cmt=strip_tags(str_replace(" ","",$cmt),"<div> <br/>");

 
$sql2=$this->Sql("select  `s_user`.`uid`,`s_user`.`nickname`,`s_user`.`face` from  `s_user`  where `uid`='".$this->res($uid)."' limit 0,1");
$u=$this->row2($sql2);

$this->sql("INSERT INTO `s_comment`( `uid`, `time`, `cid`, `comment`) VALUES ('".$this->res($uid)."','".time()."','".$this->res($cid)."','".$this->res($cmt)."')");

$this->sql("update `s_content` set `comment`=`comment`+1 where `cid`='".$this->res($cid)."'");
$str="<div class='imsg'><div class='imsg1'><div class='demo'></div><div class='imsg3'><div class='imsg31'>
<div class='imsg311'>".$cmt."</div>
<div class='imsg312'>
".date("Y-m-d H:i:s",time())."
</div>
</div></div>
<div class='iface'><img src='/public/face/".$u["face"]."'/></div>
</div></div>";

$this->rs($str,1);

}









function reg_escape( $str )
{
	$conversions = array( "^" => "\^", "[" => "\[", "." => "\.", "$" => "\$", "{" => "\{", "*" => "\*", "(" => "\(", "\\" => "\\\\", "/" => "\/", "+" => "\+", ")" => "\)", "|" => "\|", "?" => "\?", "<" => "\<", ">" => "\>" );
	return strtr( $str, $conversions );
}
 
/**
* Strip attribute Class
* Remove attributes from XML elements
* @author David (semlabs.co.uk)
* @version 0.2.1
*/
 
class cleanHtml{
	
	public $str			= '';
	public $allow		= array();
	public $exceptions	= array();
	public $ignore		= array();
	
	public function strip( $str )
	{
		$this->str = $str;
		
		if( is_string( $str ) && strlen( $str ) > 0 )
		{
			$res = $this->findElements();
			if( is_string( $res ) )
				return $res;
			$nodes = $this->findAttributes( $res );
			$this->removeAttributes( $nodes );
		}
		
		return $this->str;
	}
	
	private function findElements()
	{
		
		# Create an array of elements with attributes
		$nodes = array();
		preg_match_all( "/<([^ !\/\>\n]+)([^>]*)>/i", $this->str, $elements );
		foreach( $elements[1] as $el_key => $element )
		{
			if( $elements[2][$el_key] )
			{
				$literal = $elements[0][$el_key];
				$element_name = $elements[1][$el_key];
				$attributes = $elements[2][$el_key];
				if( is_array( $this->ignore ) && !in_array( $element_name, $this->ignore ) )
					$nodes[] = array( 'literal' => $literal, 'name' => $element_name, 'attributes' => $attributes );
			}
		}
		
		# Return the XML if there were no attributes to remove
		if( !$nodes[0] )
			return $this->str;
		else
			return $nodes;
	}
	
	private function findAttributes( $nodes )
	{
		
		# Extract attributes
		foreach( $nodes as &$node )
		{
			preg_match_all( "/([^ =]+)\s*=\s*[\"|']{0,1}([^\"']*)[\"|']{0,1}/i", $node['attributes'], $attributes );
			if( $attributes[1] )
			{
				foreach( $attributes[1] as $att_key => $att )
				{
					$literal = $attributes[0][$att_key];
					$attribute_name = $attributes[1][$att_key];
					$value = $attributes[2][$att_key];
					$atts[] = array( 'literal' => $literal, 'name' => $attribute_name, 'value' => $value );
				}
			}
			else
				$node['attributes'] = null;
			
			$node['attributes'] = $atts;
			unset( $atts );
		}
		
		return $nodes;
	}
	
	private function removeAttributes( $nodes )
	{
		
		# Remove unwanted attributes
		foreach( $nodes as $node )
		{
			
			# Check if node has any attributes to be kept
			$node_name = $node['name'];
			$new_attributes = '';
			if( is_array( $node['attributes'] ) )
			{
				foreach( $node['attributes'] as $attribute )
				{
					if( ( is_array( $this->allow ) && in_array( $attribute['name'], $this->allow ) ) || $this->isException( $node_name, $attribute['name'], $this->exceptions ) )
						$new_attributes = $this->createAttributes( $new_attributes, $attribute['name'], $attribute['value'] );
				}
			}
			$replacement = ( $new_attributes ) ? "<$node_name $new_attributes>" : "<$node_name>";
			$this->str = preg_replace( '/'. reg_escape( $node['literal'] ) .'/', $replacement, $this->str );
		}
		
	}
	
	private function isException( $element_name, $attribute_name, $exceptions )
	{
		if( array_key_exists($element_name, $this->exceptions) )
		{
			if( in_array( $attribute_name, $this->exceptions[$element_name] ) )
				return true;
		}
		
		return false;
	}
	
	private function createAttributes( $new_attributes, $name, $value )
	{
		if( $new_attributes )
			$new_attributes .= " ";
		$new_attributes .= "$name=\"$value\"";
		
		return $new_attributes;
	}
 
}

?>