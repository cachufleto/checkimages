<form  class="recherche" name="recherche" method="POST">
    <div class="form">
        <div class="ligne">
            <label>Laboratoire:</label><div><?php echo $Laboratoire; ?></div>
        </div>
        <div class="ligne">
            <label>Etat</label><div><?php echo $Etat; ?></div>
        </div>
        <div class="ligne">
            <label>Fam.:</label><div><?php echo $Fam; ?></div>
        </div>
    </div>
    <div class="form">
        <div class="ligne">
            <label>Nom:</label><div><?php echo $Nom; ?></div>
        </div>
        <div class="ligne">
            <label>Code CIP</label><div><?php echo $Code; ?></div>
        </div>
        <div class="ligne">
            <label> </label>
            <div>
                <input type="submit" name="chercher" value="<?php echo $this->_lib['option']['valider']; ?>">
            </div>
        </div>
    </div>
    <div class="ligne">
    <?php echo $listeRecherche; ?>
    </div>
</form>

