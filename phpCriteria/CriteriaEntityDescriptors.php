<?php
include_once dirname(__FILE__).'/'.LIB_CRITERIA_ADDENDUM.'/annotations.php';

class Entity extends Annotation{
   public $Table;
}

class Id extends Annotation{}

class Column extends Annotation{
    public $Field;
    public $Type;
    public $Key;
    public $Null;
    public $Default;
    public $Extra;
}

class JoinColumn extends Annotation{
    public $Table;
    public $Column;
}
?>
