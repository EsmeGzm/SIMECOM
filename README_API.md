# 🚀 INICIO RÁPIDO - API SIMECON

## ✅ Tu API está completamente configurada y lista para usar

### 📋 Archivos Creados

1. **Controladores API** (en `app/Http/Controllers/Api/`)
   - ✅ `AuthController.php` - Login, registro, logout
   - ✅ `DatosController.php` - CRUD de datos generales
   - ✅ `ReclutasController.php` - Gestión de reclutas
   - ✅ `ReservaController.php` - Gestión de reservas

2. **Rutas API**
   - ✅ `routes/api.php` - Todas las rutas configuradas
   - ✅ `bootstrap/app.php` - Rutas API habilitadas

3. **Modelos y Recursos**
   - ✅ `app/Models/User.php` - Modelo con Sanctum
   - ✅ `app/Http/Resources/DatoResource.php`
   - ✅ `app/Http/Resources/UserResource.php`

4. **Documentación**
   - ✅ `API_DOCUMENTATION.md` - Documentación completa de endpoints
   - ✅ `ANDROID_INTEGRATION.md` - Código Kotlin completo para Android

---

## 🏃 Pasos para Iniciar

### 1. Limpiar Caché (Ya hecho ✅)
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### 2. Iniciar el Servidor

#### Para acceso local:
```bash
php artisan serve
```
Acceso: `http://127.0.0.1:8000`

#### Para acceso desde tu red (Android en el mismo WiFi):
```bash
php artisan serve --host=0.0.0.0 --port=8000
```
Acceso: `http://TU_IP_LOCAL:8000`

**Para saber tu IP:**
```bash
ipconfig
```
Busca "Dirección IPv4" (Ejemplo: 192.168.1.100)

---

## 🧪 Probar la API

### Opción 1: Con cURL (Terminal)

```bash
# Login
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d "{\"username\":\"admin\",\"password\":\"tu_password\"}"

# Obtener reclutas (reemplaza TOKEN)
curl -X GET http://127.0.0.1:8000/api/reclutas \
  -H "Authorization: Bearer TOKEN"
```

### Opción 2: Con Postman

1. Crear nueva request POST: `http://127.0.0.1:8000/api/login`
2. En Body > raw > JSON:
   ```json
   {
       "username": "admin",
       "password": "tu_password"
   }
   ```
3. Copiar el `token` de la respuesta
4. Para las demás rutas, agregar en Headers:
   - Key: `Authorization`
   - Value: `Bearer TOKEN_COPIADO`

---

## 📱 Conectar con Android

### 1. Actualizar IP en Android

En tu proyecto Android, archivo `ApiClient.kt`, línea 14:

```kotlin
private const val BASE_URL = "http://TU_IP_AQUI:8000/api/"
```

**Ejemplo:**
```kotlin
private const val BASE_URL = "http://192.168.1.100:8000/api/"
```

### 2. Asegúrate de que:
- ✅ Tu teléfono y PC están en la misma red WiFi
- ✅ El servidor Laravel está corriendo con `--host=0.0.0.0`
- ✅ Tu firewall permite conexiones en el puerto 8000

---

## 📚 Documentación Completa

### Ver todos los endpoints disponibles:
```bash
php artisan route:list --path=api
```

### Documentación detallada:
- **API Endpoints**: Ver `API_DOCUMENTATION.md`
- **Integración Android**: Ver `ANDROID_INTEGRATION.md`

---

## 🔐 Endpoints Principales

### Autenticación (Sin token)
- `POST /api/login` - Iniciar sesión
- `POST /api/register` - Registrar usuario

### Autenticación (Con token)
- `POST /api/logout` - Cerrar sesión
- `GET /api/me` - Obtener usuario actual

### Reclutas (Con token)
- `GET /api/reclutas` - Listar reclutas
- `POST /api/reclutas` - Crear recluta
- `GET /api/reclutas/{curp}` - Ver recluta
- `PUT /api/reclutas/{curp}` - Actualizar recluta
- `DELETE /api/reclutas/{curp}` - Eliminar recluta
- `POST /api/reclutas/{curp}/promover` - Promover a reserva

