<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendrier interactif</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }
        .day, .header {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
        }
        .header {
            font-weight: bold;
            background-color: #f4f4f4;
        }
        .day {
            background-color: #e9ecef;
            position: relative;
        }
        .timeslot {
            margin: 5px 0;
        }
        .timeslot input {
            margin-right: 5px;
        }
        .selected {
            background-color: #d4edda;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .navigation button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        .navigation button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Calendrier interactif</h1>

    <?php
    // Récupération des paramètres pour l'année et le mois
    $year = isset($_GET['year']) ? (int)$_GET['year'] : date("Y");
    $month = isset($_GET['month']) ? (int)$_GET['month'] : date("m");

    // Gestion de la navigation entre mois
    if ($month < 1) {
        $month = 12;
        $year--;
    } elseif ($month > 12) {
        $month = 1;
        $year++;
    }

    // Nombre de jours dans le mois sélectionné
    $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    // Jours de la semaine
    $weekDays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

    // Plages horaires par jour
    $timeSlots = [
        "09:00 - 10:00",
        "10:00 - 11:00",
        "11:00 - 12:00",
        "13:00 - 14:00",
        "14:00 - 15:00",
        "15:00 - 16:00"
    ];

    // Calcul du premier jour du mois
    $firstDayOfMonth = date("N", strtotime("$year-$month-01"));

    // Affichage de la navigation
    echo "<div class='navigation'>";
    echo "<a href='?year=$year&month=" . ($month - 1) . "'><button>Mois précédent</button></a>";
    echo "<strong>" . date("F Y", strtotime("$year-$month-01")) . "</strong>";
    echo "<a href='?year=$year&month=" . ($month + 1) . "'><button>Mois suivant</button></a>";
    echo "</div>";
    ?>

    <form method="POST" id="calendarForm">
        <?php
        echo "<div class='calendar'>";

        // En-tête du calendrier
        foreach ($weekDays as $day) {
            echo "<div class='header'>$day</div>";
        }

        // Espaces vides avant le début du mois
        for ($i = 1; $i < $firstDayOfMonth; $i++) {
            echo "<div class='day'></div>";
        }

        // Affichage des jours avec plages horaires
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = "$year-$month-" . str_pad($day, 2, "0", STR_PAD_LEFT);
            echo "<div class='day'>";
            echo "<strong>$day</strong>";

            // Plages horaires
            foreach ($timeSlots as $index => $slot) {
                echo "<div class='timeslot'>";
                echo "<input type='radio' name='selection' value='$date|$slot' id='$date-$index'>";
                echo "<label for='$date-$index'>$slot</label>";
                echo "</div>";
            }

            echo "</div>";
        }

        echo "</div>";
        ?>

        <button type="submit">Réserver</button>
    </form>

    <?php
    // Traitement de la sélection après soumission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selection'])) {
        list($selectedDate, $selectedTime) = explode('|', $_POST['selection']);
        echo "<h2>Vous avez sélectionné :</h2>";
        echo "<p>Date : <strong>$selectedDate</strong></p>";
        echo "<p>Plage horaire : <strong>$selectedTime</strong></p>";
    }
    ?>

    <script>
        // Ajout d'une classe "selected" pour la case cochée
        document.querySelectorAll("input[type='radio']").forEach(radio => {
            radio.addEventListener("change", () => {
                document.querySelectorAll(".day").forEach(day => day.classList.remove("selected"));
                if (radio.checked) {
                    const parentDay = radio.closest(".day");
                    parentDay.classList.add("selected");
                }
            });
        });
    </script>
</body>
</html>
