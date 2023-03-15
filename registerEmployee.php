<?php
session_start();
include "dbConfig.php";

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
    <title>Register Employee</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="extra.css" />
</head>

<body>
    <?php include "hrAdminNavbar.php" ?>

    <div class="container-fluid row" style="margin-top: 75px;">
        <div class="col-2"></div>
        <div class="col-8">
            <h1>Register Employee</h1>
            <div>
                <form class="form" method="POST" id="registerForm" action="registerEmployee.php" style="margin: 10px 10px 10px 10px;">
                    <div class="form-group form-inline">
                        <label for="employeeID" class="col-lg-2 text-right" style="justify-content: flex-end;">Employee ID:</label>
                        <input type="text" class="form-control sizing col-lg-10" id="employeeID" name="employeeID" placeholder="Enter Employee ID" required>
                    </div>
                    <div class="form-group form-inline">
                        <label for="name" class="col-lg-2 text-right" style="justify-content: flex-end;">Name:</label>
                        <input type="text" class="form-control sizing col-lg-10" id="name" name="name" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group form-inline">
                        <label for="position" class="col-lg-2 text-right" style="justify-content: flex-end;">Position:</label>
                        <select name="position" id="position" form="registerForm">
                            <?php
                            $allPositions = file("positions.txt");
                            foreach ($allPositions as $position) {
                                $fieldValues = explode(", ", $position);
                                echo '<option value="' . $fieldValues[1] . '">' . $fieldValues[1] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="email" class="col-lg-2 text-right" style="justify-content: flex-end;">Email:</label>
                        <input type="text" class="form-control sizing col-lg-10" id="email" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class='form-group form-inline'>
                        <label for="department" class="col-lg-2 text-right" style="justify-content: flex-end;">Department:</label>
                        <select name="department" id="department" form="registerForm">
                            <?php
                            $allDepartments = file("departments.txt");
                            foreach ($allDepartments as $department) {
                                $fieldValues = explode(", ", $department);
                                echo '<option value="' . $fieldValues[1] . '">' . $fieldValues[2] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group form-inline">
                        <label for="supervisorID" class="col-lg-2 text-right" style="justify-content: flex-end;">Supervisor ID:</label>
                        <input type="text" class="form-control sizing col-lg-10" id="supervisorID" name="supervisorID" placeholder="Enter Supervisor ID (optional)" form="registerForm">
                    </div>
                    <container class="form-inline">
                        <div class="col-lg-2"></div>
                        <div class="col-lg-10" style="padding-left: 0px;">
                            <button type="submit" class="btn btn-warning" name="register">Register Employee</button>
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
    $name = $_POST['name'];
    $position = $_POST['position'];
    $fwaStatus = "New";
    $email = $_POST['email'];
    $department_id = $_POST['department'];
    $password = $employeeID . "123";
    $supervisorID = $_POST['supervisorID'];

    $checkEmpIDSql = "SELECT * FROM employeedb WHERE employeeID = '$employeeID'";
    $checkEmailSql = "SELECT * FROM employeedb WHERE email = '$email'";

    if ($con->query($checkEmpIDSql)->num_rows > 0) {
        echo "<script>alert('Employee already exists!')</script>";
        return;
    } else if ($con->query($checkEmailSql)->num_rows > 0) {
        echo "<script>alert('Email already exists!')</script>";
        return;
    } else {
        if ($supervisorID == "") {
            $insertSql = "INSERT INTO employeedb (employeeID, name, position, fwaStatus, email, deptID, password, supervisorID)
        VALUES ('$employeeID', '$name', '$position', '$fwaStatus', '$email', '$department_id', '$password', null)";
        } else {
            if ($con->query("SELECT * FROM employeedb WHERE employeeID = '$supervisorID'")->num_rows == 0) {
                echo "<script>alert('Supervisor does not exist!')</script>";
                return;
            } else {
                $insertSql = "INSERT INTO employeedb (employeeID, name, position, fwaStatus, email, deptID, password, supervisorID) 
            VALUES ('$employeeID', '$name', '$position', '$fwaStatus', '$email', '$department_id', '$password', '$supervisorID')";
            }
        }

        if ($con->query($insertSql) === true) {
            echo "<script>alert('Employee successfully registered!')</script>";
        }
    }
}
?>