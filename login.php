<?php
session_start();

// If already logged in, redirect to their dashboard
if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            header("Location: admin_dashboard.php");
            exit();
        case 'counselor':
            header("Location: counselor_dashboard.php");
            exit();
        case 'patient':
            header("Location: patient_dashboard.php");
            exit();
    }
}

// PostgreSQL connection
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

$error = "";

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $result = pg_query_params($dbconn, "SELECT * FROM users WHERE email = $1", [$email]);

    if ($result && $row = pg_fetch_assoc($result)) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['email']   = $row['email'];
            $_SESSION['role']    = $row['role'];

            pg_close($dbconn);

            // Role-based redirection
            switch ($row['role']) {
                case 'admin':
                    header("Location: admin_dashboard.php");
                    break;
                case 'counselor':
                    header("Location: counselor_dashboard.php");
                    break;
                case 'patient':
                    header("Location: patient_dashboard.php");
                    break;
                default:
                    header("Location: dashboard.php"); // fallback
                    break;
            }
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}

pg_close($dbconn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Balance Buddy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex flex-col min-h-screen bg-gray-100">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white shadow-md">
      <div class="px-6 mx-auto max-w-7xl sm:px-8 lg:px-10">
        <div class="flex items-center justify-between h-16">
          <a href="index.html" class="flex items-center">
            <img src="https://tse1.mm.bing.net/th/id/OIP.mMwmkJAohuInWX0nhDrI0AAAAA?rs=1&pid=ImgDetMain&o=7&rm=3"
                 alt="Logo"
                 class="w-12 h-12 mr-3 rounded-full shadow-sm" />
            <span class="text-2xl font-semibold tracking-wide text-pink-600">
              Balance Buddy
            </span>
          </a>

          <div class="items-center hidden space-x-6 font-medium text-pink-600 md:flex">
            <?php if (!isset($_SESSION['role'])): ?>
              <a href="about.html" class="transition hover:text-pink-400">About Us</a>
              <a href="experts.html" class="transition hover:text-pink-400">Our Experts</a>
              <a href="services.html" class="transition hover:text-pink-400">Services</a>
              <a href="mindgym.html" class="transition hover:text-pink-400">Mind Gym</a>
              <a href="team.html" class="transition hover:text-pink-400">Join Our Team</a>
              <a href="contact.html" class="transition hover:text-pink-400">Contact</a>
              <a href="login.php"
                 class="px-5 py-2 font-semibold text-white transition rounded-full"
                 style="background-color: #017b92">
                Login
              </a>
            <?php else: ?>
              <?php
                $role = $_SESSION['role'];
                if ($role === 'admin') echo '<a href="admin_dashboard.php" class="transition hover:text-pink-400">Admin Dashboard</a>';
                if ($role === 'counselor') echo '<a href="counselor_dashboard.php" class="transition hover:text-pink-400">Counselor Dashboard</a>';
                if ($role === 'patient') echo '<a href="patient_dashboard.php" class="transition hover:text-pink-400">My Dashboard</a>';
              ?>
              <a href="logout.php"
                 class="px-5 py-2 font-semibold text-white transition rounded-full"
                 style="background-color: #e74c3c">
                Logout
              </a>
            <?php endif; ?>

            <select class="px-2 py-1 ml-2 text-sm border border-gray-300 rounded">
              <option>English</option>
              <option>සිංහල</option>
              <option>தமிழ்</option>
            </select>
          </div>
        </div>
      </div>
    </nav>

    <!-- Login Form -->
    <div class="flex items-center justify-center flex-grow px-4">
      <div class="w-full max-w-md p-8 bg-white border-t-4 shadow-xl rounded-xl" style="border-color: #017b92">
        <h2 class="text-2xl font-bold text-center text-[#017B92] mb-6">Welcome Back</h2>

        <?php if (!empty($error)): ?>
        <div class="p-2 mb-4 text-red-700 bg-red-100 rounded">
          <?= htmlspecialchars($error) ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="login.php" novalidate>
          <div class="mb-4">
            <label for="email" class="block mb-1 font-semibold text-gray-700">Email</label>
            <input type="email" id="email" name="email" required placeholder="you@example.com"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#017B92]" />
          </div>

          <div class="mb-4">
            <label for="password" class="block mb-1 font-semibold text-gray-700">Password</label>
            <input type="password" id="password" name="password" required minlength="6" placeholder="••••••••"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#017B92]" />
          </div>

          <button type="submit" class="w-full py-2 px-4 bg-[#017B92] text-white font-semibold rounded-lg hover:bg-[#026c7f] transition">
            Login
          </button>
        </form>

        <div class="mt-4 text-sm text-center text-gray-600">
          <a href="#" class="hover:underline text-[#017B92]">Forgot Password?</a>
        </div>
        <p class="mt-6 text-center text-gray-600">
          Don’t have an account?
          <a href="registration.html" class="font-semibold text-teal-600 hover:underline">
            Create an Account
          </a>
        </p>
      </div>
    </div>
</body>
</html>
