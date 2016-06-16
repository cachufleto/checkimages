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
        // extract($_SESSION[$this->info->page]);
        $data = [];
        $data['page'] = $this->info->page;
        $data['b'] = $_SESSION[$data['page']]['b'];
        $data['numProduits'] = $this->info->count($this->info->criterMoteurRecherche());

        $p = $_SESSION[$data['page']]['p'];
        $display = $_SESSION[$data['page']]['display'];
        $produit = $_SESSION[$data['page']]['produit'];

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

        $data['bouttonAvecImage'] = $this->info->_lib['bouttonAvecImage'];
        $data['bouttonSansImage'] = $this->info->_lib['bouttonSansImage'];
        $data['bouttonTousImage'] = $this->info->_lib['bouttonTousImage'];

        include VUE . 'menu.tpl.php';

        return;
    }



}