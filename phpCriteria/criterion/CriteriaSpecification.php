<?php

/**
 * Description of CriteriaSpecification
 *
 * @package cl.phpcriteria.criterion
 * @author edgar
 */
class CriteriaSpecification {

    /**
     * @access protected
     * @var <dbh>
     */
    protected $dbh;
    
    /**
     * @access protected
     * @var <array>
    */
    protected $list;

    /**
     * @access protected
     * @var <integer>
    */
    protected $numRows;

    /**
     * @access protected
     * @var <integer>
    */
    protected $insertID;

    /**
     * @access protected
     * @var <object>
    */
    protected $object;

    /**
     * @access protected
     * @var <array>
    */
    protected $arrayList;

    /**
     * @access protected
     * @var <result>
    */
    protected $result;

    /**
     * @access protected
     * @var <array>
     */
    protected $array_order;

    /**
     * @access protected
     * @var <string>
     */
    protected $type_order;

    /**
     * @access protected
     * @var <string>
     */
    protected $SQL;

    /**
     * @access protected
     * @var <string>
     */
    protected $db;

    /**
     * @access protected
     * @var <string>
     */
    protected $className;

    /**
     * @access protected
     * @var <string>
    */
    protected $table;

    /**
     * @access protected
     * @var <boolean>
    */
    protected $flagCreateCtriteria;

    /**
     * @access protected
     * @var <array>
    */
    protected $array_restrictions;

    /**
     * @access protected
     * @var <string>
     */
    protected $objectClass;

    /**
     * Función que retorna el resultado de la query en un arreglo
     * @return Array
    */
    public function getArrayList() {
       if(is_array($this->arrayList))
            unset($this->arrayList);

       $this->arrayList = array();

       while ($row = MySQL_DB::instance()->DBFetchArray($this->result)){
                $this->arrayList[] = $row;
       }
       return $this->arrayList;
    }

    public function getResult() {
        return $this->result;
    }

    public function getInsertID() {
        return $this->insertID;
    }

    protected function setInsertID($insertID) {
        $this->insertID = $insertID;
    }

    public function getNumRows() {
        return $this->numRows;
    }

    protected function setNumRows($numRows) {
        $this->numRows = $numRows;
    }

    /*
     * Función que retorna un objeto único
     * @return Object
     */
    public function uniqueResult(){
        return $this->object;
    }

    /*
     * Función que retorna un arreglo de objetos
     * @return Array[Object]
     */
    public function listResult(){
        return $this->list;
    }

    protected function setObject($object) {
        $this->object = $object;
    }

    protected function setList($list) {
        $this->list = $list;
    }

}

?>