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

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .form-group label {
            display: block;
            color: #555;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
            transition: color 0.3s ease;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            color: #667eea;
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

        .terms-checkbox {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 20px 0;
            font-size: 14px;
        }

        .terms-checkbox input[type="checkbox"] {
            width: auto;
            margin-top: 2px;
        }

        .terms-checkbox label {
            margin: 0;
            line-height: 1.4;
        }

        .terms-checkbox a {
            color: #667eea;
            text-decoration: none;
        }

        .terms-checkbox a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

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

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
            color: #666;
            font-size: 14px;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
        }

        .divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 15px;
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

        .back-to-login {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .back-to-login:hover {
            background: white;
            transform: scale(1.1);
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
                margin: 10px;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .form-row {
                flex-direction: column;
                gap: 0;
            }
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

        .form-group.error input, .form-group.error select {
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
                <label for="username">Nombre de Usuario</label>
                <input type="text" id="username" name="username" required>
                <div class="error-message">El nombre de usuario debe tener al menos 3 caracteres</div>
                <div class="success-message">✓ Nombre de usuario disponible</div>
            </div>
            
            <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
                <div class="error-message">Ingresa un email válido</div>
                <div class="success-message">✓ Email válido</div>
            </div>


            
            <div class="form-group">
                <label for="password">Contraseña</label>
                <div style="position: relative;">
                    <input type="password" id="password" name="password" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('password')">
                        👁️
                    </button>
                </div>
                <div class="password-strength">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthBar"></div>
                    </div>
                    <span id="strengthText">Ingresa una contraseña</span>
                </div>
                <div class="error-message">La contraseña debe tener al menos 8 caracteres</div>
            </div>
            
            <div class="form-group">
                <label for="confirmPassword">Confirmar Contraseña</label>
                <div style="position: relative;">
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                    <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                        👁️
                    </button>
                </div>
                <div class="error-message">Las contraseñas no coinciden</div>
                <div class="success-message">✓ Las contraseñas coinciden</div>
            </div>
            

            
            <button type="submit" class="register-button" id="registerBtn">
                Crear Cuenta
            </button>
        </form>
        
        <div class="divider">
            <span>o</span>
        </div>
        
        <div class="login-link">
            ¿Ya tienes cuenta? <a href="Login.html" onclick="goToLogin()">Inicia sesión aquí</a>
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
            
            if (password.length >= 8) strength++;
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



        // Event listeners
        document.getElementById('password').addEventListener('input', function() {
            const result = checkPasswordStrength(this.value);
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            
            strengthBar.className = 'strength-fill ' + result.className;
            strengthText.textContent = result.text;
            
            // Limpiar error si hay contraseña
            if (this.value.length > 0) {
                this.parentElement.parentElement.classList.remove('error');
            }
        });

        document.getElementById('confirmPassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const formGroup = this.parentElement.parentElement;
            
            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    formGroup.classList.remove('error');
                    formGroup.classList.add('success');
                } else {
                    formGroup.classList.remove('success');
                    formGroup.classList.add('error');
                }
            } else {
                formGroup.classList.remove('error', 'success');
            }
        });

        document.getElementById('username').addEventListener('input', function() {
            const username = this.value;
            const formGroup = this.parentElement;
            
            if (username.length >= 3) {
                // Simular verificación de disponibilidad
                setTimeout(() => {
                    formGroup.classList.remove('error');
                    formGroup.classList.add('success');
                }, 500);
            } else {
                formGroup.classList.remove('success');
            }
        });

        document.getElementById('email').addEventListener('input', function() {
            const email = this.value;
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            const formGroup = this.parentElement;
            
            if (emailPattern.test(email)) {
                formGroup.classList.remove('error');
                formGroup.classList.add('success');
            } else {
                formGroup.classList.remove('success');
            }
        });

        // Validación del formulario
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Limpiar errores previos
            document.querySelectorAll('.form-group').forEach(group => {
                group.classList.remove('error');
            });
            
            let hasErrors = false;
            
            // Validaciones
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');
            
            if (!username.value.trim() || username.value.length < 3) {
                username.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!email.value.trim() || !emailPattern.test(email.value)) {
                email.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            if (!password.value || password.value.length < 8) {
                password.parentElement.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            if (password.value !== confirmPassword.value) {
                confirmPassword.parentElement.parentElement.classList.add('error');
                hasErrors = true;
            }
            
            if (!hasErrors) {
                // Simular registro
                const button = document.getElementById('registerBtn');
                button.textContent = 'Creando cuenta...';
                button.disabled = true;
                
                setTimeout(() => {
                    button.textContent = 'Crear Cuenta';
                    button.disabled = false;
                    document.getElementById('successModal').style.display = 'flex';
                }, 2000);
            }
        });

        // Remover errores al escribir
        document.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('input', function() {
                if (this.parentElement.classList.contains('form-group')) {
                    this.parentElement.classList.remove('error');
                } else {
                    this.parentElement.parentElement.classList.remove('error');
                }
            });
        });
    </script>
</body>
</html>