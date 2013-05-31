<?php
include_once dirname(__FILE__).'/'.LIB_CRITERIA_ADDENDUM.'/annotations.php';

class CriteriaEntityMgr{
   
   private static $instancia;

   public static function instance()
   {
      if (  !self::$instancia instanceof self)
      {
         self::$instancia = new self;
      }
      return self::$instancia;
   }   

   public function findTable($className) {
       $reflection = new ReflectionAnnotatedClass($className);       
       $tableName = $reflection->getAnnotation('Entity')->Table;
       if(strlen($tableName)>0)
           return (string) $tableName;
       Throw new Exception('La clase '.$className." no tiene Una entidad Tabla bien definida");
    }
    
    public function findPks($className) {
        $reflection = new ReflectionAnnotatedClass($className); // by class name
        $properties = $reflection->getProperties();
        $atributes_column = array();
        if(count($properties) > 0)
            foreach ($properties as $key => $property) {
                $reflectionAnotatedProperty = new ReflectionAnnotatedProperty($className, $property->getName());
                $Key = $reflectionAnotatedProperty->getAnnotation('Column')->Key;
                if(strlen($Key)>0 && $Key == "PRI")
                    $atributes_column[] = (string) $reflectionAnotatedProperty->getAnnotation('Column')->Field;
            }
        if(count($atributes_column)>0)
            return $atributes_column;
        Throw new Exception('La clase '.$className." no tiene definidas llaves");
    }
}
?>