<?php
session_start();
include "dbConfig.php";

$position = $_SESSION['position'];

$departmentID = $_SESSION['departmentID'];

switch ($departmentID) {
    case 'COM':
        $departmentName = "Compliance";
        break;
    case 'ENG':
        $departmentName = "Engineering";
        break;
    case 'FIN':
        $departmentName = "Finance";
        break;
    default:
        $departmentName = "No";
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
                <div class="mt-3">
                    <h4>FWA Requests for the week:</h4>
                    <h5>Compliance Department</h5>
                    <table class="table table-bordered">
                        <thead class="bg-flexis-dark text-light">
                            <th scope="col" style="width: 25%;">Work Type</th>
                            <th scope="col">Number of Requests</th>
                        </thead>
                        <tbody class="bg-light">
                            <?php
                            $getCOMNumOfRequestsql = "SELECT workType, COUNT(*) as numOfFWA FROM fwarequestdb WHERE status = 'Accepted' AND WEEK(requestDate) = WEEK(CURDATE()) AND EmployeeID IN (SELECT employeeID FROM employeedb WHERE deptID = 'COM') GROUP BY workType";
                            $getCOMNumOfRequestsResult = $con->query($getCOMNumOfRequestsql);
                            if (!$getCOMNumOfRequestsResult->num_rows == 0) {
                                while ($row = mysqli_fetch_array($getCOMNumOfRequestsResult)) {
                                    echo '<tr>';
                                    echo '<th scope="row">' . $row['workType'] . '</th>';
                                    echo '<td>' . $row['numOfFWA'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr>';
                                echo '<td colspan="3">No FWA requests so far this week!</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    <h5>Engineering Department</h5>
                    <table class="table table-bordered">
                        <thead class="bg-flexis-dark text-light">
                            <th scope="col" style="width: 25%;">Work Type</th>
                            <th scope="col">Number of Requests</th>
                        </thead>
                        <tbody class="bg-light">
                            <?php
                            $getENGNumOfRequestsql = "SELECT workType, COUNT(*) as numOfFWA FROM fwarequestdb WHERE status = 'Accepted' AND WEEK(requestDate) = WEEK(CURDATE()) AND EmployeeID IN (SELECT employeeID FROM employeedb WHERE deptID = 'ENG') GROUP BY workType";
                            $getENGNumOfRequestsResult = $con->query($getENGNumOfRequestsql);
                            if (!$getENGNumOfRequestsResult->num_rows == 0) {
                                while ($row = mysqli_fetch_array($getENGNumOfRequestsResult)) {
                                    echo '<tr>';
                                    echo '<th scope="row">' . $row['workType'] . '</th>';
                                    echo '<td>' . $row['numOfFWA'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr>';
                                echo '<td colspan="3">No FWA requests so far this week!</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    <h5>Finance Department</h5>
                    <table class="table table-bordered">
                        <thead class="bg-flexis-dark text-light">
                            <th scope="col" style="width: 25%;">Work Type</th>
                            <th scope="col">Number of Requests</th>
                        </thead>
                        <tbody class="bg-light">
                            <?php
                            $getFINNumOfRequestsql = "SELECT workType, COUNT(*) as numOfFWA FROM fwarequestdb WHERE status = 'Accepted' AND WEEK(requestDate) = WEEK(CURDATE()) AND EmployeeID IN (SELECT employeeID FROM employeedb WHERE deptID = 'FIN') GROUP BY workType";
                            $getFINNumOfRequestsResult = $con->query($getFINNumOfRequestsql);
                            if (!$getFINNumOfRequestsResult->num_rows == 0) {
                                while ($row = mysqli_fetch_array($getFINNumOfRequestsResult)) {
                                    echo '<tr>';
                                    echo '<th scope="row">' . $row['workType'] . '</th>';
                                    echo '<td>' . $row['numOfFWA'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr>';
                                echo '<td colspan="3">No FWA requests so far this week!</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    <h4>View schedules from:</h4>
                    <form class="form mb-3" method="POST" action="viewAnalytics2.php">
                        <div class="form-group form-inline">
                            <label for="deptID" class="col-lg-2 text-right" style="justify-content: flex-end;">Department:</label>
                            <select id="deptID" name="deptID" <?php if ($position == "Supervisor") {
                                                                    echo 'hidden disabled';
                                                                } ?>>
                                <option value="COM">Compliance</option>
                                <option value="ENG">Engineering</option>
                                <option value="FIN">Finance</option>
                            </select>
                            <?php if ($position == "Supervisor") {
                                echo '<input type="text" value="' . $departmentName . '" disabled>';
                            } ?>
                        </div>
                        <div class="form-group form-inline">
                            <label for="startDate" class="col-lg-2 text-right" style="justify-content: flex-end;">Start Date:</label>
                            <input type="date" class="form-control sizing col-lg-10" id="startDate" name="startDate" required>
                        </div>
                        <div class="form-group form-inline">
                            <label for="endDate" class="col-lg-2 text-right" style="justify-content: flex-end;">End Date:</label>
                            <input type="date" class="form-control sizing col-lg-10" id="endDate" name="endDate" required>
                        </div>
                        <container class="form-inline">
                            <div class="col-lg-2"></div>
                            <div class="col-lg-10" style="padding-left: 0px;">
                                <button type="submit" class="btn btn-primary" name="submit">View Summary</button>
                            </div>
                        </container>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-1"></div>
    </div>
</body>

</html>