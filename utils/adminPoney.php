<?php
    require_once "../utils/annexe.php";
?>

<label for="nomPoney">Nom</label>
<input type="text" name="nomPoney" id="nomPoney" placeholder="gerard" autocomplete="off" class="form-control-material" required>


<label for="poidMax">Poids supportable</label>
<input type="number" name="poidMax" id="poidMax" placeholder="lourd" min="0" max="255" autocomplete="off" class="form-control-material" required>

<label for="photo">Photo (chemin acces)</label>
<input type="text" name="photo" id="photo" placeholder="blabla.png" autocomplete="off" class="form-control-material" required>

<label for="race">Race</label>

<select name="race" id="race" required>
    <?php
        print_r(getRaces($bdd));
        foreach(getRaces($bdd) as $race){
            echo "<option value='$race[nomRace]'>$race[nomRace]</option>";
        }
    ?>
</select>


<?php
    if(isset($_GET["erreurCreerPoney"])){
        echo '<font color="red">'.$_GET["erreurCreerPoney"]."</font>";
    }
?>