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

    extract($_SESSION[$page]);

    $_arriere = ($display >= 1)? $display-1 : 0;
    $_suivante = ($display == intval($numProduits/$b))? $display : $display+1 ;

    $l = ($p)? $b."&produit=$produit" : $b;
    $f = '&display=' . $display . '&nombre=' . $l;
    $link = '
    << <a href="?page=' . $page . '&display=' . $_arriere . '&nombre=' . $l .'"> page avant</a> ::
    <a href="?page=' . $page . '&produit=ok"> Sélectionées  </a> :: 
    <a href="?page=' . $page . '&produit=ko"> Ecartés </a> :: 
    <a href="?page=' . $page . '"> à traiter </a>
    <a href="?page=' . $page . '&display=' . $_suivante . '&nombre=' . $l . '"> page suivante</a> >>  
    ';
    $titre = ($p)? (($produit == 'ok')? "Produits Selectiones" : "Produits écartes") : 'Liste des produits avec images';

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

