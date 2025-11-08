<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login');
    exit;
}

// Verificar permisos
$allowed_roles = ['ADMIN', 'DOCENTE'];
if (!in_array($_SESSION['user_rol'], $allowed_roles)) {
    header('Location: home');
    exit;
}

$userName = $_SESSION['user_name'];
$userRol = $_SESSION['user_rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat - UTU Escuela Técnica Trinidad Flores</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'utu-blue': '#003366',
                        'utu-blue-light': '#004d99',
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .message-sent { animation: slideInRight 0.3s ease; }
        .message-received { animation: slideInLeft 0.3s ease; }
        .pulse-notification { animation: pulse 0.6s ease-in-out; }
        
        .smooth-scroll {
            scroll-behavior: smooth;
        }
        
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .fade-in {
            animation: fadeIn 0.3s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Header -->
    <nav class="bg-gradient-to-r from-utu-blue to-utu-blue-light text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <button onclick="goBack()" class="px-3 py-2 rounded-lg transition-all bg-white bg-opacity-10 hover:bg-opacity-20 border-0">
                        <i class="fas fa-arrow-left"></i>
                    </button>
                    <div>
                        <h1 class="text-xl font-bold m-0">Sistema de Mensajería</h1>
                        <p class="text-sm opacity-80 m-0">Comunícate con docentes y administradores</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="bg-white bg-opacity-20 px-3 py-2 rounded-full text-sm">
                        <?php echo htmlspecialchars($userName); ?> (<?php echo $userRol; ?>)
                    </span>
                    <button onclick="logout()" class="bg-white bg-opacity-20 hover:bg-opacity-30 px-4 py-2 rounded-lg transition-all border-0 cursor-pointer text-white">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto p-4">
        <div class="bg-white rounded-xl shadow-xl overflow-hidden" style="height: calc(100vh - 200px);">
            <div class="flex h-full">
                <!-- Lista de usuarios -->
                <div class="w-full lg:w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col">
                    <div class="p-4 border-b border-gray-200 bg-white">
                        <div class="flex justify-between items-center">
                            <h2 class="text-lg font-semibold text-gray-800 m-0">Conversaciones</h2>
                            <div id="global-notification" class="hidden">
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full pulse-notification">
                                    Nuevos mensajes
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="flex-1 overflow-y-auto scrollbar-hide">
                        <div id="users-list" class="p-2">
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-spinner fa-spin text-2xl mb-3"></i>
                                <p class="m-0">Cargando usuarios...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Área de chat -->
                <div class="w-full lg:w-2/3 flex flex-col">
                    <!-- Header del chat -->
                    <div id="chat-header" class="p-4 border-b border-gray-200 bg-white">
                        <div class="text-center text-gray-500 py-4">
                            <i class="fas fa-comments text-xl mb-2"></i>
                            <p class="m-0">Selecciona una conversación para comenzar a chatear</p>
                        </div>
                    </div>

                    <!-- Mensajes -->
                    <div id="messages-container" class="flex-1 p-4 bg-gray-50 overflow-y-auto smooth-scroll scrollbar-hide">
                        <div class="text-center text-gray-500 py-12">
                            <i class="fas fa-comments text-5xl mb-4 opacity-20"></i>
                            <p class="text-lg m-0 mb-1">Selecciona un contacto</p>
                            <p class="text-sm m-0">para ver los mensajes</p>
                        </div>
                    </div>

                    <!-- Input para mensajes -->
                    <div id="message-input-container" class="p-4 border-t border-gray-200 bg-white hidden">
                        <div class="flex gap-2">
                            <input 
                                type="text" 
                                id="message-input" 
                                placeholder="Escribe tu mensaje..." 
                                maxlength="500"
                                class="flex-1 border border-gray-300 rounded-lg px-4 py-3 outline-none text-sm transition-all focus:border-blue-500 focus:ring-2 focus:ring-blue-100"
                            >
                            <button 
                                onclick="sendMessage()" 
                                class="bg-gradient-to-r from-utu-blue to-utu-blue-light text-white px-6 py-3 rounded-lg transition-all hover:-translate-y-0.5 hover:shadow-lg border-0 cursor-pointer"
                            >
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                        <div class="text-xs text-gray-500 mt-2 text-right">
                            <span id="char-count">0</span>/500 caracteres
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentReceiver = null;
        let currentReceiverName = '';
        let messageInterval = null;
        let usersInterval = null;
        let unreadMessages = {};
        let lastMessages = [];
        let isFirstLoad = true;

        function goBack() {
            window.location.href = 'home';
        }

        function logout() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                window.location.href = '/api/v1/user/logout';
            }
        }

        function scrollToBottom(container) {
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 100);
        }

        // Sistema de notificaciones mejorado
        function updateUnreadBadges() {
            let totalUnread = 0;
            
            document.querySelectorAll('.user-item').forEach(item => {
                const userId = item.getAttribute('data-user-id');
                const badge = item.querySelector('.unread-badge');
                const count = unreadMessages[userId] || 0;
                totalUnread += count;
                
                if (count > 0) {
                    if (!badge) {
                        const newBadge = document.createElement('div');
                        newBadge.className = 'unread-badge bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full ml-auto';
                        newBadge.textContent = count > 99 ? '99+' : count;
                        item.querySelector('.flex-1').appendChild(newBadge);
                    } else {
                        badge.textContent = count > 99 ? '99+' : count;
                    }
                } else if (badge) {
                    badge.remove();
                }
            });
            
            // Notificación global
            const globalNotification = document.getElementById('global-notification');
            if (totalUnread > 0 && currentReceiver) {
                globalNotification.classList.remove('hidden');
            } else {
                globalNotification.classList.add('hidden');
            }
        }

        function markMessagesAsRead(userId) {
            if (unreadMessages[userId]) {
                delete unreadMessages[userId];
                updateUnreadBadges();
                
                // Actualizar la lista de usuarios para quitar el badge
                loadUsers();
            }
        }

        async function loadUsers() {
            try {
                const response = await fetch('/api/v1/mensajeria/getUsers', {
                    method: 'GET',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' }
                });
                
                if (!response.ok) throw new Error('Error del servidor');
                
                const data = await response.json();
                const usersList = document.getElementById('users-list');
                
                if (data.status === 'success' && data.data && data.data.length > 0) {
                    usersList.innerHTML = data.data.map(user => {
                        const unreadCount = unreadMessages[user.id] || 0;
                        const isActive = currentReceiver === user.id;
                        
                        return `
                        <div class="user-item p-3 border-b border-gray-100 cursor-pointer transition-all rounded-lg mb-1 hover:bg-gray-100 ${isActive ? 'bg-blue-50 border-2 border-blue-500' : ''}" 
                             onclick="selectUser(${user.id}, '${escapeHtml(user.nombre)}', '${user.rol}')" 
                             data-user-id="${user.id}">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-utu-blue to-utu-blue-light rounded-full flex items-center justify-center text-white font-semibold">
                                    ${user.nombre.charAt(0).toUpperCase()}
                                </div>
                                <div class="flex-1 flex items-center justify-between">
                                    <div>
                                        <div class="font-semibold text-gray-800">${escapeHtml(user.nombre)}</div>
                                        <div class="text-xs text-gray-500 flex items-center gap-1">
                                            <span class="inline-block w-1.5 h-1.5 rounded-full ${user.rol === 'ADMIN' ? 'bg-red-500' : 'bg-green-500'}"></span>
                                            ${user.rol}
                                        </div>
                                    </div>
                                    ${unreadCount > 0 ? `
                                    <div class="unread-badge bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                                        ${unreadCount > 99 ? '99+' : unreadCount}
                                    </div>
                                    ` : ''}
                                </div>
                            </div>
                        </div>
                    `}).join('');
                } else {
                    usersList.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-users text-4xl mb-3 opacity-20"></i>
                            <p class="m-0 mb-2">No hay usuarios disponibles</p>
                            <p class="text-sm m-0 text-gray-400">Solo se muestran docentes y administradores</p>
                        </div>
                    `;
                }
            } catch (error) {
                document.getElementById('users-list').innerHTML = `
                    <div class="text-center py-8 text-red-600">
                        <i class="fas fa-exclamation-triangle text-2xl mb-3"></i>
                        <p class="m-0 mb-2 font-semibold">Error al cargar usuarios</p>
                        <button onclick="loadUsers()" class="bg-utu-blue text-white px-4 py-2 rounded text-sm border-0 cursor-pointer hover:bg-utu-blue-light transition-colors">
                            <i class="fas fa-redo mr-1"></i> Reintentar
                        </button>
                    </div>
                `;
            }
        }

        // Verificar nuevos mensajes sin recargar toda la conversación
        async function checkNewMessages() {
            if (!currentReceiver) return;

            try {
                const response = await fetch(`/api/v1/mensajeria/getMessages?id_receptor=${currentReceiver}`, {
                    method: 'GET',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' }
                });

                if (!response.ok) return;

                const data = await response.json();
                
                if (data.status === 'success' && data.data) {
                    const newMessages = data.data;
                    
                    // Solo actualizar si hay mensajes nuevos
                    if (newMessages.length > lastMessages.length) {
                        const newMessageCount = newMessages.length - lastMessages.length;
                        
                        // Si no estamos en este chat, mostrar notificación
                        if (document.hidden || !isChatActive()) {
                            if (currentReceiver in unreadMessages) {
                                unreadMessages[currentReceiver] += newMessageCount;
                            } else {
                                unreadMessages[currentReceiver] = newMessageCount;
                            }
                            updateUnreadBadges();
                            
                            // Mostrar notificación del navegador
                            showBrowserNotification(newMessageCount);
                        }
                        
                        // Actualizar mensajes si estamos en el chat activo
                        if (isChatActive()) {
                            displayMessages(newMessages);
                        }
                        
                        lastMessages = newMessages;
                    }
                }
            } catch (error) {
                console.error('Error verificando mensajes:', error);
            }
        }

        function isChatActive() {
            return currentReceiver && !document.hidden;
        }

        function showBrowserNotification(messageCount) {
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification(`Nuevo mensaje de ${currentReceiverName}`, {
                    body: `Tienes ${messageCount} nuevo(s) mensaje(s)`,
                    icon: '/favicon.ico',
                    tag: 'chat-message'
                });
            }
        }

        function selectUser(userId, userName, userRol) {
            currentReceiver = userId;
            currentReceiverName = userName;
            
            // Marcar mensajes como leídos al seleccionar el chat
            markMessagesAsRead(userId);
            
            document.getElementById('chat-header').innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                        ${userName.charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800 text-lg">${escapeHtml(userName)}</div>
                        <div class="text-sm text-gray-500 flex items-center gap-1">
                            <span class="inline-block w-1.5 h-1.5 rounded-full ${userRol === 'ADMIN' ? 'bg-red-500' : 'bg-green-500'}"></span>
                            ${userRol}
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('message-input-container').classList.remove('hidden');
            
            // Cargar mensajes iniciales
            loadMessages();
            
            // Configurar intervalos
            setupIntervals();
            
            document.getElementById('message-input').focus();
        }

        function setupIntervals() {
            // Limpiar intervalos anteriores
            if (messageInterval) clearInterval(messageInterval);
            if (usersInterval) clearInterval(usersInterval);
            
            // Nuevos intervalos más espaciados
            messageInterval = setInterval(() => {
                if (currentReceiver) {
                    checkNewMessages();
                }
            }, 5000); // Cada 5 segundos para mensajes
            
            usersInterval = setInterval(loadUsers, 10000); // Cada 10 segundos para usuarios
        }

        async function loadMessages() {
            if (!currentReceiver) return;

            try {
                const response = await fetch(`/api/v1/mensajeria/getMessages?id_receptor=${currentReceiver}`, {
                    method: 'GET',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' }
                });

                if (!response.ok) throw new Error('Error de conexión');

                const data = await response.json();
                const container = document.getElementById('messages-container');

                if (data.status === 'success') {
                    lastMessages = data.data || [];
                    displayMessages(lastMessages);
                    
                    if (isFirstLoad) {
                        isFirstLoad = false;
                    }
                } else {
                    showError('Error al cargar los mensajes');
                }
            } catch (error) {
                showError('Error de conexión');
            }
        }

        function displayMessages(messages) {
            const container = document.getElementById('messages-container');
            
            if (messages && messages.length > 0) {
                container.innerHTML = messages.map(msg => `
                    <div class="flex ${msg.es_mio ? 'justify-end' : 'justify-start'} mb-3 fade-in">
                        <div class="${msg.es_mio ? 'message-sent bg-gradient-to-r from-purple-500 to-purple-600 text-white' : 'message-received bg-gray-200 text-gray-800'} max-w-[70%] px-4 py-3 rounded-2xl ${msg.es_mio ? 'rounded-br-md' : 'rounded-bl-md'} shadow-sm">
                            ${!msg.es_mio ? `<div class="text-xs font-semibold mb-1 opacity-80">${escapeHtml(msg.nombre_emisor)}</div>` : ''}
                            <div class="text-sm leading-relaxed break-words">${escapeHtml(msg.contenido)}</div>
                            <div class="text-xs opacity-70 mt-1 ${msg.es_mio ? 'text-right' : 'text-left'}">
                                ${formatTime(msg.fecha_envio)}
                            </div>
                        </div>
                    </div>
                `).join('');
                
                scrollToBottom(container);
            } else {
                container.innerHTML = `
                    <div class="text-center text-gray-500 py-12">
                        <i class="fas fa-comment-slash text-5xl mb-4 opacity-20"></i>
                        <p class="text-lg m-0 mb-2">No hay mensajes aún</p>
                        <p class="text-sm m-0">¡Sé el primero en enviar un mensaje!</p>
                    </div>
                `;
            }
        }

        function showError(message) {
            const container = document.getElementById('messages-container');
            container.innerHTML = `
                <div class="text-center text-red-600 py-12">
                    <i class="fas fa-exclamation-circle text-2xl mb-4"></i>
                    <p class="text-base mb-2">${message}</p>
                    <button onclick="loadMessages()" class="mt-4 bg-utu-blue text-white px-4 py-2 rounded text-sm border-0 cursor-pointer">
                        <i class="fas fa-redo"></i> Reintentar
                    </button>
                </div>
            `;
        }

        async function sendMessage() {
            if (!currentReceiver) return;

            const input = document.getElementById('message-input');
            const contenido = input.value.trim();

            if (!contenido) {
                input.focus();
                return;
            }

            try {
                const response = await fetch('/api/v1/mensajeria/sendMessage', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id_receptor: currentReceiver,
                        contenido: contenido
                    })
                });

                const data = await response.json();

                if (data.success || data.status === 'success') {
                    input.value = '';
                    updateCharCount();
                    // Recargar mensajes después de enviar
                    loadMessages();
                } else {
                    alert('Error: ' + (data.message || 'No se pudo enviar el mensaje'));
                }
            } catch (error) {
                alert('Error de conexión al enviar mensaje');
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function formatTime(dateString) {
            try {
                const date = new Date(dateString);
                return date.toLocaleTimeString('es-ES', { hour: '2-digit', minute: '2-digit' });
            } catch (e) {
                return '--:--';
            }
        }

        function updateCharCount() {
            const input = document.getElementById('message-input');
            const count = document.getElementById('char-count');
            const charCount = input.value.length;
            count.textContent = charCount;
            
            if (charCount > 450) count.className = 'text-red-600';
            else if (charCount > 400) count.className = 'text-orange-500';
            else count.className = 'text-gray-500';
        }

        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        }

        document.getElementById('message-input').addEventListener('input', updateCharCount);
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            loadUsers();
            updateCharCount();
            requestNotificationPermission();
        });

        window.addEventListener('beforeunload', function() {
            if (messageInterval) clearInterval(messageInterval);
            if (usersInterval) clearInterval(usersInterval);
        });
    </script>
</body>
</html>