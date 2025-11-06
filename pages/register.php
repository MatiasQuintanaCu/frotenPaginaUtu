<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro - Crear Cuenta</title>
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

    .register-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 40px;
        width: 100%;
        max-width: 450px;
        transform: translateY(0);
        transition: transform 0.3s ease;
    }

    .register-container:hover {
        transform: translateY(-5px);
    }

    .register-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .register-header h1 {
        color: #333;
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .register-header p {
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

    .password-strength {
        margin-top: 5px;
        font-size: 12px;
    }

    .strength-bar {
        width: 100%;
        height: 4px;
        background: #e1e5e9;
        border-radius: 2px;
        margin: 5px 0;
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .strength-weak { background: #e74c3c; width: 25%; }
    .strength-fair { background: #f39c12; width: 50%; }
    .strength-good { background: #f1c40f; width: 75%; }
    .strength-strong { background: #27ae60; width: 100%; }

    .register-button {
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

    .register-button:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
    }

    .register-button:active {
        transform: translateY(0);
    }

    .register-button:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .login-link {
        text-align: center;
        margin-top: 20px;
        font-size: 14px;
        color: #666;
    }

    .login-link a {
        color: #667eea;
        text-decoration: none;
        font-weight: 600;
    }

    .login-link a:hover {
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

    .form-group.success .success-message {
        display: block;
    }

    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
        z-index: 1000;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 30px;
        border-radius: 15px;
        text-align: center;
        max-width: 400px;
        margin: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-content h2 {
        color: #27ae60;
        margin-bottom: 15px;
    }

    .modal-button {
        background: #667eea;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        margin-top: 15px;
    }

    #resultado {
        margin-top: 20px;
        padding: 15px;
        border-radius: 10px;
        text-align: center;
        font-weight: bold;
        display: none;
    }

    .result-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        display: block !important;
    }

    .result-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        display: block !important;
    }

    .result-loading {
        background-color: #d1ecf1;
        color: #0c5460;
        border: 1px solid #bee5eb;
        display: block !important;
    }

    @media (max-width: 480px) {
        .register-container {
            padding: 30px 20px;
            margin: 10px;
        }

        .register-header h1 {
            font-size: 24px;
        }
    }
  </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>Crear Cuenta</h1>
            <p>Únete a nuestra comunidad</p>
        </div>
        
        <form id="registerForm" novalidate>
            <div class="form-group">
                <label for="nombre">Nombre Completo</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ingresa tu nombre completo">
                <div class="error-message">El nombre debe tener al menos 3 caracteres</div>
                <div class="success-message">✓ Nombre válido</div>
            </div>
            
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required placeholder="ejemplo@correo.com">
                <div class="error-message">Ingresa un email válido</div>
                <div class="success-message">✓ Email válido</div>
            </div>
            
            <div class="form-group">
                <label for="contrasena">Contraseña</label>
                <div style="position: relative;">
                    <input type="password" id="contrasena" name="contrasena" required placeholder="Mínimo 6 caracteres">
                    <button type="button" class="password-toggle" onclick="togglePassword('contrasena')">
                        👁️
                    </button>
                </div>
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthBar"></div>
                    </div>
                    <span id="strengthText">Ingresa una contraseña</span>
                </div>
                <div class="error-message">La contraseña debe tener al menos 6 caracteres</div>
            </div>
            
            <button type="submit" class="register-button" id="registerBtn">
                Crear Cuenta
            </button>
        </form>

        <div id="resultado"></div>
        
        <div class="login-link">
            ¿Ya tienes cuenta? <a href="login">Inicia sesión aquí</a>
        </div>
    </div>

    <!-- Modal de éxito -->
    <div class="modal" id="successModal">
        <div class="modal-content">
            <h2>¡Registro Exitoso!</h2>
            <p>Tu cuenta ha sido creada exitosamente. Ahora puedes iniciar sesión.</p>
            <button class="modal-button" onclick="goToLoginFromModal()">Ir al Login</button>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const passwordInput = document.getElementById(inputId);
            const toggleButton = passwordInput.nextElementSibling;
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.textContent = '🙈';
            } else {
                passwordInput.type = 'password';
                toggleButton.textContent = '👁️';
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            let text = '';
            let className = '';
            
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            switch (strength) {
                case 0:
                case 1:
                    text = 'Muy débil';
                    className = 'strength-weak';
                    break;
                case 2:
                    text = 'Débil';
                    className = 'strength-weak';
                    break;
                case 3:
                    text = 'Regular';
                    className = 'strength-fair';
                    break;
                case 4:
                    text = 'Buena';
                    className = 'strength-good';
                    break;
                case 5:
                    text = 'Muy fuerte';
                    className = 'strength-strong';
                    break;
            }
            
            return { strength, text, className };
        }

        function showResult(message, type) {
            const resultado = document.getElementById('resultado');
            resultado.textContent = message;
            resultado.className = type;
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        // Event listeners
        document.getElementById('contrasena').addEventListener('input', function() {
            const result = checkPasswordStrength(this.value);
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            strengthBar.className = 'strength-fill ' + result.className;
            strengthText.textContent = result.text;
            
            // Validación básica
            const formGroup = this.parentElement.parentElement;
            if (this.value.length >= 6) {
                formGroup.classList.remove('error');
                formGroup.classList.add('success');
            } else if (this.value.length > 0) {
                formGroup.classList.remove('success');
                formGroup.classList.add('error');
            } else {
                formGroup.classList.remove('error', 'success');
            }
        });

        document.getElementById('nombre').addEventListener('input', function() {
            const nombre = this.value;
            const formGroup = this.parentElement;
            
            if (nombre.length >= 3) {
                formGroup.classList.remove('error');
                formGroup.classList.add('success');
            } else if (nombre.length > 0) {
                formGroup.classList.remove('success');
                formGroup.classList.add('error');
            } else {
                formGroup.classList.remove('error', 'success');
            }
        });

        document.getElementById('correo').addEventListener('input', function() {
            const email = this.value;
            const formGroup = this.parentElement;
            
            if (validateEmail(email)) {
                formGroup.classList.remove('error');
                formGroup.classList.add('success');
            } else if (email.length > 0) {
                formGroup.classList.remove('success');
                formGroup.classList.add('error');
            } else {
                formGroup.classList.remove('error', 'success');
            }
        });

        // Validación del formulario
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Limpiar errores previos
            document.querySelectorAll('.form-group').forEach(group => {
                group.classList.remove('error');
            });
            
            let hasErrors = false;
            
            // Validaciones
            const nombre = document.getElementById('nombre');
            const correo = document.getElementById('correo');
            const contrasena = document.getElementById('contrasena');
            
            if (!nombre.value.trim() || nombre.value.length < 3) {
                nombre.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            if (!correo.value.trim() || !validateEmail(correo.value)) {
                correo.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            if (!contrasena.value || contrasena.value.length < 6) {
                contrasena.parentElement.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            if (hasErrors) {
                showResult('❌ Por favor, corrige los errores en el formulario', 'result-error');
                return;
            }

            // Deshabilitar botón durante el envío
            const button = document.getElementById('registerBtn');
            button.textContent = 'Creando cuenta...';
            button.disabled = true;
            showResult('⏳ Procesando registro...', 'result-loading');

            try {
                const data = {
                    nombre: nombre.value.trim(),
                    correo: correo.value.trim(),
                    contrasena: contrasena.value
                };

                const res = await fetch("/api/v1/user/create.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data)
                });

                const text = await res.text();
                let json = {};
                
                try {
                    json = text ? JSON.parse(text) : {};
                } catch (parseError) {
                    console.error("Error parseando JSON:", parseError);
                    showResult("❌ Error en la respuesta del servidor", "result-error");
                    return;
                }

                if (!res.ok) {
                    const errorMessage = json.error || json.detalle || `Error HTTP ${res.status}`;
                    showResult(`❌ ${errorMessage}`, "result-error");
                } else {
                    showResult(`✅ ${json.message || "¡Registro exitoso!"}`, "result-success");
                    document.getElementById('registerForm').reset();
                    document.querySelectorAll('.form-group').forEach(group => {
                        group.classList.remove('success');
                    });
                    document.getElementById('strengthText').textContent = 'Ingresa una contraseña';
                    document.getElementById('strengthBar').className = 'strength-fill';
                    
                    // Mostrar modal de éxito
                    setTimeout(() => {
                        document.getElementById('successModal').style.display = 'flex';
                    }, 1000);
                }
                
            } catch (err) {
                console.error("Error de conexión:", err);
                showResult("❌ Error al conectar con el servidor. Verifica tu conexión.", "result-error");
            } finally {
                // Rehabilitar botón
                button.disabled = false;
                button.textContent = 'Crear Cuenta';
            }
        });

        function goToLoginFromModal() {
            window.location.href = 'login';
        }

        // Remover errores al escribir
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                this.parentElement.classList.remove('error');
                if (this.parentElement.parentElement.classList.contains('form-group')) {
                    this.parentElement.parentElement.classList.remove('error');
                }
            });
        });
    </script>
</body>
</html>