### Reservas (Con token)
- `GET /api/reserva` - Listar reservas
- `GET /api/reserva/{curp}` - Ver reserva
- `GET /api/reserva/matricula/{matricula}` - Buscar por matrícula
- `PUT /api/reserva/{curp}` - Actualizar reserva
- `GET /api/reserva/estadisticas` - Estadísticas

### Datos Generales (Con token)
- `GET /api/datos` - Listar todos los datos
- `POST /api/datos` - Crear dato
- `GET /api/datos/{curp}` - Ver dato
- `PUT /api/datos/{curp}` - Actualizar dato
- `DELETE /api/datos/{curp}` - Eliminar dato

---

## 🎯 Estructura de Respuestas

### Respuesta Exitosa:
```json
{
    "success": true,
    "message": "Operación exitosa",
    "data": { ... },
    "total": 10
}
```

### Respuesta con Error:
```json
{
    "success": false,
    "message": "Error descriptivo",
    "errors": {
        "campo": ["Mensaje de error"]
    }
}
```

---

## ⚠️ Importante

1. **Token de Autenticación**: Todos los endpoints (excepto login y register) requieren el header:
   ```
   Authorization: Bearer {token}
   ```

2. **Formato de Booleanos**: Usar `true`/`false` (no "si"/"no") para:
   - `acta_nacimiento`
   - `copia_curp`
   - `certificado_estudios`
   - `comprobante_domicilio`
   - `fotografias`

3. **CURP**: Es la clave primaria. Si cambias el CURP al actualizar, se eliminará el registro anterior y creará uno nuevo.

---

## 🐛 Solución de Problemas

### Error de CORS (Android):
Editar `config/cors.php`:
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['*'],
```

### No conecta desde Android:
1. Verificar IP: `ipconfig`
2. Iniciar servidor: `php artisan serve --host=0.0.0.0 --port=8000`
3. Probar en navegador: `http://TU_IP:8000/api/reclutas`
4. Si no funciona, desactivar firewall temporalmente

### Error 401 Unauthorized:
- Verificar que el token es correcto
- Verificar que el header Authorization esté bien formado
- El token puede haber expirado (hacer login nuevamente)

---

## 📞 Testing Completo

### 1. Crear un usuario de prueba (si no existe):
```bash
php artisan tinker
```
```php
User::create([
    'username' => 'testuser',
    'password' => Hash::make('password123'),
    'usertype' => 'admin'
]);
```

### 2. Probar login:
```bash
curl -X POST http://127.0.0.1:8000/api/login \
  -H "Content-Type: application/json" \
  -d "{\"username\":\"testuser\",\"password\":\"password123\"}"
```

### 3. Copiar el token de la respuesta

### 4. Probar endpoint protegido:
```bash
curl -X GET http://127.0.0.1:8000/api/reclutas \
  -H "Authorization: Bearer TU_TOKEN_AQUI"
```

---

## ✨ Características Implementadas

- ✅ Autenticación con tokens (Laravel Sanctum)
- ✅ CRUD completo de Reclutas
- ✅ CRUD completo de Reservas
- ✅ Búsqueda y filtros
- ✅ Promoción de Recluta a Reserva
- ✅ Estadísticas
- ✅ Validación de datos
- ✅ Manejo de errores profesional
- ✅ Documentación completa
- ✅ Código Android completo (Kotlin + Retrofit)

---

## 🎉 ¡Todo Listo!

Tu API REST profesional está completamente funcional y lista para ser consumida desde tu aplicación móvil Android.

**Próximos pasos:**
1. Inicia el servidor: `php artisan serve --host=0.0.0.0`
2. Lee `ANDROID_INTEGRATION.md` para integrar con tu app
3. Prueba los endpoints con Postman o desde tu app Android

**¡Éxito con tu proyecto! 🚀**
