<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Balance Buddy</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Swiper CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />

  <style>
    @keyframes slideLeftRight {
      0% { transform: translateX(0); }
      50% { transform: translateX(30px); }
      100% { transform: translateX(0); }
    }
    .moving-image {
      animation: slideLeftRight 3s ease-in-out infinite;
      max-width: 200px;
      margin-top: 20px;
    }
  </style>
</head>
<body class="text-gray-800 bg-blue-100">

  <!-- Navbar -->
  <nav class="sticky top-0 z-50 bg-white shadow-md">
    <div class="px-6 mx-auto max-w-7xl sm:px-8 lg:px-10">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <a href="index.php" class="flex items-center">
          <img src="https://tse1.mm.bing.net/th/id/OIP.mMwmkJAohuInWX0nhDrI0AAAAA?rs=1&pid=ImgDetMain&o=7&rm=3" alt="Logo" class="w-12 h-12 mr-3 rounded-full shadow-sm" />
          <span class="text-2xl font-semibold tracking-wide text-pink-600">Balance Buddy</span>
        </a>

        <!-- Desktop Menu -->
        <div class="items-center hidden space-x-6 font-medium text-pink-600 md:flex">
          <a href="about.html" class="transition hover:text-pink-400">About Us</a>
          <a href="experts.html" class="transition hover:text-pink-400">Our Experts</a>
          <a href="services.html" class="transition hover:text-pink-400">Services</a>
          <a href="mindgym.html" class="transition hover:text-pink-400">Mind Gym</a>
          <a href="team.html" class="transition hover:text-pink-400">Join Our Team</a>
          <a href="contact.html" class="transition hover:text-pink-400">Contact</a>

          <!-- Profile / Login -->
          <?php if (isset($_SESSION['user_name'])): ?>
            <div class="flex items-center gap-2 px-3 py-1 bg-pink-100 rounded-full">
              <img src="<?php echo $_SESSION['user_image']; ?>" alt="Profile" class="w-8 h-8 rounded-full">
              <span class="font-medium"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
            </div>
          <?php else: ?>
            <a href="login.php" class="px-5 py-2 font-semibold text-white transition rounded-full" style="background-color: #017b92">Login</a>
          <?php endif; ?>

          <!-- Language Selector -->
          <select class="px-2 py-1 ml-2 text-sm border border-gray-300 rounded">
            <option>English</option>
            <option>සිංහල</option>
            <option>தமிழ்</option>
          </select>
        </div>

        <!-- Mobile Hamburger Menu -->
        <button id="menu-toggle" class="text-pink-600 md:hidden focus:outline-none" aria-label="Toggle menu">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>
    </div>

    <!-- Mobile Menu Items -->
    <div id="mobile-menu" class="hidden px-6 pb-4 md:hidden">
      <div class="flex flex-col space-y-3 font-medium text-pink-600">
        <a href="/Frontend_Development/index.html">Home</a>

        <a href="aboutus.html" class="hover:text-pink-400">About Us</a>
        <a href="ourexperts.html" class="hover:text-pink-400">Our Experts</a>
        <a href="services.html" class="hover:text-pink-400">Services</a>
        <a href="mindgym.html" class="hover:text-pink-400">Mind Gym</a>
        <a href="team.html" class="hover:text-pink-400">Join Our Team</a>
        <a href="contact.html" class="hover:text-pink-400">Contact</a>

        <?php if (isset($_SESSION['user_name'])): ?>
          <div class="flex items-center gap-2 px-3 py-1 bg-pink-100 rounded-full">
            <img src="<?php echo $_SESSION['user_image']; ?>" alt="Profile" class="w-8 h-8 rounded-full">
            <span class="font-medium"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
          </div>
        <?php else: ?>
          <a href="login.php" class="px-4 py-2 text-white bg-pink-600 rounded-full hover:bg-pink-500">Login</a>
        <?php endif; ?>

        <select class="w-full px-2 py-1 text-sm border border-gray-300 rounded">
          <option>English</option>
          <option>සිංහල</option>
          <option>தமிழ்</option>
        </select>
      </div>
    </div>
  </nav>

