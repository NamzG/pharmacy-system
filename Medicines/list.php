<?php
session_start();
require_once __DIR__ . '/../config/db.php';

// Restrict only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$search = "";
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $stmt = $conn->prepare("SELECT * FROM medicines WHERE name LIKE ? OR type LIKE ? ORDER BY created_at DESC");
    $like = "%$search%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $medicines = $stmt->get_result();
} else {
    $medicines = $conn->query("SELECT * FROM medicines ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Medicine List - Pharmacy System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <h2 class="mb-4 text-success">💊 Medicine List</h2>

  <!-- Search bar -->
  <form method="GET" class="row mb-3">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search medicine..." value="<?php echo htmlspecialchars($search); ?>">
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
    <div class="col-md-2">
      <a href="list.php" class="btn btn-secondary">Reset</a>
    </div>
    <div class="col-md-4 text-end">
      <a href="add.php" class="btn btn-success">+ Add Medicine</a>
    </div>
  </form>

  <table class="table table-bordered table-striped shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Type</th>
        <th>Price (Ksh)</th>
        <th>Quantity</th>
        <th>Expiry Date</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php if($medicines->num_rows > 0): ?>
        <?php while($row = $medicines->fetch_assoc()): ?>
          <?php
            $statusBadge = '<span class="badge bg-success">Available</span>';
            
            // Expiry calculation
            $today = new DateTime();
            $expiryDate = new DateTime($row['expiry_date']);
            $diffDays = $today->diff($expiryDate)->days;

            if ($row['quantity'] < 10) {
                $statusBadge = '<span class="badge bg-danger">Low Stock</span>';
            } elseif ($expiryDate < $today) {
                $statusBadge = '<span class="badge bg-dark">Expired</span>';
            } elseif ($diffDays <= 30) {
                $statusBadge = '<span class="badge bg-warning text-dark">Expiring Soon</span>';
            }
          ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['type']); ?></td>
            <td><?php echo number_format($row['price'], 2); ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['expiry_date']; ?></td>
            <td><?php echo $statusBadge; ?></td>
            <td>
              <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                 onclick="return confirm('Are you sure you want to delete this medicine?')">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="8" class="text-center text-muted">No medicines found</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

</body>
</html>
