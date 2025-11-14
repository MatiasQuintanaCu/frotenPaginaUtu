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
            'primary': '#0A2540',
            'primary-light': '#1A3A5F',
            'accent': '#00A67E',
            'accent-dark': '#008866',
          }
        }
      }
    }
  </script>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
    }

    /* Navigation */
    .nav-container {
      background: rgba(255, 255, 255, 0.98);
      backdrop-filter: blur(10px);
      border-bottom: 1px solid rgba(0, 0, 0, 0.06);
    }

    .nav-link {
      color: #334155;
      font-weight: 500;
      font-size: 0.9375rem;
      transition: color 0.2s ease;
      cursor: pointer;
    }

    .nav-link:hover {
      color: #00A67E;
    }

    /* Hero Carousel - Fixed positioning */
    .carousel-wrapper {
      position: relative;
      width: 100%;
      height: 560px;
      overflow: hidden;
      background: #0A2540;
    }

    @media (max-width: 768px) {
      .carousel-wrapper {
        height: 400px;
      }
    }

    .carousel-slide {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      transition: opacity 0.7s ease-in-out;
      pointer-events: none;
    }

    .carousel-slide.active {
      opacity: 1;
      z-index: 1;
      pointer-events: auto;
    }

    .carousel-slide img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .hero-overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: linear-gradient(135deg, rgba(10, 37, 64, 0.92) 0%, rgba(10, 37, 64, 0.75) 100%);
      z-index: 1;
    }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 700px;
    }

    /* Cards */
    .event-card {
      background: white;
      border-radius: 12px;
      border: 1px solid rgba(0, 0, 0, 0.08);
      padding: 1.5rem;
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .event-card:hover {
      transform: translateY(-4px);
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
      border-color: rgba(0, 166, 126, 0.2);
    }

    /* Buttons */
    .btn-primary {
      background: #00A67E;
      color: white;
      font-weight: 600;
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      transition: all 0.2s ease;
      border: none;
      font-size: 0.9375rem;
      cursor: pointer;
    }

    .btn-primary:hover {
      background: #008866;
      transform: translateY(-1px);
      box-shadow: 0 4px 12px rgba(0, 166, 126, 0.3);
    }

    .btn-secondary {
      background: white;
      color: #0A2540;
      font-weight: 600;
      padding: 0.75rem 1.5rem;
      border-radius: 8px;
      transition: all 0.2s ease;
      border: 1px solid rgba(0, 0, 0, 0.1);
      font-size: 0.9375rem;
      cursor: pointer;
    }

    .btn-secondary:hover {
      border-color: #00A67E;
      color: #00A67E;
    }

    /* Loading States */
    .spinner {
      border: 3px solid rgba(0, 166, 126, 0.1);
      border-top-color: #00A67E;
      border-radius: 50%;
      width: 40px;
      height: 40px;
      animation: spin 0.8s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    /* Dropdown */
    .dropdown-menu {
      opacity: 0;
      visibility: hidden;
      transform: translateY(-8px);
      transition: all 0.2s ease;
      position: absolute;
      top: 100%;
      right: 0;
      margin-top: 0.75rem;
    }

    .dropdown.active .dropdown-menu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }

    /* Footer */
    .footer-link {
      color: #94A3B8;
      font-size: 0.9375rem;
      transition: color 0.2s ease;
      text-decoration: none;
    }

    .footer-link:hover {
      color: #00A67E;
    }

    /* Carousel Controls */
    .carousel-control {
      width: 48px;
      height: 48px;
      background: rgba(255, 255, 255, 0.9);
      backdrop-filter: blur(8px);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.2s ease;
      border: 1px solid rgba(0, 0, 0, 0.08);
      cursor: pointer;
      z-index: 10;
    }

    .carousel-control:hover {
      background: white;
      transform: scale(1.05);
    }

    .carousel-indicator {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.5);
      transition: all 0.3s ease;
      cursor: pointer;
      border: none;
    }

    .carousel-indicator.active {
      width: 24px;
      border-radius: 4px;
      background: white;
    }

    /* User Badge */
    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: linear-gradient(135deg, #00A67E 0%, #008866 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      font-size: 0.875rem;
    }

    .role-badge {
      background: rgba(0, 166, 126, 0.1);
      color: #00A67E;
      padding: 2px 8px;
      border-radius: 4px;
      font-size: 0.75rem;
      font-weight: 600;
    }

    /* Section spacing */
    .section-events {
      padding-top: 5rem;
      padding-bottom: 5rem;
    }

    @keyframes slideIn {
      from {
        transform: translateX(100%);
        opacity: 0;
      }
      to {
        transform: translateX(0);
        opacity: 1;
      }
    }

    @keyframes slideOut {
      from {
        transform: translateX(0);
        opacity: 1;
      }
      to {
        transform: translateX(100%);
        opacity: 0;
      }
    }
  </style>
