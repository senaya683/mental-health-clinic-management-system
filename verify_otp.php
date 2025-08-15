<?php
session_start();

if (!isset($_SESSION['reg_data'])) {
    // No registration data, redirect to register page
    header("Location: register.html");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputOtp = trim($_POST['otp']);
    $regData = $_SESSION['reg_data'];

    // Check OTP expiration (e.g., 10 min)
    if (time() - $regData['otp_time'] > 600) {
        $error = "OTP expired. Please register again.";
        unset($_SESSION['reg_data']);
    } elseif ($inputOtp == $regData['otp']) {
        // OTP correct, insert user into DB
        $host = "localhost";
        $port = "5432";
        $dbname = "final_db";
        $user = "postgres";
        $pass = "SENAYA58";

        $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$pass";
        $dbconn = pg_connect($conn_string);

        if (!$dbconn) {
            die("Connection failed: " . pg_last_error());
        }

        $passwordHash = password_hash($regData['password'], PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO users (first_name, last_name, phone, nic, epf, email, password_hash, role)
                        VALUES ($1, $2, $3, $4, $5, $6, $7, 'patient')";

        $insertResult = pg_query_params($dbconn, $insertQuery, [
            $regData['firstName'],
            $regData['lastName'],
            $regData['phone'],
            $regData['nic'],
            $regData['epf'],
            $regData['email'],
            $passwordHash
        ]);

        pg_close($dbconn);

        if ($insertResult) {
            unset($_SESSION['reg_data']);
            header("Location: login.php?registered=1");
            exit();
        } else {
            $error = "Failed to register user, please try again.";
        }
    } else {
        $error = "Invalid OTP, please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Verify OTP - Balance Buddy</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-10 bg-gray-100">
  <div class="max-w-md w-full bg-white p-8 rounded shadow-lg border-t-4 border-[#017B92]">
    <h2 class="mb-6 text-2xl font-semibold text-pink-600">Verify Your Email</h2>

    <?php if ($error): ?>
      <p class="mb-4 text-red-600"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="">
      <label for="otp" class="block mb-2 font-semibold text-gray-700">Enter OTP sent to your email</label>
      <input
        type="text"
        name="otp"
        id="otp"
        required
        maxlength="6"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#017B92]"
      />
      <button
        type="submit"
        class="mt-4 w-full py-2 bg-[#017B92] text-white font-semibold rounded hover:bg-[#026c7f] transition"
      >
        Verify OTP
      </button>
    </form>
  </div>
</body>
</html>
