<?php
header('Content-Type: application/json');
require_once '../config/db.php';

// Decode JSON input
$data = json_decode(file_get_contents("php://input"), true);

// ✅ Check if input is valid
if (!$data || !isset($data['email']) || !isset($data['password'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid input.']);
    exit;
}

// Sanitize input
$email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$password = trim($data['password']);

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
    exit;
}

// Validate password length
if (strlen($password) < 6) {
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters.']);
    exit;
}

// Check if user already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
    exit;
}
$stmt->close();

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$insert = $conn->prepare("INSERT INTO users (email, password_hash) VALUES (?, ?)");
$insert->bind_param("ss", $email, $hashedPassword);
if ($insert->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Signup successful!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to sign up.']);
}
$insert->close();
$conn->close();
