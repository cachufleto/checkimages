<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 01/06/2016
 * Time: 13:07
 */


function file_contents_libelles(){

    include CONF . 'libelles.php';
    return $_libelle;
}

/*
   Return error codes:
   1 = Invalid URL host
   2 = Unable to connect to remote host
*/
function remote_file_exists ($url)
{
    $head = "";

    $url_p = parse_url ($url);
    
    if (isset ($url_p["host"])){
        $host = $url_p["host"]; 
    } else { 
        return false; 
    }
    
    if (isset ($url_p["path"])){ 
        $path = $url_p["path"];
    }


    $fp = fsockopen ('tls://'.$host, 443);

    if (!$fp) {
        return false; 
    } else {
        $parse = parse_url($url);
        $host = $parse['host'];
        fputs($fp, "HEAD ".$url." HTTP/1.1\r\n");
        fputs($fp, "HOST: ".$host."\r\n");
        fputs($fp, "Connection: close\r\n\r\n");
        $headers = "";
        while (!feof ($fp))
        { $headers .= fgets ($fp, 128); }
    }
    
    fclose ($fp);

    $arr_headers = explode("\n", $headers);
    $return = false;

    if (isset ($arr_headers[0])) {
        $return = strpos ($arr_headers[0], "404") === false;
    }

    return $return;
}

function afficheMenu($page, $numProduits = 0)
{

    include CONF . 'libelles.php';
    extract($_SESSION[$page]);

    $_arriere = ($display >= 1)? $display-1 : 0;
    $_suivante = ($display == intval($numProduits/$b))? $display : $display+1 ;

    $l = ($p)? $b."&produit=$produit" : $b;
    $f = '&display=' . $display . '&nombre=' . $l;
    $link = '
    << <a href="?page=' . $page . '&display=' . $_arriere . '&nombre=' . $l .'"> page avant</a> ::
    <a href="?page=' . $page . '&produit=ok"> Avec Images  </a> :: 
    <a href="?page=' . $page . '&produit=ko"> Sans Images </a> :: 
    <a href="?page=' . $page . '"> à traiter </a>
    <a href="?page=' . $page . '&display=' . $_suivante . '&nombre=' . $l . '"> page suivante</a> >>  
    ';
    $titre = ($p)? (($produit == 'ok')? "Tous les produits" : "Liste des produits sans images") : 'Liste des produits avec images';

    include VUE . 'menu.tpl.php';
    return $f;
}

function testPagination($page, $num){

    if($num < $_SESSION[$page]['a']){
        $_SESSION[$page]['display'] = intval( $num / $_SESSION[$page]['b']);
        header('Location:?page='.$page.'&display='.$_SESSION[$page]['display']);
        exit();
    }

    $_SESSION[$page]['a'] = $_SESSION[$page]['b'] * $_SESSION[$page]['display'];
}

function criterMoteurRecherche($page)
{
    $chercher = $_SESSION['recherche'][$page];
    $recherche = '';
    $option = [];
    if( (
            isset($chercher['cip13']) AND !empty($chercher['cip13'])
        ) OR (
            isset($chercher['nom']) AND !empty($chercher['nom'])
        ) )
    {
        // recherche par cip
        if (isset($chercher['cip13']) AND !empty($chercher['cip13'])){
            $option[] = ' p.cip13 LIKE "%' . $chercher['cip13'] . '%"';
        }

        // recherche par libelle du produit
        if (isset($chercher['nom']) AND !empty($chercher['nom'])) {
            $option[] = ' p.libelle_ospharm LIKE "' . $chercher['nom'] . '%"';
        }

        // agrementation du libelle du produit
        $_nom = (isset($chercher['nom']) AND !empty($chercher['nom']))? explode(' ', $chercher['nom']) : '';

        if(is_array($_nom) AND count($_nom) > 1){
            foreach ($_nom as $mot){
                $option[] = ' p.libelle_ospharm LIKE "%' . $mot .'%"';
            }
        }

        $_option = '';
        foreach($option as $_r){
            $_option .= (empty($_option)? '' : ' OR ') . $_r;
        }
        $recherche = (!empty($_option))? ' AND ' . ((count($option) > 1 )? "( $_option )" : $_option) : '';

    } else {

        if (isset($chercher['labo']) && $chercher['labo'] > 0){
            $option[] = ' p.id_laboratoire = ' . $chercher['labo'];
        }

        if(isset($chercher['etat'])){
            $etat = '';
            $etat .= isset($chercher['etat']['i'])?
                ' p.produit_actif = "i"' : '';
            $etat .= isset($chercher['etat']['o'])?
                (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "o"' : '';
            $etat .= isset($chercher['etat']['n'])?
                (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "n"' : '';
            $etat .= isset($chercher['etat']['a'])?
                (!empty($etat)? ' OR ' : '' ) . ' p.produit_actif = "a"' : '';
            $option[] = (count($chercher['etat']) > 1 )? "( $etat )" : $etat;
        }
        // recherche partielle
        if (isset($chercher['famille']) && !empty($chercher['famille'])){
            $option[] = ' p.id_famille = ' . $chercher['famille'];
        }
        $_option = '';
        foreach($option as $_r){
            $_option .= (empty($_option)? '' : ' AND ') . $_r;
        }
        $recherche = (!empty($_option))? ' AND ' . $_option : '';
    }

    return $recherche;
}

