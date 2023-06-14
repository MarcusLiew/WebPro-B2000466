<?php
session_start();
include "dbConfig.php";
$supervisorID = $_SESSION['supervisorID'];
if ($supervisorID == null)
    $supervisorID = "No supervisor";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Employee Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="extra.css" />
</head>

<body>
    <?php include "employeeNavbar.php"; ?>

    <div class="container-fluid row" style="margin-top: 75px;">
        <div class="col-10">
            <div class="pt-2 pb-2">
                <h5>Employee ID:</h5>
                <h2><?php echo $_SESSION['employeeID']; ?></h2>
            </div>
            <div class="pt-2 pb-2">
                <h5>Employee Name:</h5>
                <h2><?php echo $_SESSION['name']; ?></h2>
            </div>sssss
            <div class="pt-2 pb-2">
                <h5>Supervisor ID:</h5>
                <h2><?php echo $supervisorID; ?></h2>
            </div>
            <div class="pt-2 pb-2">
                <h5>FWA Status:</h5>
                <h2><?php echo $_SESSION['fwaStatus']; ?></h2>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</body>

</html>