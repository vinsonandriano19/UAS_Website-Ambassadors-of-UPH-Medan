<style>
body {
    font-family: 'Poppins';
    font-size: 16px;
    line-height: 1.5;
    color: #FFF;
    background: url("assets/img/background.png") top right;
    background-size: cover;
    position: relative;
}

.table-wrapper {
   max-width: 800px;
   margin: 0 auto;
   padding: 30px;
   border-radius: 4px;
   box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

table {
   width: 100%;
   border-collapse: collapse;
   margin-bottom: 30px;
   background-color: rgba(0,0,0,0);
}

th, td {
   text-align: left;
   padding: 10px;
   background-color: rgba(0,0,0,1);
}

th {
   background-color: #444;
   color: #fff;
   text-transform: uppercase;
   font-weight: bold;
   font-size: 14px;
   letter-spacing: 1px;
}

td {
   background-color: #f9f9f9;
   background-color: rgba(0,0,0,1);
}

tr:hover td {
   background-color: #B1884A;
}

</style>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "voting";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM tbl_kandidat";
$result = mysqli_query($conn, $sql);

// Check for errors
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Build the HTML table
echo "<table>";
echo "<tr><th>Name</th><th>Total Votes</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>" . $row['name'] . "</td><td>" . $row['total_votes'] . "</td></tr>";
}
echo "</table>";

// Free the result object
mysqli_free_result($result);

// Close the connection
mysqli_close($conn);

?>

