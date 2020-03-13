<?php

// URL: http://localhost/myProject/PHPTipCalc.php
//phpinfo();

?>

<?php

$partyErr = $billErr = $serviceQualErr = $peopleErr = "";
$resbox = $billamt = $serviceQual = $peopleamt = "";
$tiptotal = 0;
$valid = true;

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (empty($_POST["resbox"])) {
        $partyErr = "Please enter your party's name";
        $valid = false;
    }

    if (empty($_POST["billamt"])) {
        $billErr = "Please enter your bill amount";
        $valid = false;
    }

    if (empty($_POST["serviceQual"])) {
        $serviceQualErr = "Please enter your quality of service";
        $valid = false;
    }

    if (empty($_POST["peopleamt"])) {
        $peopleErr = "Please enter the total number of people";
        $valid = false;
    }

    if ($valid) {

        // collect values
        $serviceQual = $_POST["serviceQual"];
        $resbox = $_POST["resbox"];
        $billamt = $_POST["billamt"];
        $peopleamt = $_POST["peopleamt"];

        // convert tip to percent
        $serviceQual = ($serviceQual * .01);

        // calculate tip
        $tiptotal = ($billamt * $serviceQual) / ($peopleamt);

        // round to two decimal places
        $tiptotal = round($tiptotal * 100) / 100;


        $servername = "localhost";
        $username = "mainuser";
        $password = "Hello123";
        $dbname = "tips";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // convert output to integer to match DB value
        $int = (int) $tiptotal;

        // Build Query
        $sql = "INSERT INTO tiplog (partyName, billAmt, serviceLevel, numPeople, tipAmt)
                VALUES ('$_POST[resbox]','$_POST[billamt]','$_POST[serviceQual]','$_POST[peopleamt]', $int)";

        // Query Succesful (row added)
        if ($conn->query($sql) === FALSE) {
            // Error inserting row
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();

        // display total
        $total = "Total tip will be $" . $tiptotal;
        $recordplus = "New record added to database!";
    } else {
        echo $partyErr;
        echo $billErr;
        echo $serviceQualErr;
        echo $peopleErr;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JQuery Tip Calculator</title>
    <link rel="stylesheet" type="text/css" href="tipcalc.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</head>

<body>
    <div id="container">
        <h4>Tip Calculator</h4>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

            <div class="reservation">
                <p>Reservation Name</p>
                <p><input id="resbox" name="resbox" type="text"></p>
            </div>

            <p>How much was your bill?</p>
            <p class="dollarSign">$</p>
            <input type="number" id="billamt" name="billamt" placeholder="Bill Amount">

            <p>How was your service?</p>
            <select id="serviceQual" name="serviceQual">
                <option disabled selected value="0">--Choose an option--</option>
                <option value="30">30% - Outstanding</option>
                <option value="20">20% - Good</option>
                <option value="15">15% - OK</option>
                <option value="10">10% - Poor</option>
            </select>

            <p>How many people are sharing the bill?</p>
            <input type="number" id="peopleamt" name="peopleamt" placeholder="Number of People">&nbsp; &nbsp; (People >1)

            <div class="input-button">
                <p><input type="submit" value="Calculate Tip"></p>
            </div>
            
            <br>

            <p name="total" id="total"><?php echo $total ?></p>
            <p name="recordplus" id="recordplus"><?php echo $recordplus ?></p>

        </form>

        <p><a href="historypage.php"><input type="button" value="History Page"></p>
    </div>

</body>

</html>