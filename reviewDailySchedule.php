<?php
session_start();
include "dbConfig.php";

$supervisorID = $_SESSION['employeeID'];
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
        <div class="col-1"></div>
        <div class="col-10">
            <h1>Review Daily Schedule</h1>
            <table class="table table-bordered">
                <thead class="bg-flexis-dark text-light">
                    <th scope="col" style="width: 5%;">Schedule ID</th>
                    <th scope="col" style="width: 5%;">Employee ID</th>
                    <th scope="col" style="width: 10%;">Work Date</th>
                    <th scope="col" style="width: 10%;">Work Location</th>
                    <th scope="col" style="width: 10%;">Work Hours</th>
                    <th scope="col" style="width: 30%;">Work Report</th>
                    <th scope="col" style="width: 30%;">Supervisor Comments</th>
                </thead>
                <tbody>
                    <?php
                    $getDailySchedulesSQL = "SELECT * FROM dailyscheduledb WHERE employeeID IN (SELECT employeeID FROM employeedb WHERE supervisorID = '$supervisorID') ORDER BY workDate DESC, employeeID ASC";
                    if ($getDailySchedulesResult = $con->query($getDailySchedulesSQL)) {
                        while ($row = mysqli_fetch_array($getDailySchedulesResult)) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row['scheduleID'] . '</th>';
                            echo '<td>' . $row['employeeID'] . '</td>';
                            echo '<td>' . $row['workDate'] . '</td>';
                            echo '<td>' . $row['workLocation'] . '</td>';
                            echo '<td>' . $row['workHours'] . '</td>';
                            echo '<td>' . $row['workReport'] . '</td>';
                            echo '<td>';
                            if ($row['workDate'] >= date('Y-m-d') && $row['supervisorComments'] == null) {
                                echo '<form method="POST" class="form">';
                                echo '<input class="pr-5 mr-2 mb-2 w-100" type="text" name="supervisorComments" placeholder="Enter comment" id="supervisorComments"/><br>';
                                echo '<input type="hidden" value="' . $row['scheduleID'] . '" name="scheduleID" />';
                                echo '<button class="btn btn-warning mt-1 mr-2" type="submit">Save Comment</button></form></td>';
                            } else if ($row['workDate'] < date('Y-m-d') && $row['supervisorComments'] == null) {
                                echo '<p class="font-italic">Daily schedule expired, no comment!</p></td>';
                            } else {
                                echo $row['supervisorComments'] . '</td>';
                            }
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-1"></div>
    </div>
</body>

<?php
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $scheduleID = $_POST['scheduleID'];
    $supervisorComments = $_POST['supervisorComments'];

    if ($supervisorComments != "" && $supervisorComments != null) {
        $insertCommentSQL = "UPDATE dailyscheduledb SET supervisorComments = '$supervisorComments' WHERE scheduleID = '$scheduleID'";
        if ($insertCommentResult = $con->query($insertCommentSQL)) {
            echo '<script>alert("Daily schedule reviewed successfully!")</script>';
        } else {
            echo '<script>alert("Review unsuccessful: ' . $con->error . '")</script>';
        }
    } else {
        echo '<script>alert("Comment cannot be empty!");</script>';
    }

    echo "<meta http-equiv='refresh' content='0'>";
}
?>