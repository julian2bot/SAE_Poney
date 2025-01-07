<?php
    require_once "../utils/annexe.php";
?>

<label for="nomPoney">Nom</label>
<input type="text" name="nomPoney" placeholder="gerard" autocomplete="off" class="nomPoney form-control-material" required>


<label for="poidMax">Poids supportable</label>
<input type="number" name="poidMax" placeholder="lourd" min="0" max="255" autocomplete="off" class="poidMax form-control-material" required>

<label for="photo">Photo (chemin acces)</label>
<input type="text" name="photo" placeholder="blabla.png" autocomplete="off" class="photo form-control-material" required>

<label for="race">Race</label>

<select name="race" class="race" required>
    <?php
        print_r(getRaces($bdd));
        foreach(getRaces($bdd) as $race){
            echo "<option value='$race[nomRace]'>$race[nomRace]</option>";
        }
    ?>
</select>