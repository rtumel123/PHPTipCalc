<?php
$servername = "localhost";
$username = "mainuser";
$password = "Hello123";
$dbname = "tips";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

    $sql = 'SELECT * FROM tiplog
              ORDER BY tipAmt DESC';

    $q = $pdo->query($sql);
    $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Customer History</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <div id="container">
        <h1>Customer History</h1>
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>Party Name</th>
                    <th>Bill Amount</th>
                    <th>Service Quality</th>
                    <th>Number of People</th>
                    <th>Tip Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $q->fetch()) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['partyName']) ?></td>
                        <td><?php echo htmlspecialchars($row['billAmt']); ?></td>
                        <td><?php echo htmlspecialchars($row['serviceLevel']); ?></td>
                        <td><?php echo htmlspecialchars($row['numPeople']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipAmt']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
</body>
</div>

</html>