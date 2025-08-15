<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="sticky top-0 z-50 px-6 py-3 bg-white shadow-md">
    <div class="flex items-center justify-between mx-auto max-w-7xl">
        <!-- Logo -->
        <a href="index.php" class="flex items-center">
            <img src="https://tse1.mm.bing.net/th/id/OIP.mMwmkJAohuInWX0nhDrI0AAAAA?rs=1&pid=ImgDetMain&o=7&rm=3" 
                 alt="Logo" class="w-12 h-12 mr-3 rounded-full shadow-sm">
            <span class="text-2xl font-semibold tracking-wide text-pink-600">Balance Buddy</span>
        </a>

        <!-- Desktop Menu -->
        <div class="items-center hidden space-x-6 font-medium text-pink-600 md:flex">
            <a href="about.php" class="hover:text-pink-400">About Us</a>
            <a href="experts.php" class="hover:text-pink-400">Our Experts</a>
            <a href="services.php" class="hover:text-pink-400">Services</a>
            <a href="mindgym.php" class="hover:text-pink-400">Mind Gym</a>
            <a href="contact.php" class="hover:text-pink-400">Contact</a>

            <?php if (isset($_SESSION['user_name'])): ?>
                <!-- User Profile Dropdown -->
                <div class="relative group">
                    <button class="flex items-center gap-2 focus:outline-none">
                        <img src="<?php echo $_SESSION['user_image']; ?>" 
                             alt="Profile" class="w-10 h-10 border-2 border-pink-500 rounded-full">
                        <span><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <svg class="w-4 h-4 mt-1 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="absolute right-0 hidden w-40 mt-2 bg-white border rounded shadow-md group-hover:block">
                        <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-100">My Profile</a>
                        <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-100">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <a href="login.php" class="px-5 py-2 font-semibold text-white bg-pink-600 rounded-full hover:bg-pink-500">Login</a>
            <?php endif; ?>
        </div>

        <!-- Mobile Hamburger -->
        <div class="flex items-center gap-3 md:hidden">
            <?php if (isset($_SESSION['user_name'])): ?>
                <div class="relative">
                    <button id="mobile-user-btn" class="flex items-center gap-1 focus:outline-none">
                        <img src="<?php echo $_SESSION['user_image']; ?>" 
                             alt="Profile" class="w-10 h-10 border-2 border-pink-500 rounded-full">
                        <svg class="w-4 h-4 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div id="mobile-user-menu" class="absolute right-0 hidden w-40 mt-2 bg-white border rounded shadow-md">
                        <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-100">My Profile</a>
                        <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-pink-100">Logout</a>
                    </div>
                </div>
            <?php endif; ?>

            <button id="menu-toggle" class="text-pink-600 focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Items -->
    <div id="mobile-menu" class="flex flex-col hidden px-6 pb-4 mt-2 space-y-3 font-medium text-pink-600 md:hidden">
        <a href="about.php" class="hover:text-pink-400">About Us</a>
        <a href="experts.php" class="hover:text-pink-400">Our Experts</a>
        <a href="services.php" class="hover:text-pink-400">Services</a>
        <a href="mindgym.php" class="hover:text-pink-400">Mind Gym</a>
        <a href="contact.php" class="hover:text-pink-400">Contact</a>
        <?php if (!isset($_SESSION['user_name'])): ?>
            <a href="login.php" class="px-4 py-2 text-white bg-pink-600 rounded-full hover:bg-pink-500">Login</a>
        <?php endif; ?>
    </div>
</nav>

<script>
    // Mobile hamburger toggle
    document.getElementById("menu-toggle").addEventListener("click", () => {
        document.getElementById("mobile-menu").classList.toggle("hidden");
    });

    // Mobile user dropdown toggle
    const userBtn = document.getElementById("mobile-user-btn");
    if(userBtn){
        userBtn.addEventListener("click", () => {
            document.getElementById("mobile-user-menu").classList.toggle("hidden");
        });
    }
</script>
