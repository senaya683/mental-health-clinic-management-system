<?php
header('Content-Type: application/json');

// PostgreSQL connection
$host = "localhost";
$port = "5432";
$dbname = "final_db"; // your DB name
$user = "postgres";   // DB username
$pass = "SENAYA58";   // DB password

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");
if (!$conn) {
    echo json_encode(["status"=>"error","message"=>"Database connection failed"]);
    exit;
}

// Read JSON input
$data = json_decode(file_get_contents("php://input"), true);

// Collect data
$medium = $data['medium'] ?? '';
$language = $data['language'] ?? '';
$purposes = $data['purposes'] ?? [];
$dateTime = $data['dateTime'] ?? '';
$duration = $data['duration'] ?? '';
$customerType = $data['customerType'] ?? '';
$title = $data['title'] ?? '';
$nic = $data['nic'] ?? '';
$firstName = $data['firstName'] ?? '';
$lastName = $data['lastName'] ?? '';
$email = $data['email'] ?? '';
$phone = $data['phone'] ?? '';
$displayName = $data['displayName'] ?? '';
$agreement = isset($data['agreement']) ? true : false;

$purposesStr = implode(", ", $purposes);

// Insert into database
$query = "INSERT INTO appointment_form
(medium, language, purposes, datetime, duration, customer_type, title, nic, first_name, last_name, email, phone, display_name, agreement)
VALUES ($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14)";
$result = pg_query_params($conn, $query, [$medium, $language, $purposesStr, $dateTime, $duration, $customerType, $title, $nic, $firstName, $lastName, $email, $phone, $displayName, $agreement]);

if($result){
    echo json_encode(["status"=>"success","message"=>"Appointment submitted successfully"]);
}else{
    echo json_encode(["status"=>"error","message"=>"Failed to save appointment"]);
}

pg_close($conn);
?>
