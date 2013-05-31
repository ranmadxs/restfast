<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author edgar
 */
interface DBSQLInterface {
    function DBConnect(&$dbh, &$db = null);
    function DBQuery($SQL_query, $dbh);
    function DBCambioPermanente($anio);
    function DBFetchArray($result);
    function DBError($sentencia);
    function DBBegin(&$dbh);
    function DBCommit(&$dbh);
    function DBRollback(&$dbh);
    function DBSQLSelect($table, $array_atributos = null, $datos_where = null, $array_order = null, $type_order = "");
    function DBSQLInsert($array, $table);
    function DBSQLUpdate($datos_set, $datos_where, $table, $autocompleteNull=false);
    function getDataBase();
    function DBSQLShowStatus();
}
?>
