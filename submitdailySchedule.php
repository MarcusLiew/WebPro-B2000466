<?php
session_start();
include "dbConfig.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Submit Daily Schedule</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="extra.css" />
</head>

<body>
    <?php include "employeeNavbar.php"; ?>

    <div class="container-fluid row" style="margin-top: 75px;">
        <div class="col-2"></div>
        <div class="col-8">
            <h1>Submit Daily Schedule</h1>
            <div>
                <form class="form" method="POST" onsubmit="return validateForm()" style="margin: 10px 10px 10px 10px;">
                    <div class="form-group form-inline">
                        <label for="employeeID" class="col-lg-2 text-right" style="justify-content: flex-end;">Employee ID:</label>
                        <input type="text" class="form-control sizing col-lg-10" id="employeeID" name="employeeID" value="<?php echo $_SESSION['employeeID']; ?>" readonly>
                    </div>
                    <div class="form-group form-inline">
                        <label for="workDate" class="col-lg-2 text-right" style="justify-content: flex-end;">Work Date:</label>
                        <input type="date" class="form-control sizing col-lg-10" id="workDate" name="workDate">
                    </div>
                    <div class="form-group form-inline">
                        <label for="workHours" class="col-lg-2 text-right" style="justify-content: flex-end;">Work Hours:</label>
                        <select name="workHours" id="workHours">
                            <?php
                            $allWorkHours = file("dailyScheduleWorkHours.txt");
                            foreach ($allWorkHours as $workHours) {
                                $fieldValues = explode(", ", $workHours);
                                echo '<option value="' . $fieldValues[0] . '">' . $fieldValues[1] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="workLocation" class="col-lg-2 text-right" style="justify-content: flex-end;">Work Location:</label>
                        <select name="workLocation" id="workLocation">
                            <?php
                            $workLocations = file("dailyScheduleLocations.txt");
                            foreach ($workLocations as $workLocation) {
                                $fieldValues = explode(", ", $workLocation);
                                echo '<option value="' . $fieldValues[0] . '">' . $fieldValues[1] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="workReport" class="col-lg-2 text-right" style="justify-content: flex-end;">Work Report:</label>
                        <input type="text" class="form-control sizing col-lg-10" id="workReport" name="workReport" placeholder="Enter Work Report" required>
                    </div>
                    <div class="form-inline">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10" style="padding-left: 0px;">
                            <button type="submit" class="btn btn-warning">Submit Daily Schedule</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</body>

<script>
    function validateForm() {
        var dateInput = document.getElementById('workDate').value;
        var today = new Date();
        var inputtedDate = new Date(dateInput);

        if (inputtedDate > today) {
            return true;
        } else {
            alert("Work Date cannot be a past date!");
            return false;
        }
    }
</script>

<?php
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $workDate = $_POST['workDate'];
    $workHours = $_POST['workHours'];
    $workLocation = $_POST['workLocation'];
    $workReport = $_POST['workReport'];
    $employeeID = $_POST['employeeID'];

    $checkDailyScheduleSQL = "SELECT * FROM dailyscheduledb WHERE workDate = '$workDate' AND employeeID = '$employeeID'";
    $checkDailyScheduleResult = $con->query($checkDailyScheduleSQL);

    if ($checkDailyScheduleResult->num_rows > 0) {
        echo '<script>alert("A schedule already exists for this date!");</script>';
    } else {
        $insertSql = "INSERT INTO dailyscheduledb (workDate, workHours, workLocation, workReport, supervisorComments, employeeID)
        VALUES ('$workDate', '$workHours', '$workLocation', '$workReport', null, '$employeeID')";

        if ($con->query($insertSql) === TRUE) {
            echo '<script>alert("Daily schedule submitted!")</script>';
        } else {
            echo '<script>alert("Submission unsuccessful: ' . $con->error . '")</script>';
        }
    }
}
?>