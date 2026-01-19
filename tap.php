<?php
$con = mysqli_connect("77.104.144.221","synpat19_synpat","PRsI4SgEN-n","synpat19_synpat");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  } else {
	  echo "connected";
  }
  $result=mysqli_query($con,"SELECT * FROM wp_popup_data");
$row=mysqli_fetch_array($result,MYSQLI_NUM);
print_r($row);
?> 


<?php
/*
$servername = "77.104.144.221";
$username = "synpat19_synpat";
$password = "PRsI4SgEN-n";
cpanel IP - 77.104.146.144
// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";*/
?>