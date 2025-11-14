<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - UTU Trinidad Flores</title>
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

        .login-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .login-card:hover {
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
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md">
        <!-- Logo Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-2xl mb-4">
                <i class="fas fa-graduation-cap text-accent text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Bienvenido</h1>
            <p class="text-gray-600">UTU Trinidad Flores</p>
        </div>

        <!-- Login Card -->
        <div class="login-card bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form id="loginForm" class="space-y-6">
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
                            placeholder="tu@correo.com"
                            required
                        >
                    </div>
                    <p class="text-red-500 text-xs mt-1 hidden" id="emailError">Ingresa un email válido</p>
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
                            placeholder="Tu contraseña"
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
                    <p class="text-red-500 text-xs mt-1 hidden" id="passwordError">La contraseña es requerida</p>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="loginBtn"
                    class="w-full bg-accent hover:bg-accent/90 text-white font-semibold py-3 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 hover:shadow-lg hover:-translate-y-0.5"
                >
                    <span>Iniciar Sesión</span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    ¿No tienes cuenta? 
                    <a href="register" class="text-accent font-semibold hover:text-accent/80 transition-colors">
                        Regístrate aquí
                    </a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-sm text-gray-500">
            <p>&copy; 2025 UTU Trinidad Flores</p>
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

        function showNotification(message, type) {
            // Remove existing notifications
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
                button.innerHTML = '<div class="spinner"></div><span>Iniciando sesión...</span>';
            } else {
                button.disabled = false;
                button.innerHTML = '<span>Iniciar Sesión</span><i class="fas fa-arrow-right"></i>';
            }
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
                    window.location.href = "home";
                }
            } catch (error) {
                console.log("No hay sesión activa");
            }
        }

        // Form validation
        document.getElementById('correo').addEventListener('input', function() {
            const emailError = document.getElementById('emailError');
            if (this.value && !validateEmail(this.value)) {
                emailError.classList.remove('hidden');
                this.classList.add('border-red-500');
            } else {
                emailError.classList.add('hidden');
                this.classList.remove('border-red-500');
            }
        });

        document.getElementById('contrasena').addEventListener('input', function() {
            const passwordError = document.getElementById('passwordError');
            if (!this.value) {
                passwordError.classList.remove('hidden');
                this.classList.add('border-red-500');
            } else {
                passwordError.classList.add('hidden');
                this.classList.remove('border-red-500');
            }
        });

        // Form submit
        document.getElementById('loginForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const correo = document.getElementById('correo');
            const contrasena = document.getElementById('contrasena');
            let hasErrors = false;
            
            // Validate
            if (!correo.value.trim() || !validateEmail(correo.value)) {
                document.getElementById('emailError').classList.remove('hidden');
                correo.classList.add('border-red-500');
                hasErrors = true;
            }
            
            if (!contrasena.value) {
                document.getElementById('passwordError').classList.remove('hidden');
                contrasena.classList.add('border-red-500');
                hasErrors = true;
            }
            
            if (hasErrors) {
                showNotification('Por favor, corrige los errores en el formulario', 'error');
                return;
            }

            const button = document.getElementById('loginBtn');
            setButtonLoading(button, true);
            showNotification('Verificando credenciales...', 'info');

            try {
                const data = {
                    email: correo.value.trim(),
                    password: contrasena.value
                };

                const res = await fetch("/api/v1/user/login", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    credentials: "include",
                    body: JSON.stringify(data)
                });

                const responseData = await res.json();
                
                if (responseData.success) {
                    showNotification(responseData.message || 'Inicio de sesión exitoso', 'success');
                    
                    if (responseData.data && responseData.data.user) {
                        localStorage.setItem('user', JSON.stringify(responseData.data.user));
                        localStorage.setItem('user_name', responseData.data.user.nombre);
                    }
                    
                    setTimeout(() => {
                        const redirectUrl = (responseData.data && responseData.data.redirect) || 'home';
                        window.location.href = redirectUrl;
                    }, 1500);
                } else {
                    showNotification(responseData.message || 'Error al iniciar sesión', 'error');
                }
                
            } catch (err) {
                console.error("Error:", err);
                showNotification("Error al conectar con el servidor", "error");
            } finally {
                setButtonLoading(button, false);
            }
        });

        // Check session on load
        document.addEventListener('DOMContentLoaded', checkExistingSession);
    </script>
</body>
</html>
