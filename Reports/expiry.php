<?php
session_start();
require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$today = new DateTime();
$soon = new DateTime("+30 days");

$stmt = $conn->prepare("SELECT * FROM medicines WHERE expiry_date <= ?");
$soonDate = $soon->format("Y-m-d");
$stmt->bind_param("s", $soonDate);
$stmt->execute();
$expiringMedicines = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Expiry Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="text-danger mb-4">⏳ Expiry Report</h2>

  <table class="table table-bordered shadow-sm">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Expiry Date</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php if($expiringMedicines->num_rows > 0): ?>
        <?php while($row = $expiringMedicines->fetch_assoc()): ?>
          <?php
            $expiryDate = new DateTime($row['expiry_date']);
            $status = $expiryDate < $today 
                ? '<span class="badge bg-dark">Expired</span>' 
                : '<span class="badge bg-warning text-dark">Expiring Soon</span>';
          ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo $row['expiry_date']; ?></td>
            <td><?php echo $status; ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" class="text-center text-muted">No medicines expiring soon</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
