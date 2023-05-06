<?php
  session_start();
    include 'connection.php';
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
  
  if(isset($_POST['input-data'])) {
    $name = $_POST['candidate-name'];
    $image_name = $_POST['candidate-image-name'];

    if ($_FILES["candidate-image"]["error"] == UPLOAD_ERR_OK) {
      // Upload image
      $target_dir = "images-vote/"; // Specify the folder to save the image
      $target_file = $target_dir . basename($_FILES["candidate-image"]["name"]);
      if (move_uploaded_file($_FILES["candidate-image"]["tmp_name"], $target_file)) {
        // Insert data into database
        $sql = "INSERT INTO tbl_kandidat (name, image_name) VALUES ('$name', '$image_name')";
        mysqli_query($con, $sql);
      } else {
        echo "Error uploading the file.";
      }
    } else {
      echo "Error uploading the file.";
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
  <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css">
  <meta http-equiv="refresh" content="45">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/modal_style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                            <small class="mb-1 text-muted">Total Candidates</small>
                            <h5 class="me-2 mb-0">
                            <?php
                                include 'connection.php';

                                if ($con->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $sql = "SELECT COUNT(*) as count FROM tbl_kandidat";

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
                          <i class="mdi mdi-account-multiple  me-3 icon-lg text-success"></i>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Most Voted</small>
                            <h5 class="me-2 mb-0">
                            <?php
                                include 'connection.php';

                                if ($con->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                }

                                $query = "SELECT * FROM tbl_kandidat WHERE total_votes = (SELECT MAX(total_votes) FROM tbl_kandidat)";
                                $result = $con->query($query);

                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    echo $row['name'];
                                } else {
                                    echo "No rows found.";
                                }

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
                  <p class="card-title">AoU Candidates</p>
                  
                  <button id="show-modal-btn" type="submit" name="send-email" class="btn btn-primary" style="color: yellow">Add New+</button>

                        <!-- The Modal -->
                        <div id="myModal" class="modal">

                          <!-- Modal content -->
                          <div class="modal-content">
                            <span class="close">&times;</span>
                            <form class="forms-sample" method="POST" enctype="multipart/form-data">
                              <div class="form-group">
                                <label for="c-name">Name</label>
                                <input type="text" class="form-control" id="c-name" placeholder="Name" name="candidate-name">
                              </div>
                              <div class="form-group">
                                <label>File upload</label>
                                <input type="file" class="file-upload-default" name="candidate-image">
                                <div class="input-group col-xs-12">
                                  <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Image">
                                  <span class="input-group-append">
                                    <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                  </span>
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="c-image-name">Image Name</label>
                                <input type="text" class="form-control" id="c-image-name" placeholder="Image Name" name="candidate-image-name">
                              </div>
                              
                              <button type="submit" class="btn btn-primary me-2" name="input-data">Submit</button>
                            </form>
                          </div>

                        </div>
                        
                        
                        <script>
                          // Get the modal
                          var modal = document.getElementById("myModal");

                          // Get the button that opens the modal
                          var btn = document.getElementById("show-modal-btn");

                          // Get the <span> element that closes the modal
                          var span = document.getElementsByClassName("close")[0];

                          // When the user clicks the button, open the modal
                          btn.onclick = function() {
                            modal.style.display = "block";
                          }

                          // When the user clicks on <span> (x), close the modal
                          span.onclick = function() {
                            modal.style.display = "none";
                          }

                          // When the user clicks anywhere outside of the modal, close it
                          window.onclick = function(event) {
                            if (event.target == modal) {
                              modal.style.display = "none";
                            }
}
                        </script>
                        
                  <div class="table-responsive">
                    <table id="recent-purchases-listing" class="table">
                      <thead>
                        <tr>
                          <th>Id</th>
                          <th>Name</th>
                          <th>Image</th>
                          <th>Total Vote</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                            include 'connection.php';
                            // Check connection
                            if (!$con) {
                            die("Connection failed: " . mysqli_connect_error());
                            }
                            $update_query = "UPDATE tbl_kandidat k SET k.total_votes = (
                                SELECT COUNT(f.vote) 
                                FROM tbl_form f 
                                WHERE f.vote = k.name
                            )";
                            mysqli_query($con, $update_query);
                            $sql = "SELECT k.*, COUNT(f.vote) as total_votes FROM tbl_kandidat k LEFT JOIN tbl_form f ON k.name = f.vote GROUP BY k.id";
                            $result = mysqli_query($con, $sql);
                            
                            if (mysqli_num_rows($result) > 0) {
                            // output data of each row
                                while($row = mysqli_fetch_assoc($result)) {
                                  $image_path = "images-vote/" . $row['image_name'];
                                    echo "<tr>
                                        <td>".$row['id']."</td>
                                        <td>".$row['name']."</td>
                                        <td><img src='$image_path' /></td>
                                        <td>".$row['total_votes']."</td>
                                        
                                        <td><button type='button' class='btn btn-danger btn-rounded btn-fw btn-sm delete-btn' data-id='".$row['id']."' style='color:white' data-delete-id='".$row['id']."'>Delete</button></td>
                                        </tr>";
                                }
                            }
                            else 
                            {
                            echo "0 results";
                            }
                            mysqli_close($con);
                        ?>
                        <script>
                                $(document).on('click', '.delete-btn', function() {
                                  var id = $(this).data('id');
                                  if (confirm('Are you sure you want to delete this record?')) {
                                    $.ajax({
                                        url: 'delete.php',
                                        type: 'post',
                                        data: {id: id},
                                        success: function(response) {
                                            if (response == 'success') {
                                                alert('Record deleted successfully.');
                                                reloadTable();
                                            } else {
                                                alert('Failed to delete record.');
                                            }
                                        }
                                    });

                                    function reloadTable() {
                                        $.ajax({
                                            url: 'load_table.php',
                                            success: function(data) {
                                                $('table tbody').html(data);
                                            }
                                        });
                                    }

                                  }
                              });

                          </script>
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
  <script src="js/file-upload.js"></script>
  
</body>

</html>