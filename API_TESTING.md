# 🧪 Colección de Requests para Testing - API SIMECON

## 📌 Variables Globales
```
BASE_URL = http://127.0.0.1:8000/api
TOKEN = (Se obtiene después del login)
```

---

## 1️⃣ AUTENTICACIÓN

### Login
```http
POST {{BASE_URL}}/login
Content-Type: application/json

{
    "username": "admin",
    "password": "password123"
}
```

**Response Esperado:**
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

---

### Registro de Usuario
```http
POST {{BASE_URL}}/register
Content-Type: application/json

{
    "username": "nuevo_usuario",
    "password": "password123",
    "usertype": "user"
}
```

---

### Obtener Usuario Actual
```http
GET {{BASE_URL}}/me
Authorization: Bearer {{TOKEN}}
```

---

### Logout
```http
POST {{BASE_URL}}/logout
Authorization: Bearer {{TOKEN}}
```

---

## 2️⃣ RECLUTAS

### Listar Todos los Reclutas
```http
GET {{BASE_URL}}/reclutas
Authorization: Bearer {{TOKEN}}
```

---

### Buscar Reclutas
```http
GET {{BASE_URL}}/reclutas?search=JUAN
Authorization: Bearer {{TOKEN}}
```

---

### Obtener Recluta por CURP
```http
GET {{BASE_URL}}/reclutas/JUAP900101HDFLRN09
Authorization: Bearer {{TOKEN}}
```

---

### Crear Recluta
```http
POST {{BASE_URL}}/reclutas
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
    "curp": "JUAP900101HDFLRN09",
    "nombre": "JUAN",
    "apellido_paterno": "PEREZ",
    "apellido_materno": "LOPEZ",
    "clase": "2024",
    "lugar_de_nacimiento": "CIUDAD DE MEXICO",
    "domicilio": "Calle Principal 123, Col. Centro",
    "ocupacion": "Estudiante",
    "nombre_del_padre": "Jose Perez Garcia",
    "nombre_de_la_madre": "Maria Lopez Martinez",
    "estado_civil": "Soltero",
    "grado_de_estudios": "Preparatoria",
    "acta_nacimiento": true,
    "copia_curp": true,
    "certificado_estudios": false,
    "comprobante_domicilio": true,
    "fotografias": true
}
```

---

### Actualizar Recluta
```http
PUT {{BASE_URL}}/reclutas/JUAP900101HDFLRN09
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
    "curp": "JUAP900101HDFLRN09",
    "nombre": "JUAN CARLOS",
    "apellido_paterno": "PEREZ",
    "apellido_materno": "LOPEZ",
    "clase": "2024",
    "lugar_de_nacimiento": "CIUDAD DE MEXICO",
    "domicilio": "Calle Principal 456, Col. Centro",
    "ocupacion": "Estudiante",
    "nombre_del_padre": "Jose Perez Garcia",
    "nombre_de_la_madre": "Maria Lopez Martinez",
    "estado_civil": "Soltero",
    "grado_de_estudios": "Licenciatura",
    "matricula": null,
    "status": "Recluta",
    "acta_nacimiento": true,
    "copia_curp": true,
    "certificado_estudios": true,
    "comprobante_domicilio": true,
    "fotografias": true
}
```

---

### Eliminar Recluta
```http
DELETE {{BASE_URL}}/reclutas/JUAP900101HDFLRN09
Authorization: Bearer {{TOKEN}}
```

---

### Promover Recluta a Reserva
```http
POST {{BASE_URL}}/reclutas/JUAP900101HDFLRN09/promover
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
    "matricula": "RES-2024-001"
}
```

---

## 3️⃣ RESERVAS

### Listar Todas las Reservas
```http
GET {{BASE_URL}}/reserva
Authorization: Bearer {{TOKEN}}
```

---

### Buscar Reservas
```http
GET {{BASE_URL}}/reserva?search=RES-2024
Authorization: Bearer {{TOKEN}}
```

---

### Obtener Reserva por CURP
```http
GET {{BASE_URL}}/reserva/JUAP900101HDFLRN09
Authorization: Bearer {{TOKEN}}
```

---

