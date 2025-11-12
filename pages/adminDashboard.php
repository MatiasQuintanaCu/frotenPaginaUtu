<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UTU - Panel de Administración</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <style>
    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-5px); }
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(30px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-float { animation: float 3s ease-in-out infinite; }
    .animate-slide-up { animation: slideUp 0.6s ease-out; }
  </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-gray-100 min-h-screen flex flex-col">

  <!-- Navigation -->
  <nav class="bg-gradient-to-r from-blue-900 to-blue-800 text-white shadow-2xl">
    <div class="container mx-auto px-6 py-5 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <img 
          src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw9e0Ez8kcPL3R7GtTdsIszwJ8M4JpSefntg&s" 
          alt="Logo UTU"
          class="w-16 h-16 rounded-full object-cover border-4 border-white/30 shadow-lg hover:scale-110 transition-transform animate-float"
        >
        <span class="text-2xl font-bold tracking-wide drop-shadow-lg">UTU - Universidad Técnica del Uruguay</span>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="flex-1 container mx-auto px-4 py-12">
    <div class="grid lg:grid-cols-2 gap-8 max-w-7xl mx-auto">
      
      <!-- Formulario Crear Evento -->
      <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 animate-slide-up border-t-4 border-blue-600">
        <h2 class="text-3xl font-bold text-blue-900 mb-8 flex items-center gap-3">
          <i class="fas fa-calendar-plus text-blue-600"></i>
          Crear Evento
        </h2>
        
        <form id="formEvento" class="space-y-6">
          <div>
            <label for="titulo-evento" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-heading text-blue-600 mr-2"></i>Título del Evento
            </label>
            <input 
              type="text" 
              id="titulo-evento" 
              name="nombre" 
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all outline-none"
              placeholder="Ingrese el título del evento"
              required
            >
          </div>

          <div>
            <label for="descripcion-evento" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-align-left text-blue-600 mr-2"></i>Descripción
            </label>
            <textarea 
              id="descripcion-evento" 
              name="descripcion" 
              rows="5"
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all outline-none resize-none"
              placeholder="Ingrese la descripción del evento"
              required
            ></textarea>
          </div>

          <div>
            <label for="fecha-evento" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-calendar text-blue-600 mr-2"></i>Fecha del Evento
            </label>
            <input 
              type="date" 
              id="fecha-evento" 
              name="fecha_evento" 
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all outline-none"
              required
            >
          </div>

          <button 
            type="submit" 
            class="w-full bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg"
          >
            <i class="fas fa-paper-plane"></i>
            <span>Publicar Evento</span>
          </button>
        </form>

        <!-- Mensajes -->
        <div id="mensaje-evento" class="mt-4 hidden"></div>
      </div>

      <!-- Formulario Crear Noticia -->
      <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 animate-slide-up border-t-4 border-orange-500" style="animation-delay: 0.1s;">
        <h2 class="text-3xl font-bold text-orange-900 mb-8 flex items-center gap-3">
          <i class="fas fa-newspaper text-orange-600"></i>
          Crear Noticia
        </h2>
        
        <form id="formNoticia" class="space-y-6">
          <div>
            <label for="titulo-noticia" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-heading text-orange-600 mr-2"></i>Título de la Noticia
            </label>
            <input 
              type="text" 
              id="titulo-noticia" 
              name="titulo" 
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all outline-none"
              placeholder="Ingrese el título de la noticia"
              required
            >
          </div>

          <div>
            <label for="contenido-noticia" class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-align-left text-orange-600 mr-2"></i>Contenido
            </label>
            <textarea 
              id="contenido-noticia" 
              name="contenido" 
              rows="5"
              class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-orange-500 focus:ring-4 focus:ring-orange-100 transition-all outline-none resize-none"
              placeholder="Ingrese el contenido de la noticia"
              required
            ></textarea>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
              <i class="fas fa-image text-orange-600 mr-2"></i>Imagen <span class="text-red-500">*</span>
            </label>
            <div class="relative border-3 border-dashed border-gray-300 rounded-xl p-8 text-center cursor-pointer hover:border-orange-500 hover:bg-orange-50 transition-all group">
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
                <i class="fas fa-cloud-upload-alt text-5xl text-orange-500 mb-3 group-hover:scale-110 transition-transform"></i>
                <p id="file-name-noticia" class="text-gray-600 font-medium">Seleccionar imagen (obligatorio)</p>
              </div>
            </div>
          </div>

          <button 
            type="submit" 
            class="w-full bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3 text-lg"
          >
            <i class="fas fa-paper-plane"></i>
            <span>Publicar Noticia</span>
          </button>
        </form>

        <!-- Mensajes -->
        <div id="mensaje-noticia" class="mt-4 hidden"></div>
      </div>

    </div>
  </main>

  <!-- Footer -->
  <footer class="bg-gradient-to-r from-blue-900 to-blue-800 text-white mt-16 shadow-2xl">
    <div class="container mx-auto px-6 py-8">
      <div class="text-center">
        <p class="mb-4 text-sm opacity-90">&copy; 2025 UTU - Universidad Técnica del Uruguay. Todos los derechos reservados.</p>
        <div class="flex justify-center gap-6 flex-wrap">
          <a href="#" class="text-sm hover:text-yellow-300 transition-colors px-3 py-1 rounded hover:bg-white/10">Política de Privacidad</a>
          <a href="#" class="text-sm hover:text-yellow-300 transition-colors px-3 py-1 rounded hover:bg-white/10">Términos de Servicio</a>
          <a href="#" class="text-sm hover:text-yellow-300 transition-colors px-3 py-1 rounded hover:bg-white/10">Acceso</a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    let imagenBase64 = null;

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
          span.classList.add('text-orange-600', 'font-bold');
        };
        reader.onerror = function() {
          mostrarMensaje('mensaje-noticia', 'error', '❌ Error al leer la imagen');
        };
        reader.readAsDataURL(file);
      } else {
        imagenBase64 = null;
        span.textContent = 'Seleccionar imagen (obligatorio)';
        span.classList.remove('text-orange-600', 'font-bold');
      }
    }

    function mostrarMensaje(id, tipo, texto) {
      const div = document.getElementById(id);
      div.className = `p-4 rounded-xl mt-4 ${tipo === 'success' ? 'bg-green-100 text-green-800 border-2 border-green-300' : 'bg-red-100 text-red-800 border-2 border-red-300'}`;
      div.innerHTML = `<i class="fas fa-${tipo === 'success' ? 'check-circle' : 'exclamation-circle'} mr-2"></i>${texto}`;
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
          document.getElementById('file-name-noticia').classList.remove('text-orange-600', 'font-bold');
        } else {
          mostrarMensaje('mensaje-noticia', 'error', '❌ Error: ' + (result.message || 'No se pudo crear la noticia'));
        }
      } catch (error) {
        mostrarMensaje('mensaje-noticia', 'error', '❌ Error de conexión: ' + error.message);
      }
    });
  </script>
</body>
</html>