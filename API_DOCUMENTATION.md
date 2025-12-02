# 📱 API SIMECON - Documentación Completa

## 🎯 Descripción
API REST profesional para el sistema SIMECON (Sistema de Información Militar y Control de Personal). Esta API permite gestionar reclutas, reservas y autenticación de usuarios desde aplicaciones móviles Android.

## 🔗 URL Base
```
http://TU_IP:8000/api/
```
**Ejemplo:** `http://192.168.1.100:8000/api/`

---

## 🔐 Autenticación

La API utiliza **Laravel Sanctum** para autenticación mediante tokens Bearer.

### 📌 Login

**Endpoint:** `POST /api/login`

**Request Body:**
```json
{
    "username": "admin",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Inicio de sesión exitoso",
    "token": "1|AbCdEfGhIjKlMnOpQrStUvWxYz...",
    "user": {
        "id": 1,
        "username": "admin",
        "usertype": "admin"
    }
}
```

**Response Error (422):**
```json
{
    "message": "Las credenciales son incorrectas.",
    "errors": {
        "username": ["Las credenciales son incorrectas."]
    }
}
```

---

### 📌 Registro (Solo Admin)

**Endpoint:** `POST /api/register`

**Request Body:**
```json
{
    "username": "nuevo_usuario",
    "password": "password123",
    "usertype": "user"
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Usuario registrado exitosamente",
    "token": "2|AbCdEfGhIjKlMnOpQrStUvWxYz...",
    "user": {
        "id": 2,
        "username": "nuevo_usuario",
        "usertype": "user"
    }
}
```

---

### 📌 Logout

**Endpoint:** `POST /api/logout`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Sesión cerrada exitosamente"
}
```

---

### 📌 Obtener Usuario Autenticado

**Endpoint:** `GET /api/me`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "user": {
        "id": 1,
        "username": "admin",
        "usertype": "admin"
    }
}
```

---

## 👥 Reclutas

### 📌 Listar Reclutas

**Endpoint:** `GET /api/reclutas`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters (Opcionales):**
- `search` - Buscar por CURP, nombre, apellidos, clase o domicilio

**Example:** `GET /api/reclutas?search=JUAN`

**Response (200):**
```json
{
    "success": true,
    "data": [
        {
            "curp": "JUAP900101HDFLRN09",
            "nombre": "JUAN",
            "apellido_paterno": "PEREZ",
            "apellido_materno": "LOPEZ",
            "clase": "2024",
            "lugar_de_nacimiento": "CIUDAD DE MEXICO",
            "domicilio": "Calle 123",
            "ocupacion": "Estudiante",
            "nombre_del_padre": "Jose Perez",
            "nombre_de_la_madre": "Maria Lopez",
            "estado_civil": "Soltero",
            "grado_de_estudios": "Preparatoria",
            "matricula": null,
            "status": "Recluta",
            "acta_nacimiento": true,
            "copia_curp": true,
            "certificado_estudios": false,
            "comprobante_domicilio": true,
            "fotografias": true,
            "created_at": "2025-12-02T10:30:00.000000Z",
            "updated_at": "2025-12-02T10:30:00.000000Z"
        }
    ],
    "total": 1
}
```

---

### 📌 Obtener Recluta por CURP

**Endpoint:** `GET /api/reclutas/{curp}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "curp": "JUAP900101HDFLRN09",
        "nombre": "JUAN",
        "apellido_paterno": "PEREZ",
        ...
    }
}
```

**Response Error (404):**
```json
{
    "success": false,
    "message": "Recluta no encontrado"
}
```

---

### 📌 Crear Recluta

**Endpoint:** `POST /api/reclutas`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "curp": "JUAP900101HDFLRN09",
    "nombre": "JUAN",
    "apellido_paterno": "PEREZ",
    "apellido_materno": "LOPEZ",
    "clase": "2024",
    "lugar_de_nacimiento": "CIUDAD DE MEXICO",
    "domicilio": "Calle 123",
    "ocupacion": "Estudiante",
    "nombre_del_padre": "Jose Perez",
    "nombre_de_la_madre": "Maria Lopez",
    "estado_civil": "Soltero",
    "grado_de_estudios": "Preparatoria",
    "acta_nacimiento": true,
    "copia_curp": true,
    "certificado_estudios": false,
    "comprobante_domicilio": true,
    "fotografias": true
}
```

**Response (201):**
```json
{
    "success": true,
    "message": "Recluta creado exitosamente",
    "data": { ... }
}
```

---

### 📌 Actualizar Recluta

**Endpoint:** `PUT /api/reclutas/{curp}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:** (Igual que crear, pero incluyendo `status` y `matricula`)
```json
{
    "curp": "JUAP900101HDFLRN09",
    "nombre": "JUAN",
    ...,
    "status": "Recluta",
    "matricula": null
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Recluta actualizado exitosamente",
    "data": { ... }
}
```

---

### 📌 Eliminar Recluta

**Endpoint:** `DELETE /api/reclutas/{curp}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Recluta eliminado exitosamente"
}
```

