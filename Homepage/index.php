<?php
session_start();
echo "<pre>";
print_r($_SESSION);
echo "</pre>";
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>

<?php
require_once("../includes/header.php");
require_once("../includes/sidebar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pharmacy Dashboard</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="main-content">
        <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        <p>You are logged in as <strong><?php echo $_SESSION['role']; ?></strong></p>

        <div class="quick-links">
            <ul>
                <li><a href="../medicines/list.php">Manage Medicines</a></li>
                <li><a href="../reports/index.php">View Reports</a></li>
                <li><a href="../auth/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
