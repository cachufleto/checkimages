<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 06/06/2016
 * Time: 11:58
 */
namespace Upload;
require APP . 'Modeles/Images_old.php';

use Upload\Images;

/*

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id_image` int(10) UNSIGNED NOT NULL,
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `cip13` char(15) DEFAULT NULL,
  `denomination` longtext NOT NULL,
  `presentation` text NOT NULL,
  `type` int(1) DEFAULT NULL,
  `date_traitement` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `libelle` char(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

  `cip13` char(15) DEFAULT NULL,
  `denomination` longtext NOT NULL,
  `presentation` text NOT NULL,
  `type` int(1) DEFAULT NULL,
  `libelle` char(200) DEFAULT NULL,


 * */
class Upload extends Images
{
    var $session = 'Upload';

    public function listeAction(){

        extract($_SESSION[$this->session]);
        $this->zapper = "= $zapper";
        $numProduits = $this->getNumImages();
        $f = afficheMenu($this->page, $this->session, $numProduits);

        $liste = $this->getListeImages($a, $b, $p);

        include(VUE . 'listeUpload.tpl.php');

    }

    public function selectAction(){

        if(isset($_POST['id'])){
            if($_POST['option'] == 'zapper'){
                $this->updateZapper();
            } else if($_POST['option'] == 'conserver'){
                $this->updateConserver();
            } else if($_POST['option'] == 'retirer'){
                $this->updateRetirer();
            }
        }
        if(isset($_GET['mode']) && $_GET['mode'] == 'exist'){
            $this->existantAction();
        }
        else {
            $this->listeAction();
        }
    }

    public function photoAction(){

        if(isset($_POST['id'])){
            if($_POST['option'] == 'zapper'){
                $this->updateZapper();
            } else if($_POST['option'] == 'conserver'){
                $this->updateConserver();
            } else if($_POST['option'] == 'retirer'){
                $this->updateRetirer();
            } else if($_POST['option'] == 'CIP'){
                $this->updateCip();
            }
        }

        $this->existantAction();
    }

    public function existantAction(){

        extract($_SESSION[$this->session]);
        $this->zapper = "= $zapper";
        $data = $this->getExistImages($p);
        $data = $this->extractImages($data, $a, $b);
        $listing = $data['liste'];

        $numProduits = $data['num'];

        $f = afficheMenu($this->page, $this->session, $numProduits);
        $liste = [];
        foreach ($listing as $key => $image) {

            $liste[$key]['existe'] = (file_exists(PHOTO . $image['nom'] . '.jpg')) ?
                '<img src="' . PHOTO . $image['nom'] . '.jpg' . '">' : '';
            $liste[$key]['existepng'] = (file_exists(PHOTO . $image['nom'] . '.png')) ?
                '<img src="' . PHOTO . $image['nom'] . '.png' . '">' : '';
            $liste[$key]['zapper2'] = ($image['zapper'] != 2) ?
                '<input name="option" type="submit" value="conserver">' :
                '<input name="option" type="submit" value="retirer">';
            $liste[$key]['zapper1'] = ($image['zapper'] != 1) ? 
                '<input name="option" type="submit" value="zapper">' : '';
            $data = getExistProduit($image['id']);
            $produit = $data->fetch_assoc();
            $liste[$key]['cip13'] = isset($produit['cip13'])? $produit['cip13']:'';
            $liste[$key]['denomination'] = isset($produit['denomination'])? $produit['denomination']:'';
            $liste[$key]['libelle'] = isset($produit['libelle'])? $produit['libelle']:'';
            $liste[$key]['presentation'] = isset($produit['presentation'])? $produit['presentation']:'';
            $liste[$key]['date'] = isset($produit['date_traitement'])? $produit['date_traitement']:'';
            $type = isset($produit['type'])? $produit['type']:'';
            $liste[$key]['med'] = ($type == 1)? 'selected' : '';
            $liste[$key]['para'] = ($type == 2)? 'selected' : '';
        }
//        include(VUE . 'listeExistant.tpl.php');
    }

    public function extractImages($liste, $a=0, $b=5){
        $result = [];
        $i = 1;
        foreach ($liste as $key=>$info){
            if( file_exists( PHOTO . $info['nom'] . '.jpg') OR file_exists( PHOTO . $info['nom'] . '.png')){
                if($i >$a && $i <= ($a + $b)) {
                    $result[] = $info;
                }
                $i++;
            }
        }
        return ['num' => $i, 'liste' => $result];
    }
}