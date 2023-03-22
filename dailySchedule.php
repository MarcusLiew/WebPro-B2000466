<?php
session_start();
include "dbConfig.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Daily Schedules</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="extra.css" />
</head>

<body>
    <?php include "employeeNavbar.php";
    if ($_SESSION['fwaStatus'] == "New") {
        echo '<script>alert("Your status is New, please change your password!");</script>';
        echo '<meta http-equiv="refresh" content="0; url=profileSettings.php" />';
    }
    ?>

    <div class="container-fluid row" style="margin-top: 75px;">
        <div class="col-1"></div>
        <div class="col-10">
            <h1>Daily Schedules</h1>

            <div class="container">
                <div class="col-lg-12 text-center">
                    <a href="submitDailySchedule.php">
                        <button class="btn btn-warning mb-3">Submit New Daily Schedule</button>
                    </a>
                </div>
            </div>

            <h3>Existing Daily Schedules</h3>
            <table class="table table-bordered">
                <thead class="bg-flexis-dark text-light">
                    <th scope="col" style="width: 10%;">Schedule ID</th>
                    <th scope="col" style="width: 10%;">Work Date</th>
                    <th scope="col" style="width: 10%;">Work Location</th>
                    <th scope="col" style="width: 10%;">Work Hours</th>
                    <th scope="col" style="width: 30%;">Work Report</th>
                    <th scope="col" style="width: 30%;">Supervisor Comments</th>
                </thead>
                <tbody>
                    <?php
                    $currentEmpID = $_SESSION['employeeID'];
                    $getDailyScheduleSQL = "SELECT * FROM dailyscheduledb WHERE employeeID = '$currentEmpID'";
                    if ($getDailyScheduleResult = $con->query($getDailyScheduleSQL)) {
                        while ($row = mysqli_fetch_array($getDailyScheduleResult)) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row['scheduleID'] . '</th>';
                            echo '<td>' . $row['workDate'] . '</td>';
                            echo '<td>' . $row['workLocation'] . '</td>';
                            echo '<td>' . $row['workHours'] . '</td>';
                            echo '<td>' . $row['workReport'] . '</td>';
                            echo '<td>';
                            if ($row['workDate'] >= date('Y-m-d') && $row['supervisorComments'] == null) {
                                echo '<form method="POST" action="updateDailySchedule.php" class="form">';
                                echo '<div class="container">';
                                echo '<div class="col-lg-12 text-center">';
                                echo '<input type="hidden" value="' . $row['scheduleID'] . '" name="scheduleID" />';
                                echo '<input type="submit" class="btn btn-warning" value="Update" /></form></td>';
                                echo '</div></div>';
                            } else if ($row['workDate'] < date('Y-m-d')) {
                                echo '<p class="font-italic">Daily schedule expired!</p>';
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
    $comment = $_POST['comment'];
    $status = $_POST['status'];
    $requestID = $_POST['requestID'];
    $workType = $_POST['workType'];
    $employeeID = $_POST['employeeID'];

    $findEmployeesql = "SELECT * FROM employeedb WHERE employeeID = '$employeeID'";
    if ($findEmployeeResult = $con->query($findEmployeesql)) {
        $row = mysqli_fetch_array($findEmployeeResult);
        $email = $row['email'];
    }

    $insertCommentsql = "UPDATE fwarequestdb SET comment = '$comment', status = '$status' WHERE requestID = '$requestID'";
    if ($insertCommentResult = $con->query($insertCommentsql)) {
        echo '<script>alert("FWA request reviewed successfully!")</script>';
    } else {
        echo '<script>alert("Review unsuccessful: ' . $con->error . '")</script>';
    }

    if ($status == "Accepted") {
        $updateEmployeeStatussql = "UPDATE employeedb SET fwaStatus = '$workType' WHERE employeeID = '$employeeID'";
        if ($updateEmployeeStatusResult = $con->query($updateEmployeeStatussql)) {
            echo '<script>alert("Employee status updated successfully!")</script>';
        } else {
            echo '<script>alert("Failed to update employee status: ' . $con->error . '")</script>';
        }
    }

    include 'reviewFWAEmail.php';
    echo "<meta http-equiv='refresh' content='0'>";
}
?>