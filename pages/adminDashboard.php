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
    
    .admin-card {
      background: white;
      border-radius: 8px;
      padding: 24px;
      border: 1px solid #e2e8f0;
      transition: all 0.2s ease;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      border-top: 4px solid #2d7744;
    }
    
    .admin-card:hover {
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    .animate-slide-up { animation: slideUp 0.6s ease-out; }
  </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col font-sans">

  <!-- Navigation Mejorada -->
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
              Panel de Administración
            </span>
          </div>
        </div>
        
        <!-- Información del Usuario -->
        <div class="flex items-center gap-3">
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
          
          <!-- Botón Volver al Inicio -->
          <button onclick="goToHome()" 
                  class="btn-secondary font-semibold px-3 py-2 flex items-center gap-2">
            <i class="fas fa-home"></i>
            <span class="hidden sm:inline">Inicio</span>
          </button>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-1 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    <!-- Header del Panel -->
    <div class="text-center mb-8">
      <h1 class="text-3xl sm:text-4xl font-bold text-utu-blue mb-4">
        <i class="fas fa-cogs text-utu-green mr-3"></i>
        Panel de Administración
      </h1>
      <p class="text-gray-600 text-lg max-w-2xl mx-auto">
        Gestiona eventos y noticias institucionales de la Escuela Técnica Trinidad Flores
      </p>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
      
      <!-- Formulario Crear Evento -->
      <div class="admin-card animate-slide-up">
        <h2 class="section-title text-2xl font-bold mb-6 flex items-center gap-3">
          <i class="fas fa-calendar-plus text-utu-green"></i>
          Crear Evento
        </h2>
        
        <form id="formEvento" class="space-y-6">
          <div>
            <label for="titulo-evento" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-heading text-utu-blue mr-2"></i>Título del Evento
            </label>
            <input 
              type="text" 
              id="titulo-evento" 
              name="nombre" 
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-utu-blue focus:ring-2 focus:ring-utu-blue/20 transition-all outline-none"
              placeholder="Ingrese el título del evento"
              required
            >
          </div>

          <div>
            <label for="descripcion-evento" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-align-left text-utu-blue mr-2"></i>Descripción
            </label>
            <textarea 
              id="descripcion-evento" 
              name="descripcion" 
              rows="5"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-utu-blue focus:ring-2 focus:ring-utu-blue/20 transition-all outline-none resize-none"
              placeholder="Ingrese la descripción del evento"
              required
            ></textarea>
          </div>

          <div>
            <label for="fecha-evento" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-calendar text-utu-blue mr-2"></i>Fecha del Evento
            </label>
            <input 
              type="date" 
              id="fecha-evento" 
              name="fecha_evento" 
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-utu-blue focus:ring-2 focus:ring-utu-blue/20 transition-all outline-none"
              required
            >
          </div>

          <button 
            type="submit" 
            class="w-full bg-utu-blue text-white font-bold py-3 rounded-lg shadow hover:shadow-lg hover:bg-utu-blue-dark transition-all duration-300 flex items-center justify-center gap-3"
          >
            <i class="fas fa-paper-plane"></i>
            <span>Publicar Evento</span>
          </button>
        </form>

        <!-- Mensajes -->
        <div id="mensaje-evento" class="mt-4 hidden"></div>
      </div>

      <!-- Formulario Crear Noticia -->
      <div class="admin-card animate-slide-up" style="animation-delay: 0.1s;">
        <h2 class="section-title text-2xl font-bold mb-6 flex items-center gap-3">
          <i class="fas fa-newspaper text-utu-green"></i>
          Crear Noticia
        </h2>
        
        <form id="formNoticia" class="space-y-6">
          <div>
            <label for="titulo-noticia" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-heading text-utu-blue mr-2"></i>Título de la Noticia
            </label>
            <input 
              type="text" 
              id="titulo-noticia" 
              name="titulo" 
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-utu-blue focus:ring-2 focus:ring-utu-blue/20 transition-all outline-none"
              placeholder="Ingrese el título de la noticia"
              required
            >
          </div>

          <div>
            <label for="contenido-noticia" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-align-left text-utu-blue mr-2"></i>Contenido
            </label>
            <textarea 
              id="contenido-noticia" 
              name="contenido" 
              rows="5"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-utu-blue focus:ring-2 focus:ring-utu-blue/20 transition-all outline-none resize-none"
              placeholder="Ingrese el contenido de la noticia"
              required
            ></textarea>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-image text-utu-blue mr-2"></i>Imagen <span class="text-utu-red">*</span>
            </label>
            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center cursor-pointer hover:border-utu-blue hover:bg-blue-50 transition-all group">
              <input 
                type="file" 
                id="imagen-noticia" 
                name="imagen" 
                accept="image/*"
                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                onchange="handleFileSelect(event)"
                required
              >
              <div class="pointer-events-none">
                <i class="fas fa-cloud-upload-alt text-4xl text-utu-blue mb-3 group-hover:scale-110 transition-transform"></i>
                <p id="file-name-noticia" class="text-gray-600 font-medium">Seleccionar imagen (obligatorio)</p>
                <p class="text-sm text-gray-500 mt-2">Formatos: JPG, PNG, GIF, WEBP - Máx. 5MB</p>
              </div>
            </div>
          </div>

          <button 
            type="submit" 
            class="w-full bg-utu-green text-white font-bold py-3 rounded-lg shadow hover:shadow-lg hover:bg-utu-green/90 transition-all duration-300 flex items-center justify-center gap-3"
          >
            <i class="fas fa-paper-plane"></i>
            <span>Publicar Noticia</span>
          </button>
        </form>

        <!-- Mensajes -->
        <div id="mensaje-noticia" class="mt-4 hidden"></div>
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

  <!-- Footer Institucional -->
  <footer class="footer-institutional text-gray-300 mt-12">
    <div class="max-w-7xl mx-auto px-6 py-8">
      <div class="text-center">
        <p class="mb-4 text-sm opacity-90">&copy; 2025 Escuela Técnica Trinidad Flores (UTU). Todos los derechos reservados.</p>
        <div class="flex justify-center gap-6 flex-wrap">
          <a href="#" class="text-sm hover:text-accent transition-colors px-3 py-1 rounded hover:bg-white/10">Política de Privacidad</a>
          <a href="#" class="text-sm hover:text-accent transition-colors px-3 py-1 rounded hover:bg-white/10">Términos de Servicio</a>
          <a href="/" class="text-sm hover:text-accent transition-colors px-3 py-1 rounded hover:bg-white/10">Volver al Inicio</a>
        </div>
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
      const span = document.getElementById('file-name-noticia');
      
      if (file) {
        // Validar tipo
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        if (!allowedTypes.includes(file.type)) {
          mostrarMensaje('mensaje-noticia', 'error', '❌ Tipo de archivo no permitido. Use: jpg, png, gif, webp');
          event.target.value = '';
          return;
        }

        // Validar tamaño (5MB)
        if (file.size > 5242880) {
          mostrarMensaje('mensaje-noticia', 'error', '❌ La imagen no debe superar 5MB');
          event.target.value = '';
          return;
        }

        // Convertir a base64
        const reader = new FileReader();
        reader.onload = function(e) {
          imagenBase64 = e.target.result;
          span.textContent = file.name;
          span.classList.add('text-utu-blue', 'font-bold');
        };
        reader.onerror = function() {
          mostrarMensaje('mensaje-noticia', 'error', '❌ Error al leer la imagen');
        };
        reader.readAsDataURL(file);
      } else {
        imagenBase64 = null;
        span.textContent = 'Seleccionar imagen (obligatorio)';
        span.classList.remove('text-utu-blue', 'font-bold');
      }
    }

    function mostrarMensaje(id, tipo, texto) {
      const div = document.getElementById(id);
      const bgColor = tipo === 'success' ? 'bg-green-100 border-green-300 text-green-800' : 'bg-red-100 border-red-300 text-red-800';
      const icon = tipo === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
      
      div.className = `p-4 rounded-lg mt-4 border ${bgColor}`;
      div.innerHTML = `<i class="fas ${icon} mr-2"></i>${texto}`;
      div.classList.remove('hidden');
      
      setTimeout(() => {
        div.classList.add('hidden');
      }, 5000);
    }

    // Submit Evento
    document.getElementById('formEvento').addEventListener('submit', async function(e) {
      e.preventDefault();
      
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
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
          mostrarMensaje('mensaje-evento', 'success', '✅ Evento creado exitosamente!');
          this.reset();
        } else {
          mostrarMensaje('mensaje-evento', 'error', '❌ Error: ' + (result.message || 'No se pudo crear el evento'));
        }
      } catch (error) {
        mostrarMensaje('mensaje-evento', 'error', '❌ Error de conexión: ' + error.message);
      }
    });

    // Submit Noticia
    document.getElementById('formNoticia').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      // Validar que se haya seleccionado una imagen
      if (!imagenBase64) {
        mostrarMensaje('mensaje-noticia', 'error', '❌ Debe seleccionar una imagen');
        return;
      }

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
          body: JSON.stringify(data)
        });

        const result = await response.json();

        if (response.ok) {
          mostrarMensaje('mensaje-noticia', 'success', '✅ Noticia creada exitosamente!');
          this.reset();
          imagenBase64 = null;
          document.getElementById('file-name-noticia').textContent = 'Seleccionar imagen (obligatorio)';
          document.getElementById('file-name-noticia').classList.remove('text-utu-blue', 'font-bold');
        } else {
          mostrarMensaje('mensaje-noticia', 'error', '❌ Error: ' + (result.message || 'No se pudo crear la noticia'));
        }
      } catch (error) {
        mostrarMensaje('mensaje-noticia', 'error', '❌ Error de conexión: ' + error.message);
      }
    });

    // Establecer fecha mínima como hoy
    document.getElementById('fecha-evento').min = new Date().toISOString().split('T')[0];
  </script>
</body>
</html>