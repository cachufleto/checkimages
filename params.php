<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 31/05/2016
 * Time: 14:51
 */
define('RACINE' , str_replace('\\', DIRECTORY_SEPARATOR, __DIR__.DIRECTORY_SEPARATOR));
define('APP', RACINE . 'App'.DIRECTORY_SEPARATOR);
define('CONF', RACINE . 'Conf'.DIRECTORY_SEPARATOR);
define('FUNC', RACINE . 'Functions'.DIRECTORY_SEPARATOR);
define('LIB', RACINE . 'Library'.DIRECTORY_SEPARATOR);
define('MOD', APP . 'Modeles'.DIRECTORY_SEPARATOR);
define('NUM', 10);
define('SITE', RACINE . 'www'.DIRECTORY_SEPARATOR);
define('PHOTO', RACINE . 'www' . DIRECTORY_SEPARATOR . 'photos'.DIRECTORY_SEPARATOR);
define('PHOTO_EN_COUR', PHOTO . 'en_cours' . DIRECTORY_SEPARATOR);
define('PHOTO_PRODUCTION', PHOTO . 'production' . DIRECTORY_SEPARATOR);
define('PHOTO_TRAITEMENT', PHOTO . 'traitement' . DIRECTORY_SEPARATOR);
define('VUE', APP . 'Vues'.DIRECTORY_SEPARATOR);
define('LINK', 'http://'. str_replace('//', '/', $_SERVER['HTTP_HOST'].'/'.$_SERVER['CONTEXT_PREFIX']));
define('LINK_EN_COUR', 'photos/en_cours/');
