<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}
?>
<h1>Welcome, <?php echo $_SESSION['email']; ?>!</h1>
<p>This is your profile page.</p>
<a href="logout.php">Logout</a>
