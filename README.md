# Chuck Norris Jokes - CakePHP 5

## 🚀 Aplicación Chuck Norris Jokes - CakePHP 5

Esta aplicación implementa un sistema completo de chistes de Chuck Norris utilizando **CakePHP 5**, **SQLite** y la **API de Chuck Norris**. Desarrollada como proyecto educativo para aprender las funcionalidades principales del framework.

### ✨ Características implementadas:

- **🔌 API Integration**: Conecta con https://api.chucknorris.io/jokes/random
- **💾 Base de datos SQLite**: Almacenamiento local optimizado y ligero
- **💡 Sistema de guardado**: Permite guardar chistes favoritos en la base de datos
- **⚡ Optimizaciones de rendimiento**: Cache en sesión y consultas optimizadas
- **🔒 Validación de duplicados**: Evita chistes repetidos en la base de datos
- **📱 Interfaz responsive**: Diseño limpio con Bootstrap y formularios intuitivos
- **🚦 Manejo de errores**: Mensajes flash informativos y manejo robusto de excepciones

### 🛠️ Tecnologías utilizadas:

- **Framework**: CakePHP 5.x
- **Base de datos**: SQLite 3
- **PHP**: 8.1+ (recomendado 8.2/8.3)
- **Frontend**: HTML5, Bootstrap CSS
- **API Externa**: Chuck Norris Jokes API

### 📋 Requisitos previos:

- PHP 8.1+ (recomendado 8.2/8.3)
- Composer 2.x
- Extensión pdo_sqlite habilitada
- Git para el control de versiones

### 🚀 Instalación y configuración:

1. **Clonar el repositorio**:
   ```bash
   git clone https://github.com/cifpfbmoll/chuck-jokes-como-acercamiento-a-cakephp-5-XiscoRossello.git
   cd chuck-jokes-como-acercamiento-a-cakephp-5-XiscoRossello
   ```

2. **Instalar dependencias**:
   ```bash
   composer install
   ```

3. **Configurar base de datos**:
   - El archivo `config/app_local.php` ya está configurado para SQLite
   - La base de datos se crea automáticamente en `tmp/database.sqlite`

4. **Ejecutar migraciones**:
   ```bash
   php bin/cake.php migrations migrate
   ```

5. **Iniciar servidor de desarrollo**:
   ```bash
   php -S 0.0.0.0:8765 -t webroot
   ```

6. **Acceder a la aplicación**:
   - URL principal: http://localhost:8765/
   - Chistes de Chuck Norris: http://localhost:8765/jokes/random

### 🎯 Funcionalidades principales:

#### � Ver chiste aleatorio
- Accede a `/jokes/random` para obtener un chiste aleatorio de la API
- El chiste se muestra en un blockquote estilizado
- Sistema de cache en sesión para mejorar el rendimiento

#### 💾 Guardar chistes
- Botón "Guardar" para almacenar el chiste en la base de datos local
- Validación automática de duplicados
- Mensajes informativos de éxito/error

#### 🔄 Obtener nuevo chiste
- Botón "Nuevo Chiste" para obtener otro chiste aleatorio
- Limpia el cache de sesión automáticamente

### �📁 Estructura del proyecto:

```
src/
├── Controller/
│   └── JokesController.php          # Controlador principal con lógica de negocio
├── Model/
│   ├── Entity/
│   │   └── Joke.php                 # Entidad Joke con propiedades
│   └── Table/
│       └── JokesTable.php           # Modelo con validaciones y métodos optimizados
templates/
└── Jokes/
    └── random.php                   # Vista principal con formulario
config/
├── routes.php                       # Rutas personalizadas
├── app_local.php                    # Configuración de base de datos
└── Migrations/
    └── 20251003140801_CreateJokes.php # Migración de la tabla jokes
```

### 🗄️ Esquema de base de datos:

```sql
CREATE TABLE jokes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    setup VARCHAR(255) NOT NULL,        -- Texto del chiste
    punchline VARCHAR(255),             -- Remate (opcional)
    created DATETIME,                   -- Fecha de creación
    modified DATETIME                   -- Fecha de modificación
);
```

### 🔧 Optimizaciones implementadas:

#### ⚡ Rendimiento
- **Cache en sesión**: Los chistes se almacenan temporalmente para evitar peticiones innecesarias
- **Inserción directa**: Bypass del ORM para operaciones de guardado más rápidas
- **Timeout HTTP**: Límite de 5 segundos en peticiones a la API externa
- **Validación de duplicados**: Método `jokeExists()` optimizado

#### 🛡️ Seguridad
- **Escape HTML**: Todos los datos se escapan antes de mostrar
- **Validación de datos**: Longitud máxima y tipos de datos
- **Sanitización**: Truncado automático a 255 caracteres

### 🧪 Testing y desarrollo:

```bash
# Ejecutar migraciones en modo desarrollo
php bin/cake.php migrations migrate

# Verificar estado de las migraciones
php bin/cake.php migrations status

# Generar modelos con Bake
php bin/cake.php bake model Jokes --no-test
```

### 🚦 Rutas disponibles:

| Método | URL | Acción | Descripción |
|--------|-----|--------|-------------|
| GET | `/jokes/random` | random | Muestra chiste aleatorio |
| POST | `/jokes/random` | random | Guarda chiste en BD |
| GET | `/jokes/new` | newJoke | Obtiene nuevo chiste |

### 🐛 Solución de problemas:

#### Puerto ocupado
```bash
# Verificar puertos en uso
lsof -i :8765 -sTCP:LISTEN -n -P

# Usar puerto alternativo
php -S 0.0.0.0:8770 -t webroot
```

#### Error de permisos en SQLite
```bash
# Dar permisos al directorio tmp
chmod 755 tmp/
touch tmp/database.sqlite
chmod 664 tmp/database.sqlite
```

### 📸 Capturas de pantalla:

_[Aquí se incluirían las imágenes del funcionamiento de la aplicación]_

### 🤝 Contribuciones:

Este proyecto fue desarrollado siguiendo el tutorial y guías proporcionadas:
- [GUIDE_JOKES.md](https://github.com/maximofernandezriera/chuck-jokes/blob/main/GUIDE_JOKES.md)
- [README original](https://github.com/maximofernandezriera/chuck-jokes/blob/main/README.md)

### 📚 Recursos adicionales:

- [Documentación oficial CakePHP 5](https://book.cakephp.org/5/en/index.html)
- [Chuck Norris API](https://api.chucknorris.io/)
- [SQLite Documentation](https://www.sqlite.org/docs.html)
