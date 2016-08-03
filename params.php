<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 31/05/2016
 * Time: 14:51
 */
/************* LINK SUR KIWAKI **************************/
define('LINK_PRODUITS_MEDICAMENTS', 'https://www.pharmaplay.fr/m/produits/');
define('LINK_PRODUITS_PARAPHARMACIE', 'https://www.pharmaplay.fr/p/produits/');

/************* LINK EN LOCAL ****************************/
define('LINK', 'http://'. str_replace('//', '/', $_SERVER['HTTP_HOST'].'/'.$_SERVER['CONTEXT_PREFIX']));
define('LINK_EN_COUR', 'photos/en_cours/');

/************** CONSTANTES GENERALES ********************/
define('RACINE' , str_replace('\\', DIRECTORY_SEPARATOR, __DIR__ . DIRECTORY_SEPARATOR));
define('CONF', RACINE . 'Conf' . DIRECTORY_SEPARATOR);
define('FUNC', RACINE . 'Functions' . DIRECTORY_SEPARATOR);
define('LIB', RACINE . 'Library' . DIRECTORY_SEPARATOR);

/************** CONSTANTE APPLICATION *******************/
define('APP', RACINE . 'App' . DIRECTORY_SEPARATOR);
define('CONT', APP . 'Controleurs' . DIRECTORY_SEPARATOR);
define('MOD', APP . 'Modeles' . DIRECTORY_SEPARATOR);
define('VUE', APP . 'Vues' . DIRECTORY_SEPARATOR);

/************** CONSTANTE TRAITEMENT IMAGES *************/
define('SITE', RACINE . 'www' . DIRECTORY_SEPARATOR);
define('PHOTO', SITE . 'photos' . DIRECTORY_SEPARATOR);
define('PHOTO_EN_COUR', PHOTO . 'en_cours' . DIRECTORY_SEPARATOR);
define('PHOTO_PRODUCTION', PHOTO . 'production' . DIRECTORY_SEPARATOR);
define('PHOTO_TRAITEMENT', PHOTO . 'traitement' . DIRECTORY_SEPARATOR);

/************** CONSTANTE AFFICHAGE ********************/
define('NUM', 10);
define('LIMIT', 20);

