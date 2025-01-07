<label for="usernameMoniteur">UserName</label>
<input type="text" name="usernameMoniteur" placeholder="UserName" autocomplete="off" class="usernameMoniteur form-control-material" required>

<label for="nomMoniteur">Nom</label>
<input type="text" name="nomMoniteur" placeholder="nom" autocomplete="off" class="nomMoniteur form-control-material" required>

<label for="prenomMoniteur">Prenom</label>
<input type="text" name="prenomMoniteur" placeholder="prenom" autocomplete="off" class="prenomMoniteur form-control-material" required>

<label for="Mail">Mail</label>
<input type="email" name="Mail" placeholder="Email" autocomplete="off" class="Mail form-control-material" required>

<label for="salaire">Salaire</label>
<input type="number" name="salaire" placeholder="0" min="0" max="255" autocomplete="off" class="salaire form-control-material" required    >


<label for="estAdmin">Droit d'administration</label>
<select name="estAdmin" class="estAdmin">
    <option value="non" selected>Non</option>
    <option value="oui">Oui</option>
</select>

<?php
    if(isset($_GET["erreurCreerMoniteur"])){
        echo '<font color="red">'.$_GET["erreurCreerMoniteur"]."</font>";
    }
?>