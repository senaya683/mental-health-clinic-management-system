<?php
session_start();

// 1️⃣ CONNECT TO POSTGRESQL
$host = "localhost";
$port = "5432";
$dbname = "final_db"; // your database name
$user = "postgres";   // your database username
$pass = "SENAYA58";   // your database password

$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    die("Connection failed: " . pg_last_error());
}

// 2️⃣ PROCESS FORM DATA
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize POST data
    $firstName = trim($_POST['firstName']);
    $lastName  = trim($_POST['lastName']);
    $phone     = trim($_POST['phone']);
    $nic       = strtoupper(trim($_POST['nic']));
    $epf       = trim($_POST['epf']);
    $email     = trim($_POST['email']);
    $password  = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Check if passwords match
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Check if email already exists
    $check = pg_query_params($dbconn, "SELECT 1 FROM users WHERE email = $1", [$email]);
    if (pg_num_rows($check) > 0) {
        die("Email already registered.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database
    $sql = "
        INSERT INTO users 
        (first_name, last_name, phone, nic, epf, email, password_hash, role, created_at) 
        VALUES 
        ($1, $2, $3, $4, $5, $6, $7, 'patient', CURRENT_TIMESTAMP)
    ";

    $result = pg_query_params($dbconn, $sql, [
        $firstName,
        $lastName,
        $phone,
        $nic,
        $epf,
        $email,
        $hashedPassword
    ]);

   if ($result) {
    // ✅ Store user info in session
    $_SESSION['user_name'] = $firstName . ' ' . $lastName;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_role'] = 'patient';
    $_SESSION['user_image'] = 'uploads/default_profile.png'; // or from DB if you have

    // Redirect to homepage after successful registration
    header("Location: index.php"); // make sure navbar can read session
    exit();
} else {
    die("Error inserting user: " . pg_last_error($dbconn));
}

}
?>
