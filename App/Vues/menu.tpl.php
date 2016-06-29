<?php
echo <<<EOL
<div id="menu">
    <div class="suite">
        {$data['liensPages']}
    </div>
    <div class="suite">
    <form action="" method="POST">
        <a class="page" href="?page={$data['page']}&display={$data['arriere']}&nombre={$data['l']}"><<</a> page précédente
        <a {$data['ok']} href="?page={$data['page']}&produit=ok"> {$data['bouttonAvec']}  </a>  
        <a {$data['ko']} href="?page={$data['page']}&produit=ko"> {$data['bouttonSans']} </a>  
        <a {$data['tous']} href="?page={$data['page']}"> {$data['bouttonTous']} </a>
         page suivante <a class="page" href="?page={$data['page']}&display={$data['suivante']}&nombre={$data['l']}">>></a>
        <input type="text" name="nombre"><input type="submit" name="display" value="Nombre">
    </form>   
    </div>
EOL;
$this->info->afficheMoteurRecherche();
echo <<<EOL
    <div class="suite">
        <h1>{$data['titre']}</h1>
        <div class="resultat">Images : {$data['num']}
            [ page: {$data['p']}]
            Affichage de {$data['b']} Images par pages ( TOTAL: {$data['numProduits']} )</div>
    </div>
</div>
<div id="content">
EOL;
