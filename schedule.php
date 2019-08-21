<?php
$DB_HOST="localhost";
$DB_PORT='3306';
$DB_DATABASE='l5studio';
$DB_USERNAME='l5studio';
$DB_PASSWORD='qingfeng';

$conn = new mysqli($DB_HOST, $DB_USERNAME, $DB_PASSWORD);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>
