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

    /* Footer */
    footer {
      background: #003366; color: white; padding: 20px 10px;
      text-align: center; margin-top: auto;
    }
    .footer-content { max-width: 900px; margin: 0 auto; }
    .footer-content p { margin-bottom: 10px; font-size: 14px; }
    .footer-links {
      display: flex; justify-content: center; gap: 15px; flex-wrap: wrap;
    }
    .footer-links a { color: #fff; text-decoration: none; font-size: 14px; transition: color 0.3s; }
    .footer-links a:hover { color: #ffcc00; }

    #LogoUtu { width: 10vh; border-radius: 200px; }
    .user-menu { display: flex; align-items: center; gap: 15px; }
    .loading-text { text-align: center; color: #666; margin: 20px 0; }

    /* Responsive */
    @media (max-width: 768px) {
      .main-container { grid-template-columns: 1fr; }
      .nav-center { flex-direction: column; gap: 10px; }
      .user-menu { flex-direction: column; }
      nav { padding: 15px 20px; }
      .main-container { padding: 20px; gap: 20px; }
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
          <!-- Usuario Logueado - Muestra bienvenida y botón de cerrar sesión -->
          <div class="welcome-message">¡Bienvenido, <?php echo htmlspecialchars($userName); ?>!</div>
          <button class="logout-btn" onclick="logout()">
            <i class="fas fa-sign-out-alt" style="margin-right: 5px;"></i> Cerrar Sesión
          </button>
        <?php else: ?>
          <!-- Usuario No Logueado - Muestra botón de acceder -->
          <button class="login-btn" onclick="goToLogin()">
            <i class="fas fa-sign-in-alt" style="margin-right: 5px;"></i> Acceder
          </button>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <div class="main-container">
    <!-- Carrusel -->
    <div class="carousel" id="carousel">
      <h2><i class="fas fa-info-circle"></i> Información Institucional</h2>
      <div class="carousel-controls">
        <button onclick="prevSlide()"><i class="fas fa-chevron-left"></i> Anterior</button>
        <button onclick="nextSlide()">Siguiente <i class="fas fa-chevron-right"></i></button>
      </div>
      <div class="carousel-indicators" id="indicators"></div>
    </div>

    <!-- Noticias -->
    <div class="news-scroll" id="news-container">
      <h2><i class="fas fa-newspaper"></i> Noticias UTU</h2>
      <div class="loading-text">Cargando noticias...</div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer>
    <div class="footer-content">
      <p>&copy; 2025 UTU - Universidad Técnica del Uruguay. Todos los derechos reservados.</p>
      <div class="footer-links">
        <a href="#">Política de Privacidad</a>
        <a href="#">Términos de Servicio</a>
        <a href="login">Acceso</a>
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
    function cargarInformacionGeneral(arr){
      const c = document.getElementById('carousel'); 
      const ctr = c.querySelector('.carousel-controls');
      c.querySelectorAll('.carousel-item').forEach(el => el.remove());
      
      arr.forEach((it, idx) => {
        const s = document.createElement('div');
        s.className = 'carousel-item' + (idx === 0 ? ' active' : '');
        s.innerHTML = `
          <img src="${it.imagen}" alt="${it.titulo}">
          <h3>${it.titulo}</h3>
          <p>${it.descripcion}</p>
        `; 
        c.insertBefore(s, ctr);
      });
      
      carouselSlides = c.querySelectorAll('.carousel-item'); 
      createIndicators(carouselSlides.length); 
      showSlide(0);
    }
    
    function cargarNoticias(arr){
      const cont = document.getElementById('news-container'); 
      const t = cont.querySelector('h2'); 
      cont.innerHTML = ''; 
      cont.appendChild(t);
      
      if(!arr.length){
        const m = document.createElement('div');
        m.className = 'loading-text';
        m.textContent = 'No hay noticias disponibles';
        cont.appendChild(m);
        return;
      }
      
      arr.forEach(n => {
        const it = document.createElement('div');
        it.className = 'news-item';
        const f = n.fecha || new Date().toLocaleDateString('es-UY');
        it.innerHTML = `
          <div class="news-date">${f}</div>
          <h3>${n.titulo}</h3>
          <p>${n.descripcion}</p>
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
          // Recargar la página para actualizar el estado PHP
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

    // Auto-avance del carrusel
    function startCarouselAutoAdvance() {
      setInterval(() => {
        nextSlide();
      }, 5000);
    }

    // Datos y inicialización
    window.onload = () => {
      const noticiasUTU = [
        {
          titulo: "Nuevas Carreras Técnicas 2025",
          descripcion: "UTU incorpora carreras en Energías Renovables, Robótica Industrial y Desarrollo de Aplicaciones Móviles. Inscripciones abiertas.",
          fecha: "15 Sep 2025"
        },
        {
          titulo: "Convenio con Industria Nacional", 
          descripcion: "Acuerdo estratégico con empresas uruguayas para prácticas laborales y formación dual. Oportunidades para estudiantes.",
          fecha: "14 Sep 2025"
        },
        {
          titulo: "Modernización de Laboratorios",
          descripcion: "Nuevos laboratorios en Electrónica y TI equipados con tecnología de última generación para formación práctica.",
          fecha: "13 Sep 2025"
        },
        {
          titulo: "Programa de Becas 2025",
          descripcion: "Convocatoria abierta para becas de estudio. Postulaciones hasta el 30 de octubre.",
          fecha: "12 Sep 2025"
        }
      ];
      
      const infoInstitucional = [
        {
          titulo: "Inscripciones 2025",
          descripcion: "Inscripciones abiertas hasta el 30 de septiembre para todas las carreras técnicas y tecnológicas.",
          imagen: "https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=500&h=280&fit=crop"
        },
        {
          titulo: "Campus Virtual",
          descripcion: "Acceso a materiales, evaluaciones y clases en línea a través de nuestra plataforma educativa.",
          imagen: "https://images.unsplash.com/photo-1547658719-da2b51169166?w=500&h=280&fit=crop"
        },
        {
          titulo: "Biblioteca Digital",
          descripcion: "Más de 10,000 recursos educativos disponibles las 24 horas para toda la comunidad UTU.",
          imagen: "https://images.unsplash.com/photo-1481627834876-b7833e8f5570?w=500&h=280&fit=crop"
        }
      ];

      cargarNoticias(noticiasUTU);
      cargarInformacionGeneral(infoInstitucional);
      startCarouselAutoAdvance();
    };
  </script>
</body>
</html>