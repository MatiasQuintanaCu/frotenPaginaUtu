<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página No Encontrada - UTU Trinidad Flores</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
          }
        }
      }
    }
  </script>
  <style>
    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
    }
    .floating {
      animation: float 3s ease-in-out infinite;
    }
  </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen flex items-center justify-center p-4 font-sans">
  <div class="max-w-2xl w-full text-center">
    
    <!-- Logo UTU -->
    <div class="mb-8 flex justify-center">
      <div class="bg-white p-4 rounded-2xl shadow-lg inline-flex items-center gap-4">
        <div class="w-16 h-16 rounded-xl bg-utu-blue flex items-center justify-center text-white font-bold text-xl">
          UTU
        </div>
        <div class="text-left">
          <h1 class="text-xl font-bold text-utu-blue">UTU Trinidad Flores</h1>
          <p class="text-sm text-gray-600">Educación Técnica de Excelencia</p>
        </div>
      </div>
    </div>
    
    <!-- Contenido principal -->
    <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 mb-8">
      <!-- Icono animado -->
      <div class="floating mb-6">
        <div class="relative inline-flex">
          <div class="w-24 h-24 rounded-full bg-red-100 flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-4xl text-red-500"></i>
          </div>
          <div class="absolute -top-2 -right-2 w-10 h-10 rounded-full bg-utu-blue flex items-center justify-center text-white font-bold">
            404
          </div>
        </div>
      </div>
      
      <!-- Texto principal -->
      <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Página no encontrada</h1>
      <p class="text-gray-600 mb-2 text-lg">Lo sentimos, la página que estás buscando no existe o ha sido movida.</p>
      <p class="text-gray-500 mb-8">Puede que hayas escrito mal la dirección o que la página haya sido eliminada.</p>
      
      <!-- Botones de acción -->
      <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
        <a href="/" class="bg-utu-blue hover:bg-utu-blue-dark text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-300 flex items-center justify-center gap-2">
          <i class="fas fa-home"></i>
          Volver al Inicio
        </a>
        <a href="javascript:history.back()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold py-3 px-6 rounded-lg transition-colors duration-300 flex items-center justify-center gap-2">
          <i class="fas fa-arrow-left"></i>
          Página Anterior
        </a>
      </div>
      
      <!-- Información adicional -->
      <div class="bg-blue-50 rounded-xl p-4 border border-blue-200">
        <p class="text-blue-800 mb-2 flex items-center justify-center gap-2">
          <i class="fas fa-info-circle"></i>
          ¿Necesitas ayuda?
        </p>
        <p class="text-blue-700 text-sm">
          Si crees que esto es un error, por favor contacta con la administración del sitio.
        </p>
      </div>
    </div>
    
    <!-- Enlaces rápidos -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
      <a href="/login" class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow duration-300 flex items-center justify-center gap-2 text-utu-blue">
        <i class="fas fa-sign-in-alt"></i>
        Acceder al Sistema
      </a>
      <a href="#" class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow duration-300 flex items-center justify-center gap-2 text-utu-blue">
        <i class="fas fa-phone"></i>
        Contacto
      </a>
      <a href="#" class="bg-white rounded-lg p-4 shadow-md hover:shadow-lg transition-shadow duration-300 flex items-center justify-center gap-2 text-utu-blue">
        <i class="fas fa-map-marker-alt"></i>
        Ubicación
      </a>
    </div>
    
    <!-- Footer -->
    <div class="mt-8 text-center text-gray-500 text-sm">
      <p>UTU - Escuela Técnica Trinidad Flores &copy; 2025</p>
    </div>
  </div>
</body>
</html>