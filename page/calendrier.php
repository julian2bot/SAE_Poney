<!-- <style>
table{
    border-collapse: collapse;
    border: none; 
}
th, td{
  border: 1px solid black;
  padding: 10px;
}


td:nth-child(2n){
    background-color:red;
}

td::chr{
    background-color:red;
}

</style> -->
<!-- <style>

    /* style a la chatgpt lol car pas envie de le refaire */
        table {
            border-collapse: collapse;
            border: none;
        }

        td {
            border: 1px solid #ddd;
            width: 80px;
            height: 80px;
            position: relative; 
            text-align: left;
            vertical-align: top;
            padding: 5px;
            transition: transform 0.3s ease, z-index 0.3s ease; 
        }

 
        .styled-cell {
            background-color: #e0f7fa; 
            position: relative; 
            overflow: hidden;
        }

        .event-box {
            font-family: Arial, sans-serif;
            color: #333;
            position: relative; 
        }

        .event-box p {
            font-size: 10px;
            margin: 0;
        }

         .event-title {
            font-size: 12px;
            font-weight: bold;
            color: #2e7d32;  
            margin-bottom: 5px;
        }

         .event-details {
            position: absolute; 
            top: 0;
            left: 0;
            width: 100%;
            height: 100%; 
            display: none;  
            background-color: #a5d6a7;  
            padding: 5px;
            box-sizing: border-box;
            color: #333;
            z-index: 5; 
            transition: all 0.5s ease;  
            overflow: auto;  
        }
        .event-details p{
            font-size: 8px;

        }

        .styled-cell.hover:hover {
            transform: scale(1.6);  
            z-index: 10;  
        }

        .styled-cell.hover:hover .event-details {
            display: block;

        }

     
        .event-details::-webkit-scrollbar {
            width: 4px; 
            height: 4px; 
        }

        .event-details::-webkit-scrollbar-thumb {
            background-color: rgba(0, 0, 0, 0.2); 
            border-radius: 10px; 
        }

        .event-details::-webkit-scrollbar-track {
            background: transparent; 
        }
    </style>
 -->
<link rel="stylesheet" href="../assets/style/calendrier.css">
<div>

<?php
require_once "../utils/connexionBD.php";
require_once "../utils/annexe.php";



// creerCalendrierV2($bdd, $_SESSION["connecte"]["username"]);
creerCalendrier($bdd, "client1");
echo "<pre>";
print_r($_SESSION);

print_r(
    
    getAllInfoByMonth($bdd, "client1","12", "2023")

);

















print_r(getInfoByDate($bdd,"client2", "2023-12-01"));
echo "</pre>";
?>
</div>


<!-- 

<table border="1">
    <tbody>
        <tr>
            <th>Lundi</th>
            <th>Mardi</th>
            <th>Mercredi</th>
            <th>Jeudi</th>
            <th>Vendredi</th>
            <th>Samedi</th>
            <th>Dimanche</th>
        
        
        </tr><tr><td></td><td></td><td></td><td></td><td></td><td>1</td><td>2</td></tr>


        <tr>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td>6</td>
            <td>7</td>
            <td>8</td>
            <td>9</td>
        </tr>


        <tr><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td></tr>
        <tr><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td></tr>
        <tr><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td></tr>
        <tr><td>31</td><td></td><td></td><td></td><td></td><td></td><td></td></tr>

</tbody>
</table> -->