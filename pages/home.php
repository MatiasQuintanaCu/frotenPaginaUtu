<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
$userRol = $isLoggedIn ? $_SESSION['user_rol'] : '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTU - Escuela tecnica Trinidad flores</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'utu-blue': '#003366',
            'utu-blue-light': '#004d99',
            'utu-orange': '#ff6b35',
            'utu-yellow': '#ffcc00',
          }
        }
      }
    }
  </script>
  <style>
    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }
    .carousel-item.active {
      animation: fadeIn 0.8s ease;
    }
    .dropdown.active .dropdown-menu {
      opacity: 1 !important;
      visibility: visible !important;
      transform: translateY(0) !important;
    }
    .dropdown-menu {
      opacity: 0;
      visibility: hidden;
      transform: translateY(-10px);
      transition: all 0.3s ease;
    }
    /* Estilos para los nuevos botones */
    .chat-bubble {
      position: relative;
    }
    .chat-bubble::after {
      content: '';
      position: absolute;
      top: -5px;
      right: -5px;
      width: 12px;
      height: 12px;
      background: #ff6b35;
      border-radius: 50%;
      border: 2px solid white;
    }
    .btn-hover-effect {
      transition: all 0.3s ease;
    }
    .btn-hover-effect:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    /* Responsive improvements */
    @media (max-width: 640px) {
      .user-buttons {
        flex-direction: column;
        gap: 0.5rem;
      }
    }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-200 text-gray-800 min-h-screen flex flex-col">

  <!-- NAV -->
  <nav class="bg-gradient-to-r from-utu-blue to-utu-blue-light text-white shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
      <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
        
        <!-- Logo y Marca -->
        <div class="flex items-center gap-4">
          <img id="LogoUtu" 
               src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw9e0Ez8kcPL3R7GtTdsIszwJ8M4JpSefntg&s" 
               alt="LogoUtu"
               class="w-12 h-12 sm:w-16 sm:h-16 rounded-full border-2 border-white border-opacity-20 shadow-lg hover:scale-105 transition-transform duration-300">
          <div class="flex flex-col text-center lg:text-left">
            <span class="text-lg sm:text-xl lg:text-2xl font-bold tracking-wide">UTU - Escuela tecnica Trinidad flores</span>
          </div>
        </div>
        
        <!-- Dropdown Contacto -->
        <div class="relative dropdown" id="contactDropdown">
          <button onclick="toggleDropdown()" 
                  class="flex items-center gap-2 sm:gap-3 bg-white bg-opacity-10 border-2 border-white border-opacity-20 text-white font-semibold px-4 sm:px-6 py-2 sm:py-3 rounded-lg hover:bg-opacity-20 hover:border-opacity-40 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 backdrop-blur-sm text-sm sm:text-base">
            <i class="fas fa-phone-alt"></i> Contacto <i class="fas fa-chevron-down text-xs"></i>
          </button>
          <div class="dropdown-menu absolute right-0 mt-2 bg-white rounded-xl min-w-[300px] sm:min-w-[350px] shadow-2xl overflow-hidden z-50">
            <div class="flex items-start gap-3 sm:gap-4 p-4 sm:p-5 border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:pl-5 sm:hover:pl-7 transition-all duration-200">
              <i class="fas fa-map-marker-alt w-5 sm:w-6 text-utu-blue text-base sm:text-lg mt-1"></i>
              <div>
                <strong class="block text-utu-blue font-semibold mb-1 text-sm sm:text-base">Sede Central</strong>
                <small class="text-gray-600 text-xs sm:text-sm">25 de agosto Nº 427 esq. Batlle y Ordoñez</small>
              </div>
            </div>
            <div class="flex items-start gap-3 sm:gap-4 p-4 sm:p-5 border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:pl-5 sm:hover:pl-7 transition-all duration-200">
              <i class="fas fa-phone w-5 sm:w-6 text-utu-blue text-base sm:text-lg mt-1"></i>
              <div>
                <strong class="block text-utu-blue font-semibold mb-1 text-sm sm:text-base">Teléfono</strong>
                <small class="text-gray-600 text-xs sm:text-sm">4364 8962 - 4364 2426</small>
              </div>
            </div>
            <div class="flex items-start gap-3 sm:gap-4 p-4 sm:p-5 border-b border-gray-100 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:pl-5 sm:hover:pl-7 transition-all duration-200">
              <i class="fas fa-envelope w-5 sm:w-6 text-utu-blue text-base sm:text-lg mt-1"></i>
              <div>
                <strong class="block text-utu-blue font-semibold mb-1 text-sm sm:text-base">Correo Institucional</strong>
                <small class="text-gray-600 text-xs sm:text-sm">tecnicatrinidad@gmail.com</small>
              </div>
            </div>
            <div class="flex items-start gap-3 sm:gap-4 p-4 sm:p-5 hover:bg-gradient-to-r hover:from-gray-50 hover:to-gray-100 hover:pl-5 sm:hover:pl-7 transition-all duration-200">
              <i class="fas fa-clock w-5 sm:w-6 text-utu-blue text-base sm:text-lg mt-1"></i>
              <div>
                <strong class="block text-utu-blue font-semibold mb-1 text-sm sm:text-base">Horario</strong>
                <small class="text-gray-600 text-xs sm:text-sm">Lun a Vie: 7:00 - 23:30</small>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Botones de Usuario -->
        <div class="flex items-center gap-2 sm:gap-4 user-buttons" id="userMenu">
          <?php if ($isLoggedIn && !empty($userName)): ?>
            <!-- Botones para ADMIN y DOCENTE -->
            <?php if ($userRol === 'ADMIN' || $userRol === 'DOCENTE'): ?>
              <div class="flex items-center gap-2 sm:gap-3">
                <!-- Botón de Chat -->
                <button onclick="goToChat()" 
                        class="flex items-center gap-1 sm:gap-2 bg-gradient-to-r from-green-600 to-green-700 text-white font-semibold px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg hover:from-green-700 hover:to-green-800 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 text-sm sm:text-base btn-hover-effect">
                  <i class="fas fa-comments text-xs sm:text-sm"></i>
                  <span class="hidden xs:inline">Chat</span>
                </button>
                
                <!-- Botón de Gestionar Noticias (solo ADMIN) -->
                <?php if ($userRol === 'ADMIN'): ?>
                  <button onclick="goToGestion()" 
                          class="flex items-center gap-1 sm:gap-2 bg-gradient-to-r from-purple-600 to-purple-700 text-white font-semibold px-3 sm:px-5 py-2 sm:py-2.5 rounded-lg hover:from-purple-700 hover:to-purple-800 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 text-sm sm:text-base btn-hover-effect">
                    <i class="fas fa-newspaper text-xs sm:text-sm"></i>
                    <span class="hidden xs:inline">Gestionar</span>
                  </button>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <!-- Información del usuario -->
            <div class="text-utu-yellow font-semibold px-3 sm:px-5 py-2 sm:py-2.5 bg-yellow-400 bg-opacity-10 rounded-lg border border-yellow-400 border-opacity-30 flex items-center gap-2 sm:gap-3 flex-wrap justify-center">
              <span class="text-sm sm:text-base">¡Hola, <?php echo htmlspecialchars($userName); ?>!</span>
              <span class="text-xs bg-utu-blue px-2 py-1 rounded"><?php echo $userRol; ?></span>
            </div>
            
            <!-- Botón de Cerrar Sesión -->
            <button onclick="logout()" 
                    class="flex items-center gap-1 sm:gap-2 bg-gradient-to-r from-blue-600 to-blue-600 text-white font-semibold px-3 sm:px-5 py-2 sm:py-3 rounded-lg hover:from-blue-600 hover:to-blue-700 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 uppercase tracking-wide text-sm sm:text-base">
              <i class="fas fa-sign-out-alt text-xs sm:text-sm"></i>
              <span class="hidden sm:inline">Cerrar</span>
            </button>
          <?php else: ?>
            <button onclick="goToLogin()" 
                    class="flex items-center gap-1 sm:gap-2 bg-gradient-to-r from-utu-yellow to-orange-500 text-white font-semibold px-4 sm:px-7 py-2 sm:py-3 rounded-lg hover:from-orange-500 hover:to-orange-600 hover:-translate-y-0.5 hover:shadow-lg transition-all duration-300 uppercase tracking-wide text-sm sm:text-base">
              <i class="fas fa-sign-in-alt text-xs sm:text-sm"></i>
              <span class="hidden xs:inline">Acceder</span>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTAINER -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 sm:pt-8 pb-6 sm:pb-8 flex-1 w-full">
    
    <!-- Banner Carousel -->
    <div class="relative w-full mb-6 sm:mb-8 overflow-hidden rounded-xl sm:rounded-2xl shadow-xl sm:shadow-2xl" id="carousel">
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white z-10 bg-black bg-opacity-70 px-6 sm:px-10 py-4 sm:py-5 rounded-xl loading-text text-sm sm:text-base">
        Cargando información...
      </div>
      
      <!-- Controles -->
      <div class="carousel-controls absolute top-1/2 -translate-y-1/2 w-full flex justify-between px-3 sm:px-5 z-20">
        <button onclick="prevSlide()" 
                class="w-8 h-8 sm:w-12 sm:h-12 bg-utu-blue bg-opacity-80 text-white rounded-full hover:bg-opacity-100 hover:scale-110 hover:shadow-xl transition-all duration-300 flex items-center justify-center backdrop-blur-sm">
          <i class="fas fa-chevron-left text-sm sm:text-xl"></i>
        </button>
        <button onclick="nextSlide()" 
                class="w-8 h-8 sm:w-12 sm:h-12 bg-utu-blue bg-opacity-80 text-white rounded-full hover:bg-opacity-100 hover:scale-110 hover:shadow-xl transition-all duration-300 flex items-center justify-center backdrop-blur-sm">
          <i class="fas fa-chevron-right text-sm sm:text-xl"></i>
        </button>
      </div>
      
      <!-- Indicadores -->
      <div id="indicators" class="carousel-indicators absolute bottom-3 sm:bottom-5 left-1/2 -translate-x-1/2 flex gap-2 sm:gap-2.5 z-20"></div>
    </div>

    <!-- Eventos/Noticias -->
    <div class="news-section rounded-xl p-4 sm:p-6 lg:p-8 border border-utu-blue border-opacity-5 bg-white shadow-sm">
      <h2 class="text-xl sm:text-2xl lg:text-3xl font-bold text-blue-900 flex items-center gap-2 sm:gap-4 mb-4 sm:mb-6 lg:mb-8 pb-3 sm:pb-4 lg:pb-5 border-b-2 border-gray-100">
        <i class="fas fa-calendar-alt text-utu-orange text-2xl sm:text-3xl lg:text-4xl"></i> Eventos y Noticias
      </h2>
      <div id="eventos-container">
        <div class="loading-text text-center text-gray-600 py-6 sm:py-8 lg:py-10 text-base sm:text-lg">Cargando eventos...</div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="site-footer bg-gradient-to-r from-blue-900 to-blue-800 text-gray-300 pt-12 sm:pt-16 mt-12 sm:mt-16 lg:mt-20 shadow-2xl">
    <div class="footer-container max-w-6xl mx-auto px-4 sm:px-5">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8 lg:gap-10 mb-8 sm:mb-10">
        
        <!-- Logo y Social -->
        <div class="footer-section px-3 sm:px-4">
          <div class="footer-logo">
            <h3 class="text-blue-400 text-2xl sm:text-3xl font-bold mb-1 tracking-wider">UTU</h3>
            <p class="footer-subtitle text-gray-400 text-xs sm:text-sm mb-3 sm:mb-4 font-medium">Escuela tecnica Trinidad flores</p>
          </div>
          <p class="footer-description text-gray-400 text-xs sm:text-sm leading-relaxed mb-4 sm:mb-5">
            Formando profesionales técnicos con excelencia académica desde 1942.
            Educación de calidad para el desarrollo del país.
          </p>
          <div class="footer-social flex gap-2 sm:gap-3 mt-4 sm:mt-5">
            <a href="#" aria-label="Facebook" class="social-link w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-blue-400 bg-opacity-10 border border-blue-400 border-opacity-30 rounded-full text-blue-400 hover:bg-blue-400 hover:text-gray-900 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-sm sm:text-base">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" aria-label="Twitter" class="social-link w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-blue-400 bg-opacity-10 border border-blue-400 border-opacity-30 rounded-full text-blue-400 hover:bg-blue-400 hover:text-gray-900 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-sm sm:text-base">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" aria-label="Instagram" class="social-link w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-blue-400 bg-opacity-10 border border-blue-400 border-opacity-30 rounded-full text-blue-400 hover:bg-blue-400 hover:text-gray-900 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-sm sm:text-base">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" aria-label="LinkedIn" class="social-link w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-blue-400 bg-opacity-10 border border-blue-400 border-opacity-30 rounded-full text-blue-400 hover:bg-blue-400 hover:text-gray-900 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-sm sm:text-base">
              <i class="fab fa-linkedin-in"></i>
            </a>
            <a href="#" aria-label="YouTube" class="social-link w-8 h-8 sm:w-10 sm:h-10 flex items-center justify-center bg-blue-400 bg-opacity-10 border border-blue-400 border-opacity-30 rounded-full text-blue-400 hover:bg-blue-400 hover:text-gray-900 hover:-translate-y-1 hover:shadow-lg transition-all duration-300 text-sm sm:text-base">
              <i class="fab fa-youtube"></i>
            </a>
          </div>
        </div>

        <!-- Enlaces Rápidos -->
        <div class="footer-section px-3 sm:px-4">
          <h4 class="footer-title text-white text-base sm:text-lg font-semibold mb-3 sm:mb-4 lg:mb-5 pb-2 border-b-2 border-blue-400 inline-block">Enlaces Rápidos</h4>
          <ul class="footer-list space-y-2 sm:space-y-3">
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Inicio</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Sobre Nosotros</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Carreras y Cursos</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Inscripciones</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Noticias</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Contacto</a></li>
          </ul>
        </div>

        <!-- Servicios -->
        <div class="footer-section px-3 sm:px-4">
          <h4 class="footer-title text-white text-base sm:text-lg font-semibold mb-3 sm:mb-4 lg:mb-5 pb-2 border-b-2 border-blue-400 inline-block">Servicios</h4>
          <ul class="footer-list space-y-2 sm:space-y-3">
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Biblioteca Virtual</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Plataforma Educativa</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Bedelía Online</a></li>
            <li><a href="login" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Portal Estudiantes</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Bolsa de Trabajo</a></li>
            <li><a href="#" class="text-gray-400 text-xs sm:text-sm hover:text-blue-400 hover:pl-1 transition-all duration-300 inline-block">Mesa de Ayuda</a></li>
          </ul>
        </div>

        <!-- Contacto -->
        <div class="footer-section px-3 sm:px-4">
          <h4 class="footer-title text-white text-base sm:text-lg font-semibold mb-3 sm:mb-4 lg:mb-5 pb-2 border-b-2 border-blue-400 inline-block">Contacto</h4>
          <ul class="footer-contact space-y-3 sm:space-y-4">
            <li class="flex items-start gap-2 sm:gap-3 text-xs sm:text-sm text-gray-400">
              <i class="fas fa-map-marker-alt text-blue-400 mt-0.5 sm:mt-1 text-sm sm:text-base min-w-[16px] sm:min-w-[20px]"></i>
              <span>25 de agosto Nº 427 esq. Batlle y Ordoñez<br>Trinidad, Flores</span>
            </li>
            <li class="flex items-start gap-2 sm:gap-3 text-xs sm:text-sm text-gray-400">
              <i class="fas fa-phone text-blue-400 mt-0.5 sm:mt-1 text-sm sm:text-base min-w-[16px] sm:min-w-[20px]"></i>
              <span>4364 8962 - 4364 2426</span>
            </li>
            <li class="flex items-start gap-2 sm:gap-3 text-xs sm:text-sm text-gray-400">
              <i class="fas fa-envelope text-blue-400 mt-0.5 sm:mt-1 text-sm sm:text-base min-w-[16px] sm:min-w-[20px]"></i>
              <span>tecnicatrinidad@gmail.com</span>
            </li>
            <li class="flex items-start gap-2 sm:gap-3 text-xs sm:text-sm text-gray-400">
              <i class="fas fa-clock text-blue-400 mt-0.5 sm:mt-1 text-sm sm:text-base min-w-[16px] sm:min-w-[20px]"></i>
              <span>Lun - Vie: 7:00 - 23:30</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom bg-black bg-opacity-30 py-4 sm:py-6 border-t border-blue-400 border-opacity-20">
      <div class="footer-bottom-content max-w-6xl mx-auto px-4 sm:px-6 lg:px-9 flex flex-col md:flex-row justify-between items-center gap-3 sm:gap-4 lg:gap-5 flex-wrap">
        <p class="copyright text-gray-400 text-xs sm:text-sm text-center md:text-left">&copy; 2025 Escuela tecnica Trinidad flores (UTU). Todos los derechos reservados.</p>
        <div class="footer-legal flex items-center gap-1 sm:gap-2 flex-wrap justify-center text-xs sm:text-sm">
          <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">Política de Privacidad</a>
          <span class="separator text-blue-400 text-opacity-40">|</span>
          <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">Términos y Condiciones</a>
          <span class="separator text-blue-400 text-opacity-40">|</span>
          <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">Accesibilidad</a>
          <span class="separator text-blue-400 text-opacity-40">|</span>
          <a href="#" class="text-gray-400 hover:text-blue-400 transition-colors duration-300">Mapa del Sitio</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Dropdown
    function toggleDropdown() {
      document.getElementById('contactDropdown').classList.toggle('active');
    }
    document.addEventListener('click', e => {
      if (!document.getElementById('contactDropdown').contains(e.target)) {
        document.getElementById('contactDropdown').classList.remove('active');
      }
    });

    // Carousel
    let currentSlide = 0, carouselSlides = [];
    function showSlide(i) {
      carouselSlides.forEach((s, idx) => s.classList.toggle('active', idx === i));
      document.querySelectorAll('.indicator').forEach((ind, idx) => ind.classList.toggle('active', idx === i));
    }
    function nextSlide() { 
      if (carouselSlides.length) { 
        currentSlide = (currentSlide + 1) % carouselSlides.length; 
        showSlide(currentSlide);
      }
    }
    function prevSlide() { 
      if (carouselSlides.length) { 
        currentSlide = (currentSlide - 1 + carouselSlides.length) % carouselSlides.length; 
        showSlide(currentSlide);
      }
    }
    function goToSlide(i){ 
      currentSlide = i; 
      showSlide(currentSlide); 
    }
    function createIndicators(n){
      const cont = document.getElementById('indicators'); 
      cont.innerHTML = '';
      for(let i = 0; i < n; i++){ 
        const d = document.createElement('div'); 
        d.className = 'indicator w-2 h-2 sm:w-3 sm:h-3 rounded-full cursor-pointer transition-all duration-300 border-2 border-transparent ' + (i === 0 ? 'active bg-utu-yellow border-white scale-125' : 'bg-white bg-opacity-50');
        d.onclick = () => goToSlide(i); 
        cont.appendChild(d); 
      }
    }
    
    // Navegación a las nuevas páginas
    function goToChat() {
      window.location.href = 'chat';
    }

    function goToGestion() {
      window.location.href = 'gestion-noticias';
    }

    function goToLogin() {
      window.location.href = 'login';
    }

    // Función para mostrar notificaciones de nuevos mensajes
    function checkNewMessages() {
      // Aquí puedes implementar la lógica para verificar mensajes nuevos
      // Por ahora es un placeholder
      const chatButton = document.querySelector('button[onclick="goToChat()"]');
      if (chatButton && Math.random() > 0.7) { // Ejemplo aleatorio
        chatButton.classList.add('chat-bubble');
      }
    }

    // Cargar posts en el carrusel
    function cargarInformacionGeneral(posts){
      const c = document.getElementById('carousel'); 
      const ctr = c.querySelector('.carousel-controls');
      const ind = c.querySelector('.carousel-indicators');
      const loading = c.querySelector('.loading-text');
      
      if (loading) loading.remove();
      
      c.querySelectorAll('.carousel-item').forEach(el => el.remove());
      
      const postsConImagen = posts.filter(post => post.imagen);
      
      if (postsConImagen.length === 0) {
        const noData = document.createElement('div');
        noData.className = 'loading-text absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white z-10 bg-black bg-opacity-70 px-6 sm:px-10 py-4 sm:py-5 rounded-xl text-sm sm:text-base';
        noData.textContent = 'No hay información disponible';
        c.appendChild(noData);
        return;
      }
      
      postsConImagen.forEach((post, idx) => {
        const s = document.createElement('div');
        s.className = 'carousel-item relative w-full h-[300px] sm:h-[400px] lg:h-[500px]' + (idx === 0 ? ' active' : ' hidden');
        
        const imageUrl = `data:image/jpeg;base64,${post.imagen}`;
        const fecha = new Date(post.fecha_publicacion).toLocaleDateString('es-UY', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        
        s.innerHTML = `
          <img src="${imageUrl}" alt="${post.titulo}" class="w-full h-full object-cover" onerror="this.style.display='none'">
          <div class="carousel-overlay absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black from-0% via-black via-50% to-transparent to-100% text-white px-4 sm:px-8 lg:px-12 pt-8 sm:pt-12 lg:pt-16 pb-6 sm:pb-8 lg:pb-10">
            <h3 class="text-xl sm:text-2xl lg:text-3xl xl:text-4xl font-bold mb-2 sm:mb-3 lg:mb-4 leading-tight drop-shadow-lg">${post.titulo}</h3>
            <p class="text-gray-200 text-sm sm:text-base lg:text-lg leading-relaxed max-w-3xl mb-3 sm:mb-4 lg:mb-5 drop-shadow line-clamp-2">${post.contenido}</p>
            <div class="carousel-meta flex items-center gap-3 sm:gap-4 lg:gap-5 text-xs sm:text-sm text-utu-yellow mt-2 sm:mt-3 lg:mt-4">
              <span><i class="fas fa-user mr-1"></i> ${post.autor.nombre}</span>
              <span><i class="fas fa-calendar mr-1"></i> ${fecha}</span>
            </div>
          </div>
        `; 
        c.appendChild(s);
      });
      
      // Mover controles e indicadores al final
      c.appendChild(ctr);
      c.appendChild(ind);
      
      carouselSlides = c.querySelectorAll('.carousel-item'); 
      createIndicators(carouselSlides.length); 
      showSlide(0);
    }
    
    // Cargar eventos/noticias
    function cargarEventos(eventos){
      const cont = document.getElementById('eventos-container'); 
      const loading = cont.querySelector('.loading-text');
      
      if (loading) loading.remove();
      cont.innerHTML = ''; 
      
      if(!eventos.length){
        const m = document.createElement('div');
        m.className = 'loading-text text-center text-gray-600 py-6 sm:py-8 lg:py-10 text-base sm:text-lg';
        m.textContent = 'No hay eventos disponibles';
        cont.appendChild(m);
        return;
      }

      // Crear grid de noticias
      const grid = document.createElement('div');
      grid.className = 'news-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 lg:gap-6';
      
      eventos.forEach(evento => {
        const it = document.createElement('div');
        it.className = 'news-item bg-gradient-to-r from-gray-50 to-white rounded-lg sm:rounded-xl p-4 sm:p-5 lg:p-6 border-l-[4px] sm:border-l-[5px] border-utu-orange relative hover:-translate-y-1 hover:shadow-lg sm:hover:shadow-xl hover:border-blue-900 transition-all duration-300';
        const fecha = new Date(evento.fecha_evento).toLocaleDateString('es-UY', {
          day: '2-digit',
          month: 'short',
          year: 'numeric'
        });
        
        it.innerHTML = `
          <div class="news-date absolute top-3 sm:top-4 right-3 sm:right-4 bg-gradient-to-r from-blue-900 to-blue-800 text-white px-2 sm:px-3 py-1 sm:py-1.5 rounded text-xs font-semibold shadow">${fecha}</div>
          <h3 class="text-blue-900 font-bold text-lg sm:text-xl mb-2 sm:mb-3 pr-16 sm:pr-20">${evento.titulo}</h3>
          <p class="text-gray-600 leading-relaxed text-sm sm:text-[0.95rem] line-clamp-3">${evento.descripcion}</p>
          <small class="block text-gray-500 mt-2 text-xs sm:text-sm">
            Por: ${evento.autor.nombre}
          </small>
        `;
        grid.appendChild(it);
      });
      
      cont.appendChild(grid);
    }

    // Funciones de autenticación
    async function logout() {
      try {
        const res = await fetch("/api/v1/user/logout", {
          method: "POST",
          credentials: "include"
        });
        
        const data = await res.json();
        if (data.success) {
          showNotification('Sesión cerrada correctamente', 'success');
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        }
      } catch (error) {
        console.log("Error al cerrar sesión:", error);
        showNotification('Error al cerrar sesión', 'error');
      }
    }

    function showNotification(message, type) {
      const notification = document.createElement('div');
      notification.className = `fixed top-4 sm:top-5 right-4 sm:right-5 px-4 sm:px-5 py-3 sm:py-4 rounded-lg text-white font-medium z-[10000] shadow-lg transition-all duration-300 ${type === 'success' ? 'bg-green-600' : 'bg-red-600'} text-sm sm:text-base`;
      notification.textContent = message;
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.remove();
      }, 3000);
    }

    // Cargar datos desde ambos endpoints
    async function cargarDatos() {
      try {
        // Cargar posts para el carrusel
        const postsResponse = await fetch('/api/v1/home/getPost');
        if (!postsResponse.ok) throw new Error(`Error HTTP posts: ${postsResponse.status}`);
        const postsData = await postsResponse.json();
        
        if (postsData.status === 'success') {
          cargarInformacionGeneral(postsData.data);
          startCarouselAutoAdvance();
        }

        // Cargar eventos para las noticias
        const eventosResponse = await fetch('/api/v1/home/getEvento');
        if (!eventosResponse.ok) throw new Error(`Error HTTP eventos: ${eventosResponse.status}`);
        const eventosData = await eventosResponse.json();
        
        if (eventosData.status === 'success') {
          cargarEventos(eventosData.data);
        }

      } catch (error) {
        console.error('Error cargando datos:', error);
        
        const carousel = document.getElementById('carousel');
        const eventos = document.getElementById('eventos-container');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-text text-center text-red-600 py-6 sm:py-8 lg:py-10 text-base sm:text-lg';
        errorDiv.textContent = 'Error al cargar la información';
        
        carousel.querySelector('.loading-text')?.remove();
        eventos.querySelector('.loading-text')?.remove();
        
        carousel.appendChild(errorDiv.cloneNode(true));
        eventos.appendChild(errorDiv.cloneNode(true));
      }
    }

    // Auto-avance del carrusel
    function startCarouselAutoAdvance() {
      setInterval(() => {
        nextSlide();
      }, 5000);
    }

    // Verificar mensajes cada 30 segundos (cuando esté implementado el chat)
    // setInterval(checkNewMessages, 30000);

    // Inicialización
    window.onload = () => {
      cargarDatos();
    };
  </script>
</body>
</html>