<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 11/07/2016
 * Time: 12:18
 */
$changements = count($liste);

$traitement =  "<br>Produits modifies : " . ($changements);
foreach ($liste as $key=>$produit){
    $traitement .=   "<br>{$produit['cip13']} {$produit['type']}  => {$produit['message']} ";
 }
echo $traitement;
