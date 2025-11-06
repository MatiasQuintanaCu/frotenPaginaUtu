<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UTU</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            width: 100%;
            max-width: 400px;
            transform: translateY(0);
            transition: transform 0.3s ease;
        }

        .login-container:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #333;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #555;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            transition: color 0.3s ease;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #666;
            font-size: 16px;
            padding: 4px;
        }

        .password-toggle:hover {
            color: #667eea;
        }

        .login-button {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .login-button:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .login-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }

        .register-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            color: #764ba2;
        }

        .error-message {
            color: #e74c3c;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .success-message {
            color: #27ae60;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .form-group.error input {
            border-color: #e74c3c;
        }

        .form-group.success input {
            border-color: #27ae60;
        }

        .form-group.error .error-message {
            display: block;
        }

        #message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            display: none;
        }

        .message-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block !important;
        }

        .message-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block !important;
        }

        .message-loading {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            display: block !important;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
                margin: 10px;
            }

            .login-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>Iniciar Sesión</h1>
            <p>Bienvenido de vuelta</p>
        </div>
        
        <form id="loginForm" novalidate>
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required placeholder="tu@correo.com">
                <div class="error-message">Ingresa un email válido</div>
            </div>
            
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <div style="position: relative;">
                    <input type="password" id="contrasena" name="contrasena" required placeholder="Tu contraseña">
                    <button type="button" class="password-toggle" onclick="togglePassword()">
                        👁️
                    </button>
                </div>
                <div class="error-message">La contraseña es requerida</div>
            </div>
            
            <button type="submit" class="login-button" id="loginBtn">
                Ingresar
            </button>
        </form>

        <div id="message"></div>
        
        <div class="register-link">
            ¿No tienes cuenta? <a href="register">Regístrate aquí</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('contrasena');
            const toggleButton = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }

        function showMessage(message, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = message;
            messageDiv.className = type;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Verificar si ya está logueado
        async function checkExistingSession() {
            try {
                const res = await fetch("/api/v1/user/check_session", {
                    method: "GET",
                    credentials: "include"
                });
                
                const data = await res.json();
                if (data.success) {
                    // Si ya hay sesión, redirigir al home
                    window.location.href = "home";
                }
            } catch (error) {
                console.log("No hay sesión activa o error al verificar:", error);
            }
        }

        // Validación del formulario
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Limpiar errores previos
            document.querySelectorAll('.form-group').forEach(group => {
                group.classList.remove('error');
            });
            
            let hasErrors = false;
            
            // Validaciones
            const correo = document.getElementById('correo');
            const contrasena = document.getElementById('contrasena');
            
            if (!correo.value.trim() || !validateEmail(correo.value)) {
                correo.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            if (!contrasena.value) {
                contrasena.parentElement.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            if (hasErrors) {
                showMessage('❌ Por favor, corrige los errores en el formulario', 'message-error');
                return;
            }

            // Deshabilitar botón durante el envío
            const button = document.getElementById('loginBtn');
            button.textContent = 'Iniciando sesión...';
            button.disabled = true;
            showMessage('⏳ Verificando credenciales...', 'message-loading');

            try {
                const data = {
                    email: correo.value.trim(),
                    password: contrasena.value
                };

                // ✅ RUTA CORREGIDA: usa el router sin .php
                const res = await fetch("/api/v1/user/login", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    credentials: "include", // Importante para enviar cookies de sesión
                    body: JSON.stringify(data) // ✅ NO OLVIDAR ESTA LÍNEA
                });

                const responseData = await res.json();
                
                if (responseData.success) {
                    showMessage(`✅ ${responseData.message}`, 'message-success');
                    
                    // Guardar información del usuario en localStorage (opcional)
                    if (responseData.data && responseData.data.user) {
                        localStorage.setItem('user', JSON.stringify(responseData.data.user));
                        localStorage.setItem('user_name', responseData.data.user.nombre);
                    }
                    
                    // Redirigir después de login exitoso
                    setTimeout(() => {
                        const redirectUrl = (responseData.data && responseData.data.redirect) || 'home';
                        window.location.href = redirectUrl;
                    }, 1500);
                } else {
                    showMessage(`❌ ${responseData.message}`, 'message-error');
                }
                
            } catch (err) {
                console.error("Error de conexión:", err);
                showMessage("❌ Error al conectar con el servidor. Verifica tu conexión.", "message-error");
            } finally {
                // Rehabilitar botón
                button.disabled = false;
                button.textContent = 'Ingresar';
            }
        });

        // Validación en tiempo real
        document.getElementById('correo').addEventListener('input', function() {
            if (validateEmail(this.value)) {
                this.parentElement.classList.remove('error');
            } else if (this.value.length > 0) {
                this.parentElement.classList.add('error');
            } else {
                this.parentElement.classList.remove('error');
            }
        });

        document.getElementById('contrasena').addEventListener('input', function() {
            if (this.value.length > 0) {
                this.parentElement.parentElement.classList.remove('error');
            } else {
                this.parentElement.parentElement.classList.add('error');
            }
        });

        // Verificar sesión al cargar la página
        document.addEventListener('DOMContentLoaded', checkExistingSession);
    </script>
</body>
</html>