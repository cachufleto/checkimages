<div class="suite">
    <a <?php 
    echo ($this->page == 'accueil')? 'class="actif"' : "";
    ?> href="?page=accueil"> <?php echo $this->_lib['accueil']; ?> </a>
    <a <?php
       echo ($this->page == 'upload')? 'class="actif"' : "";
       ?> href="?page=upload"> <?php echo $this->_lib['upload']; ?> </a>
    <a <?php
    echo ($this->page == 'existat')? 'class="actif"' : "";
    ?> href="?page=existant"> <?php echo $this->_lib['existat']; ?> </a>
    <a <?php
    echo ($this->page == 'medicament')? 'class="actif"' : "";
    ?> href="?page=medicament"> <?php echo $this->_lib['medicament']; ?> </a>
    <a <?php
    echo ($this->page == 'parapharmacie')? 'class="actif"' : "";
    ?> href="?page=parapharmacie"> <?php echo $this->_lib['parapharmacie']; ?> </a>
</div>
<div class="suite">
    <?php echo $link ?>
</div>
<?php
$this->afficheMoteurRecherche();
?>
<div class="suite">
    <h1><?php echo $titre; ?></h1>
    <div>Images : <?php echo (((($_suivante)? $_suivante : 1)-1) * $b), " &aacute; ", ((($_suivante)? $_suivante : 1) * $b)  ?>
        [ page: <?php echo (($_suivante)? $_suivante : 1), ' / ', intval($numProduits/$b +1); ?>]
        Affichage de <?php echo $b; ?> Images par pages ( TOTAL: <?php echo $numProduits ?>)</div>
</div>
