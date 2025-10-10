<?php
$host = "localhost";
$dbname = "u994782675_portal";
$username = "u994782675_Avis_portal";
$password = "Avis@123456"; // Replace with actual password

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
  die("❌ Connection failed: " . $conn->connect_error);
} else {
  echo "✅ Connected successfully to the database.";
}
?>