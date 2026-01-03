let map;
let markers = {};
let furanchos = [];
let users = [];
let currentUser = null;
let currentCategory = 'all';

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    initMap();
    loadFuranchos();
    loadUsers();
    setupEventListeners();
    loadUserSession();
});

function initMap() {
    map = L.map('map').setView([40.4168, -3.7038], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);
}

function loadFuranchos() {
    fetch('/api/furanchos')
        .then(response => response.json())
        .then(data => {
            furanchos = data;
            displayFuranchos(furanchos);
        })
        .catch(error => console.error('Error cargando furanchos:', error));
}

function loadUsers() {
    fetch('/api/users')
        .then(response => response.json())
        .then(data => {
            users = data;
        })
        .catch(error => console.error('Error cargando usuarios:', error));
}

function displayFuranchos(furanchosToDisplay) {
    // Limpiar marcadores anteriores
    Object.values(markers).forEach(marker => map.removeLayer(marker));
    markers = {};

    furanchosToDisplay.forEach(furancho => {
        const icon = L.divIcon({
            html: `<div class="marker-icon">🌮</div>`,
            className: 'furancho-marker',
            iconSize: [30, 30],
            popupAnchor: [0, -15]
        });

        const marker = L.marker([furancho.latitude, furancho.longitude], { icon })
            .bindPopup(`<strong>${furancho.name}</strong><br>${furancho.category}`, { maxWidth: 200 })
            .addTo(map);

        marker.on('click', () => showFuranchoInfo(furancho));
        markers[furancho.id] = marker;
    });
}

function showFuranchoInfo(furancho) {
    const infoPanel = document.getElementById('furancho-info');
    const isFavorited = currentUser && currentUser.favorites && currentUser.favorites.includes(furancho.id);

    infoPanel.innerHTML = `
        <div class="furancho-details">
            <h3>${furancho.name}</h3>
            <p>${furancho.description}</p>
            <div class="rating">⭐ ${furancho.rating} (${furancho.reviews} reseñas)</div>
            <span class="category-badge">${furancho.category}</span>
            <div style="margin-top: 15px;">
                <button onclick="toggleFavoriteSidebar(${furancho.id})" class="fav-btn ${isFavorited ? 'favorited' : ''}">
                    ${isFavorited ? '❤' : '♡'} ${isFavorited ? 'En Favoritos' : 'Agregar a Favoritos'}
                </button>
            </div>
        </div>
    `;

    // Mostrar modal también
    const modal = document.getElementById('furanchoModal');
    const modalBody = document.getElementById('modalBody');
    modalBody.innerHTML = `
        <h2>${furancho.name}</h2>
        <p><strong>Descripción:</strong> ${furancho.description}</p>
        <p><strong>Categoría:</strong> ${furancho.category}</p>
        <p><strong>Calificación:</strong> ⭐ ${furancho.rating} (${furancho.reviews} reseñas)</p>
        <p><strong>Ubicación:</strong> ${furancho.latitude.toFixed(4)}, ${furancho.longitude.toFixed(4)}</p>
    `;
    document.getElementById('favBtn').dataset.furanchoId = furancho.id;
}

function setupEventListeners() {
    // Filtrar por categoría
    document.querySelectorAll('.category-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentCategory = this.dataset.category;
            filterByCategory();
        });
    });

    // Modal close button
    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('furanchoModal').style.display = 'none';
    });

    // Cerrar modal al hacer click fuera
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('furanchoModal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
}

function filterByCategory() {
    if (currentCategory === 'all') {
        displayFuranchos(furanchos);
    } else {
        const filtered = furanchos.filter(f => f.category === currentCategory);
        displayFuranchos(filtered);
    }
}

function login() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (!username || !password) {
        alert('Por favor ingresa usuario y contraseña');
        return;
    }

    // Búsqueda local en el array de usuarios
    const user = users.find(u => u.username === username);
    
    if (user) {
        // En prototipo, contraseña demo es "demo123"
        if (password === 'demo123') {
            currentUser = { ...user };
            localStorage.setItem('currentUser', JSON.stringify(currentUser));
            updateAuthUI();
            loadFavorites();
            alert(`Bienvenido ${user.name}!`);
        } else {
            alert('Contraseña incorrecta');
        }
    } else {
        alert('Usuario no encontrado');
    }

    document.getElementById('username').value = '';
    document.getElementById('password').value = '';
}

function logout() {
    currentUser = null;
    localStorage.removeItem('currentUser');
    updateAuthUI();
    document.getElementById('favorites').innerHTML = '';
}

function loadUserSession() {
    const saved = localStorage.getItem('currentUser');
    if (saved) {
        currentUser = JSON.parse(saved);
        updateAuthUI();
        loadFavorites();
    }
}

function updateAuthUI() {
    const loginForm = document.getElementById('loginForm');
    const userInfo = document.getElementById('userInfo');

    if (currentUser) {
        loginForm.style.display = 'none';
        userInfo.style.display = 'flex';
        document.getElementById('userName').textContent = currentUser.name;
    } else {
        loginForm.style.display = 'flex';
        userInfo.style.display = 'none';
    }
}

function loadFavorites() {
    if (!currentUser) {
        document.getElementById('favorites').innerHTML = '<p style="color: #999; font-size: 12px;">Inicia sesión para ver favoritos</p>';
        return;
    }

    const favList = document.getElementById('favorites');
    favList.innerHTML = '';

    if (!currentUser.favorites || currentUser.favorites.length === 0) {
        favList.innerHTML = '<p style="color: #999; font-size: 12px;">Sin favoritos aún</p>';
        return;
    }

    currentUser.favorites.forEach(favId => {
        const furancho = furanchos.find(f => f.id === favId);
        if (furancho) {
            const div = document.createElement('div');
            div.className = 'favorite-item';
            div.innerHTML = `
                <strong>${furancho.name}</strong>
                <small>${furancho.category}</small>
            `;
            div.onclick = () => showFuranchoInfo(furancho);
            favList.appendChild(div);
        }
    });
}

function toggleFavoriteSidebar(furanchoId) {
    if (!currentUser) {
        alert('Por favor inicia sesión primero');
        return;
    }

    if (!currentUser.favorites) {
        currentUser.favorites = [];
    }

    const index = currentUser.favorites.indexOf(furanchoId);
    if (index > -1) {
        currentUser.favorites.splice(index, 1);
    } else {
        currentUser.favorites.push(furanchoId);
    }

    localStorage.setItem('currentUser', JSON.stringify(currentUser));
    loadFavorites();
    showFuranchoInfo(furanchos.find(f => f.id === furanchoId));
}

function toggleFavorite() {
    const furanchoId = parseInt(document.getElementById('favBtn').dataset.furanchoId);
    toggleFavoriteSidebar(furanchoId);
    const modal = document.getElementById('furanchoModal');
    modal.style.display = 'none';
}
