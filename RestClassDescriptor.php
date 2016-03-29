<?php
include_once 'config-inc.php';
include_once dirname(__FILE__)."/".LIB_ADDENDUM.'/annotations.php';

class Path extends Annotation{}

class Produces extends Annotation{
    public $mediaType;
}

class GET extends Annotation{}

class POST extends Annotation{}

class DELETE extends Annotation{}

?>
