<?php
session_start();

// Validar que el usuario esté logueado y sea administrador
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['user_rol'] !== 'ADMIN') {
    header('Location: index.php');
    exit();
}

$userName = $_SESSION['user_name'];
$userRol = $_SESSION['user_rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Administración - UTU Trinidad Flores</title>
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
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Arial', sans-serif;
      background: #f8fafc;
      color: #2d3748;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    /* Navbar estilo institucional */
    .nav-institutional {
      background: #003366;
      color: white;
      padding: 16px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 10px rgba(0, 51, 102, 0.2);
      border-bottom: 2px solid #2d7744;
    }

    .nav-left {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .nav-left span {
      font-size: 1.3em;
      font-weight: 700;
    }

    #LogoUtu { 
      width: 60px; 
      height: 60px;
      border-radius: 8px;
      object-fit: cover;
      border: 2px solid #2d7744;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 12px;
      background: rgba(255, 255, 255, 0.1);
      padding: 8px 16px;
      border-radius: 6px;
    }

    .user-avatar {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: #2d7744;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: bold;
      font-size: 14px;
    }

    .user-badge {
      background: #2d7744;
      color: white;
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 0.75rem;
      font-weight: 600;
    }

    .btn-institutional {
      background-color: #003366;
      color: white;
      border-radius: 4px;
      padding: 10px 20px;
      font-weight: 600;
      transition: all 0.2s ease;
      border: 1px solid rgba(255, 255, 255, 0.1);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
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
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
    }

    .btn-secondary:hover {
      background-color: #236335;
    }

    /* Contenido principal */
    .main-container {
      flex: 1;
      padding: 30px 20px;
      display: flex;
      max-width: 1400px;
      margin: 0 auto;
      width: 100%;
    }

    .forms-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 30px;
      width: 100%;
    }

    .form-section {
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
      display: flex;
      flex-direction: column;
      gap: 20px;
      border: 1px solid #e2e8f0;
    }

    .section-title {
      border-bottom: 2px solid #2d7744;
      padding-bottom: 8px;
      margin-bottom: 20px;
      color: #003366;
      font-size: 1.5em;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 8px;
    }

    .form-group label {
      font-weight: 600;
      color: #4a5568;
      font-size: 0.95em;
    }

    .form-input {
      padding: 12px 16px;
      border: 1px solid #cbd5e0;
      border-radius: 4px;
      font-size: 1em;
      font-family: 'Segoe UI', sans-serif;
      transition: all 0.2s ease;
      background: #fff;
    }

    .form-input:hover {
      border-color: #a0aec0;
    }

    .form-input:focus {
      outline: none;
      border-color: #003366;
      box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
    }

    textarea.form-input {
      min-height: 120px;
      resize: vertical;
    }

    .file-input-wrapper {
      position: relative;
      padding: 20px;
      border: 2px dashed #cbd5e0;
      border-radius: 4px;
      text-align: center;
      cursor: pointer;
      transition: all 0.2s ease;
      background: #f7fafc;
    }

    .file-input-wrapper:hover {
      border-color: #003366;
      background: #edf2f7;
    }

    .file-input-wrapper input[type="file"] {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      opacity: 0;
      cursor: pointer;
    }

    .file-input-label {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
      pointer-events: none;
    }

    .file-input-label i {
      font-size: 1.5em;
      color: #003366;
    }

    .file-input-label span {
      color: #718096;
      font-size: 0.9em;
    }

    .submit-btn {
      padding: 12px 24px;
      border: none;
      border-radius: 4px;
      font-size: 1em;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      margin-top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .submit-btn-evento {
      background: #003366;
      color: white;
    }

    .submit-btn-evento:hover {
      background: #002244;
    }

    .submit-btn-noticia {
      background: #2d7744;
      color: white;
    }

    .submit-btn-noticia:hover {
      background: #236335;
    }

    /* Footer */
    .footer-institutional {
      background: #002244;
      color: #cbd5e0;
      padding: 20px;
      text-align: center;
      margin-top: 40px;
    }

    .footer-content {
      max-width: 900px;
      margin: 0 auto;
    }

    .footer-content p { 
      margin-bottom: 10px; 
      font-size: 14px;
    }

    .footer-links {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .footer-links a {
      color: #cbd5e0;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.2s ease;
    }

    .footer-links a:hover { 
      color: #2d7744;
    }

    /* Responsive */
    @media (max-width: 1024px) {
      .forms-grid {
        grid-template-columns: 1fr;
        gap: 25px;
      }
    }

    @media (max-width: 768px) {
      .nav-institutional {
        padding: 12px 20px;
        flex-direction: column;
        gap: 15px;
      }

      .nav-left span {
        font-size: 1.1em;
      }

      #LogoUtu {
        width: 50px;
        height: 50px;
      }

      .form-section {
        padding: 20px;
      }
      
      .section-title {
        font-size: 1.3em;
      }
    }

    /* Notificaciones */
    .notification {
      position: fixed;
      top: 20px;
      right: 20px;
      padding: 16px 20px;
      border-radius: 4px;
      color: white;
      font-weight: 600;
      z-index: 1000;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 10px;
      transform: translateX(100%);
      transition: transform 0.3s ease;
    }

    .notification.show {
      transform: translateX(0);
    }

    .notification.success {
      background: #2d7744;
    }

    .notification.error {
      background: #c53030;
    }
  </style>
</head>
<body>

  <nav class="nav-institutional">
    <div class="nav-left">
      <img id="LogoUtu" src="./assets/img/logo.webp" alt="Logo UTU">
      <span>UTU - Trinidad Flores</span>
    </div>
    
    
  </nav>

  <div class="main-container">
    <div class="forms-grid">
      
      <!-- Formulario Crear Evento -->
      <div class="form-section">
        <h2 class="section-title">
          <i class="fas fa-calendar-plus"></i>
          Crear Evento
        </h2>
        
        <form id="formEvento" onsubmit="submitEvento(event)">
          <div class="form-group">
            <label for="titulo-evento">Título del Evento</label>
            <input 
              type="text" 
              id="titulo-evento" 
              name="nombre" 
              class="form-input" 
              placeholder="Ingrese el título del evento"
              required
            >
          </div>

          <div class="form-group">
            <label for="descripcion-evento">Descripción</label>
            <textarea 
              id="descripcion-evento" 
              name="descripcion" 
              class="form-input" 
              placeholder="Ingrese la descripción del evento"
              required
            ></textarea>
          </div>

          <div class="form-group">
            <label for="fecha-evento">Fecha del Evento</label>
            <input 
              type="date" 
              id="fecha-evento" 
              name="fecha_evento" 
              class="form-input" 
              required
            >
          </div>

          <button type="submit" class="submit-btn submit-btn-evento">
            <i class="fas fa-paper-plane"></i>
            Publicar Evento
          </button>
        </form>
      </div>

      <!-- Formulario Crear Noticia -->
      <div class="form-section">
        <h2 class="section-title">
          <i class="fas fa-newspaper"></i>
          Crear Noticia
        </h2>
        
        <form id="formNoticia" onsubmit="submitNoticia(event)">
          <div class="form-group">
            <label for="titulo-noticia">Título de la Noticia</label>
            <input 
              type="text" 
              id="titulo-noticia" 
              name="titulo" 
              class="form-input" 
              placeholder="Ingrese el título de la noticia"
              required
            >
          </div>

          <div class="form-group">
            <label for="contenido-noticia">Contenido</label>
            <textarea 
              id="contenido-noticia" 
              name="contenido" 
              class="form-input" 
              placeholder="Ingrese el contenido de la noticia"
              required
            ></textarea>
          </div>

          <div class="form-group">
            <label>Imagen (opcional)</label>
            <div class="file-input-wrapper">
              <input 
                type="file" 
                id="imagen-noticia" 
                name="imagen" 
                accept="image/*"
                onchange="handleFileSelect(event, 'noticia')"
              >
              <div class="file-input-label">
                <i class="fas fa-cloud-upload-alt"></i>
                <span id="file-name-noticia">Seleccionar imagen</span>
              </div>
            </div>
          </div>

          <button type="submit" class="submit-btn submit-btn-noticia">
            <i class="fas fa-paper-plane"></i>
            Publicar Noticia
          </button>
        </form>
      </div>

    </div>
  </div>

  <footer class="footer-institutional">
    <div class="footer-content">
      <p>&copy; 2025 UTU - Escuela Técnica Trinidad Flores. Todos los derechos reservados.</p>
      <div class="footer-links">
        <a href="index.php">Inicio</a>
        <a href="#">Política de Privacidad</a>
        <a href="#">Términos de Servicio</a>
      </div>
    </div>
  </footer>

  <script>
    function handleFileSelect(event, tipo) {
      const file = event.target.files[0];
      const spanId = 'file-name-noticia';
      const span = document.getElementById(spanId);
      
      if (file) {
        span.textContent = file.name;
        span.style.color = '#003366';
        span.style.fontWeight = '600';
      } else {
        span.textContent = 'Seleccionar imagen';
        span.style.color = '#718096';
        span.style.fontWeight = '500';
      }
    }

    function showNotification(message, type = 'success') {
      const notification = document.createElement('div');
      notification.className = `notification ${type}`;
      notification.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
        <span>${message}</span>
      `;
      
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.classList.add('show');
      }, 100);
      
      setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
          notification.remove();
        }, 300);
      }, 3000);
    }

    async function submitEvento(event) {
      event.preventDefault();
      
      const formData = new FormData(event.target);
      
      try {
        // Aquí iría la conexión con el backend
        const response = await fetch('/api/v1/admin/crear-evento', {
          method: 'POST',
          body: formData
        });
        
        if (response.ok) {
          showNotification('Evento creado exitosamente', 'success');
          event.target.reset();
        } else {
          throw new Error('Error al crear evento');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error al crear el evento', 'error');
      }
    }

    async function submitNoticia(event) {
      event.preventDefault();
      
      const formData = new FormData(event.target);
      
      try {
        // Aquí iría la conexión con el backend
        const response = await fetch('/api/v1/admin/crear-noticia', {
          method: 'POST',
          body: formData
        });
        
        if (response.ok) {
          showNotification('Noticia creada exitosamente', 'success');
          event.target.reset();
          document.getElementById('file-name-noticia').textContent = 'Seleccionar imagen';
          document.getElementById('file-name-noticia').style.color = '#718096';
          document.getElementById('file-name-noticia').style.fontWeight = '500';
        } else {
          throw new Error('Error al crear noticia');
        }
      } catch (error) {
        console.error('Error:', error);
        showNotification('Error al crear la noticia', 'error');
      }
    }

    // Validación de fecha mínima (hoy)
    document.getElementById('fecha-evento').min = new Date().toISOString().split('T')[0];
  </script>
</body>
</html>