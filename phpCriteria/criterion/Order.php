<?php
/**
 * Clase que entrega tipo de orden para el listado de resultados por atributo
 * @package cl.phpcriteria.criterion
 * @author edgar
 */
class Order {

    const ORDER_ASC = "ASC";
    const ORDER_DESC = "DESC";
    /**
     * @access private
     * @var string
    */
    private static $orderType;

    /**
     * @access private
     * @var string
    */
    private static $orderAtribute;

    /**
     * @access private
     * @var Order
    */
    private static $order;

    /**
     * @access protected
    */
    protected static function instance() {
        if (!self::$order instanceof self) {
            self::$order = new self;
        }
        return self::$order;
    }

    /**
     * Orden Ascendente
     * @param string $propertyName
     * @return Order $order
     */
    public static function asc($propertyName){
        $order = Order::instance();
        $order->orderType = self::ORDER_ASC;
        $order->orderAtribute = $propertyName;
        return $order;
    }
    /**
     * Orden Descendente
     * @param string $propertyName
     * @return Order $order
     */
    public static function desc($propertyName){
        $order = Order::instance();
        $order->orderType = self::ORDER_DESC;
        $order->orderAtribute = $propertyName;
        return $order;
    }


    public function getOrderType() {
        return $this->orderType;
    }

    public function setOrderType($orderType) {
        $this->orderType = $orderType;
    }

    public function getOrderAtribute() {
        return $this->orderAtribute;
    }

    public function setOrderAtribute($orderAtribute) {
        $this->orderAtribute = $orderAtribute;
    }

}
?>