<?php
header('Content-Type: application/json');
require_once '../includes/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$field = $data['field'];
$value = $data['value'];

$allowedFields = ["username", "email"];
if (!in_array($field, $allowedFields)) {
  echo json_encode(["error" => "Invalid field"]);
  exit;
}

$stmt = $conn->prepare("SELECT COUNT(*) FROM registration WHERE $field = ?");
$stmt->bind_param("s", $value);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

echo json_encode(["unique" => $count == 0]);
?>