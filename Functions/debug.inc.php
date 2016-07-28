<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 31/05/2016
 * Time: 14:03
 */
function debug($var, $libelle = 'debug' )
{
    if(DEBUG){
        $_ENV['debug'][$libelle][] = $var;
    }
}

function getDebug()
{
    if(isset($_ENV['debug'])){
        debug(get_required_files(), 'REQUIERED');
        echo '<pre>';
        foreach($_ENV['debug'] as $key=>$info){
            echo "<br>$key<br>";
            var_dump($info);
        }
        echo '</pre>';
    }
}