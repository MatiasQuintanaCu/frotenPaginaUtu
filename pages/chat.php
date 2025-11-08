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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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
                <!-- Lista de usuarios (izquierda) -->
                <div class="w-full lg:w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col">
                    <!-- Buscador y nuevo chat -->
                    <div class="p-4 border-b border-gray-200 bg-white">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800 m-0">Conversaciones</h2>
                            <div id="global-notification" class="hidden">
                                <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full pulse-notification">
                                    Nuevos mensajes
                                </span>
                            </div>
                        </div>

                        <!-- Buscador mejorado -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                id="userSearch" 
                                placeholder="Buscar o iniciar nuevo chat..." 
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-10 py-2.5 text-sm outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                            >
                            <button 
                                id="clearSearch"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 hidden"
                                onclick="clearSearch()"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        <!-- Resultados de búsqueda -->
                        <div id="searchResults" class="hidden mt-2 bg-white border border-gray-200 rounded-lg shadow-lg max-h-64 overflow-y-auto">
                            <div id="searchResultsList"></div>
                        </div>
                    </div>

                    <!-- Lista de conversaciones existentes -->
                    <div class="flex-1 overflow-y-auto scrollbar-hide">
                        <div id="users-list" class="p-2">
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-spinner fa-spin text-2xl mb-3"></i>
                                <p class="m-0">Cargando conversaciones...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Área de chat (derecha) -->
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
                                id="send-button"
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
        /* Estado */
        let currentReceiver = null;
        let currentReceiverName = '';
        let messageInterval = null;
        let usersInterval = null;
        let unreadMessages = {};
        let lastMessages = [];
        let isFirstLoad = true;
        let allUsers = []; // Cache de todos los usuarios

        /* Navegación */
        function goBack() { window.location.href = 'home'; }
        function logout() {
            if (confirm('¿Estás seguro de que quieres cerrar sesión?')) {
                window.location.href = '/api/v1/user/logout';
            }
        }

        function scrollToBottom(container) {
            setTimeout(() => container.scrollTop = container.scrollHeight, 100);
        }

        /* Badges / notificaciones */
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
                loadConversations();
            }
        }

        /* Cargar usuarios (para el buscador) */
        async function loadUsers() {
            try {
                const response = await fetch('/api/v1/mensajeria/getUsers', {
                    method: 'GET',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' }
                });

                if (!response.ok) throw new Error('Error del servidor');
                const data = await response.json();

                if (data.status === 'success' && data.data && data.data.length > 0) {
                    allUsers = data.data; // Guardar en cache
                } else {
                    allUsers = [];
                }
            } catch (error) {
                console.error('Error al cargar usuarios:', error);
                allUsers = [];
            } finally {
                loadConversations();
            }
        }

        /* Búsqueda de usuarios */
        function searchUsers() {
            const searchTerm = document.getElementById('userSearch').value.trim().toLowerCase();
            const searchResults = document.getElementById('searchResults');
            const searchResultsList = document.getElementById('searchResultsList');
            const clearBtn = document.getElementById('clearSearch');

            // Mostrar/ocultar botón de limpiar
            if (searchTerm) {
                clearBtn.classList.remove('hidden');
            } else {
                clearBtn.classList.add('hidden');
                searchResults.classList.add('hidden');
                return;
            }

            if (searchTerm.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            // Filtrar usuarios
            const filtered = allUsers.filter(user => 
                user.nombre.toLowerCase().includes(searchTerm) ||
                user.rol.toLowerCase().includes(searchTerm)
            );

            if (filtered.length === 0) {
                searchResultsList.innerHTML = `
                    <div class="p-4 text-center text-gray-500">
                        <i class="fas fa-user-slash mb-2"></i>
                        <p class="text-sm m-0">No se encontraron usuarios</p>
                    </div>
                `;
                searchResults.classList.remove('hidden');
                return;
            }

            // Mostrar resultados
            searchResultsList.innerHTML = '';
            filtered.forEach(user => {
                const item = document.createElement('div');
                item.className = 'p-3 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0';
                
                const flex = document.createElement('div');
                flex.className = 'flex items-center gap-3';

                const avatar = document.createElement('div');
                avatar.className = 'w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0';
                avatar.textContent = user.nombre.charAt(0).toUpperCase();

                const info = document.createElement('div');
                info.className = 'flex-1 min-w-0';

                const name = document.createElement('div');
                name.className = 'font-semibold text-gray-800 truncate';
                name.textContent = user.nombre;

                const role = document.createElement('div');
                role.className = 'text-xs text-gray-500 flex items-center gap-1';
                const dot = document.createElement('span');
                dot.className = `inline-block w-1.5 h-1.5 rounded-full ${user.rol === 'ADMIN' ? 'bg-red-500' : 'bg-green-500'}`;
                role.appendChild(dot);
                role.appendChild(document.createTextNode(user.rol));

                info.appendChild(name);
                info.appendChild(role);

                const icon = document.createElement('div');
                icon.className = 'text-gray-400';
                icon.innerHTML = '<i class="fas fa-comment-dots"></i>';

                flex.appendChild(avatar);
                flex.appendChild(info);
                flex.appendChild(icon);
                item.appendChild(flex);

                item.addEventListener('click', () => {
                    selectUser(user.id, user.nombre, user.rol);
                    clearSearch();
                });

                searchResultsList.appendChild(item);
            });

            searchResults.classList.remove('hidden');
        }

        function clearSearch() {
            document.getElementById('userSearch').value = '';
            document.getElementById('searchResults').classList.add('hidden');
            document.getElementById('clearSearch').classList.add('hidden');
        }

        /* Cargar conversaciones (solo usuarios con mensajes) */
        async function loadConversations() {
            const usersList = document.getElementById('users-list');
            try {
                const response = await fetch('/api/v1/mensajeria/getConversations', {
                    method: 'GET',
                    credentials: 'include',
                    headers: { 'Content-Type': 'application/json' }
                });

                if (!response.ok) {
                    if (response.status === 404) {
                        usersList.innerHTML = `
                            <div class="text-center py-8 text-gray-500">
                                <i class="fas fa-info-circle text-3xl mb-3"></i>
                                <p class="m-0 mb-2">El endpoint <strong>getConversations</strong> no está disponible.</p>
                                <p class="text-sm text-gray-400 m-0">Se mostrarán los usuarios desde el buscador arriba.</p>
                            </div>
                        `;
                        return;
                    }
                    throw new Error('Error del servidor');
                }

                const data = await response.json();

                if (data.status === 'success' && data.data && data.data.length > 0) {
                    usersList.innerHTML = '';
                    data.data.forEach(user => {
                        const item = document.createElement('div');
                        item.className = 'user-item p-3 border-b border-gray-100 cursor-pointer transition-all rounded-lg mb-1 hover:bg-gray-100';
                        item.setAttribute('data-user-id', user.id);

                        const flex = document.createElement('div');
                        flex.className = 'flex items-center gap-3';

                        const avatar = document.createElement('div');
                        avatar.className = 'w-10 h-10 bg-gradient-to-br from-utu-blue to-utu-blue-light rounded-full flex items-center justify-center text-white font-semibold';
                        avatar.textContent = (user.nombre || ' ')[0] ? user.nombre.charAt(0).toUpperCase() : '?';

                        const infoWrap = document.createElement('div');
                        infoWrap.className = 'flex-1';

                        const nameEl = document.createElement('div');
                        nameEl.className = 'font-semibold text-gray-800';
                        nameEl.textContent = user.nombre;

                        const roleEl = document.createElement('div');
                        roleEl.className = 'text-xs text-gray-500';
                        roleEl.textContent = user.rol;

                        infoWrap.appendChild(nameEl);
                        infoWrap.appendChild(roleEl);

                        flex.appendChild(avatar);
                        flex.appendChild(infoWrap);
                        item.appendChild(flex);

                        item.addEventListener('click', () => {
                            selectUser(user.id, user.nombre, user.rol);
                        });

                        usersList.appendChild(item);
                    });
                } else {
                    usersList.innerHTML = `
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-comments text-4xl mb-3 opacity-20"></i>
                            <p class="m-0">Aún no tenés conversaciones</p>
                            <p class="text-sm">Selecciona un usuario en el buscador para empezar a chatear</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Error al cargar conversaciones:', error);
                usersList.innerHTML = `
                    <div class="text-center py-8 text-red-600">
                        <i class="fas fa-exclamation-triangle text-2xl mb-3"></i>
                        <p class="m-0 mb-2 font-semibold">Error al cargar conversaciones</p>
                    </div>
                `;
            }
        }

        /* Verificar nuevos mensajes (polling) */
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
                    if (newMessages.length > lastMessages.length) {
                        const newMessageCount = newMessages.length - lastMessages.length;

                        if (document.hidden || !isChatActive()) {
                            if (currentReceiver in unreadMessages) {
                                unreadMessages[currentReceiver] += newMessageCount;
                            } else {
                                unreadMessages[currentReceiver] = newMessageCount;
                            }
                            updateUnreadBadges();
                            showBrowserNotification(newMessageCount);
                        }

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

        /* Seleccionar usuario (desde lista o búsqueda) */
        function selectUser(userId, userName, userRol) {
            currentReceiver = userId;
            currentReceiverName = userName;

            markMessagesAsRead(userId);

            // Resaltar usuario seleccionado en la lista
            document.querySelectorAll('.user-item').forEach(item => {
                item.classList.remove('bg-blue-50', 'border-l-4', 'border-blue-500');
            });
            const selectedItem = document.querySelector(`.user-item[data-user-id="${userId}"]`);
            if (selectedItem) {
                selectedItem.classList.add('bg-blue-50', 'border-l-4', 'border-blue-500');
            }

            document.getElementById('chat-header').innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center text-white font-semibold">
                        ${escapeHtml(userName).charAt(0).toUpperCase()}
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

            loadMessages();
            setupIntervals();
            document.getElementById('message-input').focus();
        }

        /* Intervals */
        function setupIntervals() {
            if (messageInterval) clearInterval(messageInterval);
            if (usersInterval) clearInterval(usersInterval);

            messageInterval = setInterval(() => {
                if (currentReceiver) checkNewMessages();
            }, 5000);

            usersInterval = setInterval(() => {
                loadUsers();
            }, 10000);
        }

        /* Cargar mensajes iniciales */
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
                    if (isFirstLoad) isFirstLoad = false;
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

        /* Enviar mensaje */
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
                    body: JSON.stringify({ id_receptor: currentReceiver, contenido: contenido })
                });
                const data = await response.json();
                if (data.success || data.status === 'success') {
                    input.value = '';
                    updateCharCount();
                    loadMessages();
                } else {
                    alert('Error: ' + (data.message || 'No se pudo enviar el mensaje'));
                }
            } catch (error) {
                alert('Error de conexión al enviar mensaje');
            }
        }

        /* Utilidades */
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML || '';
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

        /* Eventos de input / envío */
        document.getElementById('userSearch').addEventListener('input', searchUsers);
        
        // Cerrar resultados al hacer click fuera
        document.addEventListener('click', function(e) {
            const searchResults = document.getElementById('searchResults');
            const userSearch = document.getElementById('userSearch');
            if (!searchResults.contains(e.target) && e.target !== userSearch) {
                searchResults.classList.add('hidden');
            }
        });

        document.getElementById('message-input').addEventListener('input', updateCharCount);
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });
        document.getElementById('send-button').addEventListener('click', sendMessage);

        /* Inicialización */
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