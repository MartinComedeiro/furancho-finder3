# FuranchoFinder 🌮

Un prototipo de aplicación web para descubrir los mejores furanchos de la zona, construido con CodeIgniter 4 y Leaflet.

## Características

- 🗺️ **Mapa interactivo** con Leaflet para visualizar furanchos
- 👤 **Sistema de usuarios** con login/logout
- ❤️ **Favoritos** - Guarda tus furanchos preferidos
- 📱 **Datos JSON** - Sin necesidad de base de datos (prototipo)
- 🐳 **Containerizado** - Docker y Docker Compose para fácil deployment
- 🍽️ **Múltiples categorías** - Tacos, Arepas, Empanadas, Ceviches, y más

## Requisitos previos

- [Docker](https://www.docker.com/) (versión 20.10+)
- [Docker Compose](https://docs.docker.com/compose/) (versión 1.29+)
- [Git](https://git-scm.com/)

## Instalación y ejecución

### 1. Clonar el repositorio

```bash
git clone https://github.com/tu-usuario/furancho-finder.git
cd furancho-finder
```

### 2. Levantar los contenedores con Docker Compose

```bash
docker-compose up -d
```

La aplicación estará disponible en `http://localhost`

### 3. Detener los contenedores

```bash
docker-compose down
```

## Usuarios de prueba

Usa cualquiera de estos usuarios para probar la aplicación:

| Usuario | Contraseña | Nombre |
|---------|-----------|--------|
| user1 | demo123 | Juan García |
| foodlover | demo123 | María López |
| streetfood | demo123 | Carlos Rodríguez |

## Estructura del proyecto

```
furancho-finder/
├── app/
│   ├── Controllers/
│   │   ├── Home.php          # Controlador principal
│   │   └── API.php           # Controlador API REST
│   ├── Data/
│   │   ├── furanchos.json    # Datos de furanchos
│   │   └── users.json        # Datos de usuarios
│   ├── Views/
│   │   └── home.php          # Vista principal
│   └── Config/
│       └── Routes.php         # Rutas de la aplicación
├── public/
│   ├── css/
│   │   └── style.css         # Estilos CSS
│   ├── js/
│   │   └── app.js            # JavaScript del cliente
│   └── index.php             # Entrada de la aplicación
├── Dockerfile                # Configuración Docker
├── docker-compose.yml        # Configuración Docker Compose
├── apache.conf               # Configuración Apache
├── composer.json             # Dependencias PHP
└── README.md                 # Este archivo
```

## API Endpoints

### Furanchos

- `GET /api/furanchos` - Obtener todos los furanchos
- `GET /api/furanchos/:id` - Obtener furancho por ID

### Usuarios

- `GET /api/users` - Obtener todos los usuarios
- `GET /api/users/:id` - Obtener usuario por ID
- `POST /api/login` - Iniciar sesión (parámetros: username, password)

## Funcionalidades

### 1. Explorar furanchos en el mapa
- Visualiza todos los furanchos disponibles en el mapa
- Haz clic en los marcadores para ver detalles
- Filtra por categoría usando los botones en el sidebar izquierdo

### 2. Sistema de usuarios
- **Registro**: Los usuarios están predefinidos en `app/Data/users.json`
- **Login**: Usa cualquier usuario de prueba con contraseña `demo123`
- **Logout**: Cierra sesión usando el botón en la esquina superior derecha

### 3. Favoritos
- Inicia sesión para agregar furanchos a favoritos
- Los favoritos se guardan en localStorage (navegador)
- Visualiza tus favoritos en el sidebar izquierdo

### 4. Filtrado por categoría
- Tacos
- Arepas
- Postres
- Empanadas
- Ceviches
- Parrilla
- Hot Dogs
- Papas Rellenas

## Desarrollo

### Modificar datos de furanchos

Edita el archivo `app/Data/furanchos.json` para agregar o modificar furanchos.

### Agregar usuarios

Edita el archivo `app/Data/users.json` para agregar nuevos usuarios.

### Cambiar la ubicación del mapa

En `public/js/app.js`, modifica la línea:
```javascript
map = L.map('map').setView([40.4168, -3.7038], 13);
```

Cambia las coordenadas (latitud, longitud) y el nivel de zoom.

## Tecnologías utilizadas

- **Backend**: CodeIgniter 4
- **Frontend**: HTML5, CSS3, JavaScript vanilla
- **Mapas**: Leaflet.js
- **Datos**: JSON
- **Containerización**: Docker, Docker Compose
- **Servidor**: Apache 2.4
- **PHP**: 8.1

## Notas sobre el prototipo

- Los datos se almacenan en JSON, no en base de datos
- Las contraseñas se usan solo para demostración
- Los favoritos se guardan en el navegador (localStorage)
- No hay validación de seguridad robusta (es un prototipo)

## Próximas mejoras

- [ ] Integración con base de datos real
- [ ] Autenticación con JWT
- [ ] Sistema de reseñas
- [ ] Búsqueda por nombre/ubicación
- [ ] Funcionalidad de "cerca de mí"
- [ ] Carrito de pedidos
- [ ] Notificaciones push

## Licencia

MIT License - Ver archivo LICENSE para más detalles

## Autor

Creado como prototipo de FuranchoFinder

## Soporte

Para reportar bugs o sugerir mejoras, abre un issue en el repositorio de GitHub.
