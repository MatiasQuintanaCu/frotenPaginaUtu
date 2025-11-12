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
            'utu-blue-dark': '#002244',
            'utu-gray': '#4a5568',
            'utu-gray-light': '#718096',
            'utu-green': '#2d7744',
            'utu-red': '#c53030',
          },
          fontFamily: {
            'sans': ['Segoe UI', 'Roboto', 'Arial', 'sans-serif'],
          }
        }
      }
    }
  </script>
  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
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
    
    /* Estilos mejorados para institución pública */
    .nav-institutional {
      background: #003366;
      border-bottom: 2px solid #2d7744;
    }
    
    .btn-institutional {
      background-color: #003366;
      color: white;
      border-radius: 4px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.2s ease;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .btn-institutional:hover {
      background-color: #002244;
      transform: translateY(-1px);
    }
    
    .btn-secondary {
      background-color: #2d7744;
      color: white;
      border-radius: 4px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.2s ease;
    }
    
    .btn-secondary:hover {
      background-color: #236335;
    }
    
    .event-card {
      background: white;
      border-radius: 6px;
      padding: 20px;
      border: 1px solid #e2e8f0;
      transition: all 0.2s ease;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }
    
    .event-card:hover {
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    .event-date {
      background: #003366;
      color: white;
      padding: 6px 12px;
      border-radius: 4px;
      font-weight: 600;
      font-size: 0.875rem;
    }
    
    .user-badge {
      background: #2d7744;
      color: white;
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 0.75rem;
      font-weight: 600;
    }
    
    .footer-institutional {
      background: #002244;
    }
    
    .section-title {
      border-bottom: 2px solid #2d7744;
      padding-bottom: 8px;
      margin-bottom: 20px;
      color: #003366;
    }
    
    .institutional-logo {
      border: 2px solid #2d7744;
    }
    
    .accent-color {
      color: #2d7744;
    }
    
    .bg-accent {
      background-color: #2d7744;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
      .hero-buttons {
        flex-direction: column;
        gap: 10px;
      }
      
      .event-grid {
        grid-template-columns: 1fr;
        gap: 16px;
      }
    }
  </style>
</head>

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col font-sans">

  <!-- NAV -->
  <nav class="nav-institutional text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
      <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
        
        <!-- Logo y Marca -->
        <div class="flex items-center gap-4">
          <div class="relative">
            <img id="LogoUtu" 
                 src="./assets/img/logo.webp" 
                 alt="Logo UTU"
                 class="w-14 h-14 md:w-16 md:h-16 institutional-logo rounded-lg shadow-md">
          </div>
          <div class="flex flex-col text-center lg:text-left">
            <span class="text-lg sm:text-xl lg:text-2xl font-bold">
              UTU - Trinidad Flores
            </span>
            <span class="text-xs text-gray-300 font-medium mt-1">
              Educación Técnica de Excelencia
            </span>
          </div>
        </div>
        
        <!-- Dropdown Contacto -->
        <div class="relative dropdown" id="contactDropdown">
          <button onclick="toggleDropdown()" 
                  class="btn-institutional font-semibold px-4 py-2 flex items-center gap-2">
            <i class="fas fa-phone-alt"></i>
            <span>Contacto</span>
            <i class="fas fa-chevron-down text-xs"></i>
          </button>
          <div class="dropdown-menu absolute right-0 mt-2 bg-white rounded-md min-w-[280px] shadow-lg overflow-hidden z-50 border border-gray-200">
            <div class="p-2">
              <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded transition-all duration-200">
                <i class="fas fa-map-marker-alt text-utu-blue mt-1"></i>
                <div>
                  <strong class="block text-utu-blue font-semibold mb-1">Sede Central</strong>
                  <small class="text-gray-600 text-sm">25 de agosto Nº 427 esq. Batlle y Ordoñez</small>
                </div>
              </div>
              <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded transition-all duration-200">
                <i class="fas fa-phone text-utu-blue mt-1"></i>
                <div>
                  <strong class="block text-utu-blue font-semibold mb-1">Teléfono</strong>
                  <small class="text-gray-600 text-sm">4364 8962 - 4364 2426</small>
                </div>
              </div>
              <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded transition-all duration-200">
                <i class="fas fa-envelope text-utu-blue mt-1"></i>
                <div>
                  <strong class="block text-utu-blue font-semibold mb-1">Correo</strong>
                  <small class="text-gray-600 text-sm">tecnicatrinidad@gmail.com</small>
                </div>
              </div>
              <div class="flex items-start gap-3 p-3 hover:bg-gray-50 rounded transition-all duration-200">
                <i class="fas fa-clock text-utu-blue mt-1"></i>
                <div>
                  <strong class="block text-utu-blue font-semibold mb-1">Horario</strong>
                  <small class="text-gray-600 text-sm">Lun a Vie: 7:00 - 23:30</small>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Botones de Usuario -->
        <div class="flex items-center gap-3 user-buttons" id="userMenu">
          <?php if ($isLoggedIn && !empty($userName)): ?>
            <?php if ($userRol === 'ADMIN' || $userRol === 'DOCENTE'): ?>
              <div class="flex items-center gap-3 hero-buttons">
                <button onclick="goToChat()" 
                        class="btn-institutional font-semibold px-3 py-2 flex items-center gap-2">
                  <i class="fas fa-comments"></i>
                  <span class="hidden sm:inline">Chat</span>
                </button>
                
                <?php if ($userRol === 'ADMIN'): ?>
                  <button onclick="goToGestion()" 
                          class="btn-institutional font-semibold px-3 py-2 flex items-center gap-2">
                    <i class="fas fa-newspaper"></i>
                    <span class="hidden sm:inline">Gestionar</span>
                  </button>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <!-- Información del usuario -->
            <div class="flex items-center gap-3 bg-white bg-opacity-10 rounded-lg px-3 py-2">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-accent flex items-center justify-center text-white font-bold text-sm">
                  <?php echo strtoupper(substr($userName, 0, 1)); ?>
                </div>
                <div class="flex flex-col">
                  <span class="text-white font-semibold text-sm"><?php echo htmlspecialchars(explode(' ', $userName)[0]); ?></span>
                  <span class="user-badge text-xs"><?php echo $userRol; ?></span>
                </div>
              </div>
            </div>
            
            <!-- Botón de Cerrar Sesión -->
            <button onclick="logout()" 
                    class="btn-secondary font-semibold px-3 py-2 flex items-center gap-2">
              <i class="fas fa-sign-out-alt"></i>
              <span class="hidden sm:inline">Salir</span>
            </button>
          <?php else: ?>
            <button onclick="goToLogin()" 
                    class="btn-secondary font-semibold px-4 py-2 flex items-center gap-2">
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
    
    <!-- Banner Carousel MEJORADO -->
    <div class="relative w-full mb-8 sm:mb-10 overflow-hidden rounded-lg shadow-md h-[400px] sm:h-[500px] lg:h-[600px] bg-gray-200">
      
      <!-- Loading State -->
      <div id="loading-carousel" class="absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-30">
        <div class="bg-black bg-opacity-70 px-6 py-4 rounded-lg flex items-center gap-3">
          <div class="w-6 h-6 border-3 border-utu-green border-t-transparent rounded-full animate-spin"></div>
          <span class="text-white font-medium">Cargando información...</span>
        </div>
      </div>

      <!-- Error State -->
      <div id="error-carousel" class="hidden absolute inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 z-30">
        <div class="bg-black bg-opacity-70 px-6 py-4 rounded-lg flex flex-col items-center gap-3 text-center">
          <i class="fas fa-exclamation-triangle text-red-500 text-3xl"></i>
          <span class="text-white font-medium">Error al cargar la información</span>
          <button onclick="cargarDatos()" class="mt-2 px-4 py-2 bg-utu-blue text-white rounded-lg hover:bg-utu-blue/90 transition-colors">
            <i class="fas fa-redo mr-2"></i>Reintentar
          </button>
        </div>
      </div>

      <!-- Empty State -->
      <div id="empty-carousel" class="hidden absolute inset-0 flex items-center justify-center bg-gradient-to-br from-utu-blue to-blue-900 z-30">
        <div class="text-center text-white px-6">
          <i class="fas fa-info-circle text-5xl mb-4 opacity-50"></i>
          <p class="text-xl font-semibold">No hay publicaciones disponibles</p>
          <p class="text-sm opacity-75 mt-2">Vuelve pronto para ver contenido nuevo</p>
        </div>
      </div>

      <!-- Carousel Container -->
      <div id="carousel-slides" class="relative w-full h-full"></div>

      <!-- Controles -->
      <div id="carousel-controls" class="hidden">
        <button onclick="prevSlide()" 
                class="absolute left-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-40 backdrop-blur-sm text-white rounded-full transition-all flex items-center justify-center">
          <i class="fas fa-chevron-left"></i>
        </button>
        <button onclick="nextSlide()" 
                class="absolute right-4 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-40 backdrop-blur-sm text-white rounded-full transition-all flex items-center justify-center">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>

      <!-- Indicadores -->
      <div id="carousel-indicators" class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2"></div>
    </div>

    <!-- Eventos/Noticias -->
    <div class="news-section">
      <h2 class="section-title text-2xl sm:text-3xl font-bold mb-6">
        Eventos y Noticias
      </h2>
      <div id="eventos-container">
        <div class="loading-text text-center text-gray-600 py-12 flex flex-col items-center gap-4">
          <div class="w-10 h-10 border-4 border-utu-blue border-t-transparent rounded-full animate-spin"></div>
          <span class="text-base font-medium">Cargando eventos...</span>
        </div>
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="footer-institutional text-gray-300 pt-12 mt-12">
    <div class="footer-container max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-10">
        
        <div class="footer-section">
          <div class="footer-logo mb-6">
            <h3 class="text-2xl font-bold text-white mb-2">UTU TRINIDAD</h3>
            <p class="text-accent text-sm font-medium mb-4">Escuela Técnica Trinidad Flores</p>
          </div>
          <p class="text-gray-400 text-sm leading-relaxed mb-6">
            Formando profesionales técnicos con excelencia académica desde 1942.
          </p>
          <div class="footer-social flex gap-3">
            <a href="#" class="w-8 h-8 rounded-md bg-gray-700 flex items-center justify-center text-gray-300 hover:bg-accent transition-colors">
              <i class="fab fa-facebook-f text-sm"></i>
            </a>
            <a href="#" class="w-8 h-8 rounded-md bg-gray-700 flex items-center justify-center text-gray-300 hover:bg-accent transition-colors">
              <i class="fab fa-twitter text-sm"></i>
            </a>
            <a href="#" class="w-8 h-8 rounded-md bg-gray-700 flex items-center justify-center text-gray-300 hover:bg-accent transition-colors">
              <i class="fab fa-instagram text-sm"></i>
            </a>
          </div>
        </div>

        <div class="footer-section">
          <h4 class="text-white text-lg font-semibold mb-4">Enlaces Rápidos</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 text-sm hover:text-accent transition-colors">Inicio</a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-accent transition-colors">Sobre Nosotros</a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-accent transition-colors">Carreras y Cursos</a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-accent transition-colors">Inscripciones</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h4 class="text-white text-lg font-semibold mb-4">Servicios</h4>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 text-sm hover:text-accent transition-colors">Biblioteca Virtual</a></li>
            <li><a href="#" class="text-gray-400 text-sm hover:text-accent transition-colors">Plataforma Educativa</a></li>
            <li><a href="login" class="text-gray-400 text-sm hover:text-accent transition-colors">Portal Estudiantes</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h4 class="text-white text-lg font-semibold mb-4">Contacto</h4>
          <ul class="space-y-3">
            <li class="flex items-start gap-3 text-sm text-gray-400">
              <i class="fas fa-map-marker-alt text-accent mt-1"></i>
              <span>25 de agosto Nº 427<br>Trinidad, Flores</span>
            </li>
            <li class="flex items-start gap-3 text-sm text-gray-400">
              <i class="fas fa-phone text-accent mt-1"></i>
              <span>4364 8962 - 4364 2426</span>
            </li>
            <li class="flex items-start gap-3 text-sm text-gray-400">
              <i class="fas fa-envelope text-accent mt-1"></i>
              <span>tecnicatrinidad@gmail.com</span>
            </li>
            <li class="flex items-start gap-3 text-sm text-gray-400">
              <i class="fas fa-clock text-accent mt-1"></i>
              <span>Lun - Vie: 7:00 - 23:30</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="bg-black bg-opacity-30 py-4 border-t border-gray-700">
      <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <p class="text-gray-400 text-sm text-center md:text-left">
          &copy; 2025 Escuela Técnica Trinidad Flores (UTU). Todos los derechos reservados.
        </p>
        <div class="flex items-center gap-4 text-sm">
          <a href="#" class="text-gray-400 hover:text-accent transition-colors">Privacidad</a>
          <span class="text-gray-600">•</span>
          <a href="#" class="text-gray-400 hover:text-accent transition-colors">Términos</a>
          <span class="text-gray-600">•</span>
          <a href="#" class="text-gray-400 hover:text-accent transition-colors">Mapa del Sitio</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    let currentSlide = 0;
    let carouselSlides = [];
    let autoAdvanceInterval = null;

    // Dropdown
    function toggleDropdown() {
      document.getElementById('contactDropdown').classList.toggle('active');
    }
    document.addEventListener('click', e => {
      if (!document.getElementById('contactDropdown').contains(e.target)) {
        document.getElementById('contactDropdown').classList.remove('active');
      }
    });

    // Navegación
    function goToChat() { window.location.href = 'chat'; }
    function goToGestion() { window.location.href = 'adminDashboard'; }
    function goToLogin() { window.location.href = 'login'; }

    function showNotification(message, type = 'success') {
      const notification = document.createElement('div');
      const bgColor = type === 'success' ? 'bg-utu-green' : 'bg-utu-red';
      notification.className = `fixed top-6 right-6 px-6 py-3 rounded-md text-white font-semibold z-[10000] shadow-lg ${bgColor} flex items-center gap-3`;
      notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
      document.body.appendChild(notification);
      setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transform = 'translateX(100px)';
        setTimeout(() => notification.remove(), 300);
      }, 3000);
    }

    async function logout() {
      try {
        const res = await fetch("/api/v1/user/logout", { method: "POST", credentials: "include" });
        const data = await res.json();
        if (data.success) {
          showNotification('Sesión cerrada correctamente', 'success');
          setTimeout(() => window.location.reload(), 1500);
        }
      } catch (error) {
        showNotification('Error al cerrar sesión', 'error');
      }
    }

    // ========== CARRUSEL MEJORADO ==========
    function createSlide(post, index) {
      const slide = document.createElement('div');
      slide.className = `absolute inset-0 transition-opacity duration-500 ${index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'}`;
      
      const fecha = new Date(post.fecha_publicacion).toLocaleDateString('es-UY', {
        year: 'numeric', month: 'long', day: 'numeric'
      });

      // Usar la imagen base64 del post
      const imageUrl = `data:image/jpeg;base64,${post.imagen}`;
      
      slide.innerHTML = `
        <img src="${imageUrl}" alt="${post.titulo}" class="absolute inset-0 w-full h-full object-cover"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 800 600%22%3E%3Crect fill=%22%23003366%22 width=%22800%22 height=%22600%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 dominant-baseline=%22middle%22 text-anchor=%22middle%22 fill=%22white%22 font-size=%2224%22%3ESin imagen%3C/text%3E%3C/svg%3E'">
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/60 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-6 sm:p-8 lg:p-12 text-white z-10">
          <div class="max-w-4xl">
            <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold mb-3 sm:mb-4 leading-tight drop-shadow-lg">${post.titulo}</h2>
            <p class="text-sm sm:text-base lg:text-lg text-gray-200 mb-4 sm:mb-6 leading-relaxed line-clamp-2 drop-shadow-md">${post.contenido}</p>
            <div class="flex flex-wrap items-center gap-3 sm:gap-4 text-xs sm:text-sm">
              <span class="flex items-center gap-2 bg-utu-green px-3 py-1.5 rounded-full font-semibold">
                <i class="fas fa-user"></i> ${post.autor.nombre}
              </span>
              <span class="flex items-center gap-2 bg-white bg-opacity-20 backdrop-blur-sm px-3 py-1.5 rounded-full font-semibold">
                <i class="fas fa-calendar"></i> ${fecha}
              </span>
            </div>
          </div>
        </div>
      `;
      return slide;
    }

    function createIndicators(count) {
      const container = document.getElementById('carousel-indicators');
      container.innerHTML = '';
      for (let i = 0; i < count; i++) {
        const indicator = document.createElement('button');
        indicator.className = `w-2 h-2 rounded-full transition-all duration-300 ${i === 0 ? 'bg-utu-green w-8' : 'bg-white bg-opacity-50 hover:bg-opacity-75'}`;
        indicator.onclick = () => goToSlide(i);
        container.appendChild(indicator);
      }
    }

    function updateIndicators() {
      const indicators = document.querySelectorAll('#carousel-indicators button');
      indicators.forEach((indicator, index) => {
        indicator.className = index === currentSlide 
          ? 'w-8 h-2 rounded-full transition-all duration-300 bg-utu-green'
          : 'w-2 h-2 rounded-full transition-all duration-300 bg-white bg-opacity-50 hover:bg-opacity-75';
      });
    }

    function showSlide(index) {
      carouselSlides.forEach((slide, i) => {
        if (i === index) {
          slide.classList.remove('opacity-0', 'z-0');
          slide.classList.add('opacity-100', 'z-10');
        } else {
          slide.classList.remove('opacity-100', 'z-10');
          slide.classList.add('opacity-0', 'z-0');
        }
      });
      updateIndicators();
    }

    function nextSlide() {
      if (carouselSlides.length === 0) return;
      currentSlide = (currentSlide + 1) % carouselSlides.length;
      showSlide(currentSlide);
      resetAutoAdvance();
    }

    function prevSlide() {
      if (carouselSlides.length === 0) return;
      currentSlide = (currentSlide - 1 + carouselSlides.length) % carouselSlides.length;
      showSlide(currentSlide);
      resetAutoAdvance();
    }

    function goToSlide(index) {
      currentSlide = index;
      showSlide(currentSlide);
      resetAutoAdvance();
    }

    function startAutoAdvance() {
      if (carouselSlides.length <= 1) return;
      autoAdvanceInterval = setInterval(() => nextSlide(), 5000);
    }

    function resetAutoAdvance() {
      if (autoAdvanceInterval) {
        clearInterval(autoAdvanceInterval);
        startAutoAdvance();
      }
    }

    // ========== CARGAR DATOS DEL CARRUSEL ==========
    function cargarInformacionGeneral(posts) {
      const loading = document.getElementById('loading-carousel');
      const errorDiv = document.getElementById('error-carousel');
      const emptyDiv = document.getElementById('empty-carousel');
      const controls = document.getElementById('carousel-controls');
      const slidesContainer = document.getElementById('carousel-slides');
      
      // Ocultar estados anteriores
      loading.classList.add('hidden');
      errorDiv.classList.add('hidden');
      emptyDiv.classList.add('hidden');
      
      // Limpiar slides anteriores
      slidesContainer.innerHTML = '';
      carouselSlides = [];
      
      const postsConImagen = posts.filter(post => post.imagen);
      
      if (postsConImagen.length === 0) {
        emptyDiv.classList.remove('hidden');
        return;
      }
      
      // Crear slides
      postsConImagen.forEach((post, index) => {
        const slide = createSlide(post, index);
        slidesContainer.appendChild(slide);
        carouselSlides.push(slide);
      });
      
      // Mostrar controles si hay más de un slide
      if (postsConImagen.length > 1) {
        controls.classList.remove('hidden');
        createIndicators(postsConImagen.length);
        startAutoAdvance();
      }
      
      showSlide(0);
    }

    // ========== CARGAR EVENTOS ==========
    function cargarEventos(eventos) {
      const cont = document.getElementById('eventos-container');
      const loading = cont.querySelector('.loading-text');
      if (loading) loading.remove();
      cont.innerHTML = '';
      
      if (!eventos.length) {
        cont.innerHTML = `
          <div class="text-center text-gray-600 py-12 flex flex-col items-center gap-4">
            <i class="fas fa-calendar-times text-3xl text-utu-blue opacity-50"></i>
            <span class="text-base font-medium">No hay eventos disponibles</span>
          </div>`;
        return;
      }

      const grid = document.createElement('div');
      grid.className = 'event-grid grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6';
      
      eventos.forEach(evento => {
        const fecha = new Date(evento.fecha_evento).toLocaleDateString('es-UY', {
          day: 'numeric', month: 'long', year: 'numeric'
        });
        
        const it = document.createElement('div');
        it.className = 'event-card';
        it.innerHTML = `
          <div class="flex justify-between items-start mb-4">
            <div class="event-date">${fecha}</div>
          </div>
          <h3 class="text-lg font-bold text-utu-blue mb-3">${evento.titulo}</h3>
          <p class="text-gray-600 leading-relaxed mb-4 line-clamp-3">${evento.descripcion}</p>
          <div class="flex items-center justify-between pt-4 border-t border-gray-200">
            <div class="flex items-center gap-2 text-sm text-gray-500">
              <i class="fas fa-user text-utu-blue"></i>
              <span>${evento.autor.nombre}</span>
            </div>
          </div>
        `;
        grid.appendChild(it);
      });
      
      cont.appendChild(grid);
    }

    // ========== CARGAR TODOS LOS DATOS ==========
    async function cargarDatos() {
      try {
        // Mostrar loading
        document.getElementById('loading-carousel').classList.remove('hidden');
        document.getElementById('error-carousel').classList.add('hidden');
        
        // Cargar posts para el carrusel
        const postsResponse = await fetch('/api/v1/home/getPost');
        if (!postsResponse.ok) throw new Error(`Error HTTP posts: ${postsResponse.status}`);
        const postsData = await postsResponse.json();
        
        if (postsData.status === 'success') {
          cargarInformacionGeneral(postsData.data);
        } else {
          throw new Error('Error en la respuesta de posts');
        }

        // Cargar eventos para las noticias
        const eventosResponse = await fetch('/api/v1/home/getEvento');
        if (!eventosResponse.ok) throw new Error(`Error HTTP eventos: ${eventosResponse.status}`);
        const eventosData = await eventosResponse.json();
        
        if (eventosData.status === 'success') {
          cargarEventos(eventosData.data);
        } else {
          throw new Error('Error en la respuesta de eventos');
        }

      } catch (error) {
        console.error('Error cargando datos:', error);
        document.getElementById('loading-carousel').classList.add('hidden');
        document.getElementById('error-carousel').classList.remove('hidden');
        
        const eventosContainer = document.getElementById('eventos-container');
        eventosContainer.querySelector('.loading-text')?.remove();
        eventosContainer.innerHTML = `
          <div class="text-center text-utu-red py-12 flex flex-col items-center gap-3">
            <i class="fas fa-exclamation-triangle text-2xl"></i>
            <span class="text-base font-medium">Error al cargar los eventos</span>
            <button onclick="cargarDatos()" class="btn-institutional px-4 py-2 mt-4">
              <i class="fas fa-redo mr-2"></i> Reintentar
            </button>
          </div>
        `;
      }
    }

    // Inicialización
    window.onload = () => {
      cargarDatos();
    };
  </script>
</body>
</html>