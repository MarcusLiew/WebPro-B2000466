<?php
session_start();
include "dbConfig.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Review FWA Requests</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="extra.css" />
</head>

<body>
    <?php include "employeeNavbar.php"; ?>

    <div class="container-fluid row" style="margin-top: 75px;">
        <div class="col-2"></div>
        <div class="col-8">
            <h1>Review Daily Schedule</h1>
            <table class="table table-bordered">
                <thead class="bg-flexis-dark text-light">
                    <th scope="col">Sch. ID</th>
                    <th scope="col">Work Date</th>
                    <th scope="col">Work Location</th>
                    <th scope="col">Work Hours</th>
                    <th scope="col">Work Report</th>
                    <th scope="col">Employee ID</th>
                    <th scope="col">Supervisor Comments</th>
                </thead>
                <tbody>
                    <?php
                    $currentSupID = $_SESSION['supervisorID'];
                    $getDSsql = "SELECT * FROM dailyscheduledb";
                    if ($getDSresult = $con->query($getDSsql)) {
                        while ($row = mysqli_fetch_array($getDSresult)) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row['scheduleID'] . '</th>';
                            echo '<td>' . $row['workDate'] . '</td>';
                            echo '<td>' . $row['workLocation'] . '</td>';
                            echo '<td>' . $row['workHours'] . '</td>';
                            echo '<td>' . $row['workReport'] . '</td>';
                            echo '<td>' . $row['employeeID'] . '</td>';
                            echo '<td><form method="POST" class="form">';
                            if ($row['workDate'] >= date('Y-m-d')) {
                                echo '<input class="pr-5 mr-2 mb-2 w-100" type="text" name="supervisorComments" placeholder="Enter comment" id="supervisorComments" /><br>';
                                echo '<input type="hidden" value="' . $row['scheduleID'] . '" name="scheduleID" />';
                                echo '<button class="btn btn-success mt-1 mr-2" value="Accepted" name="status" type="submit">Accept</button>';
                                echo '<button class="btn btn-danger mt-1 mr-2" value="Rejected" name="status" type="submit">Reject</button></form></td>';
                            } else if ($row['workDate'] < date('Y-m-d') && $row['supervisorComments'] == null) {
                                echo '<p class="font-italic">Request expired!</p>';
                            } else {
                                echo '<input class="pr-5 mr-2 w-100" type="text" value="' . $row['supervisorComments'] . '" disabled>';
                            }
                                echo '</tr>';
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-2"></div>
    </div>
</body>

<?php
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    
    $status = $_POST['status'];
    $scheduleID = $_POST['scheduleID'];
    $workDate = $_POST['workDate'];
    $workLocation = $_POST['workLocation'];
    $workReport = $_POST['workReport'];
    $employeeID = $_POST['employeeID'];
    $supervisorComments = $_POST['supervisorComments'];

    $insertCommentsql = "UPDATE dailyscheduledb SET supervisorComments = '$supervisorComments' WHERE scheduleID = '$scheduleID'";
    if ($insertCommentResult = $con->query($insertCommentsql)) {
        echo '<script>alert("Daily schedule reviewed successfully!")</script>';
    } else {
        echo '<script>alert("Review unsuccessful: ' . $con->error . '")</script>';
    }

    echo "<meta http-equiv='refresh' content='0'>";
}
?>