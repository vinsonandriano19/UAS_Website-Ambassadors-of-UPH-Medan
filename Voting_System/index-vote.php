<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Ambassadors of UPH Medan</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/AoULogo.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body id="votebg">
    <div class="container-sm justify-content-center">
        <h1 style="text-align: center; font-weight: 300;">INTRODUCING</h1>
        <img style="width: 1296px;" src="../assets/img/all 12.png">

        <br>
        <br>
        <br>
        
        <h2 style="text-align: center; font-weight: 300;">Who will be the next Most Favorite Ambassadors of UPH Medan Campus 2023?</h2>

        <br>
        <br>
        <br>
        
        <form method="post" action="vote.php">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="code" placeholder="000000" name="random-code" required minlength=" 6" maxlength="6">
                <label for="code"><h6>Enter your assigned code</h6></label>
              </div>



        <?php
            include 'connection.php';

            if (!$con) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $sql = "SELECT * FROM tbl_kandidat";
            $result = mysqli_query($con, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $image_path = "images-vote/" . $row['image_name'];
                    echo "<input type='radio' class='input-hidden' name='result' id='" . $row['id'] . "' value='" . $row['name'] . "' required />
                            <label class='labelvotebesar' for='" . $row['id'] . "'>
                            <img src='" . $image_path . "' alt='" . $row['name'] . "'> <h6 class='labelvote'>" . $row['name'] . "</h6>
                         </label>";


                    

                    // echo "<label for='" . $row['id'] . "'>
                    //           <img src='" . $image_path . "' alt='" . $row['name'] . "'>
                    //           " . $row['name'] . "
                    //       </label>
                    //       <input type='radio' name='result' id='" . $row['id'] . "' value='" . $row['name'] . "' required /><br>";
                }
            } 
            else {
                echo "0 results";
            }

            mysqli_close($con);
        ?>
        <br>
        <input type="submit" name="submit" value="Submit" class="vote">
        <br><br>
    </form>

     <!-- Vendor JS Files -->
  <script src="../assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="../assets/vendor/aos/aos.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="../assets/vendor/typed.js/typed.min.js"></script>
  <script src="../assets/vendor/waypoints/noframework.waypoints.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>