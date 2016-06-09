<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 31/05/2016
 * Time: 15:47
 */

namespace Site;

require APP . 'Modeles/Import.php';

use Site\Import;

class Site extends Import
{
    public function indexAction(){
        $this->connexion('ceidotest_medicaments');
        extract($_SESSION['accueil']);
        if($produit == 'ok'){
            $_liste = $this->selectMedicamentOk();
            $num = $this->countMedicamentOk();
        
        } else if ($produit == 'ko') {
            $_liste = $this->selectMedicamentKo();
            $num = $this->countMedicamentKo();
        
        } else {
            $_liste = $this->selectMedicament();
            $num = $this->countMedicament();
        }
        
        afficheMenu('accueil', $num);
        $liste = [];
        foreach($_liste as $key =>$info){
            if(!($info['image'] = $this->testImage($info['cip13']))){
                //$sql = INSERT IN TO
                $info['image'] = $info['cip13'];
            }
            $liste[] = $info;
        }

        unset($_liste);
        include_once VUE . 'liste_medicaments.tpl.php';
    }

    public function erreur404Action(){
        echo "<p style='padding: 50px;color: crimson'>ERREUR 404 : La page que vous recherchez n'existe pas!</p>";
    }

    public function existImageBDD($photo){
        $sql = "SELECT image, vignette FROM control_images WHERE cip13 = $photo";
        return $this->query($sql);
    }

}