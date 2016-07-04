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
    var $page = 'accueil';
    var $session = 'Site';
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
                $this->session = $controleur;
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
        if(!empty($this->session)){
            if(!isset($_SESSION[$this->session])){
                $_SESSION[$this->session] = [
                    'display' => 0,
                    'b' => NUM,
                    'p' => false,
                    'produit'=> "",
                    'a' => 0,
                    'zapper' => '0'
                ];
            }

            if(!empty($_POST) AND isset($_POST['nombre']) AND $_POST['nombre']>0){
                $_SESSION[$this->session]['display'] = intval($_SESSION[$this->session]['a'] / $_POST['nombre']);
                $_SESSION[$this->session]['b'] = $_POST['nombre'];
                $_SESSION[$this->session]['a'] = $_SESSION[$this->session]['b'] * $_SESSION[$this->session]['display'];
            } else if(!empty($_GET)){
                $_SESSION[$this->session]['display'] = isset($_GET['display'])? ( ($_GET['display']>=0)? $_GET['display'] : 0 ) : 0;
                $_SESSION[$this->session]['p'] = isset($_GET['produit'])? true : false;
                if($_SESSION[$this->session]['p']){
                    if(isset($_GET['produit']) AND $_GET['produit'] != $_SESSION[$this->session]['produit']){
                        $_SESSION[$this->session]['display'] = 0;
                    }
                } else {
                    if(!empty($_SESSION[$this->session]['produit'])){
                        $_SESSION[$this->session]['display'] = 0;
                    }
                }
                $_SESSION[$this->session]['produit'] = isset($_GET['produit'])? 
                                $_GET['produit'] : $_SESSION[$this->session]['produit'];
                $_SESSION[$this->session]['a'] = $_SESSION[$this->session]['b'] * $_SESSION[$this->session]['display'];
                $_SESSION[$this->session]['zapper'] = ($_SESSION[$this->session]['p'])? (
                                                        ($_SESSION[$this->session]['produit'] == 'ok')? 2 : (
                                                        ($_SESSION[$this->session]['produit'] == 'ko')? 1 : 0)
                                                        ) : 0;
            }
        }
    }

    function setSessionMoteurRecherche()
    {
        if(isset($_POST['chercher'])){
            $_SESSION['recherche'][$this->session] = $_POST;
        } else if (!isset($_SESSION['recherche'][$this->session])){
            $_SESSION['recherche'][$this->session] = [];
        }
    }
}