</head>

<body class="bg-gray-50">

  <!-- Navigation -->
  <nav class="nav-container sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-center justify-between h-20">
        
        <!-- Logo -->
        <div class="flex items-center gap-4">
          <img src="./assets/img/logo.webp" alt="Logo UTU" class="w-12 h-12 rounded-lg">
          <div>
            <div class="text-xl font-bold text-primary">UTU Trinidad Flores</div>
            <div class="text-xs text-gray-500 font-medium">Educación Técnica</div>
          </div>
        </div>

        <!-- Desktop Actions -->
        <div class="hidden md:flex items-center gap-4">
          
          <!-- Contact Dropdown -->
          <div class="relative dropdown" id="contactDropdown">
            <button onclick="toggleDropdown()" class="nav-link flex items-center gap-2">
              <i class="fas fa-phone text-sm"></i>
              <span>Contacto</span>
              <i class="fas fa-chevron-down text-xs"></i>
            </button>
            <div class="dropdown-menu bg-white rounded-xl shadow-xl w-80 border border-gray-100 overflow-hidden">
              <div class="p-4 space-y-3">
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                  <i class="fas fa-map-marker-alt text-accent mt-1"></i>
                  <div class="text-sm">
                    <div class="font-semibold text-gray-900 mb-1">Dirección</div>
                    <div class="text-gray-600">25 de agosto Nº 427 esq. Batlle y Ordoñez</div>
                  </div>
                </div>
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                  <i class="fas fa-phone text-accent mt-1"></i>
                  <div class="text-sm">
                    <div class="font-semibold text-gray-900 mb-1">Teléfono</div>
                    <div class="text-gray-600">4364 8962 - 4364 2426</div>
                  </div>
                </div>
                <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                  <i class="fas fa-envelope text-accent mt-1"></i>
                  <div class="text-sm">
                    <div class="font-semibold text-gray-900 mb-1">Email</div>
                    <div class="text-gray-600">tecnicatrinidad@gmail.com</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <?php if ($isLoggedIn): ?>
            <?php if ($userRol === 'ADMIN' || $userRol === 'DOCENTE'): ?>
              <button onclick="goToChat()" class="nav-link">
                <i class="fas fa-comments text-sm"></i>
                <span class="ml-2">Chat</span>
              </button>
              <?php if ($userRol === 'ADMIN'): ?>
                <button onclick="goToGestion()" class="nav-link">
                  <i class="fas fa-cog text-sm"></i>
                  <span class="ml-2">Gestión</span>
                </button>
              <?php endif; ?>
            <?php endif; ?>
            
            <div class="flex items-center gap-3 ml-2">
              <div class="flex items-center gap-3 px-3 py-2 rounded-lg bg-gray-50">
                <div class="user-avatar">
                  <?php echo strtoupper(substr($userName, 0, 1)); ?>
                </div>
                <div class="text-left">
                  <div class="text-sm font-semibold text-gray-900">
                    <?php echo htmlspecialchars(explode(' ', $userName)[0]); ?>
                  </div>
                  <div class="role-badge"><?php echo $userRol; ?></div>
                </div>
              </div>
              <button onclick="logout()" class="btn-secondary">
                <i class="fas fa-sign-out-alt text-sm"></i>
              </button>
            </div>
          <?php else: ?>
            <button onclick="goToLogin()" class="btn-primary">
              Acceder
            </button>
          <?php endif; ?>
        </div>

        <!-- Mobile Menu Button -->
        <button class="md:hidden text-gray-600">
          <i class="fas fa-bars text-xl"></i>
        </button>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main>
    
    <!-- Hero Carousel -->
    <div class="carousel-wrapper">
      
      <!-- Loading State -->
      <div id="loading-carousel" class="absolute inset-0 flex items-center justify-center z-20">
        <div class="text-center">
          <div class="spinner mx-auto mb-4"></div>
          <p class="text-white font-medium">Cargando información...</p>
        </div>
      </div>

      <!-- Error State -->
      <div id="error-carousel" class="hidden absolute inset-0 flex items-center justify-center z-20">
        <div class="text-center text-white">
          <i class="fas fa-exclamation-circle text-5xl mb-4 opacity-50"></i>
          <p class="text-xl font-semibold mb-4">Error al cargar contenido</p>
          <button onclick="cargarDatos()" class="btn-primary">
            <i class="fas fa-redo mr-2"></i>Reintentar
          </button>
        </div>
      </div>

      <!-- Empty State -->
      <div id="empty-carousel" class="hidden absolute inset-0 flex items-center justify-center z-20">
        <div class="text-center text-white">
          <i class="fas fa-info-circle text-5xl mb-4 opacity-50"></i>
          <p class="text-xl font-semibold">No hay contenido disponible</p>
        </div>
      </div>

      <!-- Slides Container -->
      <div id="carousel-slides"></div>

      <!-- Controls -->
      <button id="prevBtn" onclick="prevSlide()" class="carousel-control absolute left-6 top-1/2 -translate-y-1/2 hidden">
        <i class="fas fa-chevron-left text-gray-700"></i>
      </button>
      <button id="nextBtn" onclick="nextSlide()" class="carousel-control absolute right-6 top-1/2 -translate-y-1/2 hidden">
        <i class="fas fa-chevron-right text-gray-700"></i>
      </button>

      <!-- Indicators -->
      <div id="carousel-indicators" class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 flex gap-2"></div>
    </div>

    <!-- Events Section -->
    <section class="section-events">
      <div class="max-w-7xl mx-auto px-6">
        <div class="mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-2">Eventos y Noticias</h2>
          <p class="text-gray-600">Mantente informado sobre las últimas novedades</p>
        </div>
        
        <div id="eventos-container">
          <div class="flex items-center justify-center py-20">
            <div class="spinner"></div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer class="bg-primary text-white pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-12">
        
        <div>
          <div class="text-xl font-bold mb-4">UTU Trinidad Flores</div>
          <p class="text-gray-400 text-sm mb-6 leading-relaxed">
            Formando profesionales técnicos con excelencia académica desde 1942
          </p>
          <div class="flex gap-3">
            <a href="#" class="w-10 h-10 rounded-lg bg-white/10 hover:bg-accent transition-colors flex items-center justify-center">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-lg bg-white/10 hover:bg-accent transition-colors flex items-center justify-center">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="w-10 h-10 rounded-lg bg-white/10 hover:bg-accent transition-colors flex items-center justify-center">
              <i class="fab fa-instagram"></i>
            </a>
          </div>
        </div>

        <div>
          <h4 class="font-semibold mb-4">Navegación</h4>
          <ul class="space-y-2">
            <li><a href="#" class="footer-link">Inicio</a></li>
            <li><a href="#" class="footer-link">Carreras</a></li>
            <li><a href="#" class="footer-link">Inscripciones</a></li>
            <li><a href="#" class="footer-link">Contacto</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-4">Recursos</h4>
          <ul class="space-y-2">
            <li><a href="#" class="footer-link">Biblioteca Virtual</a></li>
            <li><a href="#" class="footer-link">Plataforma Educativa</a></li>
            <li><a href="#" class="footer-link">Bedelía Online</a></li>
            <li><a href="login" class="footer-link">Portal Estudiantes</a></li>
          </ul>
        </div>

        <div>
          <h4 class="font-semibold mb-4">Contacto</h4>
          <ul class="space-y-3 text-sm text-gray-400">
            <li class="flex items-start gap-2">
              <i class="fas fa-map-marker-alt text-accent mt-1"></i>
              <span>25 de agosto Nº 427, Trinidad</span>
            </li>
            <li class="flex items-start gap-2">
              <i class="fas fa-phone text-accent mt-1"></i>
              <span>4364 8962 - 4364 2426</span>
            </li>
            <li class="flex items-start gap-2">
              <i class="fas fa-envelope text-accent mt-1"></i>
              <span>tecnicatrinidad@gmail.com</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="pt-8 border-t border-white/10 text-center text-gray-400 text-sm">
        <p>&copy; 2025 Escuela Técnica Trinidad Flores. Todos los derechos reservados.</p>
      </div>
    </div>
  </footer>

  <script>
    let currentSlide = 0;
    let slidesElements = [];
    let autoAdvanceInterval = null;

    function toggleDropdown() {
      document.getElementById('contactDropdown').classList.toggle('active');
    }

    document.addEventListener('click', e => {
      const dropdown = document.getElementById('contactDropdown');
      if (dropdown && !dropdown.contains(e.target)) {
        dropdown.classList.remove('active');
      }
    });

    function goToChat() { window.location.href = 'chat'; }
    function goToGestion() { window.location.href = 'adminDashboard'; }
    function goToLogin() { window.location.href = 'login'; }

    function showNotification(message, type = 'success') {
      const notification = document.createElement('div');
      const bgColor = type === 'success' ? 'bg-accent' : 'bg-red-500';
      notification.className = `fixed top-6 right-6 px-6 py-4 rounded-xl text-white font-medium z-[10000] shadow-2xl ${bgColor} flex items-center gap-3`;
      notification.style.animation = 'slideIn 0.3s ease';
      notification.innerHTML = `<i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i><span>${message}</span>`;
      document.body.appendChild(notification);
      setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
      }, 3000);
    }

    async function logout() {
      try {
        const res = await fetch("/api/v1/user/logout", { method: "POST", credentials: "include" });
        const data = await res.json();
        if (data.success) {
          showNotification('Sesión cerrada correctamente');
          setTimeout(() => window.location.reload(), 1500);
        }
      } catch (error) {
        showNotification('Error al cerrar sesión', 'error');
      }
    }

    function createSlide(post, index) {
      const slide = document.createElement('div');
      slide.className = `carousel-slide ${index === 0 ? 'active' : ''}`;
      
      const fecha = new Date(post.fecha_publicacion).toLocaleDateString('es-UY', {
        year: 'numeric', month: 'long', day: 'numeric'
      });

      const imageUrl = `data:image/jpeg;base64,${post.imagen}`;
      
      slide.innerHTML = `
        <img src="${imageUrl}" alt="${post.titulo}"
             onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 800 600%22%3E%3Crect fill=%22%230A2540%22 width=%22800%22 height=%22600%22/%3E%3C/svg%3E'">
        <div class="hero-overlay"></div>
        <div class="absolute inset-0 flex items-center" style="z-index: 2;">
          <div class="max-w-7xl mx-auto px-12 w-full">
            <div class="hero-content">
              <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight">${post.titulo}</h1>
              <p class="text-lg md:text-xl text-gray-200 mb-8 leading-relaxed">${post.contenido}</p>
              <div class="flex items-center gap-4 text-sm text-gray-300">
                <span class="flex items-center gap-2">
                  <i class="fas fa-user"></i>
                  ${post.autor.nombre}
                </span>
                <span class="flex items-center gap-2">
                  <i class="fas fa-calendar"></i>
                  ${fecha}
                </span>
              </div>
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
        indicator.className = `carousel-indicator ${i === 0 ? 'active' : ''}`;
        indicator.onclick = () => goToSlide(i);
        container.appendChild(indicator);
      }
    }

    function updateIndicators() {
      const indicators = document.querySelectorAll('#carousel-indicators button');
      indicators.forEach((indicator, index) => {
        if (index === currentSlide) {
          indicator.classList.add('active');
        } else {
          indicator.classList.remove('active');
        }
      });
    }

    function showSlide(index) {
      slidesElements.forEach((slide, i) => {
        if (i === index) {
          slide.classList.add('active');
        } else {
          slide.classList.remove('active');
        }
      });
      updateIndicators();
    }

    function nextSlide() {
      if (slidesElements.length === 0) return;
      currentSlide = (currentSlide + 1) % slidesElements.length;
      showSlide(currentSlide);
      resetAutoAdvance();
    }

    function prevSlide() {
      if (slidesElements.length === 0) return;
      currentSlide = (currentSlide - 1 + slidesElements.length) % slidesElements.length;
      showSlide(currentSlide);
      resetAutoAdvance();
    }

    function goToSlide(index) {
      currentSlide = index;
      showSlide(currentSlide);
      resetAutoAdvance();
    }

    function startAutoAdvance() {
      if (slidesElements.length <= 1) return;
      autoAdvanceInterval = setInterval(() => nextSlide(), 6000);
    }

    function resetAutoAdvance() {
      if (autoAdvanceInterval) {
        clearInterval(autoAdvanceInterval);
        startAutoAdvance();
      }
    }

    function cargarInformacionGeneral(posts) {
      const loading = document.getElementById('loading-carousel');
      const errorDiv = document.getElementById('error-carousel');
      const emptyDiv = document.getElementById('empty-carousel');
      const prevBtn = document.getElementById('prevBtn');
      const nextBtn = document.getElementById('nextBtn');
      const slidesContainer = document.getElementById('carousel-slides');
      
      loading.classList.add('hidden');
      errorDiv.classList.add('hidden');
      emptyDiv.classList.add('hidden');
      
      slidesContainer.innerHTML = '';
      slidesElements = [];
      
      const postsConImagen = posts.filter(post => post.imagen);
      
      if (postsConImagen.length === 0) {
        emptyDiv.classList.remove('hidden');
        return;
      }
      
      postsConImagen.forEach((post, index) => {
        const slide = createSlide(post, index);
        slidesContainer.appendChild(slide);
        slidesElements.push(slide);
      });
      
      if (postsConImagen.length > 1) {
        prevBtn.classList.remove('hidden');
        nextBtn.classList.remove('hidden');
        createIndicators(postsConImagen.length);
        startAutoAdvance();
      }
    }

    function cargarEventos(eventos) {
      const cont = document.getElementById('eventos-container');
      cont.innerHTML = '';
      
      if (!eventos.length) {
        cont.innerHTML = `
          <div class="text-center py-20">
            <i class="fas fa-calendar-times text-5xl text-gray-300 mb-4"></i>
            <p class="text-gray-600 font-medium">No hay eventos disponibles</p>
          </div>`;
        return;
      }

      const grid = document.createElement('div');
      grid.className = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6';
      
      eventos.forEach(evento => {
        const fecha = new Date(evento.fecha_evento).toLocaleDateString('es-UY', {
          day: 'numeric', month: 'long', year: 'numeric'
        });
        
        const card = document.createElement('div');
        card.className = 'event-card';
        card.innerHTML = `
          <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-semibold text-accent bg-accent/10 px-3 py-1 rounded-full">${fecha}</span>
          </div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">${evento.titulo}</h3>
          <p class="text-gray-600 leading-relaxed mb-4">${evento.descripcion}</p>
          <div class="pt-4 border-t border-gray-100">
            <div class="flex items-center gap-2 text-sm text-gray-500">
              <i class="fas fa-user"></i>
              <span>${evento.autor.nombre}</span>
            </div>
          </div>
        `;
        grid.appendChild(card);
      });
      
      cont.appendChild(grid);
    }

    async function cargarDatos() {
      try {
        document.getElementById('loading-carousel').classList.remove('hidden');
        document.getElementById('error-carousel').classList.add('hidden');
        
        const [postsResponse, eventosResponse] = await Promise.all([
          fetch('/api/v1/home/getPost'),
          fetch('/api/v1/home/getEvento')
        ]);
        
        if (!postsResponse.ok || !eventosResponse.ok) {
          throw new Error('Error en la respuesta del servidor');
        }
        
        const [postsData, eventosData] = await Promise.all([
          postsResponse.json(),
          eventosResponse.json()
        ]);
        
        if (postsData.status === 'success') {
          cargarInformacionGeneral(postsData.data);
        }
        
        if (eventosData.status === 'success') {
          cargarEventos(eventosData.data);
        }

      } catch (error) {
        console.error('Error:', error);
        document.getElementById('loading-carousel').classList.add('hidden');
        document.getElementById('error-carousel').classList.remove('hidden');
        
        document.getElementById('eventos-container').innerHTML = `
          <div class="text-center py-20">
            <i class="fas fa-exclamation-triangle text-5xl text-red-400 mb-4"></i>
            <p class="text-gray-600 font-medium mb-4">Error al cargar los eventos</p>
            <button onclick="cargarDatos()" class="btn-primary">
              <i class="fas fa-redo mr-2"></i>Reintentar
            </button>
          </div>
        `;
      }
    }

    window.onload = cargarDatos;
  </script>
</body>
</html>