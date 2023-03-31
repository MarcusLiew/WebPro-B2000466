<?php
session_start();
include "dbConfig.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Submit FWA Request</title>
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
        <div class="col-2"></div>
        <div class="col-8">
            <h1>Submit FWA Request</h1>
            <div>
                <form class="form" method="POST" style="margin: 10px 10px 10px 10px;">
                    <div class="form-group form-inline">
                        <label for="employeeID" class="col-lg-2 text-right" style="justify-content: flex-end;">Employee ID:</label>
                        <input type="text" class="form-control col-lg-10" id="employeeID" name="employeeID" value="<?php echo $_SESSION['employeeID']; ?>" readonly>
                    </div>
                    <div class="form-group form-inline">
                        <label for="requestDate" class="col-lg-2 text-right" style="justify-content: flex-end;">Request Date:</label>
                        <input type="date" class="form-control col-lg-10" id="requestDate" name="requestDate" value="<?php echo date('Y-m-d') ?>" readonly>
                    </div>
                    <div class="form-group form-inline">
                        <label for="workType" class="col-lg-2 text-right" style="justify-content: flex-end;">Work Type:</label>
                        <select name="workType" id="workType">
                            <?php
                            $allWorkTypes = file("fwaWorkTypes.txt");
                            foreach ($allWorkTypes as $workType) {
                                echo '<option value="' . $workType . '">' . $workType . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="description" class="col-lg-2 text-right" style="justify-content: flex-end;">Description:</label>
                        <input type="text" class="form-control col-lg-10" id="description" name="description" placeholder="Enter Description" required>
                    </div>
                    <div class="form-group form-inline">
                        <label for="reason" class="col-lg-2 text-right" style="justify-content: flex-end;">Reason:</label>
                        <input type="text" class="form-control col-lg-10" id="reason" name="reason" placeholder="Enter Reason" required>
                    </div>
                    <div class="form-group form-inline">
                        <label for="supervisorID" class="col-lg-2 text-right" style="justify-content: flex-end;">Supervisor ID:</label>
                        <input type="text" class="form-control col-lg-10" id="supervisorID" name="supervisorID" value="<?php echo $_SESSION['supervisorID']; ?>" readonly>
                    </div>
                    <div class="form-inline">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10" style="padding-left: 0px;">
                            <button type="submit" class="btn btn-warning">Submit FWA Request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</body>

<?php
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $employeeID = $_SESSION['employeeID'];
    $supervisorID = $_SESSION['supervisorID'];
    $requestDate = $_POST['requestDate'];
    $workType = $_POST['workType'];
    $description = $_POST['description'];
    $reason = $_POST['reason'];

    $findFWASql = "SELECT * FROM fwarequestdb WHERE employeeID = '$employeeID' AND requestDate = '$requestDate' AND status NOT IN ('Rejected');";
    $findFWAResult = $con->query($findFWASql);
    if ($findFWAResult->num_rows == 0) {
        $findSupervisorsql = "SELECT * FROM employeedb WHERE employeeID = '$supervisorID'";
        if ($findSupervisorResult = $con->query($findSupervisorsql)) {
            $row = mysqli_fetch_array($findSupervisorResult);
        }

        $insertFWASql = "INSERT INTO fwarequestdb (requestDate, workType, description, reason, status, employeeID, supervisorID)
        VALUES ('$requestDate', '$workType', '$description', '$reason', 'Pending', '$employeeID', '$supervisorID')";

        if ($con->query($insertFWASql) === TRUE) {
            echo '<script>alert("FWA request submitted!")</script>';
        } else {
            echo '<script>alert("Submission unsuccessful: ' . $con->error . '")</script>';
        }
    } else {
        echo '<script>alert("FWA Request for this date exists! You can submit a new one if this request gets rejected!")</script>';
    }
}
?>