<?php
include 'Voting_System/connection.php'; 
session_start();
  if (isset($_POST['login'])){

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
  
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM tbl_user WHERE username='$username' AND password='$password'";
    $result = $con->query($sql);
  
    if ($result->num_rows > 0){
        $_SESSION['username'] = $username;
        header("Location: Voting_System/home.php");
        exit;
    } 
    else 
    {
        echo '<script>alert("Invalid Username or password")</script>';
    }
    
    
    $con->close();  
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Ambassadors Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="Voting_System/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="Voting_System/vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="Voting_System/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="Voting_System/images/favicon.png" />
  
</head>

<body>

  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <!-- <img src="../../images/logo.svg" alt="logo"> -->
              </div>
              <h4>Hello! let's get started</h4>
              <h6 class="font-weight-light">Log in to continue.</h6>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" autocomplete="off"
                    placeholder="Username" name="username" required>
                </div>
                <div class="form-group">
                  <input type="password" class="form-control form-control-lg" id="exampleInputPassword1" autocomplete="off"
                    placeholder="Password" name="password" required>
                </div>
                <div class="mt-3">
                  <!-- <a class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                    href="../../index.html">Log In</a> -->
                    <input type="submit" value="Log In" name="login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" style="color: white">
                </div>



              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="Voting_System/vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="Voting_System/js/off-canvas.js"></script>
  <script src="Voting_System/js/hoverable-collapse.js"></script>
  <script src="Voting_System/js/template.js"></script>
  <!-- endinject -->
</body>

</html>