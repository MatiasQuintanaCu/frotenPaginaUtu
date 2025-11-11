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
  <title>UTU - Escuela Técnica Trinidad Flores</title>
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
            'utu-green': '#27ae60',
            'utu-purple': '#8e44ad',
          }
        }
      }
    }
  </script>
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }
    @keyframes pulse {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.05); }
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
    
    /* Nuevos estilos mejorados */
    .nav-glass {
      background: rgba(0, 51, 102, 0.95);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .btn-modern {
      background: linear-gradient(135deg, var(--tw-gradient-from), var(--tw-gradient-to));
      border: none;
      border-radius: 12px;
      padding: 12px 24px;
      font-weight: 600;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .btn-modern::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }
    
    .btn-modern:hover::before {
      left: 100%;
    }
    
    .btn-modern:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    
    .notification-toast {
      animation: slideIn 0.5s ease, fadeIn 0.5s ease;
    }
    
    .event-card {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      border-radius: 16px;
      padding: 24px;
      border: 1px solid #e2e8f0;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    
    .event-card::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 4px;
      height: 100%;
      background: linear-gradient(to bottom, #ff6b35, #ffcc00);
    }
    
    .event-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 40px rgba(0,0,0,0.1);
      border-color: #cbd5e0;
    }
    
    .event-date {
      background: linear-gradient(135deg, #003366, #004d99);
      color: white;
      padding: 8px 16px;
      border-radius: 8px;
      font-weight: 600;
      font-size: 0.875rem;
    }
    
    .carousel-overlay {
      background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 50%, transparent 100%);
    }
    
    .user-badge {
      background: linear-gradient(135deg, #ffcc00, #ff6b35);
      color: white;
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.75rem;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .footer-gradient {
      background: linear-gradient(135deg, #003366 0%, #002244 100%);
    }
    
    .social-icon {
      transition: all 0.3s ease;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
    }
    
    .social-icon:hover {
      background: #ffcc00;
      transform: translateY(-3px) rotate(5deg);
      color: #003366;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
      .hero-buttons {
        flex-direction: column;
        gap: 12px;
      }
      
      .event-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
    }
    
    /* Loading animations */
    .loading-pulse {
      animation: pulse 2s infinite;
    }
    
    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb {
      background: linear-gradient(to bottom, #003366, #004d99);
      border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: linear-gradient(to bottom, #002244, #003366);
    }
  </style>
</head>

<body class="bg-gradient-to-br from-gray-50 via-blue-50 to-gray-100 text-gray-800 min-h-screen flex flex-col">

  <!-- NAV MEJORADO -->
  <nav class="nav-glass text-white shadow-2xl sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
      <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
        
        <!-- Logo y Marca Mejorado -->
        <div class="flex items-center gap-4 group cursor-pointer">
          <div class="relative group">
  <img id="LogoUtu" 
       src="./assets/img/logo.webp" 
       alt="Logo UTU"
       class="w-16 h-16 md:w-20 md:h-20 rounded-2xl border-2 border-white border-opacity-30 shadow-2xl group-hover:scale-110 group-hover:rotate-3 transition-all duration-500">
  <div class="absolute -inset-1 bg-utu-yellow rounded-2xl opacity-0 group-hover:opacity-20 blur-sm transition-all duration-500"></div>
</div>

          <div class="flex flex-col text-center lg:text-left">
            <span class="text-lg sm:text-xl lg:text-2xl font-bold tracking-tight bg-gradient-to-r from-white to-utu-yellow bg-clip-text text-transparent">
              UTU - Trinidad Flores
            </span>
            <span class="text-xs text-utu-yellow opacity-90 font-medium mt-1">
              Educación Técnica de Excelencia
            </span>
          </div>
        </div>
        
        <!-- Dropdown Contacto Mejorado -->
        <div class="relative dropdown" id="contactDropdown">
          <button onclick="toggleDropdown()" 
                  class="btn-modern from-utu-blue to-utu-blue-light text-white font-semibold px-5 py-3 flex items-center gap-3 group">
            <i class="fas fa-phone-alt text-utu-yellow group-hover:scale-110 transition-transform duration-300"></i>
            <span>Contacto</span>
            <i class="fas fa-chevron-down text-utu-yellow text-xs transition-transform duration-300 group-hover:rotate-180"></i>
          </button>
          <div class="dropdown-menu absolute right-0 mt-3 bg-white rounded-2xl min-w-[320px] shadow-2xl overflow-hidden z-50 border border-gray-200">
            <div class="p-1">
              <div class="flex items-start gap-4 p-4 hover:bg-gradient-to-r hover:from-blue-50 hover:to-utu-blue hover:bg-opacity-5 rounded-xl transition-all duration-200 group">
                <i class="fas fa-map-marker-alt text-utu-blue text-lg mt-1 group-hover:scale-110 transition-transform duration-300"></i>
                <div>
                  <strong class="block text-utu-blue font-semibold mb-1">Sede Central</strong>
                  <small class="text-gray-600 text-sm">25 de agosto Nº 427 esq. Batlle y Ordoñez</small>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 hover:bg-gradient-to-r hover:from-blue-50 hover:to-utu-blue hover:bg-opacity-5 rounded-xl transition-all duration-200 group">
                <i class="fas fa-phone text-utu-blue text-lg mt-1 group-hover:scale-110 transition-transform duration-300"></i>
                <div>
                  <strong class="block text-utu-blue font-semibold mb-1">Teléfono</strong>
                  <small class="text-gray-600 text-sm">4364 8962 - 4364 2426</small>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 hover:bg-gradient-to-r hover:from-blue-50 hover:to-utu-blue hover:bg-opacity-5 rounded-xl transition-all duration-200 group">
                <i class="fas fa-envelope text-utu-blue text-lg mt-1 group-hover:scale-110 transition-transform duration-300"></i>
                <div>
                  <strong class="block text-utu-blue font-semibold mb-1">Correo</strong>
                  <small class="text-gray-600 text-sm">tecnicatrinidad@gmail.com</small>
                </div>
              </div>
              <div class="flex items-start gap-4 p-4 hover:bg-gradient-to-r hover:from-blue-50 hover:to-utu-blue hover:bg-opacity-5 rounded-xl transition-all duration-200 group">
                <i class="fas fa-clock text-utu-blue text-lg mt-1 group-hover:scale-110 transition-transform duration-300"></i>
                <div>
                  <strong class="block text-utu-blue font-semibold mb-1">Horario</strong>
                  <small class="text-gray-600 text-sm">Lun a Vie: 7:00 - 23:30</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Botones de Usuario Mejorados -->
        <div class="flex items-center gap-3 user-buttons" id="userMenu">
          <?php if ($isLoggedIn && !empty($userName)): ?>
            <!-- Botones para ADMIN y DOCENTE -->
            <?php if ($userRol === 'ADMIN' || $userRol === 'DOCENTE'): ?>
              <div class="flex items-center gap-3 hero-buttons">
                <!-- Botón de Chat -->
                <button onclick="goToChat()" 
                        class="btn-modern from-utu-green to-green-600 text-white font-semibold px-4 py-3 flex items-center gap-2 relative">
                  <i class="fas fa-comments"></i>
                  <span class="hidden sm:inline">Chat</span>
                  <div id="chat-notification" class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full hidden"></div>
                </button>
                
                <!-- Botón de Gestionar Noticias (solo ADMIN) -->
                <?php if ($userRol === 'ADMIN'): ?>
                  <button onclick="goToGestion()" 
                          class="btn-modern from-utu-purple to-purple-600 text-white font-semibold px-4 py-3 flex items-center gap-2">
                    <i class="fas fa-newspaper"></i>
                    <span class="hidden sm:inline">Gestionar</span>
                  </button>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <!-- Información del usuario mejorada -->
            <div class="flex items-center gap-3 bg-white bg-opacity-10 rounded-xl px-4 py-3 border border-white border-opacity-20 backdrop-blur-sm">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-utu-yellow to-utu-orange flex items-center justify-center text-white font-bold text-sm">
                  <?php echo strtoupper(substr($userName, 0, 1)); ?>
                </div>
                <div class="flex flex-col">
                  <span class="text-white font-semibold text-sm">¡Hola, <?php echo htmlspecialchars(explode(' ', $userName)[0]); ?>!</span>
                  <span class="user-badge text-xs"><?php echo $userRol; ?></span>
                </div>
              </div>
            </div>
            
            <!-- Botón de Cerrar Sesión Mejorado -->
            <button onclick="logout()" 
                    class="btn-modern from-red-500 to-red-600 text-white font-semibold px-4 py-3 flex items-center gap-2 hover:from-red-600 hover:to-red-700">
              <i class="fas fa-sign-out-alt"></i>
              <span class="hidden sm:inline">Salir</span>
            </button>
          <?php else: ?>
            <button onclick="goToLogin()" 
                    class="btn-modern from-utu-orange to-utu-yellow text-white font-semibold px-6 py-3 flex items-center gap-2">
              <i class="fas fa-sign-in-alt"></i>
              <span>Acceder</span>
            </button>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- MAIN CONTAINER -->
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 sm:pt-8 pb-6 sm:pb-8 flex-1 w-full">
    
    <!-- Banner Carousel Mejorado -->
    <div class="relative w-full mb-8 sm:mb-12 overflow-hidden rounded-2xl sm:rounded-3xl shadow-2xl" id="carousel">
      <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white z-10 bg-black bg-opacity-80 px-8 py-6 rounded-2xl loading-text flex items-center gap-3">
        <div class="w-6 h-6 border-2 border-utu-yellow border-t-transparent rounded-full animate-spin"></div>
        <span class="text-lg font-medium">Cargando información...</span>
      </div>
      
      <!-- Controles Mejorados -->
      <div class="carousel-controls absolute top-1/2 -translate-y-1/2 w-full flex justify-between px-4 sm:px-6 z-20">
        <button onclick="prevSlide()" 
                class="w-10 h-10 sm:w-12 sm:h-12 bg-white bg-opacity-20 text-white rounded-full hover:bg-opacity-30 hover:scale-110 hover:shadow-2xl transition-all duration-300 flex items-center justify-center backdrop-blur-md border border-white border-opacity-30">
          <i class="fas fa-chevron-left text-lg"></i>
        </button>
        <button onclick="nextSlide()" 
                class="w-10 h-10 sm:w-12 sm:h-12 bg-white bg-opacity-20 text-white rounded-full hover:bg-opacity-30 hover:scale-110 hover:shadow-2xl transition-all duration-300 flex items-center justify-center backdrop-blur-md border border-white border-opacity-30">
          <i class="fas fa-chevron-right text-lg"></i>
        </button>
      </div>
      
      <!-- Indicadores Mejorados -->
      <div id="indicators" class="carousel-indicators absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20"></div>
    </div>
    <br>
    <br>
    <!-- Eventos/Noticias Mejorados -->
    <div class="news-section ">
      <div class="flex items-center justify-between mb-6 sm:mb-8">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-utu-blue flex items-center gap-3">
          <div class="w-12 h-12 rounded-2xl bg-gradient-to-r from-utu-orange to-utu-yellow flex items-center justify-center">
            <i class="fas fa-calendar-alt text-white text-xl"></i>
          </div>
          Eventos y Noticias
        </h2>
        <div class="text-sm text-gray-500 bg-gray-100 px-3 py-2 rounded-lg">
          <i class="fas fa-info-circle text-utu-blue mr-2"></i>
          Actualizado recientemente
        </div>
      </div>
      <div id="eventos-container">
        <div class="loading-text text-center text-gray-600 py-12 flex flex-col items-center gap-4">
          <div class="w-12 h-12 border-4 border-utu-blue border-t-transparent rounded-full animate-spin"></div>
          <span class="text-lg font-medium">Cargando eventos...</span>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER MEJORADO -->
  <footer class="footer-gradient text-gray-300 pt-16 mt-16 shadow-2xl">
    <div class="footer-container max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
        
        <!-- Logo y Social Mejorado -->
        <div class="footer-section">
          <div class="footer-logo mb-6">
            <h3 class="text-3xl font-bold bg-gradient-to-r from-utu-yellow to-utu-orange bg-clip-text text-transparent mb-2">UTU TRINIDAD</h3>
            <p class="text-utu-yellow text-sm font-medium mb-4">Escuela Técnica Trinidad Flores</p>
          </div>
          <p class="text-gray-400 text-sm leading-relaxed mb-6">
            Formando profesionales técnicos con excelencia académica desde 1942.
            Educación de calidad para el desarrollo del país.
          </p>
          <div class="footer-social flex gap-3">
            <a href="#" class="social-icon w-10 h-10 rounded-xl flex items-center justify-center text-utu-yellow hover:shadow-lg">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon w-10 h-10 rounded-xl flex items-center justify-center text-utu-yellow hover:shadow-lg">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon w-10 h-10 rounded-xl flex items-center justify-center text-utu-yellow hover:shadow-lg">
              <i class="fab fa-instagram"></i>
            </a>
            <a href="#" class="social-icon w-10 h-10 rounded-xl flex items-center justify-center text-utu-yellow hover:shadow-lg">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </div>

        <!-- Enlaces Rápidos Mejorado -->
        <div class="footer-section">
          <h4 class="text-white text-lg font-semibold mb-6 pb-2 border-b-2 border-utu-yellow inline-block">Enlaces Rápidos</h4>
          <ul class="space-y-3">
            <li><a href="#" class="text-gray-400 text-sm hover:text-utu-yellow hover:pl-2 transition-all duration-300 flex items-center gap-2">
              <i class="fas fa-chevron-right text-xs"></i> Inicio
            </a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-utu-yellow hover:pl-2 transition-all duration-300 flex items-center gap-2">
              <i class="fas fa-chevron-right text-xs"></i> Sobre Nosotros
            </a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-utu-yellow hover:pl-2 transition-all duration-300 flex items-center gap-2">
              <i class="fas fa-chevron-right text-xs"></i> Carreras y Cursos
            </a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-utu-yellow hover:pl-2 transition-all duration-300 flex items-center gap-2">
              <i class="fas fa-chevron-right text-xs"></i> Inscripciones
            </a></li>
          </ul>
        </div>

        <!-- Servicios Mejorado -->
        <div class="footer-section">
          <h4 class="text-white text-lg font-semibold mb-6 pb-2 border-b-2 border-utu-yellow inline-block">Servicios</h4>
          <ul class="space-y-3">
            <li><a href="#" class="text-gray-400 text-sm hover:text-utu-yellow hover:pl-2 transition-all duration-300 flex items-center gap-2">
              <i class="fas fa-chevron-right text-xs"></i> Biblioteca Virtual
            </a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-utu-yellow hover:pl-2 transition-all duration-300 flex items-center gap-2">
              <i class="fas fa-chevron-right text-xs"></i> Plataforma Educativa
            </a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-utu-yellow hover:pl-2 transition-all duration-300 flex items-center gap-2">
              <i class="fas fa-chevron-right text-xs"></i> Bedelía Online
            </a></li>
            <li><a href="login" class="text-gray-400 text-sm hover:text-utu-yellow hover:pl-2 transition-all duration-300 flex items-center gap-2">
              <i class="fas fa-chevron-right text-xs"></i> Portal Estudiantes
            </a></li>
          </ul>
        </div>

        <!-- Contacto Mejorado -->
        <div class="footer-section">
          <h4 class="text-white text-lg font-semibold mb-6 pb-2 border-b-2 border-utu-yellow inline-block">Contacto</h4>
          <ul class="space-y-4">
            <li class="flex items-start gap-3 text-sm text-gray-400">
              <i class="fas fa-map-marker-alt text-utu-yellow mt-1"></i>
              <span>25 de agosto Nº 427<br>Trinidad, Flores</span>
            </li>
            <li class="flex items-start gap-3 text-sm text-gray-400">
              <i class="fas fa-phone text-utu-yellow mt-1"></i>
              <span>4364 8962 - 4364 2426</span>
            </li>
            <li class="flex items-start gap-3 text-sm text-gray-400">
              <i class="fas fa-envelope text-utu-yellow mt-1"></i>
              <span>tecnicatrinidad@gmail.com</span>
            </li>
            <li class="flex items-start gap-3 text-sm text-gray-400">
              <i class="fas fa-clock text-utu-yellow mt-1"></i>
              <span>Lun - Vie: 7:00 - 23:30</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <!-- Footer Bottom Mejorado -->
    <div class="bg-black bg-opacity-30 py-6 border-t border-utu-yellow border-opacity-20">
      <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-gray-400 text-sm text-center md:text-left">
          &copy; 2025 Escuela Técnica Trinidad Flores (UTU). Todos los derechos reservados.
        </p>
        <div class="flex items-center gap-4 text-sm">
          <a href="#" class="text-gray-400 hover:text-utu-yellow transition-colors duration-300">Privacidad</a>
          <span class="text-utu-yellow text-opacity-40">•</span>
          <a href="#" class="text-gray-400 hover:text-utu-yellow transition-colors duration-300">Términos</a>
          <span class="text-utu-yellow text-opacity-40">•</span>
          <a href="#" class="text-gray-400 hover:text-utu-yellow transition-colors duration-300">Mapa del Sitio</a>
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
        d.className = 'indicator w-3 h-3 rounded-full cursor-pointer transition-all duration-300 border-2 ' + 
          (i === 0 ? 'active bg-utu-yellow border-utu-yellow scale-125 shadow-lg' : 'bg-white bg-opacity-50 border-white border-opacity-50');
        d.onclick = () => goToSlide(i); 
        cont.appendChild(d); 
      }
    }
    
    // Navegación
    function goToChat() {
      window.location.href = 'chat';
    }

    function goToGestion() {
      window.location.href = 'adminDashboard';
    }

    function goToLogin() {
      window.location.href = 'login';
    }

    // Función para mostrar notificaciones mejorada
    function showNotification(message, type = 'success') {
      const notification = document.createElement('div');
      const bgColor = type === 'success' ? 'bg-gradient-to-r from-utu-green to-green-600' : 'bg-gradient-to-r from-red-500 to-red-600';
      
      notification.className = `notification-toast fixed top-6 right-6 px-6 py-4 rounded-2xl text-white font-semibold z-[10000] shadow-2xl ${bgColor} flex items-center gap-3`;
      notification.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'} text-xl"></i>
        <span>${message}</span>
      `;
      
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100px)';
        setTimeout(() => notification.remove(), 300);
      }, 3000);
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
        noData.className = 'absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white z-10 bg-black bg-opacity-80 px-8 py-6 rounded-2xl text-lg font-medium flex items-center gap-3';
        noData.innerHTML = `
          <i class="fas fa-info-circle text-utu-yellow text-xl"></i>
          <span>No hay información disponible</span>
        `;
        c.appendChild(noData);
        return;
      }
      
      postsConImagen.forEach((post, idx) => {
        const s = document.createElement('div');
        s.className = 'carousel-item relative w-full h-[400px] sm:h-[500px] lg:h-[600px]' + (idx === 0 ? ' active' : ' hidden');
        
        const imageUrl = `data:image/jpeg;base64,${post.imagen}`;
        const fecha = new Date(post.fecha_publicacion).toLocaleDateString('es-UY', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        
        s.innerHTML = `
          <img src="${imageUrl}" alt="${post.titulo}" class="w-full h-full object-cover" onerror="this.style.display='none'">
          <div class="carousel-overlay absolute bottom-0 left-0 right-0 text-white px-6 sm:px-10 lg:px-16 pt-16 pb-8 sm:pb-12">
            <h3 class="text-2xl sm:text-3xl lg:text-4xl xl:text-5xl font-bold mb-4 leading-tight drop-shadow-2xl">${post.titulo}</h3>
            <p class="text-gray-200 text-base sm:text-lg lg:text-xl leading-relaxed max-w-4xl mb-6 drop-shadow line-clamp-2">${post.contenido}</p>
            <div class="flex items-center gap-6 text-sm sm:text-base text-utu-yellow font-semibold">
              <span class="flex items-center gap-2">
                <i class="fas fa-user"></i> ${post.autor.nombre}
              </span>
              <span class="flex items-center gap-2">
                <i class="fas fa-calendar"></i> ${fecha}
              </span>
            </div>
          </div>
        `; 
        c.appendChild(s);
      });
      
      c.appendChild(ctr);
      c.appendChild(ind);
      
      carouselSlides = c.querySelectorAll('.carousel-item'); 
      createIndicators(carouselSlides.length); 
      showSlide(0);
    }
    
    // Cargar eventos/noticias MEJORADO
    function cargarEventos(eventos){
      const cont = document.getElementById('eventos-container'); 
      const loading = cont.querySelector('.loading-text');
      
      if (loading) loading.remove();
      cont.innerHTML = ''; 
      
      if(!eventos.length){
        const m = document.createElement('div');
        m.className = 'text-center text-gray-600 py-12 flex flex-col items-center gap-4';
        m.innerHTML = `
          <i class="fas fa-calendar-times text-4xl text-utu-blue opacity-50"></i>
          <span class="text-lg font-medium">No hay eventos disponibles</span>
          <p class="text-gray-500 text-sm">Vuelve pronto para ver las próximas actividades</p>
        `;
        cont.appendChild(m);
        return;
      }

      // Crear grid de eventos mejorado
      const grid = document.createElement('div');
      grid.className = 'event-grid grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6';
      
      eventos.forEach(evento => {
        const it = document.createElement('div');
        it.className = 'event-card group cursor-pointer';
        
        const fecha = new Date(evento.fecha_evento).toLocaleDateString('es-UY', {
          day: 'numeric',
          month: 'long',
          year: 'numeric'
        });
        
        const hora = new Date(evento.fecha_evento).toLocaleTimeString('es-UY', {
          hour: '2-digit',
          minute: '2-digit'
        });
        
        it.innerHTML = `
          <div class="flex justify-between items-start mb-4">
            <div class="event-date">${fecha}</div>
            <div class="text-utu-orange font-semibold text-sm bg-orange-50 px-3 py-1 rounded-lg">${hora}</div>
          </div>
          <h3 class="text-xl font-bold text-utu-blue mb-3 group-hover:text-utu-orange transition-colors duration-300">${evento.titulo}</h3>
          <p class="text-gray-600 leading-relaxed mb-4 line-clamp-3">${evento.descripcion}</p>
          <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <div class="flex items-center gap-2 text-sm text-gray-500">
              <i class="fas fa-user text-utu-blue"></i>
              <span>${evento.autor.nombre}</span>
            </div>
            <div class="text-utu-blue group-hover:text-utu-orange transition-colors duration-300">
              <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform duration-300"></i>
            </div>
          </div>
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
          }, 1500);
        }
      } catch (error) {
        console.log("Error al cerrar sesión:", error);
        showNotification('Error al cerrar sesión', 'error');
      }
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
        errorDiv.className = 'text-center text-red-600 py-12 flex flex-col items-center gap-3';
        errorDiv.innerHTML = `
          <i class="fas fa-exclamation-triangle text-3xl"></i>
          <span class="text-lg font-medium">Error al cargar la información</span>
          <button onclick="cargarDatos()" class="btn-modern from-utu-blue to-utu-blue-light text-white px-6 py-3 mt-4">
            <i class="fas fa-redo mr-2"></i> Reintentar
          </button>
        `;
        
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
      }, 6000);
    }

    // Inicialización
    window.onload = () => {
      cargarDatos();
    };
  </script>
</body>
</html>