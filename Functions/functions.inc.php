<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 01/06/2016
 * Time: 13:07
 */


function file_contents_libelles()
{
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

//    $fp = fsockopen ('tls://'.$host, 443);
    $fp = fsockopen ($host, 80);

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

function afficheMenu($page, $session, $numProduits = 0)
{

    include CONF . 'libelles.php';
    extract($_SESSION[$session]);

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

    include VUE . 'menu_old.tpl.php';
    return $f;
}

function testPagination($session, $num, $page)
{
    if($num < $_SESSION[$session]['a']){
        $_SESSION[$session]['display'] = intval( $num / $_SESSION[$session]['b']);
        header('Location:?page='.$page.'&display='.$_SESSION[$session]['display']);
        exit();
    }
    $_SESSION[$session]['a'] = $_SESSION[$session]['b'] * $_SESSION[$session]['display'];
}


function listerReperoires($dir){
// Ouvre un dossier bien connu, et liste tous les fichiers
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                echo "fichier : $file : type : " . filetype($dir . $file) . "\n";
            }
            closedir($dh);
        }
    }
}

function figureHTMML($nom, $texte){
    return "
            <figure>
            <img src='$nom' alt='$texte'/>
            <figcaption>$texte</figcaption>
            </figure>";
}

function testCIP13($cip13)
{
    $cip13 = utf8_decode(trim(str_replace(' ', '', $cip13)));
    return (!preg_match('/[a-zA-Z-]/', $cip13) and strlen($cip13))? $cip13 : false;
}