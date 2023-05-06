<?php
    session_start();

    // check if the user is logged in
    if (!isset($_SESSION['username'])) {
    header("Location: ../index.php");
    exit;
    }

    $username = $_SESSION['username'];

    if(isset($_POST['logout'])) {
      session_unset();
      session_destroy();
      header("Location: ../index.php"); // Redirect to login page after logging out
      exit;
    }
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
    <div class="container-fluid page-body-wrapper">
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
      <div class="main-panel">
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
                          <i class=" mdi mdi-comment-check-outline  me-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Voted</small>
                            <h5 class="me-2 mb-0">
                            <?php
                                include 'connection.php';

                                if ($con->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT COUNT(*) as count FROM tbl_form where vote_status=1";

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
                          <i class="mdi mdi-sleep  me-3 icon-lg text-danger"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Not Voted</small>
                            <h5 class="me-2 mb-0">
                            <?php
                                include 'connection.php';

                                if ($con->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT COUNT(*) as count FROM tbl_form where vote_status=0";

                                $result = $con->query($sql);
                                $row = $result->fetch_assoc();
                                echo $row['count'];

                                $con->close();
                            ?>
                            </h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12 stretch-card">
              <div class="card">
                <div class="card-body">
                  <div style="overflow: hidden">
                    <p class="card-title">User Vote Table</p>

                  </div>
                  
                  
                  
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Vote</th>
                          <th>Vote Status</th>
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
                                    if ($row['vote_status'] == 1) {

                                        $text = "<td style='color: green ; font-weight: 500''> Voted </td>";
                                    } else {

                                        $text = "<td style='color: red ; font-weight: 500''> Not Voted </td>";
                                    }
                                    echo "<tr>
                                        <td>".$row['id']."</td>
                                        <td>".$row['username']."</td>
                                        <td>".$row['vote']."</td>
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