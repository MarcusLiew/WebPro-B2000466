<?php
$empID = $_SESSION['employeeID'];
$checkFWAStatussql = "SELECT * FROM employeedb WHERE employeeID = '$empID'";
if ($checkFWAStatusResult = $con->query($checkFWAStatussql)) {
    $employee = mysqli_fetch_array($checkFWAStatusResult);
    $fwaStatus = $employee['fwaStatus'];
} else {
    $fwaStatus = "None";
}
$_SESSION['fwaStatus'] = $fwaStatus;
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-flexis-dark fixed-top">
    <a class="navbar-brand" href="employeeDashboard.php">FlexIS</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <?php if ($_SESSION['position'] == "Employee" || $_SESSION['supervisorID']) {
                echo '<li class="nav-item">';
                echo '<a class="nav-link';
                if (basename($_SERVER['PHP_SELF']) == 'submitFWA.php') {
                    echo ' active';
                }
                echo '" href="submitFWA.php">Submit FWA</a>';
                echo '</li>';
            }
            if ($_SESSION['position'] != "Employee") {
                echo '<li class="nav-item">';
                echo '<a class="nav-link';
                if (basename($_SERVER['PHP_SELF']) == 'reviewFWA.php') {
                    echo ' active';
                }
                echo '" href="reviewFWA.php">Review FWA</a>';
                echo '</li>';
            }
            if ($_SESSION['position'] == "Employee" || $_SESSION['supervisorID']) {
                echo '<li class="nav-item">';
                echo '<a class="nav-link';
                if (basename($_SERVER['PHP_SELF']) == 'dailySchedule.php' || basename($_SERVER['PHP_SELF']) == 'updateDailySchedule.php' || basename($_SERVER['PHP_SELF']) == 'submitDailySchedule.php') {
                    echo ' active';
                }
                echo '" href="dailySchedule.php">Submit Daily Schedule</a>';
                echo '</li>';
            }
            if ($_SESSION['position'] != "Employee") {
                echo '<li class="nav-item">';
                echo '<a class="nav-link';
                if (basename($_SERVER['PHP_SELF']) == 'reviewDailySchedule.php') {
                    echo ' active';
                }
                echo '" href="reviewDailySchedule.php">Review Daily Schedule</a>';
                echo '</li>';
            }
            if ($_SESSION['position'] != "Employee") {
                echo '<li class="nav-item">';
                echo '<a class="nav-link';
                if (basename($_SERVER['PHP_SELF']) == 'viewAnalytics.php' || basename($_SERVER['PHP_SELF']) == 'viewAnalytics2.php') {
                    echo ' active';
                }
                echo '" href="viewAnalytics.php">View FWA Analytics</a>';
                echo '</li>';
            }
            ?>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link
                <?php if (basename($_SERVER['PHP_SELF']) == 'profileSettings.php') {
                    echo 'active';
                } ?>" href="profileSettings.php">Profile Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>