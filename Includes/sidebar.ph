<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="d-flex">
  <!-- Sidebar -->
  <div class="bg-dark text-white p-3 vh-100" style="width: 250px; position: fixed;">
    <h4 class="text-center mb-4">💊 Pharmacy</h4>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a href="../index.php" class="nav-link text-white">🏠 Dashboard</a>
      </li>
      <li class="nav-item mb-2">
        <a href="../medicines/list.php" class="nav-link text-white">💊 Medicines</a>
      </li>
      <li class="nav-item mb-2">
        <a href="../reports/sales.php" class="nav-link text-white">📈 Sales Report</a>
      </li>
      <li class="nav-item mb-2">
        <a href="../reports/stock.php" class="nav-link text-white">📦 Stock Report</a>
      </li>
      <li class="nav-item mb-2">
        <a href="../reports/expiry.php" class="nav-link text-white">⏳ Expiry Report</a>
      </li>
      <li class="nav-item mb-2">
        <a href="../auth/register.php" class="nav-link text-white">👤 Manage Users</a>
      </li>
      <li class="nav-item mt-4">
        <a href="../auth/logout.php" class="btn btn-danger w-100">🚪 Logout</a>
      </li>
    </ul>
  </div>

  <!-- Page Content Wrapper -->
  <div class="flex-grow-1" style="margin-left: 250px;">
