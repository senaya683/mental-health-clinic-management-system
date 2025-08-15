<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="sticky top-0 z-50 bg-white shadow-md">
  <div class="px-6 mx-auto max-w-7xl sm:px-8 lg:px-10">
    <div class="flex items-center justify-between h-16">
      <!-- Logo -->
      <a href="index.php" class="flex items-center">
        <img src="https://tse1.mm.bing.net/th/id/OIP.mMwmkJAohuInWX0nhDrI0AAAAA?rs=1&pid=ImgDetMain&o=7&rm=3" 
             alt="Logo" class="w-12 h-12 mr-3 rounded-full shadow-sm" />
        <span class="text-2xl font-semibold tracking-wide text-pink-600">Balance Buddy</span>
      </a>

      <!-- Desktop Menu -->
      <div class="items-center hidden space-x-6 font-medium text-pink-600 md:flex">
        <a href="index.php">Home</a>
        <a href="aboutus.php" class="hover:text-pink-400">About Us</a>
        <a href="ourexperts.php" class="hover:text-pink-400">Our Experts</a>
        <a href="services.php" class="hover:text-pink-400">Services</a>
        <a href="mindgym.php" class="hover:text-pink-400">Mind Gym</a>
        <a href="team.php" class="hover:text-pink-400">Join Our Team</a>
        <a href="contact.php" class="hover:text-pink-400">Contact</a>
        <a href="login.php" class="px-5 py-2 font-semibold text-white rounded-full" style="background-color: #017b92">
          Login
        </a>

        <!-- Language Selector -->
        <select class="px-2 py-1 ml-2 text-sm border border-gray-300 rounded">
          <option>English</option>
          <option>සිංහල</option>
          <option>தமிழ்</option>
        </select>
      </div>

      <!-- Mobile Hamburger -->
      <button id="menu-toggle" class="text-pink-600 md:hidden focus:outline-none" aria-label="Toggle menu">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>
    </div>
  </div>

  <!-- Mobile Menu Items -->
  <div id="mobile-menu" class="hidden px-6 pb-4 md:hidden">
    <div class="flex flex-col space-y-3 font-medium text-pink-600">
      <a href="aboutus.php" class="hover:text-pink-400">About Us</a>
      <a href="ourexperts.php" class="hover:text-pink-400">Our Experts</a>
      <a href="services.php" class="hover:text-pink-400">Services</a>
      <a href="mindgym.php" class="hover:text-pink-400">Mind Gym</a>
      <a href="team.php" class="hover:text-pink-400">Join Our Team</a>
      <a href="contact.php" class="hover:text-pink-400">Contact</a>
      <a href="login.php" class="px-4 py-2 text-white bg-pink-600 rounded-full hover:bg-pink-500">Login</a>
      <select class="w-full px-2 py-1 text-sm border border-gray-300 rounded">
        <option>English</option>
        <option>සිංහල</option>
        <option>தமிழ்</option>
      </select>
    </div>
  </div>
</nav>
