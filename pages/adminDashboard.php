<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTU - Universidad Técnica del Uruguay</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Arial', sans-serif;
      background-color: #f8f9fa;
      color: #333;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* NAV */
    nav {
      background-color: #003366;
      color: white;
      padding: 15px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 10px rgba(0, 61, 130, 0.1);
    }

    .nav-left {
      display: flex;
      align-items: center;
      gap: 12px;
    }

    .nav-left span {
      font-size: 1.3em;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    /* Dropdown */
    .dropdown { position: relative; }
    .dropdown-toggle {
      background: none;
      border: none;
      color: white;
      font-size: 1.1em;
      font-weight: 500;
      cursor: pointer;
      padding: 10px 15px;
      border-radius: 6px;
      transition: background-color 0.2s ease;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .dropdown-toggle:hover { background-color: rgba(255,255,255,0.1); }
    .dropdown-menu {
      position: absolute;
      top: 100%; right: 0;
      background: white;
      border: 2px solid #e9ecef;
      border-radius: 8px;
      min-width: 300px;
      opacity: 0; visibility: hidden;
      transform: translateY(-5px);
      transition: all 0.2s ease;
      box-shadow: 0 5px 20px rgba(0,0,0,0.15);
      z-index: 1000;
      margin-top: 5px;
    }
    .dropdown.active .dropdown-menu {
      opacity: 1; visibility: visible;
      transform: translateY(0);
    }
    .dropdown-item {
      padding: 15px 20px;
      color: #333;
      display: flex;
      align-items: center;
      gap: 15px;
      border-bottom: 1px solid #e9ecef;
      transition: background-color 0.2s ease;
    }
    .dropdown-item:last-child { border-bottom: none; }
    .dropdown-item:hover { background-color: #f8f9fa; }
    .dropdown-item i { width: 20px; color: #003366; }

    .contact-info strong { color: #003366; display: block; font-weight: 600; margin-bottom: 2px; }
    .contact-info small { color: #6c757d; font-size: 0.9em; }

    /* Login */
    .login-btn {
      background-color: #ffcc00;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 12px 20px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.2s ease;
      text-transform: uppercase;
      font-size: 0.9em;
      letter-spacing: 0.5px;
    }
    .login-btn:hover { background-color: #e55a2b; }

    /* Main */
    .main-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      padding: 30px;
      max-width: 1400px;
      margin: 0 auto;
      flex: 1;
    }

    /* Carousel */
    .carousel {
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.08);
      border: 1px solid #e9ecef;
    }
    .carousel h2 {
      color: #003d82;
      text-align: center;
      margin-bottom: 30px;
      font-size: 1.8em;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }
    .carousel-item { display: none; text-align: center; }
    .carousel-item.active { display: block; }
    .carousel-item img {
      width: 100%; max-width: 500px; height: 280px;
      object-fit: cover;
      border-radius: 8px;
      border: 2px solid #e9ecef;
    }
    .carousel-item h3 { color: #003d82; margin: 20px 0 10px; }
    .carousel-item p { color: #6c757d; max-width: 480px; margin: 0 auto; }
    .carousel-controls {
      margin-top: 25px;
      display: flex; gap: 15px;
      justify-content: center;
    }
    .carousel-controls button {
      background-color: #003d82;
      color: white; border: none;
      border-radius: 6px;
      padding: 10px 20px;
      cursor: pointer;
      font-weight: 500;
    }
    .carousel-controls button:hover { background-color: #002a5c; }
    .carousel-indicators { display: flex; gap: 8px; justify-content: center; margin-top: 20px; }
    .indicator {
      width: 10px; height: 10px; border-radius: 50%;
      background-color: #dee2e6; cursor: pointer;
    }
    .indicator.active { background-color: #ff6b35; }

    /* News */
    .news-scroll {
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 2px 15px rgba(0,0,0,0.08);
      border: 1px solid #e9ecef;
      max-height: 600px;
      overflow-y: auto;
    }
    .news-scroll h2 {
      color: #003d82;
      margin-bottom: 25px;
      font-size: 1.8em;
      font-weight: 600;
      display: flex; align-items: center; gap: 10px;
      border-bottom: 2px solid #e9ecef;
      padding-bottom: 15px;
    }
    .news-item {
      background: #f8f9fa;
      margin-bottom: 20px;
      border-radius: 8px;
      padding: 20px;
      border-left: 4px solid #ff6b35;
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      position: relative;
    }
    .news-item:hover { transform: translateY(-1px); box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
    .news-item h3 { margin: 0 0 10px; color: #003d82; padding-right: 80px; }
    .news-item p { color: #495057; }
    .news-date {
      position: absolute; top: 15px; right: 15px;
      background-color: #003d82; color: white;
      padding: 4px 8px; border-radius: 4px;
      font-size: 0.8em; font-weight: 500;
    }
    .news-scroll::-webkit-scrollbar { width: 6px; }
    .news-scroll::-webkit-scrollbar-thumb { background: #003d82; border-radius: 3px; }

    /* Footer */
    footer {
      background: #003366;
      color: white;
      padding: 20px 10px;
      text-align: center;
      margin-top: auto;
    }
    .footer-content {
      max-width: 900px;
      margin: 0 auto;
    }
    .footer-content p { margin-bottom: 10px; font-size: 14px; }
    .footer-links {
      display: flex;
      justify-content: center;
      gap: 15px;
      flex-wrap: wrap;
    }
    .footer-links a {
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      transition: color 0.3s ease;
    }
    .footer-links a:hover { color: #ffcc00; }

    #LogoUtu { width: 10vh; border-radius: 200px; }

    @media (max-width: 768px) {
      .main-container { grid-template-columns: 1fr; }
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
    
  </nav>

  

   

  <!-- FOOTER -->
  <footer>
    <div class="footer-content">
      <p>&copy; 2025 UTU - Universidad Técnica del Uruguay. Todos los derechos reservados.</p>
      <div class="footer-links">
        <a href="#">Política de Privacidad</a>
        <a href="#">Términos de Servicio</a>
        <a href="Login.html">Acceso</a>
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
    function nextSlide() { if (carouselSlides.length) { currentSlide = (currentSlide+1)%carouselSlides.length; showSlide(currentSlide);} }
    function prevSlide() { if (carouselSlides.length) { currentSlide = (currentSlide-1+carouselSlides.length)%carouselSlides.length; showSlide(currentSlide);} }
    function goToSlide(i){ currentSlide=i; showSlide(currentSlide); }
    function createIndicators(n){
      const cont=document.getElementById('indicators'); cont.innerHTML='';
      for(let i=0;i<n;i++){ const d=document.createElement('div'); d.className='indicator'+(i===0?' active':''); d.onclick=()=>goToSlide(i); cont.appendChild(d); }
    }
    function cargarInformacionGeneral(arr){
      const c=document.getElementById('carousel'); const ctr=c.querySelector('.carousel-controls');
      c.querySelectorAll('.carousel-item').forEach(el=>el.remove());
      arr.forEach((it,idx)=>{const s=document.createElement('div');s.className='carousel-item'+(idx===0?' active':'');s.innerHTML=`<img src="${it.imagen}" alt="${it.titulo}"><h3>${it.titulo}</h3><p>${it.descripcion}</p>`; c.insertBefore(s,ctr);});
      carouselSlides=c.querySelectorAll('.carousel-item'); createIndicators(carouselSlides.length); showSlide(0);
    }
    function cargarNoticias(arr){
      const cont=document.getElementById('news-container'); const t=cont.querySelector('h2'); cont.innerHTML=''; cont.appendChild(t);
      if(!arr.length){const m=document.createElement('div');m.className='loading-text';m.textContent='No hay noticias disponibles';cont.appendChild(m);return;}
      arr.forEach(n=>{const it=document.createElement('div');it.className='news-item';const f=n.fecha||new Date().toLocaleDateString('es-UY');it.innerHTML=`<div class="news-date">${f}</div><h3>${n.titulo}</h3><p>${n.descripcion}</p>`;cont.appendChild(it);});
    }

    // Datos
    window.onload=()=>{
      const noticiasUTU=[
        {titulo:"Nuevas Carreras Técnicas 2025",descripcion:"UTU incorpora carreras en Energías Renovables, Robótica Industrial y Desarrollo de Aplicaciones Móviles.",fecha:"15 Sep 2025"},
        {titulo:"Convenio con Industria Nacional",descripcion:"Acuerdo estratégico con empresas uruguayas para prácticas laborales.",fecha:"14 Sep 2025"},
        {titulo:"Modernización de Laboratorios",descripcion:"Nuevos laboratorios en Electrónica y TI.",fecha:"13 Sep 2025"}
      ];
      const infoInstitucional=[
        {titulo:"Inscripciones 2025",descripcion:"Inscripciones abiertas hasta el 30 de septiembre.",imagen:"https://via.placeholder.com/500x280/003d82/ffffff?text=INSCRIPCIONES+2025"},
        {titulo:"Campus Virtual",descripcion:"Acceso a materiales y evaluaciones en línea.",imagen:"https://via.placeholder.com/500x280/ff6b35/ffffff?text=CAMPUS+VIRTUAL"}
      ];
      setTimeout(()=>{cargarNoticias(noticiasUTU);cargarInformacionGeneral(infoInstitucional);},500);
    };
  </script>
</body>
</html>
