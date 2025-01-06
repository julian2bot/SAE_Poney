<label for="usernameMoniteur">UserName</label>
<input type="text" name="usernameMoniteur" id="usernameMoniteur" placeholder="UserName" autocomplete="off" class="form-control-material" required>

<label for="nomMoniteur">Nom</label>
<input type="text" name="nomMoniteur" id="nomMoniteur" placeholder="nom" autocomplete="off" class="form-control-material" required>

<label for="prenomMoniteur">Prenom</label>
<input type="text" name="prenomMoniteur" id="prenomMoniteur" placeholder="prenom" autocomplete="off" class="form-control-material" required>

<label for="Mail">Mail</label>
<input type="email" name="Mail" id="Mail" placeholder="Email" autocomplete="off" class="form-control-material" required>

<label for="salaire">Salaire</label>
<input type="number" name="salaire" id="salaire" placeholder="0" min="0" max="255" autocomplete="off" class="form-control-material" required    >


<label for="estAdmin">Droit d'administration</label>
<select name="estAdmin" id="estAdmin">
    <option value="non" selected>Non</option>
    <option value="oui">Oui</option>
</select>

<?php
    if(isset($_GET["erreurCreerMoniteur"])){
        echo '<font color="red">'.$_GET["erreurCreerMoniteur"]."</font>";
    }
?>