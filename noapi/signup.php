<?php
require_once '../config/db.php';

// ✅ Handle form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Basic validations
    if (empty($email) || empty($password)) {
        $error = "Email and password are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check if user already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email is already registered.";
        } else {
            // Hash and insert
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
            $insert->bind_param("ss", $email, $hashedPassword);
            if ($insert->execute()) {
                $success = "Signup successful! You can now login.";
            } else {
                $error = "Signup failed. Please try again.";
            }
            $insert->close();
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!-- Signup HTML Form -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Signup</title>
</head>
<body>
  <h2>Signup Form</h2>
  
  <?php if (isset($error)): ?>
    <p style="color: red;"><?= $error ?></p>
  <?php elseif (isset($success)): ?>
    <p style="color: green;"><?= $success ?></p>
  <?php endif; ?>

  <form method="POST" action="">
    <label>Email:</label><br>
    <input type="email" name="email" required><br><br>

    <label>Password:</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">Sign Up</button>
  </form>
</body>
</html>
