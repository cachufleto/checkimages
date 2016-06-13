<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/05/2016
 * Time: 13:54
 */

namespace App;


class App
{
    var $routeur = [];
    var $page = 'acceuil';
    var $controleur = 'Site\Site';
    var $action = 'indexAction';
    var $class = APP . 'Controleurs/Site.php';

    public function __construct()
    {
        session_start();
        $this->destroy();
        $this->getRoute();
        $this->setPage();
        $this->setSession();
        $this->setSessionMoteurRecherche();

    }

    public function destroy()
    {
        if(isset($_GET['sortir']) XOR isset($_POST['sortir'])){
            unset($_SESSION);
            session_destroy();
            header('location:?page=accueil');
        }
    }

    public function getRoute(){
        include ( CONF . 'route.inc');
        $this->routeur = $_r;
    }
    
    public function setPage(){
        if(!empty($_GET)){
            $this->page = (isset($_GET['page']) AND !empty($_GET['page']))? $_GET['page'] : 'accueil';
            $this->setControleur();
        }
    }

    public function setControleur(){
        if(array_key_exists($this->page, $this->routeur)){
            if(file_exists(APP . 'Controleurs/'.$this->routeur[$this->page]['controleur'].'.php')){
                $controleur = $this->routeur[$this->page]['controleur'];
                $this->class = APP . 'Controleurs/'.$controleur.'.php';
                $this->controleur = $controleur.'\\'.$controleur;
                $this->action = $this->routeur[$this->page]['action'];
            } else {
                $this->page = '';
                $this->action = 'erreur404Action';
            }
        } else {
            $this->page = '';
            $this->action = 'erreur404Action';
        }
    }

    public function setSession(){
        if(!empty($this->page)){
            if(!isset($_SESSION[$this->page])){
                $_SESSION[$this->page] = [
                    'display' => 0,
                    'b' => NUM,
                    'p' => false,
                    'produit'=> "",
                    'a' => 0,
                    'zaper' => '0'
                ];
            }

            if(!empty($_GET)){
                $_SESSION[$this->page]['display'] = isset($_GET['display'])? ( ($_GET['display']>=0)? $_GET['display'] : 0 ) : 0;
                $_SESSION[$this->page]['p'] = isset($_GET['produit'])? true : false;
                if($_SESSION[$this->page]['p']){
                    if($_GET['produit'] != $_SESSION[$this->page]['produit']){
                        $_SESSION[$this->page]['display'] = 0;
                    }
                } else {
                    if(!empty($_SESSION[$this->page]['produit'])){
                        $_SESSION[$this->page]['display'] = 0;
                    }
                }
                $_SESSION[$this->page]['produit'] = isset($_GET['produit'])? $_GET['produit'] : "";
                $_SESSION[$this->page]['b'] = isset($_GET['nombre'])? ( ($_GET['nombre']>0)? $_GET['nombre'] : NUM ) : NUM;
                $_SESSION[$this->page]['a'] = $_SESSION[$this->page]['b'] * $_SESSION[$this->page]['display'];
                $_SESSION[$this->page]['zaper'] = ($_SESSION[$this->page]['p'])? (
                                                        ($_SESSION[$this->page]['produit'] == 'ok')? 2 : (
                                                        ($_SESSION[$this->page]['produit'] == 'ko')? 1 : 0)
                                                        ) : 0;
            }

        }
    }

    function setSessionMoteurRecherche()
    {
        if(isset($_POST['chercher'])){
            $_SESSION['recherche'][$this->page] = $_POST;
        } else if (!isset($_SESSION['recherche'][$this->page])){
            $_SESSION['recherche'][$this->page] = [];
        }
    }
}