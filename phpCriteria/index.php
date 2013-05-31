<?php

require_once 'config-inc.php';
require_once 'CriteriaProperty.php';
require_once 'CriteriaGenerate.php';
require_once 'Criteria.php';
require_once 'criterion/Restrictions.php';
require_once 'criterion/Order.php';
require_once 'utils/LoadDirectory.php';
?>

<div align="center">
    <strong>PHPCriteria 1.02 (30-05-2013)</strong>
</div>
<?php

//exit();
//phpinfo();
//$lol = dirname(__FILE__);
//dpr($lol);
//dpr( php_uname( 's') );
//dpr(DIRECTORY_SEPARATOR);
/*
  if (DIRECTORY_SEPARATOR=='/')
  $absolute_path = dirname(__FILE__).'/';
  else
  $absolute_path = str_replace('\\', '/', dirname(__FILE__)).'/';
 */

$criteria = new Criteria();
$criteria->setSQL("SHOW DATABASES");
$criteria->execute();
$databases = $criteria->getArrayList();
$criteriaDBDefault = CRITERIA_DB_DEFAUTL;

if (isset($_POST['button'])) {

    switch ($_POST['button']) {
        case "GENERAR_ENTIDADES":
            recursiveDelete(CRITERIA_PATH_RELATIVE."generation");
            mkdir(CRITERIA_PATH_RELATIVE."generation", 0755);
            echo "<hr>Entitades en la carpeta generation:<hr>";
            $criteriaDBDefault = $_POST["database"];
            $criteriaGenerate = new CriteriaGenerate($criteriaDBDefault);            
            $criteriaGenerate->generateEntity();
            listar_directorios_ruta(CRITERIA_PATH_RELATIVE."generation");
            break;

        case "CARGAR_PRUEBAS":
            echo "Cargando Pruebas";
            require_once 'generation/EntityBecas.php';
//            require_once 'generation/EntityArancel.php';
            $criteria = new Criteria();
            $becas = new EntityBecas();
            $criteria->createCriteria($becas);
            $criteria->add(Restrictions::eq("beca_anio", "2011"));
            $criteria->add(Restrictions::between("beca_ID", 4, 9));
            $criteria->addOrder(Order::desc("beca_ID"));
            //$criteria->
            dprCriteria($criteria->getSQL());
            $lol = $criteria->lista();
            dprCriteria($lol);
            //$criteria->add($restrictions);
//            $filial = new EntityCCA_FILIAL();
//            $filial->ID_FILIAL = 1;
//            $criteria->find($filial);
//            dpr($filial);
//            $filial->APLICACION_ACTUALIZACION = "PruebMerg2";
//            $criteria->merge($filial);
//            $filial->ID_FILIAL = null;
//            $filial->APLICACION_ACTUALIZACION = "Persist";
//            $criteria->persist($filial);
//            $criteria = new Criteria();
//            $criteria->createCriteria(new EntityCCA_FILIAL());
//            dpr($criteria->lista());
//            $arancel = new EntityArancel();
//
//            $criteria->setSQL("SHOW TABLE STATUS FROM baseMAS")->execute();
//            dpr($criteria->getArrayList());
//
//            $criteria->createCriteria($arancel);
            //dpr($criteria->lista());
//            $criteria->add(Restrictions::eq("aran_anio", "2010"));
//            $criteria->add(Restrictions::le("aran_monto", 34000));
//            $criteria->add(Restrictions::between("aran_ID", "1", "3"));
//            dpr($criteria->getSQL());
//            $lista = $criteria->lista();
//            dpr($lista);
//            $arancel->aran_ID = 101;
//            $arancel->aran_anio = "2222";
//            $arancel->aran_monto = 22222;
//            $arancel->FK_colegios_colegio_ID = "22222";
//            $arancel->FK_curso = "2222";
//            $criteria->merge($arancel);
//            dpr($criteria);
//            dpr($criteria->getSQL());
            // dpr($lista);
            break;
        default:
            echo "default";
            break;
    }
}
?>
<form method="post" id="formGenerarPersist" name="formGenerarPersist" action="">
    <hr>
    Seleccionar la Base de Datos: <select name="database">
        <?     
            foreach ($databases as $key => $database) {
                $checked = $criteriaDBDefault == $database["Database"]?"selected":"";
                echo "<option value='".$database["Database"]."' $checked >".$database["Database"]."</option>";
            }
        ?>
    </select>
    <input type="submit" name="button" value="GENERAR_ENTIDADES" onclick="return confirm('Al generar entidades se borran todos los archivos de la carpeta generation \n ¿Esta seguro que desea Borrar Todo?')" />
    <hr>
    <br>
    <input type="submit" name="button" value="CARGAR_PRUEBAS" />
</form>