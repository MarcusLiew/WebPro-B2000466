<?php
session_start();
include "dbConfig.php";
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Profile Settings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="extra.css" />
</head>

<body>
    <?php
    if ($_SESSION['position'] == 'HR Admin')
        include "hrAdminNavbar.php";
    else
        include "employeeNavbar.php";
    ?>

    <div class="container-fluid row" style="margin-top: 75px;">
        <div class="col-2"></div>
        <div class="col-8">
            <h1>Profile Settings</h1>
            <div>
                <form class="form" method="POST" style="margin: 10px 10px 10px 10px;">
                    <div class="form-group form-inline">
                        <label for="employeeID" class="col-lg-2 text-right" style="justify-content: flex-end;">Employee ID:</label>
                        <input type="text" class="form-control sizing col-lg-10" id="employeeID" name="employeeID" value="<?php echo $_SESSION['employeeID']; ?>" readonly>
                    </div>
                    <div class="form-group form-inline">
                        <label for="name" class="col-lg-2 text-right" style="justify-content: flex-end;">Current password:</label>
                        <input type="password" class="form-control sizing col-lg-10" id="currentPassword" name="currentPassword" placeholder="Enter current password" required>
                    </div>
                    <div class="form-group form-inline">
                        <label for="email" class="col-lg-2 text-right" style="justify-content: flex-end;">New password:</label>
                        <input type="password" class="form-control sizing col-lg-10" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                    </div>
                    <div class="form-group form-inline">
                        <label for="supervisorID" class="col-lg-2 text-right" style="justify-content: flex-end;">Confirm password:</label>
                        <input type="password" class="form-control sizing col-lg-10" id="confirmPassword" name="confirmPassword" placeholder="Confirm password">
                    </div>
                    <container class="form-inline">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10" style="padding-left: 0px;">
                            <input type="submit" name="submit" class="btn btn-warning" value="Update Password" />
                        </div>
                    </container>
                </form>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
</body>

</html>

<?php
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
    $employeeID = $_POST['employeeID'];
    $oldPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    $checkPwdSql = "SELECT * FROM employeedb WHERE employeeID = '$employeeID' AND password = '$oldPassword'";
    $checkPwdResult = $con->query($checkPwdSql);

    if ($checkPwdResult->num_rows == 1) {
        if ($newPassword == $confirmPassword) {
            $updatePwdSql = "UPDATE employeedb SET password = '$newPassword', fwaStatus = 'None' WHERE password = '$oldPassword' AND employeeID = '$employeeID'";
            if ($con->query($updatePwdSql) === TRUE) {
                echo '<script>alert("Password updated successfully!")</script>';
            } else {
                echo '<script>alert("Update unsuccessful: ' . $con->error . '")</script>';
            }
        } else {
            echo '<script>alert("Confirmed password not the same as new password!")</script>';
        }
    } else {
        echo '<script>alert("Current password does not match entered password!")</script>';
    }
}
?>