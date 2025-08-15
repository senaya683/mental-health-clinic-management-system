<?php
session_start();
header('Content-Type: application/json');

// Database connection
$host = "localhost";
$port = "5432";
$dbname = "final_db";
$user = "postgres";
$pass = "SENAYA58";

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed."
    ]);
    exit;
}

// Get POST data
$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

// Basic validation
if (empty($email) || empty($password)) {
    echo json_encode([
        "status" => "error",
        "message" => "Email and password are required."
    ]);
    exit;
}

// Fetch user by email
$result = pg_query_params($dbconn, "SELECT user_id, password_hash FROM users WHERE email = $1", [$email]);

$login_success = false;

if ($result && pg_num_rows($result) > 0) {
    $user = pg_fetch_assoc($result);

    if (password_verify($password, $user['password_hash'])) {
        // Successful login
        $_SESSION['user_id'] = $user['user_id'];
        $login_success = true;

        echo json_encode([
            "status" => "success",
            "message" => "Login successful."
        ]);
    } 
}

if (!$login_success) {
    echo json_encode([
        "status" => "error",
        "message" => "Invalid email or password."
    ]);
}

// Log the attempt in login_attempts table
pg_query_params(
    $dbconn,
    "INSERT INTO login_attempts (user_email, success) VALUES ($1, $2)",
    [$email, $login_success]
);

// Close DB connection
pg_close($dbconn);
?>
