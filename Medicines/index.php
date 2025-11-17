<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Restrict only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$medicines = $conn->query("SELECT * FROM medicines ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Medicines - Pharmacy System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4 text-success">💊 Medicines</h2>
  <a href="add.php" class="btn btn-primary mb-3">+ Add Medicine</a>
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Type</th>
        <th>Price (Ksh)</th>
        <th>Quantity</th>
        <th>Expiry Date</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php while($row = $medicines->fetch_assoc()): ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['type']; ?></td>
          <td><?php echo $row['price']; ?></td>
          <td><?php echo $row['quantity']; ?></td>
          <td><?php echo $row['expiry_date']; ?></td>
          <td>
            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('Are you sure you want to delete this medicine?')">Delete</a>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

</body>
</html>
