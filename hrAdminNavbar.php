<nav class="navbar navbar-expand-lg navbar-dark bg-flexis-dark fixed-top">
    <a class="navbar-brand" href="hrAdminDashboard.php">FlexIS</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'registerEmployee.php') {
                    echo 'active';
                } ?>" href="registerEmployee.php">Register Employee</a>
            </li>
            <li class="nav-item">
                <a class="nav-link 
                <?php if (basename($_SERVER['PHP_SELF']) == 'viewAnalytics.php' || basename($_SERVER['PHP_SELF']) == 'viewAnalytics2.php') {
                    echo 'active';
                } ?>" href="viewAnalytics.php">View FWA Analytics</a>
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
                <a class="nav-link" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>