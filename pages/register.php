<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Cuenta - UTU Trinidad Flores</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#0A2540',
                        'accent': '#00A67E',
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .register-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .input-field {
            transition: all 0.2s ease;
        }

        .input-field:focus {
            transform: translateY(-1px);
            box-shadow: 0 0 0 3px rgba(0, 166, 126, 0.1);
        }

        .strength-bar {
            height: 4px;
            border-radius: 2px;
            transition: all 0.3s ease;
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

        .notification {
            animation: slideIn 0.3s ease;
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

        .modal {
            backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-2xl mb-4">
                <i class="fas fa-user-plus text-accent text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Crear Cuenta</h1>
            <p class="text-gray-600">Únete a UTU Trinidad Flores</p>
        </div>

        <!-- Register Card -->
        <div class="register-card bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form id="registerForm" class="space-y-6">
                <!-- Name Field -->
                <div>
                    <label for="nombre" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nombre Completo
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input 
                            type="text" 
                            id="nombre" 
                            name="nombre" 
                            class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-accent"
                            placeholder="Ingresa tu nombre completo"
                            required
                        >
                    </div>
                    <p class="text-red-500 text-xs mt-1 hidden" id="nameError">El nombre debe tener al menos 3 caracteres</p>
                    <p class="text-accent text-xs mt-1 hidden" id="nameSuccess">✓ Nombre válido</p>
                </div>

                <!-- Email Field -->
                <div>
                    <label for="correo" class="block text-sm font-semibold text-gray-700 mb-2">
                        Correo Electrónico
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input 
                            type="email" 
                            id="correo" 
                            name="correo" 
                            class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-accent"
                            placeholder="ejemplo@correo.com"
                            required
                        >
                    </div>
                    <p class="text-red-500 text-xs mt-1 hidden" id="emailError">Ingresa un email válido</p>
                    <p class="text-accent text-xs mt-1 hidden" id="emailSuccess">✓ Email válido</p>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="contrasena" class="block text-sm font-semibold text-gray-700 mb-2">
                        Contraseña
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input 
                            type="password" 
                            id="contrasena" 
                            name="contrasena" 
                            class="input-field w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:outline-none focus:border-accent"
                            placeholder="Mínimo 6 caracteres"
                            required
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-accent transition-colors"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    
                    <!-- Password Strength -->
                    <div class="mt-2">
                        <div class="w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                            <div id="strengthBar" class="strength-bar h-full bg-gray-300" style="width: 0%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1" id="strengthText">Ingresa una contraseña</p>
                    </div>
                    <p class="text-red-500 text-xs mt-1 hidden" id="passwordError">La contraseña debe tener al menos 6 caracteres</p>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="registerBtn"
                    class="w-full bg-accent hover:bg-accent/90 text-white font-semibold py-3 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 hover:shadow-lg hover:-translate-y-0.5"
                >
                    <span>Crear Cuenta</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Login Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    ¿Ya tienes cuenta? 
                    <a href="login" class="text-accent font-semibold hover:text-accent/80 transition-colors">
                        Inicia sesión aquí
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-sm text-gray-500">
            <p>&copy; 2025 UTU Trinidad Flores</p>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-8 text-center">
            <div class="w-16 h-16 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check-circle text-accent text-3xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-2">¡Registro Exitoso!</h2>
            <p class="text-gray-600 mb-6">Tu cuenta ha sido creada. Ahora puedes iniciar sesión.</p>
            <button 
                onclick="goToLogin()"
                class="w-full bg-accent hover:bg-accent/90 text-white font-semibold py-3 rounded-xl transition-colors"
            >
                Ir al Login
            </button>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('contrasena');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        function checkPasswordStrength(password) {
            let strength = 0;
            let text = '';
            let width = 0;
            let color = '';
            
            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            switch (strength) {
                case 0:
                case 1:
                    text = 'Muy débil';
                    width = 25;
                    color = '#EF4444';
                    break;
                case 2:
                    text = 'Débil';
                    width = 40;
                    color = '#F97316';
                    break;
                case 3:
                    text = 'Regular';
                    width = 60;
                    color = '#EAB308';
                    break;
                case 4:
                    text = 'Buena';
                    width = 80;
                    color = '#84CC16';
                    break;
                case 5:
                    text = 'Muy fuerte';
                    width = 100;
                    color = '#00A67E';
                    break;
            }
            
            return { text, width, color };
        }

        function showNotification(message, type) {
            document.querySelectorAll('.notification').forEach(n => n.remove());

            const notification = document.createElement('div');
            notification.className = `notification fixed top-6 right-6 z-50 max-w-md px-6 py-4 rounded-xl shadow-2xl flex items-center gap-3 ${
                type === 'success' ? 'bg-white border border-accent text-gray-900' : 
                type === 'error' ? 'bg-white border border-red-500 text-gray-900' : 
                'bg-white border border-blue-500 text-gray-900'
            }`;
            
            const icon = type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle';
            const iconColor = type === 'success' ? 'bg-accent' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
            
            notification.innerHTML = `
                <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center ${iconColor}">
                    <i class="fas fa-${icon} text-white text-xs"></i>
                </div>
                <span class="font-medium">${message}</span>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 4000);
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function setButtonLoading(button, isLoading) {
            if (isLoading) {
                button.disabled = true;
                button.innerHTML = '<div class="spinner"></div><span>Creando cuenta...</span>';
            } else {
                button.disabled = false;
                button.innerHTML = '<span>Crear Cuenta</span><i class="fas fa-arrow-right"></i>';
            }
        }

        // Password strength indicator
        document.getElementById('contrasena').addEventListener('input', function() {
            const result = checkPasswordStrength(this.value);
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const passwordError = document.getElementById('passwordError');
            
            strengthBar.style.width = result.width + '%';
            strengthBar.style.backgroundColor = result.color;
            strengthText.textContent = result.text;
            strengthText.style.color = result.color;
            
            if (this.value.length >= 6) {
                passwordError.classList.add('hidden');
                this.classList.remove('border-red-500');
            } else if (this.value.length > 0) {
                passwordError.classList.remove('hidden');
                this.classList.add('border-red-500');
            }
        });

        // Name validation
        document.getElementById('nombre').addEventListener('input', function() {
            const nameError = document.getElementById('nameError');
            const nameSuccess = document.getElementById('nameSuccess');
            
            if (this.value.length >= 3) {
                nameError.classList.add('hidden');
                nameSuccess.classList.remove('hidden');
                this.classList.remove('border-red-500');
            } else if (this.value.length > 0) {
                nameError.classList.remove('hidden');
                nameSuccess.classList.add('hidden');
                this.classList.add('border-red-500');
            } else {
                nameError.classList.add('hidden');
                nameSuccess.classList.add('hidden');
                this.classList.remove('border-red-500');
            }
        });

        // Email validation
        document.getElementById('correo').addEventListener('input', function() {
            const emailError = document.getElementById('emailError');
            const emailSuccess = document.getElementById('emailSuccess');
            
            if (validateEmail(this.value)) {
                emailError.classList.add('hidden');
                emailSuccess.classList.remove('hidden');
                this.classList.remove('border-red-500');
            } else if (this.value.length > 0) {
                emailError.classList.remove('hidden');
                emailSuccess.classList.add('hidden');
                this.classList.add('border-red-500');
            } else {
                emailError.classList.add('hidden');
                emailSuccess.classList.add('hidden');
                this.classList.remove('border-red-500');
            }
        });

        // Form submit
        document.getElementById('registerForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const nombre = document.getElementById('nombre');
            const correo = document.getElementById('correo');
            const contrasena = document.getElementById('contrasena');
            let hasErrors = false;
            
            // Validate
            if (nombre.value.length < 3) {
                document.getElementById('nameError').classList.remove('hidden');
                nombre.classList.add('border-red-500');
                hasErrors = true;
            }
            
            if (!validateEmail(correo.value)) {
                document.getElementById('emailError').classList.remove('hidden');
                correo.classList.add('border-red-500');
                hasErrors = true;
            }
            
            if (contrasena.value.length < 6) {
                document.getElementById('passwordError').classList.remove('hidden');
                contrasena.classList.add('border-red-500');
                hasErrors = true;
            }
            
            if (hasErrors) {
                showNotification('Por favor, corrige los errores en el formulario', 'error');
                return;
            }

            const button = document.getElementById('registerBtn');
            setButtonLoading(button, true);
            showNotification('Procesando registro...', 'info');

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
                    showNotification("Error en la respuesta del servidor", "error");
                    return;
                }

                if (res.ok) {
                    showNotification(json.message || "¡Registro exitoso!", "success");
                    this.reset();
                    document.getElementById('strengthBar').style.width = '0%';
                    document.getElementById('strengthText').textContent = 'Ingresa una contraseña';
                    document.querySelectorAll('.text-accent').forEach(el => el.classList.add('hidden'));
                    
                    setTimeout(() => {
                        document.getElementById('successModal').classList.remove('hidden');
                    }, 1000);
                } else {
                    const errorMessage = json.error || json.detalle || `Error HTTP ${res.status}`;
                    showNotification(errorMessage, "error");
                }
                
            } catch (err) {
                console.error("Error:", err);
                showNotification("Error al conectar con el servidor", "error");
            } finally {
                setButtonLoading(button, false);
            }
        });

        function goToLogin() {
            window.location.href = 'login';
        }
    </script>
</body>
</html>