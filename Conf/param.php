<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/05/2016
 * Time: 14:51
 */
define('RACINE' , str_replace('\\', '/', dirname(__DIR__).'/'));
define('APP', RACINE . 'App/');
define('CONF', RACINE . 'Conf/');
define('FUNC', RACINE . 'Functions/');
define('LIB', RACINE . 'Library/');
define('MOD', APP . 'Modeles/');
define('NUM', 10);
define('SITE', RACINE . 'www/');
define('PHOTO', RACINE . 'www/photos/');
define('REP_TRAITEMETN', PHOTO . 'traitement');
define('VUE', APP . 'Vues/');
define('LINK', 'http://'. str_replace('//', '/', $_SERVER['HTTP_HOST'].'/'.$_SERVER['CONTEXT_PREFIX']));
