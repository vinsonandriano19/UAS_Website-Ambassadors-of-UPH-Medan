<?php
include 'connection.php';

$sql = "SELECT * FROM tbl_kandidat";
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
} else {
    echo "0 results";
}

mysqli_close($con);
?>
