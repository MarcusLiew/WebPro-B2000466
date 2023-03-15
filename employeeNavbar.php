<nav class="navbar navbar-expand-lg navbar-dark bg-flexis-dark fixed-top">
    <a class="navbar-brand" href="employeeDashboard.php">FlexIS</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'submitFWA.php') {
                    echo 'active';
                }
                if (!$_SESSION['supervisorID']) {
                    echo 'disabled';
                } ?>" href="submitFWA.php">Submit FWA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'reviewFWA.php') {
                    echo 'active';
                }
                if ($_SESSION['position'] != 'Supervisor') {
                    echo 'disabled';
                } ?>" href="reviewFWA.php">Review FWA</a>
            </li>
            <li class="nav-item">
                <a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'submitDailySchedule.php') {
                    echo 'active';
                }
                if (!$_SESSION['supervisorID']) {
                    echo 'disabled';
                } ?>" href="submitDailySchedule.php">Submit Daily Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'reviewDailySchedule.php') {
                    echo 'active';
                }
                if ($_SESSION['position'] != 'Supervisor') {
                    echo 'disabled';
                } ?>" href="reviewDailySchedule.php">Review Daily Schedule</a>
            </li>
            <li class="nav-item">
                <a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'viewFWAAnalytics.php') {
                    echo 'active';
                }
                if ($_SESSION['position'] != 'Supervisor') {
                    echo 'disabled';
                } ?>" href="viewFWAAnalytics.php">View FWA Analytics</a>
            </li>
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link
                <?php if (basename($_SERVER['PHP_SELF']) == 'profileSettings.php') {
                    echo 'active';
                } ?>" href="profileSettings.php">Profile Settings</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>