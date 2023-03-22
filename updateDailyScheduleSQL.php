<?php
include "dbConfig.php";

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $workHours = $_POST['workHours'];
    $workLocation = $_POST['workLocation'];
    $workReport = $_POST['workReport'];
    $scheduleID = $_POST['scheduleID'];

    $updateDailyScheduleSQL = "UPDATE dailyscheduledb SET workHours = '$workHours', workLocation = '$workLocation', workReport = '$workReport'
        WHERE scheduleID = '$scheduleID'";

    if ($con->query($updateDailyScheduleSQL) === TRUE) {
        echo '<script>alert("Daily schedule updated!")</script>';
    } else {
        echo '<script>alert("Submission unsuccessful: ' . $con->error . '")</script>';
    }
}

echo '<meta http-equiv="refresh" content="0; url=dailySchedule.php" />'
?>