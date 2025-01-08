<?php
require_once "annexe.php";


function creerCalendrierCours($bdd, $client){
    $Days = 1;
    
    $date = new DateTime();
    
    // TODO: changer la date juste commenté cette instruction pour avoit la date de la journée
    $date->setDate("2023","12","1");
    $datedefaut = $date->format('Y-n-d');

    echo '<input type="date" id="date" name="trip-start" value= '.$datedefaut.' />';

}

?>


<?php
function genererCalendrier($mois, $annee) {
    // Obtenir le premier jour du mois et le nombre de jours dans le mois
    echo'<script src="../assets/script/jsCreationCours.js" defer></script>';

    $premierJour = new DateTime("$annee-$mois-01");

    $joursDansLeMois = $premierJour->format('t'); // Nombre total de jours dans le mois
    $jourDeLaSemaine = $premierJour->format('N'); // Jour de la semaine (1 = Lundi, 7 = Dimanche)
    
    // Créer le tableau HTML
    $calendrier = '<table border="1" style="border-collapse: collapse; width: 100%;">';

    $calendrier .= '<tr>';
    $calendrier .='<th> <button onclick="decrementerdate()">Cliquez-moi</button> </th>';
    $calendrier .= '<th id=dateactuel values='.$annee.'/'.$premierJour->format('n').'>'.$annee.' '.$premierJour->format('F').'</th>';
    $calendrier .='<th> <button onclick="incrementerdate()">Cliquez-moi</button> </th>';
    $calendrier .= '</tr>';

    $calendrier .= '<tr>';
    $calendrier .= '<th>Lundi</th><th>Mardi</th><th>Mercredi</th>';
    $calendrier .= '<th>Jeudi</th><th>Vendredi</th><th>Samedi</th><th>Dimanche</th>';
    $calendrier .= '</tr><tr>';

    // Ajouter des cellules vides avant le premier jour du mois
    for ($i = 1; $i < $jourDeLaSemaine; $i++) {
        $calendrier .= '<td class=cellule ></td>';
    }

    // Ajouter les jours du mois
    for ($jour = 1; $jour <= $joursDansLeMois; $jour++) {
        $calendrier .= "<td id='$jour ' onclick='caseCliquer()' class=cellule >$jour </td>";

        // Si c'est un dimanche, créer une nouvelle ligne
        if (($jourDeLaSemaine + $jour - 1) % 7 == 0) {
            $calendrier .= '</tr><tr>';
        }
    }

    // Ajouter des cellules vides après le dernier jour du mois
    $dernierJourDeLaSemaine = ($jourDeLaSemaine + $joursDansLeMois - 1) % 7;
    if ($dernierJourDeLaSemaine != 0) {
        for ($i = $dernierJourDeLaSemaine; $i < 7; $i++) {
            $calendrier .= '<td class=cellule onclick="caseCliquer()" ></td>';
        }
    }

    $calendrier .= '</tr>';
    $calendrier .= '</table>';
    
    echo $calendrier;
}
?>
