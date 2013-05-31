<?php
function listar_directorios_ruta($ruta, $carpeta = false){
   // abrir un directorio y listarlo recursiva
    $count = 0;
   if(!$carpeta)
    echo "<div style='text-align:left; overflow-y: scroll ; height:250px;'>";
   if (is_dir($ruta)) {
      if ($dh = opendir($ruta)) {
         while (($file = readdir($dh)) !== false) {
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio
            //mostraría tanto archivos como directorios
            if($file!="." && $file!="..")
                if (is_dir($ruta . $file)){
                   //solo si el archivo es un directorio, distinto que "." y ".."
                   echo "<br>Directorio: $ruta$file";
                   listar_directorios_ruta($ruta . $file . "/", $url, $file);
                }else{
                        echo "<br>".++$count.")<a href='#$count' >$file</a> ";
                }
         }
      closedir($dh);
      }
   }else

      echo "<br>No es ruta valida";
   if(!$carpeta)
    echo "</div>";
}

    function recursiveDelete($str){
        if(is_file($str)){
            return @unlink($str);
        }
        elseif(is_dir($str)){
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path){
                recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }

?>
