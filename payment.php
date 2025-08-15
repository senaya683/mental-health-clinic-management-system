<?php
// payment.php
session_start();

// PostgreSQL connection
$host = "localhost";
$port = "5432";
$dbname = "final_db"; // replace with your DB name
$user = "postgres";   // replace with your DB user
$pass = "SENAYA58"; // replace with your DB password

$conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$pass");

if (!$conn) {
    die(json_encode(["status" => "error", "message" => "Database connection failed."]));
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $paymentMethod = $_POST['paymentMethod'] ?? '';
    $errors = [];

    if ($paymentMethod === "online") {
        $cardName = trim($_POST['cardName'] ?? '');
        $cardNumber = preg_replace('/\s+/', '', $_POST['cardNumber'] ?? '');
        $expiry = $_POST['expiry'] ?? '';
        $cvv = trim($_POST['cvv'] ?? '');

        // Server-side validation
        if (strlen($cardName) < 3) $errors[] = "Enter a valid cardholder name.";
        if (!preg_match('/^\d{16}$/', $cardNumber)) $errors[] = "Enter a valid 16-digit card number.";
        if (!$expiry) $errors[] = "Select expiry date.";
        if (!preg_match('/^\d{3,4}$/', $cvv)) $errors[] = "Enter a valid 3 or 4-digit CVV.";

        if (empty($errors)) {
            // Insert payment record into database
            $query = "INSERT INTO payments (method, card_name, card_number, expiry, cvv, amount) VALUES ($1, $2, $3, $4, $5, $6)";
            $result = pg_query_params($conn, $query, [
                $paymentMethod,
                $cardName,
                $cardNumber,
                $expiry,
                $cvv,
                6500 // amount in LKR
            ]);

            if ($result) {
                echo json_encode(["status" => "success", "message" => "Online payment recorded successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to record payment."]);
            }
        } else {
            echo json_encode(["status" => "error", "message" => implode("\n", $errors)]);
        }

    } elseif ($paymentMethod === "bankslip") {
        if (!isset($_FILES['bankSlipFile'])) {
            $errors[] = "Bank slip file is required.";
        } else {
            $file = $_FILES['bankSlipFile'];
            $allowedTypes = ["image/jpeg", "image/png", "application/pdf"];
            if (!in_array($file['type'], $allowedTypes)) $errors[] = "Only JPG, PNG, or PDF files are allowed.";
            if ($file['size'] > 5 * 1024 * 1024) $errors[] = "File size must be less than 5MB.";

            if (empty($errors)) {
                $uploadDir = __DIR__ . "/uploads/";
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);

                $fileName = time() . "_" . basename($file['name']);
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    // Insert bank slip info into DB
                    $query = "INSERT INTO payment_form (method, bank_slip_file, amount) VALUES ($1, $2, $3)";
                    $result = pg_query_params($conn, $query, [
                        $paymentMethod,
                        $fileName,
                        6500
                    ]);

                    if ($result) {
                        echo json_encode(["status" => "success", "message" => "Bank slip uploaded successfully."]);
                    } else {
                        echo json_encode(["status" => "error", "message" => "Failed to record bank slip."]);
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Failed to upload file."]);
                }
            } else {
                echo json_encode(["status" => "error", "message" => implode("\n", $errors)]);
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid payment method."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

?>
