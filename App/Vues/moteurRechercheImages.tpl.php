<form  class="recherche" name="recherche" method="POST">
    <div class="form">
        <div class="ligne">
            <label>Image:</label><div><?php echo $Nom; ?></div>
        </div>
        <div class="ligne">
            <label>Etat:</label><div><?php echo $Etat; ?></div>
        </div>
    </div>
    <div class="form">
        <div class="ligne">
            <label>Libellé:</label><div><?php echo $libelle; ?></div>
        </div>
        <div class="ligne">
            <label>Code CIP:</label><div><?php echo $Code; ?></div>
        </div>
        <div class="ligne">
            <label></label><div><input type="submit" name="chercher" value="Valider"></div>
        </div>
    </div>
    <div class="ligne">
    <?php echo $listeRecherche; ?>
    </div>
</form>

