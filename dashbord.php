<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="max-w-md p-6 mx-auto mt-10 bg-white rounded-lg shadow-lg">
    <h2 class="mb-4 text-2xl font-bold">
        Welcome, <?php echo htmlspecialchars($_SESSION['first_name']); ?>!
    </h2>
    <p>Your role: <?php echo htmlspecialchars($_SESSION['role']); ?></p>

    <?php if ($_SESSION['role'] === 'admin'): ?>
        <p>Admin options: Manage users, view reports, etc.</p>
    <?php elseif ($_SESSION['role'] === 'counselor'): ?>
        <p>Counselor options: View appointments, manage sessions, etc.</p>
    <?php else: ?>
        <p>Patient options: Book appointments, view progress, etc.</p>
    <?php endif; ?>

    <a href="logout.php" class="block mt-4 text-red-500">Logout</a>
</div>
</body>
</html>
