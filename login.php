<?php
session_start();
include "dbConfig.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no" />
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link rel="stylesheet" href="extra.css" />
</head>

<body>
  <div class="container" style="padding: 15% 10% 15% 10%;">
    <div class="row">
      <div class="col-lg-5">
        <div class="container bg-flexis-dark rounded">
          <h1 class="text-center font-weight-bold text-light" style="padding-top: 10px;">FlexIS</h1>
          <form class="form" style="padding: 10px 10px 10px 10px;" action="login.php" method="POST">
            <div class="form-group">
              <label class="form-label text-light" for="employeeID">Employee ID:</label>
              <input type="text" class="form-control" id="employeeID" name="employeeID" placeholder="Employee ID" />
            </div>
            <div class="form-group">
              <label class="form-label text-light" for="password">Password:</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" />
            </div>
            <input type="submit" class="btn btn-warning" value="Log in" />
          </form>
        </div>
      </div>
      <div class="col-lg-7 bg-dark rounded">
        <h1 class="text-light" style="padding-top: 10px;">Welcome to FlexIS!</h1>
        <p class="text-light">
          This is a web application that allows you to submit FWA requests & schedules.
          As a supervisor, you can review your employees' FWA requests & schedules.
        </p>
      </div>
    </div>
  </div>
</body>

</html>

<?php
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == "POST") {
  $employeeID = $_POST['employeeID'];
  $password = $_POST['password'];

  $sql = "SELECT * FROM employeedb WHERE employeeID = '$employeeID'";
  $result = mysqli_query($con, $sql);
  $employee = mysqli_fetch_assoc($result);

  if ($employee != null) {
    if ($password == $employee['password']) {

      $_SESSION['employeeID'] = $employeeID;
      $_SESSION['name'] = $employee['name'];
      $_SESSION['position'] = $employee['position'];
      $_SESSION['email'] = $employee['email'];
      if ($_SESSION['position'] == "HR Admin") {
        header("Location: hrAdminDashboard.php");
      } else {
        $_SESSION['fwaStatus'] = $employee['fwaStatus'];
        $_SESSION['supervisorID'] = $employee['supervisorID'];
        header("Location: employeeDashboard.php");
      }
    } else {
      echo "<script>alert('Wrong password for this Employee ID!')</script>";
      exit();
    }
  } else {
    echo "<script>alert('Employee ID not found!')</script>";
  }
}
?>