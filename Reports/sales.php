<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// restrict login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Queries
$totalSales = $conn->query("SELECT IFNULL(SUM(total_price),0) AS total FROM sales")->fetch_assoc()['total'];
$todaySales = $conn->query("SELECT IFNULL(SUM(total_price),0) AS total FROM sales WHERE DATE(sale_date)=CURDATE()")->fetch_assoc()['total'];
$monthlySales = $conn->query("SELECT IFNULL(SUM(total_price),0) AS total FROM sales WHERE MONTH(sale_date)=MONTH(CURDATE()) AND YEAR(sale_date)=YEAR(CURDATE())")->fetch_assoc()['total'];

$salesData = $conn->query("SELECT id, medicine_id, quantity, total_price, sale_date FROM sales ORDER BY sale_date DESC LIMIT 50");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sales Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-success mb-4">📈 Sales Report</h2>

  <div class="row mb-4">
    <div class="col-md-4">
      <div class="card p-3 shadow-sm text-center">
        <h6>Total Sales</h6>
        <h4 class="text-primary">Ksh <?php echo number_format($totalSales,2); ?></h4>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-3 shadow-sm text-center">
