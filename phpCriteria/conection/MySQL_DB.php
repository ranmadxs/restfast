<?php
include_once 'DBSQLInterface.php';

/**
 * Description of MySQL_DB
 *
 * @author edgar
 */
class MySQL_DB implements DBSQLInterface {

    private static $instancia;
    private $dataBase;

    public function getDataBase() {
        return $this->dataBase;
    }

    public static function instance() {
        if (!self::$instancia instanceof self) {
            self::$instancia = new self;
        }
        return self::$instancia;
    }

    public function DBConnect(&$dbh, &$db = null) {

        $dbh = mysql_connect(CRITERIA_DB_HOST, CRITERIA_DB_USER, CRITERIA_DB_PASSWORD) or die('No se puede conectar a la base de datos, la razón es: ' . mysql_error());
        if ($db != null) {
            mysql_select_db($db);
            $this->dataBase = $db;
        } else {
            mysql_select_db(CRITERIA_DB_DEFAUTL);
            $db = $this->dataBase = CRITERIA_DB_DEFAUTL;
        }
    }

    public function DBQuery($SQL_query, $dbh) {
        mysql_select_db($this->dataBase);
        $result = mysql_query($SQL_query, $dbh) or $this->DBError($SQL_query); /* or Error(0x4) */
        return $result;
    }

    public function DBCambioPermanente($anio) {
        DBConnect($dbh);
        mysql_select_db(BD_SIGA);
        $SQL = "UPDATE db SET anio = '$anio'
                            WHERE db_ID ='" . $_SESSION['base_datos']->db_ID . "'";
        $this->DBQuery($SQL, $dbh);
        mysql_select_db($_SESSION['base_datos']->nombrebd);
    }

    public function DBFetchArray($result) {
        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        return $row;
    }

    public function DBError($sentencia) {
        $mensaje_error = mysql_error();
        $Nerror = mysql_errno();
        $error_query['0'] = array("mensaje" => $mensaje_error, "n_error" => $Nerror);
        $error_query['1'] = $sentencia;
        $titulo = "******* ERROR EN QUERY SQL *******";
        echo "<pre>";
        print_r($error_query);
        echo "</pre>";
        exit();
    }

    public function DBBegin(&$dbh) {
        $result = $this->DBQuery("BEGIN", $dbh);
        return $result;
    }

    public function DBCommit(&$dbh) {
        $result = $this->DBQuery("COMMIT", $dbh);
        return $result;
    }

    public function DBRollback(&$dbh) {
        $result = $this->DBQuery("ROLLBACK", $dbh);
        return $result;
    }

    public function DBSQLSelect($table, $array_atributos = null, $datos_where = null, $array_order = null, $type_order = "", $restrictions=false) {
        $atributos = "*";
        $cond = "";
        $order = "";
        if (count($array_atributos) > 0)
            $atributos = implode(",", $array);

        if (count($array_order) > 0) {
            $order = "ORDER BY ";
            $order .= implode(",", $array_order);
        }

        if (count($datos_where) > 0) {
            $cond = "WHERE ";
            if (!$restrictions)
                foreach ($datos_where as $nomcampo => $dato) {
                    if (strlen($dato)) {
                        $where[] = $nomcampo . "='" . $dato . "'";
                    }
                }
            else
                $where = $datos_where;
            $cond.=implode(" AND ", $where);
        }
        $SQL = "SELECT $atributos FROM $table $cond $order $type_order";
        return $SQL;
    }

    public function DBSQLInsert($array, $table) {
        $campos = "";
        $valores = "";
        foreach ($array as $nomcampo => $dato) {
            if (strlen($dato)) {
                $campos .= ( strlen($campos) ? ",\n " : "") . $nomcampo;
                $valores .= ( strlen($valores) ? ",\n " : "") . "'" . $dato . "'";
            }
        }
        $SQL = "INSERT INTO $table (\n$campos\n) VALUES (\n$valores\n)";
        return $SQL;
    }

    public function DBSQLUpdate($datos_set, $datos_where, $table, $autocompleteNull=false) {
        $set = "";
        $where = "";
        foreach ($datos_set as $nomcampo => $dato) {
            if (strlen($dato)) {
                $set .= $nomcampo . "='" . $dato . "',";
            } else
            if ($autocompleteNull) {
                $set .= $nomcampo . "=NULL,";
            }
        }
        foreach ($datos_where as $nomcampo => $dato) {
            if (strlen($dato)) {
                $where .= $nomcampo . "='" . $dato . "' AND ";
            }
        }
        $set = substr($set, 0, strlen($set) - 1);
        $where = substr($where, 0, strlen($where) - 4);
        $SQL = "UPDATE $table\n SET $set\n  WHERE $where";
        return $SQL;
    }

    public function DBSQLShowStatus() {
        $sql = "SHOW TABLE STATUS FROM " . $this->dataBase;
        return $sql;
    }

    public function DBSQLSchema($tableName) {
        $sql = "SELECT u.*
                FROM information_schema.table_constraints AS c
                INNER JOIN information_schema.key_column_usage AS u USING( constraint_schema, constraint_name )
                WHERE c.constraint_type = 'FOREIGN KEY' AND c.table_schema='$this->dataBase' AND c.table_name='$tableName' ";
        return $sql;
    }

    public function DBSQLShowCreateTable($tableName){
        $SQL = "SHOW CREATE TABLE ".$tableName;
        return $SQL;
    }

    public function DBSQLDelete($tableName, $datosWhere){
        $SQL = "DELETE FROM $tableName ";
        $strDelete = array();
        if(count($datosWhere) > 0){
            foreach ($datosWhere as $nomcampo => $valorCampo) {
                $strDelete[] = $nomcampo . " = '".$valorCampo."'";
            }
            $SQL .= " WHERE ";
            $SQL .= implode(" AND ", $strDelete);
        }
        return $SQL;
    }
}

?>