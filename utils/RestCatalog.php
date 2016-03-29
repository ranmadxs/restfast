<html>
    <head>
        <title>RestFast:<?=$_SERVER[PHP_SELF]?></title>
        <style type="text/css">
	    body    { font-family: arial; color: #000000; background-color: #ffffff; margin: 0px 0px 0px 0px; }
	    p       { font-family: arial; color: crimson ; margin-top: 0px; margin-bottom: 12px; }
	    pre { background-color: silver; padding: 5px; font-family: Courier New; font-size: x-small; color: #000000;}
	    ul      { margin-top: 10px; margin-left: 20px; }
	    li      { list-style-type: none; margin-top: 1px; color: #000000; }
	    .content{
		margin-left: 0px; padding-bottom: 2em; }
	    .nav {
		padding-top: 10px; padding-bottom: 10px; padding-left: 15px; font-size: .80em;
		margin-top: 10px; margin-left: 0px; color: #000000;
		background-color: #ccccff; width: 90%; margin-left: 20px; margin-top: 20px; }
            .cate{
		padding-top: 10px; padding-bottom: 10px; padding-left: 15px; font-size: .90em;
		margin-top: 10px; margin-left: 0px; color: #000000;
		background-color: #9999CC; width: 60%; margin-left: 20px; margin-top: 20px; }
	    .title {
		font-family: arial; font-size: 26px; color: #ffffff;
		background-color: #999999; width: 105%; margin-left: 0px;
		padding-top: 10px; padding-bottom: 10px; padding-left: 15px;}
	    a,a:active  { color: charcoal; font-weight: bold; }
	    a:visited   { color: #666666; font-weight: bold; }
	    a:hover     { color: cc3300; font-weight: bold; }
	</style>        
    </head>
    <body>
	<div class="content">
            <br><br>
            <div class=title><?=$_SERVER[PHP_SELF]?></div>
            <?
            foreach ($this->className as $key => $class) {
             $reflection = new ReflectionAnnotatedClass($class);    
             $classPath = $reflection->getAnnotation("Path")->value;  
             $mediaType = $reflection->getAnnotation('Produces')->mediaType;
         
            ?>
            <div class="cate">
                <p><b><?=$class?>.php</b></p>
            <? 
                foreach ($reflection->getMethods() as $key => $reflectionAnnotatedMethod ) { 
                    if($reflectionAnnotatedMethod->getName() != "__construct"){
            ?>
                <div class="nav">
                    <p><?=$class?>::<?=$reflectionAnnotatedMethod->getName()?></p>
                    <ul>
                        <li><b>Class Path : </b><?=$classPath?></li>
                        <li>
                            <b>Method Path :</b>
                            <a href='#'><?=$reflectionAnnotatedMethod->getAnnotation("Path")->value?></a>
                        </li>
                        <li><b>Media Type : </b><?=$mediaType?></li>
                        <li><b>Full Url :</b>
                            [<?=getTypeReqMethod($reflectionAnnotatedMethod);?>]
                            <a href='#'><?=$this->httpHost.$classPath.$reflectionAnnotatedMethod->getAnnotation("Path")->value?></a>
                        </li>
                    <ul>
                </div>
            <?      }
                } ?>
             </div>
           <? }?>
        </div>
    </body>        
    
</html>

<?
function getTypeReqMethod(ReflectionAnnotatedMethod $reflectionAnnotatedMethod){
    $res = "";
    if(is_object($reflectionAnnotatedMethod->getAnnotation(RestRequestType::TYPE_GET))){        
        $res = RestRequestType::TYPE_GET;        
    }
    if(is_object($reflectionAnnotatedMethod->getAnnotation(RestRequestType::TYPE_POST))){        
        $res = RestRequestType::TYPE_POST;        
    }
    if(is_object($reflectionAnnotatedMethod->getAnnotation(RestRequestType::TYPE_DELETE))){        
        $res = RestRequestType::TYPE_DELETE;        
    }
    return $res;
}
?>