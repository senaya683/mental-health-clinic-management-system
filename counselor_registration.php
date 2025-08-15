<?php
header('Content-Type: application/json');

// DB Connection
$host = "localhost";
$port = "5432";
$dbname = "final_db";
$user = "postgres";
$pass = "SENAYA58";

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");
if (!$conn) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
    exit;
}

// Get POST data safely
$firstName = trim($_POST['firstName'] ?? '');
$lastName = trim($_POST['lastName'] ?? '');
$contactNumber = trim($_POST['contactNumber'] ?? '');
$email = trim($_POST['email'] ?? '');
$employmentDetails = trim($_POST['employmentDetails'] ?? '');
$vacancy = trim($_POST['vacancy'] ?? '');

// Validation
if (!$firstName || !$lastName || !$contactNumber || !$email || !$vacancy) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
    exit;
}

// Insert into database
$result = pg_query_params(
    $conn,
    "INSERT INTO counselor_registration (first_name, last_name, contact_number, email, employment_details, vacancy) VALUES ($1,$2,$3,$4,$5,$6)",
    [$firstName, $lastName, $contactNumber, $email, $employmentDetails, $vacancy]
);

if ($result) {
    echo json_encode(['status' => 'success', 'message' => 'Application submitted successfully!']);
} else {
    $err = pg_last_error($conn);
    echo json_encode(['status' => 'error', 'message' => "Failed to submit: $err"]);
}

pg_close($conn);
?>
