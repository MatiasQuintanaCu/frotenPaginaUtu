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
      font-family: 'Segoe UI', -apple-system, BlinkMacSystemFont, 'Arial', sans-serif;
      background: linear-gradient(135deg, #e8f0f8 0%, #f8f9fa 100%);
      color: #333;
      line-height: 1.6;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    nav {
      background: #003366;
      color: white;
      padding: 20px 40px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 4px 20px rgba(0, 51, 102, 0.3);
      position: relative;
      overflow: hidden;
    }

    nav::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
      animation: shine 3s infinite;
    }

    @keyframes shine {
      0% { left: -100%; }
      50%, 100% { left: 100%; }
    }

    .nav-left {
      display: flex;
      align-items: center;
      gap: 15px;
      position: relative;
      z-index: 1;
    }

    .nav-left span {
      font-size: 1.4em;
      font-weight: 700;
      letter-spacing: 0.5px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
    }

    #LogoUtu { 
      width: 65px; 
      height: 65px;
      border-radius: 50%; 
      object-fit: cover;
      border: 3px solid rgba(255, 255, 255, 0.3);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.4s ease;
      animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-5px); }
    }

    #LogoUtu:hover {
      transform: scale(1.1) rotate(5deg);
      box-shadow: 0 6px 20px rgba(255, 255, 255, 0.4);
    }

    .main-container {
      flex: 1;
      padding: 40px 20px;
      display: flex;
      max-width: 1600px;
      margin: 0 auto;
      width: 100%;
    }

    .forms-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 40px;
      width: 100%;
    }

    .form-section {
      background: white;
      padding: 50px;
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      gap: 25px;
      transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
      position: relative;
      overflow: hidden;
      animation: slideUp 0.6s ease-out;
    }

    @keyframes slideUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .form-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 5px;
      background: linear-gradient(90deg, #003366, #0066cc, #003366);
      background-size: 200% 100%;
      animation: gradientMove 3s linear infinite;
    }

    .form-section:nth-child(2)::before {
      background: linear-gradient(90deg, #ff6b35, #ff8c5a, #ff6b35);
      background-size: 200% 100%;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      100% { background-position: 200% 50%; }
    }

    .form-section:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.15);
    }

    .form-section h2 {
      color: #003d82;
      font-size: 2em;
      font-weight: 700;
      text-align: center;
      margin-bottom: 15px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.05);
    }

    .form-section h2 i {
      font-size: 1.1em;
      animation: bounce 2s ease-in-out infinite;
    }

    @keyframes bounce {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-5px); }
    }

    .form-group {
      display: flex;
      flex-direction: column;
      gap: 10px;
      animation: fadeIn 0.5s ease-out backwards;
    }

    .form-group:nth-child(1) { animation-delay: 0.1s; }
    .form-group:nth-child(2) { animation-delay: 0.2s; }
    .form-group:nth-child(3) { animation-delay: 0.3s; }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateX(-20px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    .form-group label {
      font-weight: 600;
      color: #495057;
      font-size: 1em;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .form-group label::before {
      content: '•';
      color: #003366;
      font-size: 1.5em;
      line-height: 0;
    }

    .form-input {
      padding: 18px 20px;
      border: 2px solid #e0e3e8;
      border-radius: 12px;
      font-size: 1.05em;
      font-family: 'Segoe UI', sans-serif;
      transition: all 0.3s ease;
      background: #fafbfc;
    }

    .form-input:hover {
      border-color: #b0b8c0;
      background: white;
    }

    .form-input:focus {
      outline: none;
      border-color: #003366;
      box-shadow: 0 0 0 4px rgba(0, 51, 102, 0.1), 0 4px 12px rgba(0, 51, 102, 0.15);
      background: white;
      transform: translateY(-2px);
    }

    textarea.form-input {
      min-height: 160px;
      resize: vertical;
      flex: 1;
    }

    .file-input-wrapper {
      position: relative;
      padding: 35px;
      border: 3px dashed #d0d5dd;
      border-radius: 12px;
      text-align: center;
      cursor: pointer;
      transition: all 0.3s ease;
      background: linear-gradient(135deg, #fafbfc 0%, #f0f2f5 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 110px;
    }

    .file-input-wrapper:hover {
      border-color: #003366;
      background: linear-gradient(135deg, #e8f0f8 0%, #d8e5f5 100%);
      transform: scale(1.02);
      box-shadow: 0 4px 15px rgba(0, 51, 102, 0.1);
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
      gap: 10px;
      pointer-events: none;
    }

    .file-input-label i {
      font-size: 2.5em;
      color: #003366;
      transition: all 0.3s ease;
    }

    .file-input-wrapper:hover .file-input-label i {
      transform: translateY(-5px) scale(1.1);
      color: #0066cc;
    }

    .file-input-label span {
      color: #6c757d;
      font-size: 0.95em;
      font-weight: 500;
    }

    .submit-btn {
      padding: 18px 40px;
      border: none;
      border-radius: 12px;
      font-size: 1.15em;
      font-weight: 700;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      position: relative;
      overflow: hidden;
    }

    .submit-btn::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      width: 0;
      height: 0;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.3);
      transform: translate(-50%, -50%);
      transition: width 0.6s, height 0.6s;
    }

    .submit-btn:hover::before {
      width: 400px;
      height: 400px;
    }

    .submit-btn i,
    .submit-btn span {
      position: relative;
      z-index: 1;
    }

    .submit-btn-evento {
      background: linear-gradient(135deg, #003366 0%, #004080 100%);
      color: white;
      box-shadow: 0 6px 20px rgba(0, 51, 102, 0.3);
    }

    .submit-btn-evento:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(0, 51, 102, 0.4);
    }

    .submit-btn-evento:active {
      transform: translateY(-1px);
    }

    .submit-btn-noticia {
      background: linear-gradient(135deg, #ff6b35 0%, #ff8c5a 100%);
      color: white;
      box-shadow: 0 6px 20px rgba(255, 107, 53, 0.3);
    }

    .submit-btn-noticia:hover {
      transform: translateY(-3px);
      box-shadow: 0 10px 30px rgba(255, 107, 53, 0.4);
    }

    .submit-btn-noticia:active {
      transform: translateY(-1px);
    }

    footer {
      background: #003366;
      color: white;
      padding: 25px 20px;
      text-align: center;
      box-shadow: 0 -4px 20px rgba(0, 51, 102, 0.2);
      margin-top: 40px;
    }

    .footer-content {
      max-width: 900px;
      margin: 0 auto;
    }

    .footer-content p { 
      margin-bottom: 12px; 
      font-size: 14px;
      opacity: 0.95;
    }

    .footer-links {
      display: flex;
      justify-content: center;
      gap: 20px;
      flex-wrap: wrap;
    }

    .footer-links a {
      color: #fff;
      text-decoration: none;
      font-size: 14px;
      transition: all 0.3s ease;
      padding: 6px 12px;
      border-radius: 6px;
    }

    .footer-links a:hover { 
      color: #ffcc00;
      background: rgba(255, 204, 0, 0.15);
      transform: translateY(-2px);
    }

    input[type="date"].form-input {
      cursor: pointer;
    }

    @media (max-width: 1024px) {
      .forms-grid {
        grid-template-columns: 1fr;
        gap: 30px;
      }
      
      .main-container {
        padding: 30px 15px;
      }
    }

    @media (max-width: 768px) {
      nav {
        padding: 15px 20px;
      }

      .nav-left span {
        font-size: 1.1em;
      }

      #LogoUtu {
        width: 55px;
        height: 55px;
      }

      .form-section {
        padding: 35px 25px;
      }
      
      .form-section h2 {
        font-size: 1.6em;
      }

      .submit-btn {
        padding: 16px 35px;
        font-size: 1em;
      }
    }
  </style>
</head>
<body>

  <nav>
    <div class="nav-left">
      <img id="LogoUtu" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRw9e0Ez8kcPL3R7GtTdsIszwJ8M4JpSefntg&s" alt="LogoUtu">
      <span>UTU - Universidad Técnica del Uruguay</span>
    </div>
  </nav>

  <div class="main-container">
    <div class="forms-grid">
      
      <!-- Formulario Crear Evento -->
      <div class="form-section">
        <h2><i class="fas fa-calendar-plus"></i> Crear Evento</h2>
        
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
            <span>Publicar Evento</span>
          </button>
        </form>
      </div>

      <!-- Formulario Crear Noticia -->
      <div class="form-section">
        <h2><i class="fas fa-newspaper"></i> Crear Noticia</h2>
        
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
            <label for="contenido-noticia">Descripción</label>
            <textarea 
              id="contenido-noticia" 
              name="contenido" 
              class="form-input" 
              placeholder="Ingrese el contenido de la noticia"
              required
            ></textarea>
          </div>

          <div class="form-group">
            <label>Publicar Imagen</label>
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
                <span id="file-name-noticia">Seleccionar imagen (opcional)</span>
              </div>
            </div>
          </div>

          <button type="submit" class="submit-btn submit-btn-noticia">
            <i class="fas fa-paper-plane"></i>
            <span>Publicar Noticia</span>
          </button>
        </form>
      </div>

    </div>
  </div>

  <footer>
    <div class="footer-content">
      <p>&copy; 2025 UTU - Universidad Técnica del Uruguay. Todos los derechos reservados.</p>
      <div class="footer-links">
        <a href="#">Política de Privacidad</a>
        <a href="#">Términos de Servicio</a>
        <a href="#">Acceso</a>
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
        span.textContent = 'Seleccionar imagen (opcional)';
        span.style.color = '#6c757d';
        span.style.fontWeight = '500';
      }
    }

    function submitEvento(event) {
      event.preventDefault();
      
      const formData = new FormData(event.target);
      
      console.log('Datos del Evento:');
      console.log('Nombre:', formData.get('nombre'));
      console.log('Descripción:', formData.get('descripcion'));
      console.log('Fecha:', formData.get('fecha_evento'));
      
      alert('✅ Evento creado exitosamente!\n(Conectar con backend PHP)');
      event.target.reset();
    }

    function submitNoticia(event) {
      event.preventDefault();
      
      const formData = new FormData(event.target);
      
      console.log('Datos de la Noticia:');
      console.log('Título:', formData.get('titulo'));
      console.log('Contenido:', formData.get('contenido'));
      
      alert('✅ Noticia creada exitosamente!\n(Conectar con backend PHP)');
      event.target.reset();
    }
  </script>
</body>
</html>