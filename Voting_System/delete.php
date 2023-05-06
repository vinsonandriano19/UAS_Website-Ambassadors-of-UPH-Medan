<?php
    include 'connection.php';
    
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        
        // Retrieve the image name for the candidate being deleted
        $sql = "SELECT image_name FROM tbl_kandidat WHERE id = $id";
        $result = mysqli_query($con, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $image_name = $row['image_name'];
            
            // Delete the candidate's image from the server
            if (unlink("images-vote/" . $image_name)) {
                // Delete the candidate from the database
                $sql = "DELETE FROM tbl_kandidat WHERE id = $id";
                mysqli_query($con, $sql);
                echo 'success';
            } else {
                echo 'error';
            }
        }
    }
    $con->close();
?>
