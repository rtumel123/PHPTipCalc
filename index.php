<?php

$partyErr = $billErr = $serviceQualErr = $peopleErr = "";
$resbox = $billamt = $serviceQual = $peopleamt = "";
$tiptotal = 0;

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        if (empty($_POST["resbox"])) {
            $partyErr = "Please enter your party's name";
            return;
        }

        if (empty($_POST["billamt"])) {
            $billErr = "Please enter your bill amount";
            return;
        }

        if (empty($_POST["serviceQual"])) {
            $serviceQualErr = "Please enter your quality of";
            return;
        }

        if (empty($_POST["peopleamt"])) {
            $peopleErr = "Please enter the total number of people";
            return;
        }

        // convert tip to percent
        $serviceQual = ($serviceQual * .01);

        // calculate tip
        $tiptotal = ($billamt * $serviceQual) / ($peopleamt);

        // round to two decimal places
        $tiptotal = round($tiptotal * 100) / 100;

        // display total
        echo "Each person's tip will be $";
        echo $resbox;
        echo "<br>";
        echo $billamt;
        echo "<br>";
        echo $serviceQual;
        echo "<br>";
        echo $peopleamt;
        echo "<br>";
    }



?>