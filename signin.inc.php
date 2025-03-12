<?php
session_start();

// Verify request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die(json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]));
}

// Database connection
require_once 'DBS.inc.php';

// Get and sanitize input
$email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';

// Validate input
if (empty($email) || empty($password)) {
    die(json_encode([
        'success' => false,
        'message' => 'Please fill in all fields'
    ]));
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die(json_encode([
        'success' => false,
        'message' => 'Invalid email format'
    ]));
}

try {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Login successful
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        
        echo json_encode([
            'success' => true,
            'message' => 'Login successful'
        ]);
    } else {
        // Login failed
        echo json_encode([
            'success' => false,
            'message' => 'Invalid email or password'
        ]);
    }
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Login failed: ' . $e->getMessage()
    ]);
} 