<?php
/**
 * Una representación mediante objetos de restricciones para una query
 * @package cl.phpcriteria.criterion
 * @author edgar
 */
class Restrictions{

    /**
     * @access private
     * @var dbh
    */
    private static $expr;

    /**
     * @access private
     * @var Restrictions
     */
    private static $restrictions;

    public function getExpr() {
        return $this->expr;
    }

    public function setExpr($expr) {
        $this->expr = $expr;
    }

     /**
     * @access protected
     */
    protected static function instance() {
        if (!self::$restrictions instanceof self) {
            self::$restrictions = new self;
        }
        return self::$restrictions;
    }
    /**
     * Restricción: igualdad
     * <br> $field > $valor
     * @param string $field
     * @param string $valor
     * @return string $stringRestriction
     */
    public static function eq($field, $valor){
        $restrictions = Restrictions::instance();
        $restrictions->expr = $field."='".$valor."'";
        return $restrictions;
    }

    /**
     * Restricción: menor o igual
     * <br> $field <= $valor
     * @param string $field
     * @param string $valor
     * @return string $stringRestriction
     */
    public static function le($field, $valor){
        $restrictions = Restrictions::instance();
        $restrictions->expr = $field."<='".$valor."'";
        return $restrictions;
    }

    /**
     * Restricción: mayor o igual
     * <br> $field >= $valor
     * @param string $field
     * @param string $valor
     * @return string $stringRestriction
     */
    public static function ge($field, $valor){
        $restrictions = Restrictions::instance();
        $restrictions->expr =  $field.">='".$valor."'";
        return $restrictions;
    }

    /**
     * Restricción: mayor que
     * <br> $field > $valor
     * @param string $field
     * @param string $valor
     * @return string $stringRestriction
     */
    public static function gt($field, $valor){
        $restrictions = Restrictions::instance();
        $restrictions->expr =  $field.">'".$valor."'";
        return $restrictions;
    }

    /**
     * Restricción: menor que
     * <br> $field < $valor
     * @param string $field
     * @param string $valor
     * @return string $stringRestriction
     */
    public static function lt($field, $valor){
        $restrictions = Restrictions::instance();
        $restrictions->expr =  $field."<'".$valor."'";
        return $restrictions;
    }

    /**
     * Restricción: Entremedio de valores
     * <br> $valor_menor < $field < $valor_mayor
     * @param string $field
     * @param string $valor
     * @return string $stringRestriction
     */
    public static function between($field, $valor_menor, $valor_mayor){
        $restrictions = Restrictions::instance();
        $restrictions->expr =  Restrictions::gt($field, $valor_menor)->getExpr()." AND ".Restrictions::lt($field, $valor_mayor)->getExpr();
        return $restrictions;
    }
}
?>
