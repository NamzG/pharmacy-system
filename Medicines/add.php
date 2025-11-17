<?php
session_start();
require_once __DIR__ . '/../config/db.php';

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $type = trim($_POST['type']);
    $price = trim($_POST['price']);
    $quantity = trim($_POST['quantity']);
    $expiry_date = trim($_POST['expiry_date']);

    $stmt = $conn->prepare("INSERT INTO medicines (name, type, price, quantity, expiry_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdis", $name, $type, $price, $quantity, $expiry_date);

    if ($stmt->execute()) {
        $success = "Medicine added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Medicine - Pharmacy System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="text-success mb-3">➕ Add Medicine</h3>

          <?php if($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
          <?php endif; ?>
          <?php if($success): ?>
            <div class="alert alert-success"><?php echo $success; ?></div>
          <?php endif; ?>

          <form method="POST" action="">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Type</label>
              <input type="text" name="type" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Price (Ksh)</label>
              <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Quantity</label>
              <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Expiry Date</label>
              <input type="date" name="expiry_date" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Add Medicine</button>
          </form>
        </div>
      </div>
      <p class="text-center mt-3">
        <a href="index.php">← Back to Medicines</a>
      </p>
    </div>
  </div>
</div>

</body>
</html>
