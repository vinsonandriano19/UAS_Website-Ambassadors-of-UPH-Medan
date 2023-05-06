<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Portfolio Details - Personal Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="../assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: MyResume
  * Updated: Mar 10 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/free-html-bootstrap-template-my-resume/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body id="votebg">
    <div class="container-sm justify-content-center">

<?php
include 'connection.php';


$code = $_POST['random-code'];
$voting_result = $_POST['result'];

$sql = "SELECT * FROM tbl_form WHERE random_code='$code' AND vote_status=0";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) {
  $code_id = mysqli_fetch_assoc($result)['random_code'];
  $sql = "UPDATE tbl_form SET vote='$voting_result' WHERE random_code='$code_id'";
  mysqli_query($con, $sql);
  
  $sql = "UPDATE tbl_form SET vote_status=1 WHERE random_code='$code_id'";
  mysqli_query($con, $sql);

  echo "<h1 style='text-align: center; padding-top: 300px'>Form submitted successfully.</h1>";
} else {
  echo "<h1 style='text-align: center; padding-top: 300px'>Invalid code or code has already been used.</h1>";
}

mysqli_close($con);
?>
<a href='../index.php'><button class='vote' style='padding-top= -40px;'>Back to Home</button></a>"
</div>

</body>
