<?php
session_start();
include "dbConfig.php";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    if ($endDate < $startDate) {
        $tempDate = $startDate;
        $startDate = $endDate;
        $endDate = $tempDate;
    }

    if ($_SESSION['position'] == "HR Admin") {
        $deptID = $_POST['deptID'];
    } else {
        $deptID = $_SESSION['departmentID'];
    }
}

switch ($deptID) {
    case 'COM':
        $deptName = "Compliance";
        break;
    case 'ENG':
        $deptName = "Engineering";
        break;
    case 'FIN':
        $deptName = "Finance";
        break;
    default:
        $deptName = "No";
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>View FWA Analytics</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="extra.css" />
</head>

<body>
    <?php if ($_SESSION['position'] == 'HR Admin') {
        include "hrAdminNavbar.php";
    } else {
        include "employeeNavbar.php";
    }
    ?>

    <div class="container-fluid row" id="main" style="margin-top: 75px;">
        <div class="col-1"></div>
        <div class="col-10">
            <h1>View FWA Analytics</h1>
            <div>
                <?php echo "<h4>Schedules from $startDate to $endDate</h4>";
                echo "<h5>in $deptName Department</h5>";
                ?>
                <table class="table table-bordered">
                    <thead class="bg-flexis-dark text-light">
                        <th scope="col" style="width: 15%;">Date</th>
                        <th scope="col" style="width: 35%;">Work Location</th>
                        <th scope="col" style="width: 25%;">No of Employees</th>
                    </thead>
                    <tbody class="bg-light">
                        <?php
                        $getNumOfSchWorkLocssql = "SELECT workDate, workLocation, COUNT(*) as numOfSchedules FROM dailyscheduledb WHERE workDate BETWEEN '$startDate' AND '$endDate' AND EmployeeID IN (SELECT employeeID FROM employeedb WHERE deptID = '$deptID') GROUP BY workDate, workLocation;";
                        $getNumOfSchWorkLocsResult = $con->query($getNumOfSchWorkLocssql);
                        if (!$getNumOfSchWorkLocsResult->num_rows == 0) {
                            while ($row = mysqli_fetch_array($getNumOfSchWorkLocsResult)) {
                                echo '<tr>';
                                echo '<th scope="row">' . $row['workDate'] . '</th>';
                                echo '<td>' . $row['workLocation'] . '</td>';
                                echo '<td>' . $row['numOfSchedules'] . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr>';
                            echo '<td colspan="3">No schedules for this date range!</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <thead class="bg-flexis-dark text-light">
                        <th scope="col" style="width: 15%;">Date</th>
                        <th scope="col" style="width: 35%;">Work Hours</th>
                        <th scope="col" style="width: 25%;">No of Employees</th>
                    </thead>
                    <tbody class="bg-light">
                        <?php
                        $getNumOfSchWorkHourssql = "SELECT workDate, workHours, COUNT(*) as numOfSchedules FROM dailyscheduledb WHERE workDate BETWEEN '$startDate' AND '$endDate' AND EmployeeID IN (SELECT employeeID FROM employeedb WHERE deptID = '$deptID') GROUP BY workDate, workLocation;";
                        $getNumOfSchWorkHoursResult = $con->query($getNumOfSchWorkHourssql);
                        if (!$getNumOfSchWorkHoursResult->num_rows == 0) {
                            while ($row = mysqli_fetch_array($getNumOfSchWorkHoursResult)) {
                                echo '<tr>';
                                echo '<th scope="row">' . $row['workDate'] . '</th>';
                                echo '<td>' . $row['workHours'] . '</td>';
                                echo '<td>' . $row['numOfSchedules'] . '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr>';
                            echo '<td colspan="3">No schedules for this date range!</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</body>

</html>