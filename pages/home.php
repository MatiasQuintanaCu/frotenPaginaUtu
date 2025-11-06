<!DOCTYPE html>
<html lang="es">
<?php
session_start();
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
?>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTU - Universidad Técnica del Uruguay</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { 
      font-family: 'Arial', sans-serif; 
      background: #f8f9fa; 
      color: #333; 
      line-height: 1.6; 
      min-height: 100vh;
      display: flex; 
      flex-direction: column; 
    }

    /* NAV */
    nav {
      background: #003366;
      color: white;
      padding: 15px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 10px rgba(0, 61, 130, 0.1);
    }
    .nav-left { display: flex; align-items: center; gap: 12px; }
    .nav-left span { font-size: 1.3em; font-weight: 600; letter-spacing: 0.5px; }
    .nav-center { display: flex; align-items: center; gap: 15px; }
    .welcome-message { color: #ffcc00; font-weight: 500; font-size: 1em; }

    /* Dropdown */
    .dropdown { position: relative; }
    .dropdown-toggle {
      background: none; border: none; color: white;
      font-size: 1.1em; font-weight: 500; cursor: pointer;
      padding: 10px 15px; border-radius: 6px;
      display: flex; align-items: center; gap: 8px;
      transition: background 0.2s;
    }
    .dropdown-toggle:hover { background: rgba(255,255,255,0.1); }
    .dropdown-menu {
      position: absolute; top: 100%; right: 0;
      background: white; border: 2px solid #e9ecef; border-radius: 8px;
      min-width: 300px; opacity: 0; visibility: hidden;
      transform: translateY(-5px); transition: all 0.2s;
      box-shadow: 0 5px 20px rgba(0,0,0,0.15); z-index: 1000;
      margin-top: 5px;
    }
    .dropdown.active .dropdown-menu { opacity: 1; visibility: visible; transform: translateY(0); }
    .dropdown-item {
      padding: 15px 20px; color: #333;
      display: flex; align-items: center; gap: 15px;
      border-bottom: 1px solid #e9ecef; transition: background 0.2s;
    }
    .dropdown-item:last-child { border-bottom: none; }
    .dropdown-item:hover { background: #f8f9fa; }
    .dropdown-item i { width: 20px; color: #003366; }
    .contact-info strong { color: #003366; display: block; font-weight: 600; margin-bottom: 2px; }
    .contact-info small { color: #6c757d; font-size: 0.9em; }

    /* Botones */
    .login-btn, .logout-btn {
      border: none; border-radius: 6px; padding: 12px 20px;
      font-weight: 600; cursor: pointer; text-transform: uppercase;
      font-size: 0.9em; letter-spacing: 0.5px; transition: background 0.2s;
    }
    .login-btn { background: #ffcc00; color: white; }
    .login-btn:hover { background: #e55a2b; }
    .logout-btn { background: #dc3545; color: white; }
    .logout-btn:hover { background: #c82333; }

    /* Main */
    .main-container {
      display: grid; grid-template-columns: 1fr 1fr; gap: 30px;
      padding: 30px; max-width: 1400px; margin: 0 auto; flex: 1;
    }

    /* Carousel */
    .carousel {
      background: white; border-radius: 12px; padding: 30px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.08); border: 1px solid #e9ecef;
    }
    .carousel h2 {
      color: #003d82; text-align: center; margin-bottom: 30px;
      font-size: 1.8em; font-weight: 600;
      display: flex; align-items: center; justify-content: center; gap: 10px;
    }
    .carousel-item { display: none; text-align: center; }
    .carousel-item.active { display: block; }
    .carousel-item img {
      width: 100%; max-width: 500px; height: 280px;
      object-fit: cover; border-radius: 8px; border: 2px solid #e9ecef;
    }
    .carousel-item h3 { color: #003d82; margin: 20px 0 10px; }
    .carousel-item p { color: #6c757d; max-width: 480px; margin: 0 auto; }
    .carousel-controls {
      margin-top: 25px; display: flex; gap: 15px; justify-content: center;
    }
    .carousel-controls button {
      background: #003d82; color: white; border: none; border-radius: 6px;
      padding: 10px 20px; cursor: pointer; font-weight: 500;
      transition: background 0.2s;
    }
    .carousel-controls button:hover { background: #002a5c; }
    .carousel-indicators { display: flex; gap: 8px; justify-content: center; margin-top: 20px; }
    .indicator {
      width: 10px; height: 10px; border-radius: 50%; background: #dee2e6; cursor: pointer;
      transition: background 0.2s;
    }
    .indicator.active { background: #ff6b35; }

    /* News */
    .news-scroll {
      background: white; border-radius: 12px; padding: 30px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.08); border: 1px solid #e9ecef;
      max-height: 600px; overflow-y: auto;
    }
    .news-scroll h2 {
      color: #003d82; margin-bottom: 25px; font-size: 1.8em; font-weight: 600;
      display: flex; align-items: center; gap: 10px;
      border-bottom: 2px solid #e9ecef; padding-bottom: 15px;
    }
    .news-item {
      background: #f8f9fa; margin-bottom: 20px; border-radius: 8px; padding: 20px;
      border-left: 4px solid #ff6b35; position: relative;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .news-item:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .news-item h3 { margin: 0 0 10px; color: #003d82; padding-right: 80px; }
    .news-item p { color: #495057; }
    .news-date {
      position: absolute; top: 15px; right: 15px;
      background: #003d82; color: white; padding: 4px 8px; border-radius: 4px;
      font-size: 0.8em; font-weight: 500;
    }
    .news-scroll::-webkit-scrollbar { width: 6px; }
    .news-scroll::-webkit-scrollbar-thumb { background: #003d82; border-radius: 3px; }
    #LogoUtu { width: 10vh; border-radius: 200px; }
    .user-menu { display: flex; align-items: center; gap: 15px; }
    .loading-text { text-align: center; color: #666; margin: 20px 0; }
    .error-text { text-align: center; color: #dc3545; margin: 20px 0; }

    /* FOOTER STYLES */
    .site-footer {
      background-color: #003366;
      color: #e0e0e0;
      padding: 60px 0 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin-top: 80px;
      box-shadow: 0 -5px 20px rgba(0, 0, 0, 0.3);
    }

    .footer-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 40px;
      margin-bottom: 40px;
    }

    .footer-section {
      padding: 0 15px;
    }

    /* Logo y descripción */
    .footer-logo h3 {
      color: #4da6ff;
      font-size: 32px;
      font-weight: 700;
      margin: 0 0 5px 0;
      letter-spacing: 2px;
    }

    .footer-subtitle {
      color: #b8b8b8;
      font-size: 14px;
      margin: 0 0 15px 0;
      font-weight: 500;
    }

    .footer-description {
      color: #b8b8b8;
      font-size: 14px;
      line-height: 1.6;
      margin-bottom: 20px;
    }

    /* Redes sociales */
    .footer-social {
      display: flex;
      gap: 12px;
      margin-top: 20px;
    }

    .social-link {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: rgba(77, 166, 255, 0.1);
      border: 1px solid rgba(77, 166, 255, 0.3);
      border-radius: 50%;
      color: #4da6ff;
      transition: all 0.3s ease;
      text-decoration: none;
    }

    .social-link:hover {
      background: #4da6ff;
      color: #1a1a2e;
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(77, 166, 255, 0.3);
    }

    /* Títulos de sección */
    .footer-title {
      color: #ffffff;
      font-size: 18px;
      font-weight: 600;
      margin: 0 0 20px 0;
      padding-bottom: 10px;
      border-bottom: 2px solid #4da6ff;
      display: inline-block;
    }

    /* Listas */
    .footer-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-list li {
      margin-bottom: 12px;
    }

    .footer-list a,
    .footer-legal a {
      color: #b8b8b8;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.3s ease;
      display: inline-block;
    }

    .footer-list a:hover,
    .footer-legal a:hover {
      color: #4da6ff;
      padding-left: 5px;
    }

    /* Contacto */
    .footer-contact {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .footer-contact li {
      display: flex;
      align-items: flex-start;
      margin-bottom: 15px;
      font-size: 14px;
      color: #b8b8b8;
    }

    .footer-contact i {
      color: #4da6ff;
      margin-right: 12px;
      margin-top: 3px;
      font-size: 16px;
      min-width: 20px;
    }

    /* Barra inferior */
    .footer-bottom {
      background: rgba(0, 0, 0, 0.3);
      padding: 25px 0;
      border-top: 1px solid rgba(77, 166, 255, 0.2);
    }

    .footer-bottom-content {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 35px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 20px;
    }

    .copyright {
      color: #b8b8b8;
      font-size: 14px;
      margin: 0;
    }

    .footer-legal {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }

    .separator {
      color: rgba(77, 166, 255, 0.4);
    }

    /* Responsive */
    @media (max-width: 768px) {
      .main-container {
        grid-template-columns: 1fr;
      }
      
      .site-footer {
        padding: 40px 0 0;
      }
      
      .footer-container {
        grid-template-columns: 1fr;
        gap: 30px;
      }
      
      .footer-bottom-content {
        flex-direction: column;
        text-align: center;
        padding: 0 20px;
      }
      
      .footer-legal {
        justify-content: center;
      }
    }
  </style>
</head>
<body>

  <!-- NAV -->
  <nav>
    <div class="nav-left">
      <img id="LogoUtu" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw9e0Ez8kcPL3R7GtTdsIszwJ8M4JpSefntg&s" alt="LogoUtu">
      <span>UTU - Universidad Técnica del Uruguay</span>
    </div>
    
    <div class="nav-center">
      <div class="dropdown" id="contactDropdown">
        <button class="dropdown-toggle" onclick="toggleDropdown()">
          <i class="fas fa-phone-alt"></i> Contacto <i class="fas fa-chevron-down" style="font-size: 0.8em;"></i>
        </button>
        <div class="dropdown-menu">
          <div class="dropdown-item"><i class="fas fa-map-marker-alt"></i><div class="contact-info"><strong>Sede Central</strong><small>25 de agosto Nº 427 esq. Batlle y Ordoñez</small></div></div>
          <div class="dropdown-item"><i class="fas fa-phone"></i><div class="contact-info"><strong>Teléfono</strong><small>4364 8962 - 4364 2426</small></div></div>
          <div class="dropdown-item"><i class="fas fa-envelope"></i><div class="contact-info"><strong>Correo Institucional</strong><small>tecnicatrinidad@gmail.com</small></div></div>
          <div class="dropdown-item"><i class="fas fa-clock"></i><div class="contact-info"><strong>Horario</strong><small>Lun a Vie: 7:00 - 23:30</small></div></div>
        </div>
      </div>
    </div>
    
    <div class="nav-right">
      <div class="user-menu" id="userMenu">
        <?php if ($isLoggedIn && !empty($userName)): ?>
          <div class="welcome-message">¡Bienvenido, <?php echo htmlspecialchars($userName); ?>!</div>
          <button class="logout-btn" onclick="logout()">
            <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Cerrar Sesión
          </button>
        <?php else: ?>
          <button class="login-btn" onclick="goToLogin()">
            <i class="fas fa-sign-in-alt" style="margin-right: 5px;"></i> Acceder
          </button>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <div class="main-container">
    <!-- Carrusel para Posts -->
    <div class="carousel" id="carousel">
      <h2><i class="fas fa-info-circle"></i> Información UTU</h2>
      <div class="loading-text">Cargando información...</div>
      <div class="carousel-controls">
        <button onclick="prevSlide()"><i class="fas fa-chevron-left"></i> Anterior</button>
        <button onclick="nextSlide()">Siguiente <i class="fas fa-chevron-right"></i></button>
      </div>
      <div class="carousel-indicators" id="indicators"></div>
    </div>

    <!-- Eventos/Noticias -->
    <div class="news-scroll" id="eventos-container">
      <h2><i class="fas fa-calendar-alt"></i> Eventos y Noticias</h2>
      <div class="loading-text">Cargando eventos...</div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="footer-container">
      <!-- Información institucional -->
      <div class="footer-section">
        <div class="footer-logo">
          <h3>UTU</h3>
          <p class="footer-subtitle">Universidad Técnica del Uruguay</p>
        </div>
        <p class="footer-description">
          Formando profesionales técnicos con excelencia académica desde 1942.
          Educación de calidad para el desarrollo del país.
        </p>
        <div class="footer-social">
          <a href="#" aria-label="Facebook" class="social-link">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" aria-label="Twitter" class="social-link">
            <i class="fab fa-twitter"></i>
          </a>
          <a href="#" aria-label="Instagram" class="social-link">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" aria-label="LinkedIn" class="social-link">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a href="#" aria-label="YouTube" class="social-link">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </div>

      <!-- Enlaces rápidos -->
      <div class="footer-section">
        <h4 class="footer-title">Enlaces Rápidos</h4>
        <ul class="footer-list">
          <li><a href="#">Inicio</a></li>
          <li><a href="#">Sobre Nosotros</a></li>
          <li><a href="#">Carreras y Cursos</a></li>
          <li><a href="#">Inscripciones</a></li>
          <li><a href="#">Noticias</a></li>
          <li><a href="#">Contacto</a></li>
        </ul>
      </div>

      <!-- Servicios -->
      <div class="footer-section">
        <h4 class="footer-title">Servicios</h4>
        <ul class="footer-list">
          <li><a href="#">Biblioteca Virtual</a></li>
          <li><a href="#">Plataforma Educativa</a></li>
          <li><a href="#">Bedelía Online</a></li>
          <li><a href="login">Portal Estudiantes</a></li>
          <li><a href="#">Bolsa de Trabajo</a></li>
          <li><a href="#">Mesa de Ayuda</a></li>
        </ul>
      </div>

      <!-- Contacto -->
      <div class="footer-section">
        <h4 class="footer-title">Contacto</h4>
        <ul class="footer-contact">
          <li>
            <i class="fas fa-map-marker-alt"></i>
            <span>25 de agosto Nº 427 esq. Batlle y Ordoñez<br>Trinidad, Flores</span>
          </li>
          <li>
            <i class="fas fa-phone"></i>
            <span>4364 8962 - 4364 2426</span>
          </li>
          <li>
            <i class="fas fa-envelope"></i>
            <span>tecnicatrinidad@gmail.com</span>
          </li>
          <li>
            <i class="fas fa-clock"></i>
            <span>Lun - Vie: 7:00 - 23:30</span>
          </li>
        </ul>
      </div>
    </div>

    <!-- Barra inferior -->
    <div class="footer-bottom">
      <div class="footer-bottom-content">
        <p class="copyright">
          &copy; 2025 Universidad Técnica del Uruguay (UTU). Todos los derechos reservados.
        </p>
        <div class="footer-legal">
          <a href="#">Política de Privacidad</a>
          <span class="separator">|</span>
          <a href="#">Términos y Condiciones</a>
          <span class="separator">|</span>
          <a href="#">Accesibilidad</a>
          <span class="separator">|</span>
          <a href="#">Mapa del Sitio</a>
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
        d.className = 'indicator' + (i === 0 ? ' active' : ''); 
        d.onclick = () => goToSlide(i); 
        cont.appendChild(d); 
      }
    }
    
    // Cargar posts en el carrusel
    function cargarInformacionGeneral(posts){
      const c = document.getElementById('carousel'); 
      const ctr = c.querySelector('.carousel-controls');
      const loading = c.querySelector('.loading-text');
      
      if (loading) loading.remove();
      
      c.querySelectorAll('.carousel-item').forEach(el => el.remove());
      
      const postsConImagen = posts.filter(post => post.imagen);
      
      if (postsConImagen.length === 0) {
        const noData = document.createElement('div');
        noData.className = 'loading-text';
        noData.textContent = 'No hay información disponible';
        c.insertBefore(noData, ctr);
        return;
      }
      
      postsConImagen.forEach((post, idx) => {
        const s = document.createElement('div');
        s.className = 'carousel-item' + (idx === 0 ? ' active' : '');
        
        const imageUrl = `data:image/jpeg;base64,${post.imagen}`;
        
        s.innerHTML = `
          <img src="${imageUrl}" alt="${post.titulo}" onerror="this.style.display='none'">
          <h3>${post.titulo}</h3>
          <p>${post.contenido}</p>
          <small style="color: #6c757d; display: block; margin-top: 10px;">
            Publicado por: ${post.autor.nombre} | ${post.fecha_publicacion}
          </small>
        `; 
        c.insertBefore(s, ctr);
      });
      
      carouselSlides = c.querySelectorAll('.carousel-item'); 
      createIndicators(carouselSlides.length); 
      showSlide(0);
    }
    
    // Cargar eventos/noticias
    function cargarEventos(eventos){
      const cont = document.getElementById('eventos-container'); 
      const t = cont.querySelector('h2'); 
      const loading = cont.querySelector('.loading-text');
      
      if (loading) loading.remove();
      cont.innerHTML = ''; 
      cont.appendChild(t);
      
      if(!eventos.length){
        const m = document.createElement('div');
        m.className = 'loading-text';
        m.textContent = 'No hay eventos disponibles';
        cont.appendChild(m);
        return;
      }
      
      eventos.forEach(evento => {
        const it = document.createElement('div');
        it.className = 'news-item';
        const fecha = new Date(evento.fecha_evento).toLocaleDateString('es-UY', {
          year: 'numeric',
          month: 'long',
          day: 'numeric'
        });
        
        it.innerHTML = `
          <div class="news-date">${fecha}</div>
          <h3>${evento.titulo}</h3>
          <p>${evento.descripcion}</p>
          <small style="color: #6c757d; display: block; margin-top: 10px;">
            Por: ${evento.autor.nombre}
          </small>
        `;
        cont.appendChild(it);
      });
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

    function goToLogin() {
      window.location.href = 'login';
    }

    function showNotification(message, type) {
      const notification = document.createElement('div');
      notification.style.cssText = `
        position: fixed; top: 20px; right: 20px; padding: 15px 20px;
        border-radius: 8px; color: white; font-weight: 500; z-index: 10000;
        background: ${type === 'success' ? '#28a745' : '#dc3545'};
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      `;
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
        errorDiv.className = 'error-text';
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

    // Inicialización
    window.onload = () => {
      cargarDatos();
    };
  </script>
</body>
</html>