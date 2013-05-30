<?php
include_once 'config-inc.php';
include_once 'RestMediaType.php';
include_once dirname(__FILE__).'/../PHPBind.php';
include_once dirname(__FILE__)."/".LIB_ADDENDUM.'/annotations.php';
include_once dirname(__FILE__).'/utils/RestFastException.php';

/**
 * Description of RestFast
 * API para la publicación de servicios REST
 *
 * @author esanchez
 */


class RestFast {

    //var $mediaType;
    var $className;
    var $httpHost;
    //var $classPath;
    
    public function handle(){
        $this->httpHost = "http://".$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI];
        $existe = FALSE;
        $listPathInfo = explode("/", $_SERVER["PATH_INFO"]);  
        if($this->className == NULL){
            Throw new RestFastException("se debe setear la clase primero");
        }
        
        if(count($listPathInfo) == 1 && $_SERVER["REQUEST_METHOD"] == RestRequestType::TYPE_GET){
            $this->getCatalog();
            $existe = TRUE;
        }
        else{        
            foreach ($this->className as $key => $class) {
                $reflection = new ReflectionAnnotatedClass($class); 
                $mediaType = $reflection->getAnnotation('Produces')->mediaType;
                $classPath = $reflection->getAnnotation("Path")->value;  
                foreach ($reflection->getMethods() as $key => $reflectionAnnotatedMethod ) {
                    $estado = TRUE;
                    if($reflectionAnnotatedMethod->getName() != "__construct"){
                        $pathM = $classPath.$reflectionAnnotatedMethod->getAnnotation("Path")->value;
                        $listPathMethod = explode("/", $pathM);
                        $requestMethodObject = $reflectionAnnotatedMethod->getAnnotation($_SERVER["REQUEST_METHOD"]);
                        $paramMethod = array();
                        foreach ($listPathMethod as $key => $value) {
                            if(substr($listPathMethod[$key], 0, 1) == "{" && substr($listPathMethod[$key], -1) == "}"){
                                //$aux = str_replace("{", "", $listPathMethod[$key]);
                                //$paramMethod[] = str_replace("}", "", $aux);
                                $paramMethod[] = $listPathInfo[$key];
                            }else if($listPathMethod[$key] != $listPathInfo[$key]){
                                $estado = FALSE;
                                break;
                            }
                        }                  
                        if($estado && is_object($requestMethodObject)){
                            $this->printInvoke($reflectionAnnotatedMethod, $class, $paramMethod, $mediaType);
                            $existe = TRUE;
                            break; 
                        }
                    }
                }
                if($existe){
                    break;
                }
            }
        }
        if(!$existe){
            throw new RestFastException("No existe ningu metodo que satisface la peticion ".$_SERVER["REQUEST_METHOD"]. " ".$_SERVER["PATH_INFO"]);
        }
        
    }

    protected function getCatalog(){        
        require_once 'utils/RestCatalog.php';
    }

    protected function printInvoke(ReflectionAnnotatedMethod $reflectionAnnotatedMethod, $className, $paramMethod, $mediaType){
        $class = new ReflectionClass($className);
        $instance = $class->newInstance();
        $reflectionMethod = new ReflectionMethod($className, $reflectionAnnotatedMethod->getName());
        
        switch ($mediaType) {
            case RestMediaType::TYPE_JSON:                
                header('Content-type: text/json');
                echo(json_encode($reflectionMethod->invokeArgs($instance, $paramMethod)));                    
                break;
            default:
                echo($reflectionMethod->invokeArgs($instance, $paramMethod));
        }
        
    }
    
    
    public function setClass($className){
        if(is_array($className)){
            $this->className = $className;
        }else{
            $this->className = array($className);
        }
        
        //$reflection = new ReflectionAnnotatedClass($className);                
        //$this->classPath = $reflection->getAnnotation("Path")->value;            
        //$this->mediaType = $reflection->getAnnotation('Produces')->mediaType;                
    }
    
}

?>
