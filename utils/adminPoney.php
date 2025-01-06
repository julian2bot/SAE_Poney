<label for="nomPoney">Nom</label>
<input type="text" name="nomPoney" id="nomPoney" placeholder="gerard" autocomplete="off" class="form-control-material" required>


<label for="poidMax">Poids supportable</label>
<input type="number" name="poidMax" id="poidMax" placeholder="lourd" min="0" max="255" autocomplete="off" class="form-control-material" required>

<label for="photo">Photo (chemin acces)</label>
<input type="text" name="photo" id="photo" placeholder="blabla.png" autocomplete="off" class="form-control-material" required>

<label for="race">Race</label>
<input type="text" name="race" id="race" placeholder="licorned" autocomplete="off" class="form-control-material" required>


<?php
    if(isset($_GET["erreurCreerPoney"])){
        echo '<font color="red">'.$_GET["erreurCreerPoney"]."</font>";
    }
?>