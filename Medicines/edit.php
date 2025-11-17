<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$error = "";
$success = "";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$id = intval($_GET['id']);

// Fetch current medicine
$stmt = $conn->prepare("SELECT * FROM medicines WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$medicine = $stmt->get_result()->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);
    $expiry_date = trim($_POST['expiry_date']);

    $stmt = $conn->prepare("UPDATE medicines SET name=?, type=?, price=?, quantity=?, expiry_date=? WHERE id=?");
    $stmt->bind_param("ssdisi", $name, $type, $price, $quantity, $expiry_date, $id);

    if ($stmt->execute()) {
        $success = "Medicine updated successfully!";
        header("Location: index.php");
        exit;
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>
