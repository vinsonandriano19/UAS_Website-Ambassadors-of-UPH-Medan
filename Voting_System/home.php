<?php
    include 'connection.php';
    session_start();

// check if the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: ../index.php");
  exit;
}

$username = $_SESSION['username'];



if (isset($_POST['send-email'])) {

    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';
    require 'phpmailer/src/Exception.php';

    

    $mail = new PHPMailer\PHPMailer\PHPMailer();

    $mail->SMTPDebug = 3;
    $mail->isSMTP();
    
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Port = "587";
    
    // $mail->Host = "smtp.gmail.com";
    // $mail->Username = "kingkytest@gmail.com";
    // $mail->Password = "ifpmfkekwkwrchwm";
    // $mail->setFrom('kingkytest@gmail.com', 'Kingky');
    
    $mail->Host = "testonly.site";
    $mail->Username = "admin@testonly.site";
    $mail->Password = "admintestonly0123";
    $mail->setFrom('admin@testonly.site', 'Admin');
    // $mail->Port = "465";
    
    $mail->SMTPDebug  = PHPMailer\PHPMailer\SMTP::DEBUG_OFF;
    
    $sql = "SELECT subject, body FROM email LIMIT 1";
    $result = $con->query($sql);

    if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email_subject = $row["subject"];
        $email_body = $row["body"];
    }
    
    $sql = "SELECT * from tbl_form WHERE status = 0";
    $res = mysqli_query($con, $sql);

    if (mysqli_num_rows($res) > 0)
    {


      while($x = mysqli_fetch_assoc($res))
      {
        $mail_code = $x['random_code'];
        $rec_name = $x['username'];
        $mail->addAddress($x['email']);

        $replacements = array(
          '$rec_name' => $rec_name,
          '$mail_code' => $mail_code
        );
        $mail->isHTML(true);
        
        $mail->Subject = $email_subject;
        $mail->Body = str_replace(array_keys($replacements), array_values($replacements), $email_body);
        
        // $mail->Subject = "Test Email";
        // $mail->Body = "<h1>Hello $rec_name </h1></br><p>This is your code: <b> $mail_code </b> </p>";
      // $mail->addAttachment('images/2.jpg');

        if ( $mail->send() ) {
          $update_sql = "UPDATE tbl_form SET status = 1 WHERE random_code = '$mail_code'" ;
          mysqli_query($con, $update_sql);
        }else{
          echo "Message could not be sent. Mailer Error";
        }
        $mail->clearAddresses();
      }

    }
    else {
      echo "No data found!";
    }
  //Closing smtp connection
    $mail->smtpClose();
    $con->close();
}
elseif (isset($_POST['reset'])) {
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
  

    $sql = "UPDATE tbl_form set status = 0";
    $res = mysqli_query($con, $sql);
    
}
elseif(isset($_POST['logout'])) {
  session_unset();
  session_destroy();
  header("Location: ../index.php"); // Redirect to login page after logging out
  exit;
}
elseif (isset($_POST['set-random-code'])){
    if ($con->connect_error) {
      die("Connection failed: " . $con->connect_error);
    }


    function generate_random_string($length = 6) {
      $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $char_len = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[random_int(0, $char_len - 1)];
      }
      return $randomString;
    }

    $random_str = generate_random_string(6);
    $sql = "SELECT * FROM tbl_form WHERE random_code = '$random_str'";
    $result = mysqli_query($con, $sql);
    while (mysqli_num_rows($result) > 0 || $random_str == '') {
        $random_str = generate_random_string(6);
        $sql = "SELECT * FROM tbl_form WHERE random_code = '$random_str'";
        $result = mysqli_query($con, $sql);
    }
    $sql = "UPDATE tbl_form SET random_code = '$random_str' WHERE random_code = ''";
    $res = mysqli_query($con, $sql);

    $sql = "SELECT random_code FROM tbl_form GROUP BY random_code HAVING COUNT(*) > 1";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($result)) {
        $same_codes = mysqli_query($con, "SELECT * FROM tbl_form WHERE random_code = '{$row['random_code']}'");
        $count = 1;
        while ($same_codes->num_rows > 0) {
            $new_code = generate_random_string(6);
            $check = mysqli_query($con, "SELECT * FROM tbl_form WHERE random_code = '$new_code'");
            while ($check->num_rows > 0) {
                $new_code = generate_random_string(6);
                $check = mysqli_query($con, "SELECT * FROM tbl_form WHERE random_code = '$new_code'");
            }
            mysqli_query($con, "UPDATE tbl_form SET random_code = '$new_code' WHERE random_code = '{$row['random_code']}' LIMIT $count");
            $same_codes = mysqli_query($con, "SELECT * FROM tbl_form WHERE random_code = '{$row['random_code']}'");
            $count++;
        }
    }
}
elseif (isset($_POST['update-email'])){
  // $mail_code ="ABC123";
  $subject = $_POST['subject'];
  $body = $_POST['body'];

  if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
  }

  $sql = "UPDATE email SET subject='$subject', body='$body'";
  if ($con->query($sql) === TRUE) {
      
  } else {
      echo '<script>alert("failed")</script>';
  }
}
?>
 $con->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="refresh" content="45">
  <title>Ambassadors Dashboard</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="navbar-brand-wrapper d-flex justify-content-center">
        <div class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100">
          <!-- <a class="navbar-brand brand-logo" href="index.html"><img src="images/logo.svg" alt="logo" /></a>
          <a class="navbar-brand brand-logo-mini" href="index.html"><img src="images/logo-mini.svg" alt="logo" /></a> -->
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-sort-variant"></span>
          </button>
        </div>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav mr-lg-4 w-100">
          <li class="nav-item nav-search d-none d-lg-block w-100">
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id="search">
                  <i class="mdi mdi-magnify"></i>
                </span>
              </div>
              <input type="text" class="form-control" placeholder="Search now" aria-label="search"
                aria-describedby="search">
            </div>
          </li>
        </ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
              <img src="images/faces/face5.jpg" alt="profile" />
              <span class="nav-profile-name"><?php echo $username; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item">
                <i class="mdi mdi-settings text-primary"></i>
                Settings
              </a>
              <form method="POST">
                <button type="submit" name="logout" class="dropdown-item">
                    <i class="mdi mdi-logout text-primary"></i>
                    Logout
                </button>
              </form>
              
              
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper" style="padding-top: 40px">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link" href="home.php">
              <i class="mdi mdi-account" style="margin-right: 18px"></i>
              <span class="menu-title">Registration</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="user-vote.php">
              <i class=" mdi mdi-tablet-android" style="margin-right: 18px"></i>
              <span class="menu-title">Vote</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="candidates.php">
              <i class="mdi mdi-crown" style="margin-right: 18px"></i>
              <span class="menu-title">Candidates</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel" style="padding-top: 0">
        <div class="content-wrapper">

          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="me-md-3 me-xl-5">
                    <h2>Welcome back, <?php echo $username; ?>.</h2>
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab"
                        aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                  </ul>
                  <div class="tab-content py-0 px-0">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div
                          class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-account-outline me-3 icon-lg text-primary" ></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Total User</small>
                            <h5 class="me-2 mb-0">
                              <?php

                                include 'connection.php';

                                if ($con->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT COUNT(*) as count FROM tbl_form";
                                $result = $con->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'];

                                $con->close();
                              ?>
                            </h5>
                          </div>
                        </div>
                        <div
                          class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class=" mdi mdi-gmail  me-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Email Sent</small>
                            <h5 class="me-2 mb-0">
                            <?php
                                include 'connection.php';

                                if ($con->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT COUNT(*) as count FROM tbl_form where status=1";

                                $result = $con->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'];

                                $con->close();
                            ?>
                            </h5>
                          </div>
                        </div>
                        <div
                          class="d-flex border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class=" mdi mdi-gmail  me-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Email Error</small>
                            <h5 class="me-2 mb-0">
                            <?php
                                include 'connection.php';

                                if ($con->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT COUNT(*) as count FROM tbl_form where status=0";

                                $result = $con->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'];

                                $con->close();
                            ?>
                            </h5>
                          </div>
                        </div>
                        <!-- <div
                          class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-center p-3 item">
                          <i class="mdi mdi-flag me-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Flagged</small>
                            <h5 class="me-2 mb-0">3497843</h5>
                          </div>
                        </div> -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
        <div class="main-panel" style="width:100%">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" style="color:black">Set Email</h4>
                  <p class="card-description">
                  </p>
                  <form class="forms-sample" method="POST">
                    <div class="form-group">
                      <label for="subject">Subject</label>
                      <input type="text" class="form-control" id="subject" placeholder="Subject" name="subject">
                    </div>
                    <div class="form-group">
                      <label for="body">Body</label>
                      <textarea rows="10" class="form-control" id="body" placeholder="Body" name="body"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary me-2" style="color:white" name="update-email" onclick="return confirm('Are you sure you want to update email?')">Update</button>
                  </form>
                </div>
              </div>
            </div>
                              
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                        <h4 class="card-title">Email Display</h4>
                        <p class="card-description">
                        Notes:<br> Recipient name = $rec_name <br> Random Code = $mail_code
                        
                      </p>
                        <?php 
                        include 'connection.php';
                        $sql = "SELECT subject, body FROM email LIMIT 1";
                        $result = $con->query($sql);

                        if ($con->connect_error) {
                          die("Connection failed: " . $con->connect_error);
                      }
                        // Display the data
                        if ($result->num_rows > 0) {
                            // Output data of the first (and only) row
                            $row = $result->fetch_assoc();
                            echo "<p style='color: green;'>Subject: </p>" . $row["subject"] . "<br> <br>";
                            echo "<p style='color: green;'>Body: </p>" . $row["body"];
                        }
                        ?>
                    </div>
                </div>
  
          
        </div>
        
      </div>
          <div class="row" >
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <div style="overflow: hidden">
                    <p class="card-title">User registration</p>
                    <form method="POST">
                      <button type="submit" name="send-email" class="btn btn-primary" style="color: white" onclick="return confirm('Are you sure you want to send email to all user?')">Send Mail</button>
                      <button type="submit" name="set-random-code"class="btn btn-warning" style="margin-left: 55%" onclick="return confirm('Are you sure you want to set all random code?')">Set Random Code</button>
                      <button type="submit" name="reset"class="btn btn-secondary" onclick="return confirm('Are you sure you want to reset all email status?')">Reset</button>
                    </form>
                  </div>
                  
                  <br>
                  
                  
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Random Code</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            include 'connection.php';
                            // Check connection
                            if (!$con) {
                            die("Connection failed: " . mysqli_connect_error());
                            }

                            $sql = "SELECT * FROM tbl_form";
                            $result = mysqli_query($con, $sql);

                            if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                  $text = '';
                                    if ($row['status'] == 1) {

                                        $text = "<td style='color: green; font-weight: 500'> Success </td>";
                                    } else {

                                        $text = "<td style='color: red ; font-weight: 500''> Failed </td>";
                                    }
                                    echo "<tr>
                                        <td>".$row['id']."</td>
                                        <td>".$row['username']."</td>
                                        <td>".$row['email']."</td>
                                        <td>".$row['random_code']."</td>
                                        $text
                                        </tr>";
                                }
                            }
                            else 
                            {
                            echo "0 results";
                            }
                            mysqli_close($con);
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="vendors/chart.js/Chart.min.js"></script>
  <script src="vendors/datatables.net/jquery.dataTables.js"></script>
  <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/template.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/data-table.js"></script>
  <script src="js/jquery.dataTables.js"></script>
  <script src="js/dataTables.bootstrap4.js"></script>
  <!-- End custom js for this page-->

  <script src="js/jquery.cookie.js" type="text/javascript"></script>
</body>

</html>