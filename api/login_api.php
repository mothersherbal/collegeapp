<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$email = filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL);
$password = trim($data['password']);

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email or password.']);
    exit;
}

$stmt = $conn->prepare("SELECT id, password_hash FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(['status' => 'error', 'message' => 'No account found.']);
    exit;
}

$stmt->bind_result($id, $password_hash);
$stmt->fetch();

if (password_verify($password, $password_hash)) {
    $_SESSION['user_id'] = $id;
    echo json_encode(['status' => 'success', 'message' => 'Login successful.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
}
