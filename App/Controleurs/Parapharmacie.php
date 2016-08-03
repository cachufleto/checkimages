<?php
/**
 * Created by ceidodev.com
 * User: Carlos PAZ DUPRIEZ
 * Date: 13/06/2016
 * Time: 12:27
 */

namespace Parapharmacie;

require_once LIB . 'Produit.php';
use App\Produit;

require_once LIB . 'Menu.php';
use App\Menu;

require_once LIB . 'Image.php';
use App\Image;

require_once LIB . 'Moteur.php';
use App\Moteur;

class Parapharmacie extends Produit
{
    var $session = 'Parapharmacie';
    var $mage = '';
    var $champsObligatoires = '';

    public function __construct()
    {
        parent::__construct();
        $this->link = LINK_PRODUITS_PARAPHARMACIE;
        $this->connexion(PARAPHARMACIE);

        $this->menu = new Menu($this, 'Produits');

        $this->image = new Image();
        $this->image->connexion(SURFIMAGE);
        //$this->image->session = $this->session;
        $this->image->session = $this->session;

        $this->champsObligatoires = file_contents_parapharmacie();

        $this->moteur = new moteur($this, $this->image, $_SESSION['recherche'][$this->session]);
        debug($this->moteur, 'RECHERCHE');
    }

    public function indexAction()
    {
        $this->menu->afficher();
        $liste = $this->getImages($this->produits());

        include_once VUE . 'liste_produits.tpl.php';
    }

    public function ficheProduit(){
        $this->libFamilles();
        $id = isset($_GET['id'])? intval($_GET['id']) : -1;
        $produit = $this->getProduit($id);
        $data = $produit[0];

        $data['ceido_1'] = explode('_', $data['code_int_ceido_1']);
        $data['ceido_1'][0] = (isset($data['ceido_1'][0]) AND !empty($data['ceido_1'][0]))? intval($data['ceido_1'][0]) : 0;
        $data['ceido_1'][1] = isset($data['ceido_1'][1])? intval($data['ceido_1'][1]) : 0;
        $data['ceido_1'][2] = isset($data['ceido_1'][2])? intval($data['ceido_1'][2]) : 0;

        $data['ceido_2'] = explode('_', $data['code_int_ceido_2']);
        $data['ceido_2'][0] = (isset($data['ceido_2'][0]) AND !empty($data['ceido_2'][0]))? intval($data['ceido_2'][0]) : 0;
        $data['ceido_2'][1] = isset($data['ceido_2'][1])? intval($data['ceido_2'][1]) : 0;
        $data['ceido_2'][2] = isset($data['ceido_2'][2])? intval($data['ceido_2'][2]) : 0;

        $data['ceido_3'] = explode('_', $data['code_int_ceido_3']);
        $data['ceido_3'][0] = (isset($data['ceido_3'][0]) AND !empty($data['ceido_3'][0]))? intval($data['ceido_3'][0]) : 0;
        $data['ceido_3'][1] = isset($data['ceido_3'][1])? intval($data['ceido_3'][1]) : 0;
        $data['ceido_3'][2] = isset($data['ceido_3'][2])? intval($data['ceido_3'][2]) : 0;

        include VUE . 'fichePharmacie.tpl.php';
        exit();
    }
    
}