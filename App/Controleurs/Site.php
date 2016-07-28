<?php
/**
 * Created by ceidodev.com
 * User: CARLOS PAZ
 * Date: 31/05/2016
 * Time: 15:47
 */

namespace Site;

require MOD . 'Import.php';

use Site\Import;

class Site extends Import
{
    var $page = '';
    var $session = 'Site';

    /**
     * Page de démarrage
     */
    public function indexAction()
    {
        include_once VUE . 'index.tpl.php';
    }

    /* public function medicamentAction(){

        $this->page = 'medicament';

        $this->connexion(MEDICAMENTS);
        $produit='';
        extract($_SESSION[$this->session]);
        
        if($produit == 'ok'){
            testPagination($this->session, $num = $this->countMedicamentOk(), $this->page);
            $_liste = $this->selectMedicamentOk();
        
        } else if ($produit == 'ko') {
            testPagination($this->session, $num = $this->countMedicamentKo(), $this->page);
            $_liste = $this->selectMedicamentKo();
        
        } else {
            testPagination($this->session, $num = $this->countMedicament(), $this->page);
            $_liste = $this->selectMedicament();
        }

        afficheMenu($this->page, $this->session, $num);

        $this->afficheMoteurRecherche();

        $liste = [];
        foreach($_liste as $key =>$info){
            if(!($info['image'] = $this->testImage($info['cip13']))){
                $info['image'] = $info['cip13'];
            }
            $liste[] = $info;
        }

        unset($_liste);

        include_once VUE . 'liste_produits.tpl.php';
    } */

    public function erreur404Action(){
        echo "<p style='padding: 50px;color: crimson'>ERREUR 404 : La page que vous recherchez n'existe pas!</p>";
    }
    
}