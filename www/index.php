<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 31/05/2016
 * Time: 13:40
 */
require '../params.php';
require RACINE . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if(file_exists(CONF . 'Bdd.inc.php')){
    include_once (CONF . 'Bdd.inc.php');
}else{
    exit("<h2>L'Outil n'est pas instalé!<h2>");
}

require LIB . 'App.php';
require LIB . 'Bdd.php';

require FUNC . 'debug.inc.php';
require FUNC . 'functions.inc.php';

$__app = new \App\App();

require $__app->class;
$app = new $__app->controleur();

ob_start();
$app->{$__app->action}();
$contentPage = ob_get_contents();
ob_end_clean();

ob_start();
    getDebug();
    $contentDebug = ob_get_contents();
ob_end_clean();

include VUE . 'template.tpl.php';


