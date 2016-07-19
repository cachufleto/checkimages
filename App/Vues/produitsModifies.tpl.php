<?php
$changements = count($liste);

$traitement =  "<br>Produits modifies : " . ($changements);
foreach ($liste as $key=>$produit){
    $traitement .=   "<br>{$produit['cip13']} {$produit['type']}  => {$produit['message']} ";
 }
echo $traitement;
