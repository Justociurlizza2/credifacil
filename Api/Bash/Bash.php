<?php
namespace Bash;
use Controllers\Helper;

class Bash {

    static public function cloneDB ($data): bool {
        $fname   = "Bash/clonedb.sh";
        $fhandle = fopen($fname, "r");                      /* Recuperamos contenido del bash y cerramos*/
        $content = fread($fhandle, filesize($fname));
        fclose($fhandle);
        /*------------------------ Creamos el bash temporal ------------------------*/
        $dbname = $data['ruc'].'.sh';
        $dir    = 'public/tmp/'. $dbname;
        $handle = fopen($dir, 'w');
        $content = str_replace('db=bretsiadb', 'db=bret'.$data['ruc'], $content);   // Cambiamos el parametro db
        fwrite($handle, $content) or die("No se pudo escribir en el archivo");
        fclose($handle);
        $res = array();
        exec('/bin/bash /var/www/api.pe.bretsia/'.$dir.' -e 2>&1', $res);
        if(count($res)) return false;
        else            return true;
        //$result = exec('sudo /bin/bash /etc/mysql/bashdb.sh /var/www/api.pe.bretsia/');
    }
}