### Buscar Reserva por Matrícula
```http
GET {{BASE_URL}}/reserva/matricula/RES-2024-001
Authorization: Bearer {{TOKEN}}
```

---

### Actualizar Reserva
```http
PUT {{BASE_URL}}/reserva/JUAP900101HDFLRN09
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
    "curp": "JUAP900101HDFLRN09",
    "nombre": "JUAN CARLOS",
    "apellido_paterno": "PEREZ",
    "apellido_materno": "LOPEZ",
    "clase": "2024",
    "lugar_de_nacimiento": "CIUDAD DE MEXICO",
    "domicilio": "Calle Principal 456, Col. Centro",
    "ocupacion": "Reservista",
    "nombre_del_padre": "Jose Perez Garcia",
    "nombre_de_la_madre": "Maria Lopez Martinez",
    "estado_civil": "Casado",
    "grado_de_estudios": "Licenciatura",
    "matricula": "RES-2024-001",
    "status": "Reserva",
    "acta_nacimiento": true,
    "copia_curp": true,
    "certificado_estudios": true,
    "comprobante_domicilio": true,
    "fotografias": true
}
```

---

### Obtener Estadísticas
```http
GET {{BASE_URL}}/reserva/estadisticas
Authorization: Bearer {{TOKEN}}
```

**Response Esperado:**
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

## 4️⃣ DATOS GENERALES

### Listar Todos los Datos
```http
GET {{BASE_URL}}/datos
Authorization: Bearer {{TOKEN}}
```

---

### Filtrar Datos por Status
```http
GET {{BASE_URL}}/datos?status=Reserva
Authorization: Bearer {{TOKEN}}
```

---

### Buscar y Filtrar
```http
GET {{BASE_URL}}/datos?status=Recluta&search=JUAN
Authorization: Bearer {{TOKEN}}
```

---

### Obtener Dato por CURP
```http
GET {{BASE_URL}}/datos/JUAP900101HDFLRN09
Authorization: Bearer {{TOKEN}}
```

---

### Crear Dato
```http
POST {{BASE_URL}}/datos
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
    "curp": "MAPS950505MDFRRL08",
    "nombre": "MARIA",
    "apellido_paterno": "PEREZ",
    "apellido_materno": "SANCHEZ",
    "clase": "2024",
    "lugar_de_nacimiento": "GUADALAJARA",
    "domicilio": "Av. Revolucion 789",
    "ocupacion": "Profesionista",
    "nombre_del_padre": "Pedro Perez",
    "nombre_de_la_madre": "Ana Sanchez",
    "estado_civil": "Soltera",
    "grado_de_estudios": "Licenciatura",
    "acta_nacimiento": true,
    "copia_curp": true,
    "certificado_estudios": true,
    "comprobante_domicilio": true,
    "fotografias": true
}
```

---

### Actualizar Dato
```http
PUT {{BASE_URL}}/datos/MAPS950505MDFRRL08
Authorization: Bearer {{TOKEN}}
Content-Type: application/json

{
    "curp": "MAPS950505MDFRRL08",
    "nombre": "MARIA FERNANDA",
    "apellido_paterno": "PEREZ",
    "apellido_materno": "SANCHEZ",
    "clase": "2024",
    "lugar_de_nacimiento": "GUADALAJARA",
    "domicilio": "Av. Revolucion 789, Col. Centro",
    "ocupacion": "Profesionista",
    "nombre_del_padre": "Pedro Perez Lopez",
    "nombre_de_la_madre": "Ana Sanchez Garcia",
    "estado_civil": "Soltera",
    "grado_de_estudios": "Maestria",
    "matricula": "RES-2024-002",
    "status": "Reserva",
    "acta_nacimiento": true,
    "copia_curp": true,
    "certificado_estudios": true,
    "comprobante_domicilio": true,
    "fotografias": true
}
```

---

### Eliminar Dato
```http
DELETE {{BASE_URL}}/datos/MAPS950505MDFRRL08
Authorization: Bearer {{TOKEN}}
```

---

## 🔴 Respuestas de Error Comunes

