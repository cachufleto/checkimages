<style>


</style>
<form name="recherche" method="POST">
    <div class="info">
        <label>Laboratoire:</label><div><?php echo $this->getLaboratoires($this->page); ?></div>
    </div>
    <div class="ligne">
        <label>Etat</label><div><?php echo $this->getEtat(); ?></div>
    </div>
    <div class="ligne">
        <label>Code CIP</label><div><?php echo $this->getCip(); ?></div>
    </div>
    <div class="ligne">
        <label>Nom:</label><div><?php echo $this->getNoms(); ?></div>
    </div>
    <div class="ligne">
        <label>Fam.:</label><div><?php echo $this->getFamilles(); ?></div>
    </div>
    <div class="ligne">
        <label></label><div><input type="submit" name="chercher" value="Valider"></div>
    </div>
</form>

