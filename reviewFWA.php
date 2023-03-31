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
    <?php include "employeeNavbar.php";
    if ($_SESSION['fwaStatus'] == "New") {
        echo '<script>alert("Your status is New, please change your password!");</script>';
        echo '<meta http-equiv="refresh" content="0; url=profileSettings.php" />';
    }
    ?>

    <div class="container-fluid row" style="margin-top: 75px;">
        <div class="col-1"></div>
        <div class="col-10">
            <h1>Review FWA Requests</h1>
            <table class="table table-bordered">
                <thead class="bg-flexis-dark text-light">
                    <th scope="col" style="width: 5%;">Req. ID</th>
                    <th scope="col" style="width: 7.5%;">Request Date</th>
                    <th scope="col" style="width: 12.5%;">Work Type</th>
                    <th scope="col" style="width: 20%;">Description</th>
                    <th scope="col" style="width: 20%;">Reason</th>
                    <th scope="col" style="width: 5%;">Status</th>
                    <th scope="col" style="width: 5%;">Employee ID</th>
                    <th scope="col" style="width: 30%;">Comment</th>
                </thead>
                <tbody>
                    <?php
                    $currentEmpID = $_SESSION['employeeID'];
                    $getFWAsql = "SELECT * FROM fwarequestdb WHERE supervisorID = '$currentEmpID' ORDER BY requestDate DESC, employeeID ASC";
                    if ($getFWAresult = $con->query($getFWAsql)) {
                        while ($row = mysqli_fetch_array($getFWAresult)) {
                            echo '<tr>';
                            echo '<th scope="row">' . $row['requestID'] . '</th>';
                            echo '<td>' . $row['requestDate'] . '</td>';
                            echo '<td>' . $row['workType'] . '</td>';
                            echo '<td>' . $row['description'] . '</td>';
                            echo '<td>' . $row['reason'] . '</td>';
                            echo '<td';
                            if ($row['status'] == "Accepted") {
                                echo ' class="bg-success"';
                            } else if ($row['status'] == "Rejected") {
                                echo ' class="bg-danger"';
                            }
                            echo '>' . $row['status'] . '</td>';
                            echo '<td>' . $row['employeeID'] . '</td><td>';
                            if ($row['status'] == "Pending" && $row['requestDate'] >= date('Y-m-d')) {
                                echo '<form method="POST" class="form">';
                                echo '<input class="pr-5 mr-2 mb-2 w-100" type="text" name="comment" placeholder="Enter comment" id="comment" /><br>';
                                echo '<input type="hidden" value="' . $row['requestID'] . '" name="requestID" />';
                                echo '<input type="hidden" value="' . $row['workType'] . '" name="workType" />';
                                echo '<input type="hidden" value="' . $row['employeeID'] . '" name="employeeID" />';
                                echo '<button class="btn btn-success mt-1 mr-2" value="Accepted" name="status" type="submit">Accept</button>';
                                echo '<button class="btn btn-danger mt-1 mr-2" value="Rejected" name="status" type="submit">Reject</button></form></td>';
                            } else if ($row['requestDate'] < date('Y-m-d') && $row['comment'] == null) {
                                echo '<p class="font-italic">Request expired!</p></td>';
                            } else {
                                echo $row['comment'] . '</td>';
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

    echo "<meta http-equiv='refresh' content='0'>";
}
?>