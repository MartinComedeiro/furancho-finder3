<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FuranchoFinder - Descubre los mejores furanchos de Galicia</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <header class="header">
            <div class="header-content">
                <h1>🍷 FuranchoFinder</h1>
                <p>Descubre los mejores furanchos de Galicia</p>
            </div>
            <div class="auth-section">
                <div id="loginForm" class="login-form">
                    <input type="text" id="username" placeholder="Usuario">
                    <input type="password" id="password" placeholder="Contraseña">
                    <button onclick="login()">Ingresar</button>
                </div>
                <div id="userInfo" class="user-info" style="display:none;">
                    <span id="userName"></span>
                    <button onclick="logout()">Cerrar sesión</button>
                </div>
            </div>
        </header>

        <div class="content">
            <div class="sidebar">
                <h2>Favoritos</h2>
                <div id="favorites" class="favorites-list"></div>
            </div>

            <div class="map-container">
                <div id="map"></div>
            </div>

            <div class="info-panel">
                <div id="furancho-info" class="furancho-info">
                    <p>Selecciona un furancho en el mapa</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para detalles -->
    <div id="furanchoModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modalBody"></div>
            <button id="favBtn" onclick="toggleFavorite()" class="fav-btn">♡ Agregar a Favoritos</button>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="/js/app.js"></script>
</body>
</html>
