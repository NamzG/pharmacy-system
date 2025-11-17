<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$allMedicines = $conn->query("SELECT * FROM medicines ORDER BY quantity ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stock Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-success mb-4">📦 Stock Report</h2>

  <table class="table table-bordered shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Expiry</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $allMedicines->fetch_assoc()): ?>
        <?php
          $status = '<span class="badge bg-success">Available</span>';
          if ($row['quantity'] < 10) $status = '<span class="badge bg-danger">Low Stock</span>';
        ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo htmlspecialchars($row['name']); ?></td>
          <td><?php echo htmlspecialchars($row['type']); ?></td>
          <td>Ksh <?php echo number_format($row['price'],2); ?></td>
          <td><?php echo $row['quantity']; ?></td>
          <td><?php echo $row['expiry_date']; ?></td>
          <td><?php echo $status; ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
