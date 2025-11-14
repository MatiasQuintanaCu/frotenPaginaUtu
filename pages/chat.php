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
                        'utu-blue-dark': '#002244',
                        'utu-gray': '#4a5568',
                        'utu-gray-light': '#718096',
                        'utu-green': '#2d7744',
                        'utu-red': '#c53030',
                    },
                    fontFamily: {
                        'sans': ['Segoe UI', 'Roboto', 'Arial', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .nav-institutional {
            background: #003366;
            border-bottom: 2px solid #2d7744;
        }
        
        .btn-institutional {
            background-color: #003366;
            color: white;
            border-radius: 4px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.2s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .btn-institutional:hover {
            background-color: #002244;
            transform: translateY(-1px);
        }
        
        .btn-secondary {
            background-color: #2d7744;
            color: white;
            border-radius: 4px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.2s ease;
        }
        
        .btn-secondary:hover {
            background-color: #236335;
        }
        
        .user-badge {
            background: #2d7744;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .footer-institutional {
            background: #002244;
        }
        
        .institutional-logo {
            border: 2px solid #2d7744;
        }
        
        .accent-color {
            color: #2d7744;
        }
        
        .bg-accent {
            background-color: #2d7744;
        }

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
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .message-sent { animation: slideInRight 0.3s ease; }
        .message-received { animation: slideInLeft 0.3s ease; }
        .pulse-notification { animation: pulse 0.6s ease-in-out; }
        .fade-in { animation: fadeIn 0.3s ease-in; }
        
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

        /* EMOJI PICKER */
        .emoji-picker {
            position: absolute;
            bottom: 100%;
            right: 0;
            margin-bottom: 10px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            width: 320px;
            max-width: 90vw;
            max-height: 350px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
        }

        .emoji-picker-header {
            position: sticky;
            top: 0;
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 12px;
            z-index: 10;
        }

        .emoji-category {
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            background: #f9fafb;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 57px;
            z-index: 5;
        }

        .emoji-grid {
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            gap: 4px;
            padding: 8px;
            width: 100%;
            box-sizing: border-box;
        }

        .emoji-item {
            font-size: 24px;
            padding: 8px;
            cursor: pointer;
            border-radius: 6px;
            transition: all 0.15s ease;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 0;
            width: 100%;
            aspect-ratio: 1;
        }

        .emoji-item:hover {
            background: #f3f4f6;
            transform: scale(1.2);
        }

        .emoji-picker::-webkit-scrollbar {
            width: 6px;
        }

        .emoji-picker::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .emoji-picker::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .emoji-picker::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* MAIN CONTAINER */
        .main-container {
            height: calc(100vh - 120px);
        }

        @media (min-width: 1024px) {
            .main-container {
                max-width: 100% !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
            
            .chat-wrapper {
                border-radius: 0 !important;
                height: 100% !important;
                box-shadow: none !important;
            }
        }

        /* Estilos para móviles */
        @media (max-width: 1023px) {
            .mobile-chat-active .users-panel {
                transform: translateX(-100%);
            }
            
            .mobile-chat-active .chat-panel {
                transform: translateX(0);
            }
            
            .users-panel, .chat-panel {
                transition: transform 0.3s ease;
            }

            .emoji-picker {
                width: 300px;
                right: 0;
                left: auto;
            }

            .emoji-grid {
                grid-template-columns: repeat(7, 1fr);
            }

            .emoji-item {
                font-size: 22px;
                padding: 6px;
            }

            .main-container {
                padding: 0.5rem;
            }
            
            .chat-wrapper {
                border-radius: 12px;
                box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            }
        }

        @media (max-width: 640px) {
            .emoji-picker {
                width: 280px;
                max-height: 300px;
            }

            .emoji-grid {
                grid-template-columns: repeat(6, 1fr);
            }

            .emoji-item {
                font-size: 20px;
                padding: 5px;
            }
            
            .main-container {
                padding: 0.25rem;
                height: calc(100vh - 100px);
            }
        }

        .chat-card {
            background: white;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        .chat-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col font-sans">
    <!-- Header Institucional -->
    <nav class="nav-institutional text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                
                <!-- Logo y Marca -->
                <div class="flex items-center gap-4">
                    <button id="back-button" class="btn-institutional font-semibold px-3 py-2 flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i>
                        <span class="hidden sm:inline">Volver</span>
                    </button>
                    <button id="toggle-chat-button" class="lg:hidden btn-institutional font-semibold px-3 py-2 flex items-center gap-2">
                        <i class="fas fa-comments"></i>
                        <span>Chats</span>
                    </button>
                    <div class="flex items-center gap-4">
                        <img id="LogoUtu" 
                             src="./assets/img/logo.webp" 
                             alt="Logo UTU"
                             class="w-12 h-12 institutional-logo rounded-lg shadow-md">
                        <div class="flex flex-col text-center lg:text-left">
                            <span class="text-lg sm:text-xl font-bold">
                                UTU - Trinidad Flores
                            </span>
                            <span class="text-xs text-gray-300 font-medium">
                                Sistema de Mensajería
                            </span>
                        </div>
                    </div>
                </div>
                
                <!-- Información del Usuario -->
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-3 bg-white bg-opacity-10 rounded-lg px-3 py-2">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-accent flex items-center justify-center text-white font-bold text-sm">
                                <?php echo strtoupper(substr($userName, 0, 1)); ?>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-white font-semibold text-sm"><?php echo htmlspecialchars(explode(' ', $userName)[0]); ?></span>
                                <span class="user-badge text-xs"><?php echo $userRol; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-container w-full px-0 lg:px-0">
        <div class="chat-wrapper bg-white h-full lg:rounded-none rounded-xl shadow-xl lg:shadow-none overflow-hidden">
            <div class="flex h-full relative">
                <!-- Lista de usuarios (izquierda) -->
                <div class="users-panel w-full lg:w-1/3 border-r border-gray-200 bg-gray-50 flex flex-col absolute lg:relative inset-0 z-10 lg:z-0">
                    <!-- Buscador y nuevo chat -->
                    <div class="p-4 border-b border-gray-200 bg-white">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-utu-blue m-0">Conversaciones</h2>
                            <div id="global-notification" class="hidden">
                                <span class="bg-utu-red text-white text-xs font-bold px-2 py-1 rounded-full pulse-notification">
                                    Nuevos mensajes
                                </span>
                            </div>
                        </div>

                        <!-- Buscador -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input 
                                type="text" 
                                id="userSearch" 
                                placeholder="Buscar o iniciar nuevo chat..." 
                                class="w-full border border-gray-300 rounded-lg pl-10 pr-10 py-2.5 text-sm outline-none focus:ring-2 focus:ring-utu-blue focus:border-utu-blue transition-all"
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
                <div class="chat-panel w-full lg:w-2/3 flex flex-col absolute lg:relative inset-0 z-0 lg:z-0 transform lg:transform-none translate-x-full lg:translate-x-0">
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
                        <div class="relative">
                            <div class="flex gap-2">
                                <input 
                                    type="text" 
                                    id="message-input" 
                                    placeholder="Escribe tu mensaje..." 
                                    maxlength="500"
                                    class="flex-1 border border-gray-300 rounded-lg px-4 py-3 outline-none text-sm transition-all focus:border-utu-blue focus:ring-2 focus:ring-utu-blue/20"
                                >
                                <button 
                                    id="emoji-button"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-3 rounded-lg transition-all border-0 cursor-pointer"
                                    title="Agregar emoji"
                                >
                                    <i class="fas fa-smile text-xl"></i>
                                </button>
                                <button 
                                    id="send-button"
                                    class="bg-utu-blue text-white px-6 py-3 rounded-lg transition-all hover:bg-utu-blue-dark hover:shadow-lg border-0 cursor-pointer"
                                >
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                            
                            <!-- Emoji Picker -->
                            <div id="emoji-picker" class="emoji-picker hidden">
                                <div class="emoji-picker-header">
                                    <input 
                                        type="text" 
                                        id="emoji-search" 
                                        placeholder="Buscar emoji..." 
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm outline-none focus:border-utu-blue"
                                    >
                                </div>
                                <div id="emoji-content" class="w-full"></div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-2 text-right">
                            <span id="char-count">0</span>/500 caracteres
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Institucional -->
    <footer class="footer-institutional text-gray-300 mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="text-center">
                <p class="text-sm opacity-90">&copy; 2025 Escuela Técnica Trinidad Flores (UTU). Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
        /* Estado */
        let currentReceiver = null;
        let currentReceiverName = '';
        let messageInterval = null;
        let usersInterval = null;
        let unreadMessages = {};
        let lastMessages = [];
        let isFirstLoad = true;
        let allUsers = [];
        let emojiPickerOpen = false;
        let isMobileView = window.innerWidth < 1024;

        /* Emojis por categoría */
        const emojis = {
            'Caritas y Emociones': ['😀','😃','😄','😁','😆','😅','🤣','😂','🙂','🙃','😉','😊','😇','🥰','😍','🤩','😘','😗','😚','😙','🥲','😋','😛','😜','🤪','😝','🤑','🤗','🤭','🤫','🤔','🤐','🤨','😐','😑','😶','😏','😒','🙄','😬','🤥','😌','😔','😪','🤤','😴','😷','🤒','🤕','🤢','🤮','🤧','🥵','🥶','🥴','😵','🤯','🤠','🥳','🥸','😎','🤓','🧐'],
            'Gestos y Manos': ['👋','🤚','🖐','✋','🖖','👌','🤌','🤏','✌️','🤞','🤟','🤘','🤙','👈','👉','👆','🖕','👇','☝️','👍','👎','✊','👊','🤛','🤜','👏','🙌','👐','🤲','🤝','🙏'],
            'Corazones': ['❤️','🧡','💛','💚','💙','💜','🖤','🤍','🤎','💔','❤️‍🔥','❤️‍🩹','💕','💞','💓','💗','💖','💘','💝','💟'],
            'Animales': ['🐶','🐱','🐭','🐹','🐰','🦊','🐻','🐼','🐨','🐯','🦁','🐮','🐷','🐸','🐵','🐔','🐧','🐦','🐤','🦆','🦅','🦉','🦇','🐺','🐗','🐴','🦄','🐝','🐛','🦋','🐌','🐞','🐢','🐍','🦎','🦖','🦕','🐙','🦑','🦐','🦞','🦀','🐡','🐠','🐟','🐬','🐳','🐋','🦈','🐊','🐅','🐆','🦓','🦍','🦧','🐘','🦛','🦏','🐪','🐫','🦒','🦘','🦬','🐃','🐂','🐄','🐎','🐖','🐏','🐑','🦙','🐐','🦌','🐕','🐩','🦮','🐈','🦜','🦚','🦤'],
            'Comida': ['🍏','🍎','🍐','🍊','🍋','🍌','🍉','🍇','🍓','🫐','🍈','🍒','🍑','🥭','🍍','🥥','🥝','🍅','🍆','🥑','🥦','🥬','🥒','🌶','🫑','🌽','🥕','🫒','🧄','🧅','🥔','🍠','🥐','🥯','🍞','🥖','🥨','🧀','🥚','🍳','🧈','🥞','🧇','🥓','🥩','🍗','🍖','🦴','🌭','🍔','🍟','🍕','🫓','🥪','🥙','🧆','🌮','🌯','🫔','🥗','🥘','🫕','🥫','🍝','🍜','🍲','🍛','🍣','🍱','🥟','🦪','🍤','🍙','🍚','🍘','🍥','🥠','🥮','🍢','🍡','🍧','🍨','🍦','🥧','🧁','🍰','🎂','🍮','🍭','🍬','🍫','🍿','🍩','🍪','🌰','🥜','🍯'],
            'Actividades': ['⚽','🏀','🏈','⚾','🥎','🎾','🏐','🏉','🥏','🎱','🪀','🏓','🏸','🏒','🏑','🥍','🏏','🪃','🥅','⛳','🪁','🏹','🎣','🤿','🥊','🥋','🎽','🛹','🛼','🛷','⛸','🥌','🎿','⛷','🏂','🪂','🏋️','🤼','🤸','🤺','⛹️','🤾','🏌️','🏇','🧘','🏄','🏊','🤽','🚣','🧗','🚵','🚴','🏆','🥇','🥈','🥉','🏅','🎖','🎗','🎫','🎟','🎪','🤹','🎭','🩰','🎨','🎬','🎤','🎧','🎼','🎹','🥁','🪘','🎷','🎺','🪗','🎸','🪕','🎻','🎲','♟','🎯','🎳','🎮','🎰','🧩'],
            'Viajes y Lugares': ['🚗','🚕','🚙','🚌','🚎','🏎','🚓','🚑','🚒','🚐','🛻','🚚','🚛','🚜','🦯','🦽','🦼','🛴','🚲','🛵','🏍','🛺','🚨','🚔','🚍','🚘','🚖','🚡','🚠','🚟','🚃','🚋','🚞','🚝','🚄','🚅','🚈','🚂','🚆','🚇','🚊','🚉','✈️','🛫','🛬','🛩','💺','🛰','🚀','🛸','🚁','🛶','⛵','🚤','🛥','🛳','⛴','🚢','⚓','⛽','🚧','🚦','🚥','🗺','🗿','🗽','🗼','🏰','🏯','🏟','🎡','🎢','🎠','⛲','⛱','🏖','🏝','🏜','🌋','⛰','🏔','🗻','🏕','⛺','🛖','🏠','🏡','🏘','🏚','🏗','🏭','🏢','🏬','🏣','🏤','🏥','🏦','🏨','🏪','🏫','🏩','💒','🏛','⛪','🕌','🕍','🛕','🕋'],
            'Objetos': ['⌚','📱','📲','💻','⌨️','🖥','🖨','🖱','🖲','🕹','🗜','💾','💿','📀','📼','📷','📸','📹','🎥','📽','🎞','📞','☎️','📟','📠','📺','📻','🎙','🎚','🎛','🧭','⏱','⏲','⏰','🕰','⌛','⏳','📡','🔋','🔌','💡','🔦','🕯','🪔','🧯','🛢','💸','💵','💴','💶','💷','🪙','💰','💳','💎','⚖️','🪜','🧰','🪛','🔧','🔨','⚒','🛠','⛏','🪚','🔩','⚙️','🧱','⛓','🧲','🔫','💣','🧨','🪓','🔪','🗡','⚔️','🛡','🚬','⚰️','🪦','⚱️','🏺','🔮','📿','🧿','💈','⚗️','🔭','🔬','🕳','🩹','🩺','💊','💉','🩸','🧬','🦠','🧫','🧪','🌡','🧹','🪠','🧺','🧻','🚽','🚰','🚿','🛁','🛀','🧼','🪥','🪒','🧽','🪣','🧴','🛎','🔑','🗝','🚪','🪑','🛋','🛏','🛌','🧸','🪆','🖼','🪞','🪟','🛍','🎁','🎈','🎏','🎀','🪄','🪅','🎊','🎉','🎎','🏮','🎐','🧧','✉️','📩','📨','📧','💌','📥','📤','📦','🏷','🪧','📪','📫','📬','📭','📮','📯','📜','📃','📄','📑','🧾','📊','📈','📉','🗒','🗓','📆','📅','🗑','📇','🗃','🗳','🗄','📋','📁','📂','🗂','🗞','📰','📓','📔','📒','📕','📗','📘','📙','📚','📖','🔖','🧷','🔗','📎','🖇','📐','📏','🧮','📌','📍','✂️','🖊','🖋','✒️','🖌','🖍','📝','✏️','🔍','🔎','🔏','🔐','🔒','🔓'],
            'Símbolos': ['❤️','🧡','💛','💚','💙','💜','🖤','🤍','🤎','💔','❣️','💕','💞','💓','💗','💖','💘','💝','💟','☮️','✝️','☪️','🕉','☸️','✡️','🔯','🕎','☯️','☦️','🛐','⛎','♈','♉','♊','♋','♌','♍','♎','♏','♐','♑','♒','♓','🆔','⚛️','🉑','☢️','☣️','📴','📳','🈶','🈚','🈸','🈺','🈷️','✴️','🆚','💮','🉐','㊙️','㊗️','🈴','🈵','🈹','🈲','🅰️','🅱️','🆎','🆑','🅾️','🆘','❌','⭕','🛑','⛔','📛','🚫','💯','💢','♨️','🚷','🚯','🚳','🚱','🔞','📵','🚭','❗','❕','❓','❔','‼️','⁉️','🔅','🔆','〽️','⚠️','🚸','🔱','⚜️','🔰','♻️','✅','🈯','💹','❇️','✳️','❎','🌐','💠','Ⓜ️','🌀','💤','🏧','🚾','♿','🅿️','🛗','🈳','🈂️','🛂','🛃','🛄','🛅','🚹','🚺','🚼','⚧','🚻','🚮','🎦','📶','🈁','🔣','ℹ️','🔤','🔡','🔠','🆖','🆗','🆙','🆒','🆕','🆓','0️⃣','1️⃣','2️⃣','3️⃣','4️⃣','5️⃣','6️⃣','7️⃣','8️⃣','9️⃣','🔟','🔢','#️⃣','*️⃣','⏏️','▶️','⏸','⏯','⏹','⏺','⏭','⏮','⏩','⏪','⏫','⏬','◀️','🔼','🔽','➡️','⬅️','⬆️','⬇️','↗️','↘️','↙️','↖️','↕️','↔️','↪️','↩️','⤴️','⤵️','🔀','🔁','🔂','🔄','🔃','🎵','🎶','➕','➖','➗','✖️','♾','💲','💱','™️','©️','®️','👁️‍🗨️','🔚','🔙','🔛','🔝','🔜','〰️','➰','➿','✔️','☑️','🔘','🔴','🟠','🟡','🟢','🔵','🟣','⚫','⚪','🟤','🔺','🔻','🔸','🔹','🔶','🔷','🔳','🔲','▪️','▫️','◾','◽','◼️','◻️','🟥','🟧','🟨','🟩','🟦','🟪','⬛','⬜','🟫','🔈','🔇','🔉','🔊','🔔','🔕','📣','📢','💬','💭','🗯','♠️','♣️','♥️','♦️','🃏','🎴','🀄','🕐','🕑','🕒','🕓','🕔','🕕','🕖','🕗','🕘','🕙','🕚','🕛','🕜','🕝','🕞','🕟','🕠','🕡','🕢','🕣','🕤','🕥','🕦','🕧']
        };

        /* Navegación */
        function goBack() { 
            if (isMobileView && currentReceiver) {
                showConversationsList();
            } else {
                window.location.href = 'home'; 
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
                        newBadge.className = 'unread-badge bg-utu-red text-white text-xs font-bold px-2 py-1 rounded-full ml-auto';
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
                    allUsers = data.data;
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

            searchResultsList.innerHTML = '';
            filtered.forEach(user => {
                const item = document.createElement('div');
                item.className = 'p-3 hover:bg-gray-50 cursor-pointer transition-colors border-b border-gray-100 last:border-b-0';
                
                const flex = document.createElement('div');
                flex.className = 'flex items-center gap-3';

                const avatar = document.createElement('div');
                avatar.className = 'w-10 h-10 bg-gradient-to-br from-utu-blue to-utu-blue-light rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0';
                avatar.textContent = user.nombre.charAt(0).toUpperCase();

                const info = document.createElement('div');
                info.className = 'flex-1 min-w-0';

                const name = document.createElement('div');
                name.className = 'font-semibold text-gray-800 truncate';
                name.textContent = user.nombre;

                const role = document.createElement('div');
                role.className = 'text-xs text-gray-500 flex items-center gap-1';
                const dot = document.createElement('span');
                dot.className = `inline-block w-1.5 h-1.5 rounded-full ${user.rol === 'ADMIN' ? 'bg-utu-red' : 'bg-utu-green'}`;
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

        /* Cargar conversaciones */
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
                    <div class="text-center py-8 text-utu-red">
                        <i class="fas fa-exclamation-triangle text-2xl mb-3"></i>
                        <p class="m-0 mb-2 font-semibold">Error al cargar conversaciones</p>
                    </div>
                `;
            }
        }

        /* Verificar nuevos mensajes */
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

        /* Seleccionar usuario */
        function selectUser(userId, userName, userRol) {
            currentReceiver = userId;
            currentReceiverName = userName;

            markMessagesAsRead(userId);

            document.querySelectorAll('.user-item').forEach(item => {
                item.classList.remove('bg-blue-50', 'border-l-4', 'border-utu-blue');
            });
            const selectedItem = document.querySelector(`.user-item[data-user-id="${userId}"]`);
            if (selectedItem) {
                selectedItem.classList.add('bg-blue-50', 'border-l-4', 'border-utu-blue');
            }

            document.getElementById('chat-header').innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-utu-green to-utu-green/90 rounded-full flex items-center justify-center text-white font-semibold">
                        ${escapeHtml(userName).charAt(0).toUpperCase()}
                    </div>
                    <div>
                        <div class="font-semibold text-utu-blue text-lg">${escapeHtml(userName)}</div>
                        <div class="text-sm text-gray-500 flex items-center gap-1">
                            <span class="inline-block w-1.5 h-1.5 rounded-full ${userRol === 'ADMIN' ? 'bg-utu-red' : 'bg-utu-green'}"></span>
                            ${userRol}
                        </div>
                    </div>
                </div>
            `;

            document.getElementById('message-input-container').classList.remove('hidden');

            loadMessages();
            setupIntervals();
            document.getElementById('message-input').focus();
            
            if (isMobileView) {
                showChatView();
            }
        }

        /* Funciones para manejar la vista móvil */
        function showChatView() {
            document.body.classList.add('mobile-chat-active');
            document.getElementById('back-button').innerHTML = '<i class="fas fa-arrow-left"></i><span class="hidden sm:inline"> Volver</span>';
        }

        function showConversationsList() {
            document.body.classList.remove('mobile-chat-active');
            currentReceiver = null;
            document.getElementById('chat-header').innerHTML = `
                <div class="text-center text-gray-500 py-4">
                    <i class="fas fa-comments text-xl mb-2"></i>
                    <p class="m-0">Selecciona una conversación para comenzar a chatear</p>
                </div>
            `;
            document.getElementById('message-input-container').classList.add('hidden');
            document.getElementById('messages-container').innerHTML = `
                <div class="text-center text-gray-500 py-12">
                    <i class="fas fa-comments text-5xl mb-4 opacity-20"></i>
                    <p class="text-lg m-0 mb-1">Selecciona un contacto</p>
                    <p class="text-sm m-0">para ver los mensajes</p>
                </div>
            `;
        }

        function toggleChatView() {
            if (currentReceiver) {
                showConversationsList();
            }
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
                        <div class="${msg.es_mio ? 'message-sent bg-gradient-to-r from-utu-blue to-utu-blue-light text-white' : 'message-received bg-gray-200 text-gray-800'} max-w-[85%] lg:max-w-[70%] px-4 py-3 rounded-2xl ${msg.es_mio ? 'rounded-br-md' : 'rounded-bl-md'} shadow-sm">
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
                <div class="text-center text-utu-red py-12">
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
            if (charCount > 450) count.className = 'text-utu-red';
            else if (charCount > 400) count.className = 'text-orange-500';
            else count.className = 'text-gray-500';
        }

        function requestNotificationPermission() {
            if ('Notification' in window && Notification.permission === 'default') {
                Notification.requestPermission();
            }
        }

        /* Emoji Picker */
        function initEmojiPicker() {
            const emojiContent = document.getElementById('emoji-content');
            let html = '';
            
            for (const [category, emojiList] of Object.entries(emojis)) {
                html += `<div class="emoji-category">${category}</div>`;
                html += '<div class="emoji-grid">';
                emojiList.forEach(emoji => {
                    html += `<span class="emoji-item" data-emoji="${emoji}" title="${emoji}">${emoji}</span>`;
                });
                html += '</div>';
            }
            
            emojiContent.innerHTML = html;
            
            document.querySelectorAll('.emoji-item').forEach(item => {
                item.addEventListener('click', function() {
                    insertEmoji(this.getAttribute('data-emoji'));
                });
            });
        }

        function insertEmoji(emoji) {
            const input = document.getElementById('message-input');
            const cursorPos = input.selectionStart;
            const textBefore = input.value.substring(0, cursorPos);
            const textAfter = input.value.substring(cursorPos);
            
            input.value = textBefore + emoji + textAfter;
            input.focus();
            
            const newPos = cursorPos + emoji.length;
            input.setSelectionRange(newPos, newPos);
            
            updateCharCount();
            toggleEmojiPicker();
        }

        function toggleEmojiPicker() {
            const emojiPicker = document.getElementById('emoji-picker');
            emojiPickerOpen = !emojiPickerOpen;
            
            if (emojiPickerOpen) {
                emojiPicker.classList.remove('hidden');
                document.getElementById('emoji-search').value = '';
                filterEmojis();
            } else {
                emojiPicker.classList.add('hidden');
            }
        }

        function filterEmojis() {
            const searchTerm = document.getElementById('emoji-search').value.toLowerCase();
            const emojiItems = document.querySelectorAll('.emoji-item');
            const categories = document.querySelectorAll('.emoji-category');
            const grids = document.querySelectorAll('.emoji-grid');
            
            if (!searchTerm) {
                emojiItems.forEach(item => item.style.display = '');
                categories.forEach(cat => cat.style.display = '');
                grids.forEach(grid => grid.style.display = '');
                return;
            }
            
            categories.forEach(cat => cat.style.display = 'none');
            grids.forEach(grid => grid.style.display = 'none');
            
            let hasResults = false;
            emojiItems.forEach(item => {
                const emoji = item.getAttribute('data-emoji');
                const parentGrid = item.closest('.emoji-grid');
                const category = parentGrid.previousElementSibling;
                
                if (emoji.includes(searchTerm)) {
                    item.style.display = '';
                    parentGrid.style.display = '';
                    category.style.display = '';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });
            
            if (!hasResults) {
                const emojiContent = document.getElementById('emoji-content');
                emojiContent.innerHTML = `
                    <div class="p-8 text-center text-gray-500">
                        <i class="fas fa-search text-2xl mb-2"></i>
                        <p class="text-sm m-0">No se encontraron emojis</p>
                    </div>
                `;
            }
        }

        /* Eventos */
        document.getElementById('userSearch').addEventListener('input', searchUsers);
        
        document.addEventListener('click', function(e) {
            const searchResults = document.getElementById('searchResults');
            const userSearch = document.getElementById('userSearch');
            const emojiPicker = document.getElementById('emoji-picker');
            const emojiButton = document.getElementById('emoji-button');
            
            if (!searchResults.contains(e.target) && e.target !== userSearch) {
                searchResults.classList.add('hidden');
            }
            
            if (!emojiPicker.contains(e.target) && e.target !== emojiButton && !emojiButton.contains(e.target)) {
                emojiPicker.classList.add('hidden');
                emojiPickerOpen = false;
            }
        });

        document.getElementById('emoji-button').addEventListener('click', function(e) {
            e.stopPropagation();
            toggleEmojiPicker();
        });

        document.getElementById('emoji-search').addEventListener('input', filterEmojis);

        document.getElementById('message-input').addEventListener('input', updateCharCount);
        document.getElementById('message-input').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                sendMessage();
            }
        });
        document.getElementById('send-button').addEventListener('click', sendMessage);

        document.getElementById('back-button').addEventListener('click', goBack);
        document.getElementById('toggle-chat-button').addEventListener('click', toggleChatView);

        window.addEventListener('resize', function() {
            isMobileView = window.innerWidth < 1024;
        });

        /* Inicialización */
        document.addEventListener('DOMContentLoaded', function() {
            loadUsers();
            updateCharCount();
            requestNotificationPermission();
            initEmojiPicker();
            
            if (isMobileView) {
                showConversationsList();
            }
        });

        window.addEventListener('beforeunload', function() {
            if (messageInterval) clearInterval(messageInterval);
            if (usersInterval) clearInterval(usersInterval);
        });
    </script>
</body>
</html>