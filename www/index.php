<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/05/2016
 * Time: 13:40
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/Conf/param.php';

require dirname(__DIR__) . '/Class/App.php';
require dirname(__DIR__) . '/Class/Bdd.php';

require FUNC . 'debug.inc.php';
require FUNC . 'functions.inc.php';

$__app = new \App\App();

require $__app->class;
$app = new $__app->controleur();

ob_start();
$app->{$__app->action}();
$contentPage = ob_get_contents();
ob_end_clean();

//debug(get_class_methods ( $app ), 'APP');
//debug(get_class_methods ( $app ), 'APP');
ob_start();
    getDebug();
    $contentDebug = ob_get_contents();
ob_end_clean();

include VUE . 'template.tpl.php';


