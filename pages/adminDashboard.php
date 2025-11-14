<?php
session_start();

// Validar que el usuario esté logueado y sea ADMIN
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || $_SESSION['user_rol'] !== 'ADMIN') {
    header('Location: /login');
    exit;
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
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
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

    /* Form Cards */
    .form-card {
      background: white;
      border-radius: 12px;
      border: 1px solid rgba(0, 0, 0, 0.08);
      transition: all 0.3s ease;
    }

    .form-card:hover {
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
    }

    /* Input styles */
    .form-input {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1.5px solid #E2E8F0;
      border-radius: 8px;
      font-size: 0.9375rem;
      transition: all 0.2s ease;
      outline: none;
    }

    .form-input:focus {
      border-color: #00A67E;
      box-shadow: 0 0 0 3px rgba(0, 166, 126, 0.1);
    }

    .form-textarea {
      resize: vertical;
      min-height: 120px;
    }

    /* Buttons */
    .btn-primary {
      background: #00A67E;
      color: white;
      font-weight: 600;
      padding: 0.875rem 1.5rem;
      border-radius: 8px;
      transition: all 0.2s ease;
      border: none;
      cursor: pointer;
      font-size: 0.9375rem;
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .btn-primary:hover {
      background: #008866;
      transform: translateY(-2px);
      box-shadow: 0 8px 16px rgba(0, 166, 126, 0.3);
    }

    .btn-primary:active {
      transform: translateY(0);
    }

    /* File upload area */
    .file-upload-area {
      position: relative;
      border: 2px dashed #CBD5E0;
      border-radius: 12px;
      padding: 2rem;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      background: #F7FAFC;
    }

    .file-upload-area:hover {
      border-color: #00A67E;
      background: rgba(0, 166, 126, 0.03);
    }

    .file-upload-area.has-file {
      border-color: #00A67E;
      background: rgba(0, 166, 126, 0.05);
    }

    .file-upload-input {
      position: absolute;
      inset: 0;
      width: 100%;
      height: 100%;
      opacity: 0;
      cursor: pointer;
    }

    /* Notification */
    .notification {
      position: fixed;
      top: 1.5rem;
      right: 1.5rem;
      z-index: 9999;
      max-width: 400px;
      padding: 1rem 1.5rem;
      border-radius: 12px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
      display: flex;
      align-items: center;
      gap: 0.75rem;
      font-weight: 500;
      animation: slideIn 0.3s ease;
    }

    .notification.success {
      background: white;
      border: 1px solid #00A67E;
      color: #0A2540;
    }

    .notification.error {
      background: white;
      border: 1px solid #EF4444;
      color: #0A2540;
    }

    .notification-icon {
      width: 24px;
      height: 24px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-shrink: 0;
    }

    .notification.success .notification-icon {
      background: #00A67E;
      color: white;
    }

    .notification.error .notification-icon {
      background: #EF4444;
      color: white;
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

    /* Section headers */
    .section-header {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 2rem;
    }

    .section-icon {
      width: 40px;
      height: 40px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.125rem;
    }

    .section-icon.blue {
      background: rgba(59, 130, 246, 0.1);
      color: #3B82F6;
    }

    .section-icon.orange {
      background: rgba(249, 115, 22, 0.1);
      color: #F97316;
    }

    /* Label styles */
    .form-label {
      display: block;
      font-size: 0.875rem;
      font-weight: 600;
      color: #334155;
      margin-bottom: 0.5rem;
    }

    .label-icon {
      margin-right: 0.375rem;
      opacity: 0.7;
    }

    /* Loading state */
    .btn-primary:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }

    .spinner {
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top-color: white;
      border-radius: 50%;
      width: 16px;
      height: 16px;
      animation: spin 0.6s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body class="bg-gray-50">

  <!-- Navigation -->
  <nav class="nav-container sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6">
      <div class="flex items-center justify-between h-20">
        <div class="flex items-center gap-4">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw9e0Ez8kcPL3R7GtTdsIszwJ8M4JpSefntg&s" 
               alt="Logo UTU" 
               class="w-12 h-12 rounded-lg object-cover">
          <div>
            <div class="text-xl font-bold text-primary">Panel de Administración</div>
            <div class="text-xs text-gray-500 font-medium">UTU Trinidad Flores</div>
          </div>
        </div>
        <a href="/" class="text-gray-600 hover:text-accent transition-colors font-medium text-sm">
          <i class="fas fa-home mr-2"></i>Volver al inicio
        </a>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-6 py-12">
    <div class="grid lg:grid-cols-2 gap-8">
      
      <!-- Formulario Crear Evento -->
      <div class="form-card p-8">
        <div class="section-header">
          <div class="section-icon blue">
            <i class="fas fa-calendar-plus"></i>
          </div>
          <div>
            <h2 class="text-2xl font-bold text-gray-900">Crear Evento</h2>
            <p class="text-sm text-gray-500">Publica un nuevo evento institucional</p>
          </div>
        </div>
        
        <form id="formEvento" class="space-y-6">
          <div>
            <label for="titulo-evento" class="form-label">
              <i class="fas fa-heading label-icon"></i>Título del Evento
            </label>
            <input 
              type="text" 
              id="titulo-evento" 
              name="nombre" 
              class="form-input"
              placeholder="Ej: Jornada de Puertas Abiertas 2025"
              required
            >
          </div>

          <div>
            <label for="descripcion-evento" class="form-label">
              <i class="fas fa-align-left label-icon"></i>Descripción
            </label>
            <textarea 
              id="descripcion-evento" 
              name="descripcion" 
              class="form-input form-textarea"
              placeholder="Describe los detalles del evento..."
              required
            ></textarea>
          </div>

          <div>
            <label for="fecha-evento" class="form-label">
              <i class="fas fa-calendar label-icon"></i>Fecha del Evento
            </label>
            <input 
              type="date" 
              id="fecha-evento" 
              name="fecha_evento" 
              class="form-input"
              required
            >
          </div>

          <button type="submit" class="btn-primary" id="btnEvento">
            <i class="fas fa-paper-plane"></i>
            <span>Publicar Evento</span>
          </button>
        </form>
      </div>

      <!-- Formulario Crear Noticia -->
      <div class="form-card p-8">
        <div class="section-header">
          <div class="section-icon orange">
            <i class="fas fa-newspaper"></i>
          </div>
          <div>
            <h2 class="text-2xl font-bold text-gray-900">Crear Noticia</h2>
            <p class="text-sm text-gray-500">Publica contenido con imagen destacada</p>
          </div>
        </div>
        
        <form id="formNoticia" class="space-y-6">
          <div>
            <label for="titulo-noticia" class="form-label">
              <i class="fas fa-heading label-icon"></i>Título de la Noticia
            </label>
            <input 
              type="text" 
              id="titulo-noticia" 
              name="titulo" 
              class="form-input"
              placeholder="Ej: Inicio del Ciclo Lectivo 2025"
              required
            >
          </div>

          <div>
            <label for="contenido-noticia" class="form-label">
              <i class="fas fa-align-left label-icon"></i>Contenido
            </label>
            <textarea 
              id="contenido-noticia" 
              name="contenido" 
              class="form-input form-textarea"
              placeholder="Escribe el contenido de la noticia..."
              required
            ></textarea>
          </div>

          <div>
            <label class="form-label">
              <i class="fas fa-image label-icon"></i>Imagen <span class="text-red-500">*</span>
            </label>
            <div class="file-upload-area" id="uploadArea">
              <input 
                type="file" 
                id="imagen-noticia" 
                name="imagen" 
                accept="image/*"
                class="file-upload-input"
                onchange="handleFileSelect(event)"
                required
              >
              <div>
                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3 block"></i>
                <p id="file-name-noticia" class="text-sm text-gray-600 font-medium">
                  Haz clic o arrastra una imagen aquí
                </p>
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, GIF o WebP (máx. 5MB)</p>
              </div>
            </div>
          </div>

          <button type="submit" class="btn-primary" id="btnNoticia">
            <i class="fas fa-paper-plane"></i>
            <span>Publicar Noticia</span>
          </button>
        </form>
      </div>

    </div>

    <!-- Información Adicional -->
    <div class="mt-12 text-center">
      <div class="bg-white rounded-lg p-6 shadow-sm border">
        <h3 class="text-lg font-semibold text-utu-blue mb-2">
          <i class="fas fa-info-circle mr-2"></i>
          Información Importante
        </h3>
        <p class="text-gray-600 text-sm">
          Los eventos y noticias publicados aquí serán visibles para todos los usuarios en la página principal.
          Asegúrese de verificar la información antes de publicar.
        </p>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-primary text-white mt-16 py-8">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <p class="text-sm text-gray-400 mb-4">
        &copy; 2025 Escuela Técnica Trinidad Flores. Todos los derechos reservados.
      </p>
      <div class="flex justify-center gap-6 text-sm">
        <a href="#" class="text-gray-400 hover:text-accent transition-colors">Política de Privacidad</a>
        <a href="#" class="text-gray-400 hover:text-accent transition-colors">Términos de Servicio</a>
        <a href="#" class="text-gray-400 hover:text-accent transition-colors">Soporte</a>
      </div>
    </div>
  </footer>

  <script>
    let imagenBase64 = null;

    function goToHome() {
      window.location.href = '/';
    }

    function handleFileSelect(event) {
      const file = event.target.files[0];
      const fileNameDisplay = document.getElementById('file-name-noticia');
      const uploadArea = document.getElementById('uploadArea');
      
      if (file) {
        // Validar tipo
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
          mostrarNotificacion('Tipo de archivo no permitido. Use: JPG, PNG, GIF o WebP', 'error');
          event.target.value = '';
          return;
        }

        // Validar tamaño (5MB)
        if (file.size > 5242880) {
          mostrarNotificacion('La imagen no debe superar 5MB', 'error');
          event.target.value = '';
          return;
        }

        // Convertir a base64
        const reader = new FileReader();
        reader.onload = function(e) {
          imagenBase64 = e.target.result;
          fileNameDisplay.innerHTML = `<i class="fas fa-check-circle text-accent mr-2"></i>${file.name}`;
          fileNameDisplay.classList.add('text-accent', 'font-semibold');
          uploadArea.classList.add('has-file');
        };
        reader.onerror = function() {
          mostrarNotificacion('Error al leer la imagen', 'error');
        };
        reader.readAsDataURL(file);
      } else {
        resetFileInput();
      }
    }

    function resetFileInput() {
      imagenBase64 = null;
      const fileNameDisplay = document.getElementById('file-name-noticia');
      const uploadArea = document.getElementById('uploadArea');
      fileNameDisplay.textContent = 'Haz clic o arrastra una imagen aquí';
      fileNameDisplay.classList.remove('text-accent', 'font-semibold');
      uploadArea.classList.remove('has-file');
    }

    function mostrarNotificacion(mensaje, tipo) {
      const notification = document.createElement('div');
      notification.className = `notification ${tipo}`;
      
      const icon = tipo === 'success' ? 'check' : 'times';
      
      notification.innerHTML = `
        <div class="notification-icon">
          <i class="fas fa-${icon}"></i>
        </div>
        <span>${mensaje}</span>
      `;
      
      document.body.appendChild(notification);
      
      setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
      }, 4000);
    }

    function setButtonLoading(button, isLoading) {
      const originalContent = button.innerHTML;
      if (isLoading) {
        button.disabled = true;
        button.innerHTML = '<div class="spinner"></div><span>Publicando...</span>';
        button.dataset.originalContent = originalContent;
      } else {
        button.disabled = false;
        button.innerHTML = button.dataset.originalContent || originalContent;
      }
    }

    // Submit Evento
    document.getElementById('formEvento').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const button = document.getElementById('btnEvento');
      setButtonLoading(button, true);
      
      const formData = new FormData(this);
      const data = {
        nombre: formData.get('nombre'),
        descripcion: formData.get('descripcion'),
        fecha_evento: formData.get('fecha_evento')
      };

      try {
        const response = await fetch('/api/v1/eventos/crear', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          credentials: 'include', // Importante: envía las cookies de sesión
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
          mostrarNotificacion('Evento creado exitosamente', 'success');
          this.reset();
        } else {
          mostrarNotificacion('Error: ' + (result.message || 'No se pudo crear el evento'), 'error');
        }
      } catch (error) {
        mostrarNotificacion('Error de conexión: ' + error.message, 'error');
      } finally {
        setButtonLoading(button, false);
      }
    });

    // Submit Noticia
    document.getElementById('formNoticia').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      // Validar que se haya seleccionado una imagen
      if (!imagenBase64) {
        mostrarNotificacion('Debe seleccionar una imagen', 'error');
        return;
      }

      const button = document.getElementById('btnNoticia');
      setButtonLoading(button, true);

      const data = {
        titulo: document.getElementById('titulo-noticia').value,
        contenido: document.getElementById('contenido-noticia').value,
        imagen: imagenBase64
      };

      try {
        const response = await fetch('/api/v1/noticias/crear', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          credentials: 'include', // Importante: envía las cookies de sesión
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
          mostrarNotificacion('Noticia creada exitosamente', 'success');
          this.reset();
          resetFileInput();
        } else {
          mostrarNotificacion('Error: ' + (result.message || 'No se pudo crear la noticia'), 'error');
        }
      } catch (error) {
        mostrarNotificacion('Error de conexión: ' + error.message, 'error');
      } finally {
        setButtonLoading(button, false);
      }
    });

    // Establecer fecha mínima como hoy
    document.getElementById('fecha-evento').min = new Date().toISOString().split('T')[0];
  </script>
</body>
</html>