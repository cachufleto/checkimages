<div class="suite">
<a href="?page=upload"> Upload </a>
<a href="?page=existant"> Existat </a>
<a href="?page=accueil"> Accueil </a>
</div>
<h1><?php echo $titre; ?></h1>
<div class="suite">
    <p>Images : <?php echo (((($_suivante)? $_suivante : 1)-1) * $b), " &aacute; ", ((($_suivante)? $_suivante : 1) * $b)  ?>
        [ page: <?php echo (($_suivante)? $_suivante : 1), ' / ', intval($numProduits/$b +1); ?>]
        Affichage de <?php echo $b; ?> Images par pages ( TOTAL: <?php echo $numProduits ?>)</p>
    <p><?php echo $link ?></p>
</div>