---

### 📌 Promover Recluta a Reserva

**Endpoint:** `POST /api/reclutas/{curp}/promover`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:**
```json
{
    "matricula": "RES-2024-001"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Recluta promovido a Reserva exitosamente",
    "data": {
        "curp": "JUAP900101HDFLRN09",
        "status": "Reserva",
        "matricula": "RES-2024-001",
        ...
    }
}
```

---

## 🎖️ Reservas

### 📌 Listar Reservas

**Endpoint:** `GET /api/reserva`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters (Opcionales):**
- `search` - Buscar por CURP, nombre, apellidos, matrícula, clase o domicilio

**Example:** `GET /api/reserva?search=RES-2024`

**Response (200):**
```json
{
    "success": true,
    "data": [ ... ],
    "total": 5
}
```

---

### 📌 Obtener Reserva por CURP

**Endpoint:** `GET /api/reserva/{curp}`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "data": { ... }
}
```

---

### 📌 Buscar Reserva por Matrícula

**Endpoint:** `GET /api/reserva/matricula/{matricula}`

**Headers:**
```
Authorization: Bearer {token}
```

**Example:** `GET /api/reserva/matricula/RES-2024-001`

**Response (200):**
```json
{
    "success": true,
    "data": {
        "curp": "JUAP900101HDFLRN09",
        "matricula": "RES-2024-001",
        "status": "Reserva",
        ...
    }
}
```

---

### 📌 Actualizar Reserva

**Endpoint:** `PUT /api/reserva/{curp}`

**Headers:**
```
Authorization: Bearer {token}
Content-Type: application/json
```

**Request Body:** (Debe incluir `matricula` y `status`)
```json
{
    "curp": "JUAP900101HDFLRN09",
    "nombre": "JUAN",
    ...,
    "matricula": "RES-2024-001",
    "status": "Reserva"
}
```

**Response (200):**
```json
{
    "success": true,
    "message": "Reserva actualizada exitosamente",
    "data": { ... }
}
```

---

### 📌 Estadísticas de Reservas

**Endpoint:** `GET /api/reserva/estadisticas`

**Headers:**
```
Authorization: Bearer {token}
```

**Response (200):**
```json
{
    "success": true,
    "data": {
        "total_reservas": 45,
        "total_reclutas": 30,
        "reservas_por_clase": [
            {
                "clase": "2024",
                "total": 25
            },
            {
                "clase": "2023",
                "total": 20
            }
        ],
        "total_general": 75
    }
}
```

---

## 📊 Datos Generales

### 📌 Listar Todos los Datos

**Endpoint:** `GET /api/datos`

**Headers:**
```
Authorization: Bearer {token}
```

**Query Parameters (Opcionales):**
- `search` - Buscar por CURP, nombre, apellidos, matrícula o clase
- `status` - Filtrar por status: `Recluta` o `Reserva`

**Example:** `GET /api/datos?status=Reserva&search=JUAN`

**Response (200):**
```json
{
    "success": true,
    "data": [ ... ],
    "total": 10
}
```

---

## 🔴 Códigos de Error

| Código | Descripción |
|--------|-------------|
| 200 | Operación exitosa |
| 201 | Recurso creado exitosamente |
| 401 | No autenticado (token inválido o ausente) |
| 404 | Recurso no encontrado |
| 422 | Error de validación |
| 500 | Error interno del servidor |

---

## 🛠️ Configuración en Laravel

### Paso 1: Limpiar Caché
```bash
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

### Paso 2: Iniciar Servidor
```bash
php artisan serve
```

El servidor estará disponible en: `http://127.0.0.1:8000`

Para acceder desde red local:
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 📲 Configuración CORS (Si es necesario)

Si tienes problemas de CORS, edita `config/cors.php`:

```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_origins' => ['*'],
'allowed_methods' => ['*'],
'allowed_headers' => ['*'],
```

---

## ✅ Testing con cURL

### Login:
```bash
curl -X POST http://192.168.1.100:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password"}'
```

### Obtener Reclutas:
```bash
curl -X GET http://192.168.1.100:8000/api/reclutas \
  -H "Authorization: Bearer 1|tu_token_aqui"
```

---

## 📝 Notas Importantes

1. **Todos los endpoints (excepto `/login` y `/register`) requieren autenticación**
2. **El token debe enviarse en el header:** `Authorization: Bearer {token}`
3. **Los booleanos deben ser:** `true` o `false` (no "si"/"no")
4. **Las fechas se retornan en formato ISO 8601:** `YYYY-MM-DDTHH:mm:ss.000000Z`
5. **El CURP es la clave primaria**, si cambias el CURP se elimina el registro antiguo y se crea uno nuevo

---

## 🚀 Próximos Pasos

1. Integrar la API en tu aplicación Android con Retrofit
2. Implementar manejo de errores y reintentos
3. Agregar sincronización offline
4. Implementar notificaciones push

**¡Tu API está lista para ser consumida! 🎉**