<!-- Carousel Section -->
    <div class="p-4 mx-auto max-w-7xl">
      <div class="w-full swiper mySwiper">
        <div class="swiper-wrapper">
          <!-- Slide 1 -->
          <div
            class="flex flex-col items-center p-6 bg-pink-100 swiper-slide rounded-xl md:flex-row"
          >
            <div class="flex justify-center mb-6 md:w-1/2 md:mb-0">
              <img
                src="https://th.bing.com/th/id/R.b5d8c4a13c4816c82b497df3b4b2d329?rik=FTZfLtW%2fzkX1UQ&pid=ImgRaw&r=0"
                class="max-w-full shadow-md rounded-xl md:max-w-md"
              />
            </div>
            <div class="text-center md:w-1/2 md:pl-8 md:text-left">
              <h3 class="mb-3 text-2xl font-bold text-pink-700">
                Corporate Services
              </h3>
              <p class="mb-6 text-gray-700">
                Gift your employees a friendly space to relax, chat & feel
                happier!
              </p>
              <div class="space-y-3">
                <div
                  class="px-4 py-2 font-semibold text-black bg-pink-400 rounded"
                >
                  Corporate Counseling Plans
                </div>
                <div
                  class="px-4 py-2 font-semibold text-black bg-pink-300 rounded"
                >
                  Workshops & Webinars
                </div>
                <div
                  class="px-4 py-2 font-semibold text-black bg-pink-200 rounded"
                >
                  Meditational Programs
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 2 -->
          <div
            class="flex flex-col items-center p-6 bg-blue-100 swiper-slide rounded-xl md:flex-row"
          >
            <div class="flex justify-center mb-6 md:w-1/2 md:mb-0">
              <img
                src="https://www.graduateprogram.org/wp-content/uploads/2023/05/May-26-The-School-Counselor-and-Group-Counseling_web-scaled.jpg"
                class="max-w-full shadow-md rounded-xl md:max-w-md"
              />
            </div>
            <div class="text-center md:w-1/2 md:pl-8 md:text-left">
              <h3 class="mb-3 text-2xl font-bold text-blue-700">
                Group Programs
              </h3>
              <p class="mb-6 text-gray-700">
                Join together in healing spaces for wellness and support!
              </p>
              <div class="space-y-3">
                <div
                  class="px-4 py-2 font-semibold text-black bg-blue-200 rounded"
                >
                  Meditational Programs
                </div>
                <div
                  class="px-4 py-2 font-semibold text-black bg-blue-300 rounded"
                >
                  Yoga Programs
                </div>
                <div
                  class="px-4 py-2 font-semibold text-black bg-blue-200 rounded"
                >
                  Group Therapy
                </div>
              </div>
            </div>
          </div>

          <!-- Slide 3 -->
          <div
            class="flex flex-col items-center p-6 swiper-slide bg-pink-50 rounded-xl md:flex-row"
          >
            <div class="flex justify-center mb-6 md:w-1/2 md:mb-0">
              <img
                src="https://tse3.mm.bing.net/th/id/OIP.jFO8uQsoayghX3XAt817fQHaFj?rs=1&pid=ImgDetMain&o=7&rm=3"
                class="max-w-full rounded-lg shadow-md md:max-w-md"
              />
            </div>
            <div class="text-center md:w-1/2 md:pl-8 md:text-left">
              <h3 class="mb-4 text-2xl font-bold text-red-600">
                Boost Your Brain Power!
              </h3>
              <div class="space-y-3">
                <div
                  class="px-4 py-2 font-semibold text-black bg-red-300 rounded"
                >
                  Individual Counselling
                </div>
                <div
                  class="px-4 py-2 font-semibold text-black bg-red-200 rounded"
                >
                  Mind Gym
                </div>
                <div
                  class="px-4 py-2 font-semibold text-black bg-red-100 rounded"
                >
                  In-Person Consultation
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Pagination & Arrows -->
        <div class="mt-4 swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
      </div>
    </div>
    <!-- Call to Action -->
    <div class="my-8 text-center">
      <a
        href="#"
        class="inline-block px-6 py-3 font-semibold text-white transition bg-pink-600 rounded-full shadow hover:bg-pink-700"
      >
        Click Here To Calculate Your Happiness Level
      </a>
      <div class="flex justify-center mt-6">
        <img
          src="https://www.mindheals.org/theme/img/wish-pic1.png"
          class="w-48 max-w-full moving-image"
          alt="Animated"
        />
      </div>
    </div>

    <!-- Talk to Expert Section -->
    <div class="my-8 text-center">
      <h4
        class="inline-block text-[#f86328] px-8 py-3 rounded-full font-serif text-xl"
      >
        I Like To Talk With An Expert
      </h4>
    </div>

    <!-- Therapy Services Section -->
    <section class="my-12 text-center">
      <div
        class="grid justify-center grid-cols-2 gap-6 px-4 md:grid-cols-3 lg:grid-cols-4"
      >
        <!-- Individual Therapy -->
        <div
          class="p-4 transition bg-white border rounded-lg shadow-sm hover:shadow-md"
        >
          <h6 class="font-bold text-blue-600">Individual Therapy</h6>
          <p class="text-sm text-gray-500">(Above 18 years)</p>
        </div>

        <!-- Couples Therapy -->
        <div
          class="p-4 transition bg-white border rounded-lg shadow-sm hover:shadow-md"
        >
          <h6 class="font-bold text-blue-600">Couples Therapy</h6>
          <p class="text-sm text-gray-500">(All ages)</p>
        </div>

        <!-- Child Therapy -->
        <div
          class="p-4 transition bg-white border rounded-lg shadow-sm hover:shadow-md"
        >
          <h6 class="font-bold text-blue-600">Child Therapy</h6>
          <p class="text-sm text-gray-500">(Below 18 years)</p>
        </div>

        <!-- Elderly Therapy -->
        <div
          class="p-4 transition bg-white border rounded-lg shadow-sm hover:shadow-md"
        >
          <h6 class="font-bold text-blue-600">Elderly Therapy</h6>
          <p class="text-sm text-gray-500">(Above 50 Years)</p>
        </div>

        <!-- Career Guidance -->
        <div
          class="p-4 transition bg-white border rounded-lg shadow-sm hover:shadow-md"
        >
          <h6 class="font-bold text-blue-600">Career Guidance</h6>
          <p class="text-sm text-gray-500">(Above 16 Years)</p>
        </div>

        <!-- Personality Development -->
        <div
          class="p-4 transition bg-white border rounded-lg shadow-sm hover:shadow-md"
        >
          <h6 class="font-bold text-blue-600">Personality Development</h6>
          <p class="text-sm text-gray-500">(All ages)</p>
        </div>

        <!-- Motivation -->
        <div
          class="p-4 transition bg-white border rounded-lg shadow-sm hover:shadow-md"
        >
          <h6 class="font-bold text-blue-600">Motivation</h6>
          <p class="text-sm text-gray-500">(All ages)</p>
        </div>
      </div>

      <!-- Book Appointment Button -->
      <div class="mt-10">
        <a
          href="#book"
          class="inline-block px-10 py-4 text-lg font-bold text-white transition bg-pink-700 rounded-full hover:bg-pink-800"
        >
          Book Appointment Now
        </a>
      </div>
    </section>
    <!-- Mindfulness Program Registration Section -->
    <section class="py-12 text-center bg-blue-100 from-pink-50 to-white">
      <h2 class="mb-10 text-2xl font-semibold text-blue-800 md:text-3xl">
        I Would Like To Register For A Mindfulness Program
      </h2>

      <!-- Program Options -->
      <div class="flex flex-wrap justify-center gap-4 px-4 mb-10">
        <div
          class="px-6 py-4 font-semibold text-blue-800 transition border-2 border-blue-200 rounded-2xl hover:bg-blue-100"
        >
          Group therapy
        </div>
        <div
          class="px-6 py-4 font-semibold text-blue-800 transition border-2 border-blue-200 rounded-2xl hover:bg-blue-100"
        >
          Workshops
        </div>
        <div
          class="px-6 py-4 font-semibold text-blue-800 transition border-2 border-blue-200 rounded-2xl hover:bg-blue-100"
        >
          Yoga and Meditation
        </div>
        <div
          class="px-6 py-4 font-semibold text-blue-800 transition border-2 border-blue-200 rounded-2xl hover:bg-blue-100"
        >
          Personality Development
        </div>
      </div>

      <!-- Register Button -->
      <div class="mb-12">
        <a
          href="#register-form"
          class="px-8 py-4 text-lg font-bold text-white transition bg-pink-500 rounded-full shadow-md hover:bg-pink-600"
        >
          Register Now
        </a>
      </div>

      <!-- Illustration -->
      <div class="flex justify-center">
        <img
          src="https://www.mindheals.org/theme/img/wish-pic2.png"
          alt="Illustration"
          class="w-64 md:w-80 lg:w-96"
        />
      </div>
    </section>

    <!-- Footer -->
    <footer class="pt-10 pb-6 text-gray-800 bg-pink-100">
      <div class="grid grid-cols-1 gap-8 px-6 mx-auto max-w-7xl md:grid-cols-3">
        <!-- Logo & Description -->
        <div>
          <div class="flex items-center mb-4 space-x-3">
            <img
              src="https://tse1.mm.bing.net/th/id/OIP.mMwmkJAohuInWX0nhDrI0AAAAA?rs=1&pid=ImgDetMain&o=7&rm=3"
              alt="Logo"
              class="w-10 h-10"
            />
            <span class="text-2xl font-bold text-pink-600">BALANCE BUDDY</span>
          </div>
          <p class="text-sm italic leading-relaxed text-gray-600">
            Balance Buddy is a social service-oriented mental health platform
            based in Sri Lanka, offering convenient, confidential, and
            accessible care from licensed professionals across various
            specialties.
          </p>
        </div>

        <!-- Contact Info -->
        <div class="space-y-3">
          <h3 class="text-lg font-semibold text-pink-700">Contact Us</h3>
          <p>
            <strong>Hotline number:</strong> <br /><span
              class="font-semibold text-blue-900"
              >071 696 2222</span
            >
          </p>
          <p>
            <strong>WhatsApp number:</strong> <br /><span
              class="font-semibold text-blue-900"
              >071 312 0740</span
            >
          </p>
          <p>
            <strong>Email:</strong> <br /><a
              href="mailto:info@balancebuddy.org"
              class="font-semibold text-blue-900"
              >info@balancebuddy.org</a
            >
          </p>
        </div>

        <!-- Links & Socials -->
        <div class="flex flex-col justify-between">
          <div class="flex mb-4 space-x-4">
            <a href="#" class="text-2xl text-blue-800 hover:text-pink-500"
              ><i class="fab fa-facebook-f"></i
            ></a>
            <a href="#" class="text-2xl text-blue-800 hover:text-pink-500"
              ><i class="fab fa-instagram"></i
            ></a>
            <a href="#" class="text-2xl text-blue-800 hover:text-pink-500"
              ><i class="fab fa-linkedin-in"></i
            ></a>
          </div>
          <div class="flex space-x-6 text-sm text-gray-700">
            <a href="#" class="hover:text-pink-600">Terms & Conditions</a>
            <a href="#" class="hover:text-pink-600">Privacy Policy</a>
          </div>
        </div>
      </div>

      <!-- Copyright -->
      <div class="mt-6 text-sm text-center text-gray-600">
        © 2025 BalanceBuddy.org. All rights reserved. Design by EWD
      </div>

      <!-- Scroll to Top Button -->
      <div class="fixed bottom-6 right-6">
        <a
          href="#"
          class="p-3 text-white transition bg-pink-500 rounded-full shadow hover:bg-pink-600"
        >
          ↑
        </a>
      </div>
    </footer>

    <!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

<!-- Scripts -->
<script>
  // Mobile menu toggle
  const menuToggle = document.getElementById("menu-toggle");
  const mobileMenu = document.getElementById("mobile-menu");

  menuToggle.addEventListener("click", () => {
    mobileMenu.classList.toggle("hidden");
  });

  // Swiper initialization
  const swiper = new Swiper(".mySwiper", {
    loop: true,
    speed: 800,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
</script>
</body>
</html>