### Error 401 - No Autenticado
```json
{
    "message": "Unauthenticated."
}
```
**Solución:** Verificar que el token esté en el header `Authorization: Bearer {token}`

---

### Error 404 - No Encontrado
```json
{
    "success": false,
    "message": "Registro no encontrado"
}
```

---

### Error 422 - Validación Fallida
```json
{
    "success": false,
    "message": "Error de validación",
    "errors": {
        "curp": [
            "El campo curp es obligatorio."
        ],
        "nombre": [
            "El campo nombre es obligatorio."
        ]
    }
}
```

---

## 📋 Importar a Postman

### Crear Environment en Postman:
```json
{
    "name": "SIMECON API",
    "values": [
        {
            "key": "BASE_URL",
            "value": "http://127.0.0.1:8000/api",
            "enabled": true
        },
        {
            "key": "TOKEN",
            "value": "",
            "enabled": true
        }
    ]
}
```

### Pasos:
1. Hacer login con la request de login
2. Copiar el token de la respuesta
3. Pegarlo en la variable `TOKEN` del environment
4. Usar `{{BASE_URL}}` y `{{TOKEN}}` en las requests

---

## 🧪 Script de Testing Automatizado (cURL)

### `test_api.sh` (Linux/Mac)
```bash
#!/bin/bash

BASE_URL="http://127.0.0.1:8000/api"

# Login
echo "=== Testing Login ==="
RESPONSE=$(curl -s -X POST "$BASE_URL/login" \
  -H "Content-Type: application/json" \
  -d '{"username":"admin","password":"password"}')

TOKEN=$(echo $RESPONSE | jq -r '.token')
echo "Token: $TOKEN"

# Obtener Reclutas
echo -e "\n=== Testing Get Reclutas ==="
curl -s -X GET "$BASE_URL/reclutas" \
  -H "Authorization: Bearer $TOKEN" | jq

# Obtener Reservas
echo -e "\n=== Testing Get Reservas ==="
curl -s -X GET "$BASE_URL/reserva" \
  -H "Authorization: Bearer $TOKEN" | jq

# Estadísticas
echo -e "\n=== Testing Estadísticas ==="
curl -s -X GET "$BASE_URL/reserva/estadisticas" \
  -H "Authorization: Bearer $TOKEN" | jq

echo -e "\n=== Tests Completados ==="
```

### `test_api.ps1` (PowerShell - Windows)
```powershell
$BASE_URL = "http://127.0.0.1:8000/api"

# Login
Write-Host "=== Testing Login ===" -ForegroundColor Green
$loginBody = @{
    username = "admin"
    password = "password"
} | ConvertTo-Json

$response = Invoke-RestMethod -Uri "$BASE_URL/login" -Method Post -Body $loginBody -ContentType "application/json"
$TOKEN = $response.token
Write-Host "Token: $TOKEN"

# Obtener Reclutas
Write-Host "`n=== Testing Get Reclutas ===" -ForegroundColor Green
$headers = @{
    "Authorization" = "Bearer $TOKEN"
}
$reclutas = Invoke-RestMethod -Uri "$BASE_URL/reclutas" -Method Get -Headers $headers
$reclutas | ConvertTo-Json -Depth 10

# Obtener Reservas
Write-Host "`n=== Testing Get Reservas ===" -ForegroundColor Green
$reservas = Invoke-RestMethod -Uri "$BASE_URL/reserva" -Method Get -Headers $headers
$reservas | ConvertTo-Json -Depth 10

Write-Host "`n=== Tests Completados ===" -ForegroundColor Green
```

---

## ✅ Checklist de Testing

- [ ] Login exitoso
- [ ] Login con credenciales incorrectas (debe fallar)
- [ ] Obtener usuario actual con token válido
- [ ] Listar reclutas
- [ ] Crear recluta nuevo
- [ ] Actualizar recluta existente
- [ ] Promover recluta a reserva
- [ ] Listar reservas
- [ ] Buscar reserva por matrícula
- [ ] Obtener estadísticas
- [ ] Eliminar registro
- [ ] Logout
- [ ] Intentar acceder a endpoint protegido sin token (debe fallar con 401)

---

**¡Listo para testing! 🧪✨**
