<?php
session_start();
require_once("../config/db.php"); // connect DB

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // tafuta user kwa database
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // verify password
            if (password_verify($password, $user['password'])) {
                // set sessions
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: ../index.php"); // redirect dashboard
                exit;
            } else {
                $error = "❌ Wrong password!";
            }
        } else {
            $error = "❌ Username not found!";
        }
    } else {
        $error = "⚠️ Please fill in all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Pharmacy System</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
  <div class="login-container">
    <h2>Pharmacy System Login</h2>
    <?php if ($error): ?>
      <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="login.php">
      <div>
        <label>Username:</label>
        <input type="text" name="username" required>
      </div>
      <div>
        <label>Password:</label>
        <input type="password" name="password" required>
      </div>
      <div>
        <button type="submit">Login</button>
      </div>
    </form>
  </div>
</body>
</html>

















