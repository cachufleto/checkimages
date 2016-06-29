<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 15/06/2016
 * Time: 14:14
 */

namespace App;


class Menu
{
    var $info = '';
    var $file = '';

    public function afficher()
    {
        $data = $this->afficherDATA();
        $data['bouttonAvec'] = $this->info->_lib['bouttonAvecImage'];
        $data['bouttonSans'] = $this->info->_lib['bouttonSansImage'];
        $data['bouttonTous'] = $this->info->_lib['bouttonTousImage'];

        include VUE . 'menu.tpl.php';
        return;
    }

    public function afficherUpload()
    {
        $data = $this->afficherDATA();
        $data['bouttonAvec'] = $this->info->_lib['bouttonAvecInfo'];
        $data['bouttonSans'] = $this->info->_lib['bouttonSansInfo'];
        $data['bouttonTous'] = $this->info->_lib['bouttonTousImage'];

        include VUE . 'menuUpload.tpl.php';
        return;
    }

    public function afficherDATA()
    {
        // extract($_SESSION[$this->info->page]);
        $session = $this->info->session;
        $data = [];
        $data['page'] = $this->info->page;
        $data['b'] = $_SESSION[$session]['b'];
        $data['numProduits'] = $this->info->count($this->info->criterMoteurRecherche());

        $p = $_SESSION[$session]['p'];
        $display = $_SESSION[$session]['display'];
        $produit = $_SESSION[$session]['produit'];

        $data['titre'] = ($p)? (
        ($produit == 'ok')?
            $this->info->_lib['avecImage']:
            $this->info->_lib['sansImage']
        ) :
            $this->info->_lib['tousImage'];

        $data['arriere'] = ($display >= 1)? $display-1 : 0;
        $data['suivante'] = ($display == intval($data['numProduits']/$data['b']))? $display : $display+1 ;

        $data['l'] = ($p)? $data['b']."&produit=$produit" : $data['b'];

        include CONF . 'nav.inc';
        $data['liensPages'] = '';
        foreach ($nav as $page){
            $data['liensPages'] .= '<a '. (
                ($data['page'] == $page)? 'class="actif"' : ""
                ) . ' href="?page=' . $page . '"> '.$this->info->_lib[$page].'</a>';
        }

        $data['ok'] = ($produit == 'ok')? 'class="actif"' : "";
        $data['ko'] = ($produit == 'ko')? 'class="actif"' : "";
        $data['tous'] = ($produit == '')? 'class="actif"' : "";
        $data['num'] = (((($data['suivante'])? $data['suivante'] : 1)-1) * $data['b']) . " &aacute; " . ((($data['suivante'])? $data['suivante'] : 1) * $data['b']);
        $data['p'] = (($data['suivante'])? $data['suivante'] : 1) . ' / ' . intval($data['numProduits']/$data['b'] +1);

        return $data;
    }
}