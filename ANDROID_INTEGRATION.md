# 📱 Guía de Integración Android - API SIMECON

## 🎯 Configuración Inicial

### 1. Agregar Dependencias en `build.gradle` (Module: app)

```gradle
dependencies {
    // Retrofit para consumir la API
    implementation 'com.squareup.retrofit2:retrofit:2.11.0'
    implementation 'com.squareup.retrofit2:converter-gson:2.11.0'
    
    // OkHttp para logging (opcional pero recomendado)
    implementation 'com.squareup.okhttp3:logging-interceptor:4.12.0'
    
    // Coroutines para operaciones asíncronas
    implementation 'org.jetbrains.kotlinx:kotlinx-coroutines-android:1.7.3'
    implementation 'org.jetbrains.kotlinx:kotlinx-coroutines-core:1.7.3'
    
    // ViewModel y LiveData
    implementation 'androidx.lifecycle:lifecycle-viewmodel-ktx:2.7.0'
    implementation 'androidx.lifecycle:lifecycle-livedata-ktx:2.7.0'
    
    // Datastore para guardar el token
    implementation 'androidx.datastore:datastore-preferences:1.0.0'
}
```

### 2. Permisos en `AndroidManifest.xml`

```xml
<manifest xmlns:android="http://schemas.android.com/apk/res/android">
    
    <uses-permission android:name="android.permission.INTERNET" />
    <uses-permission android:name="android.permission.ACCESS_NETWORK_STATE" />
    
    <application
        android:usesCleartextTraffic="true"
        ...>
        ...
    </application>
</manifest>
```

---

## 📦 Estructura de Paquetes

```
com.tuapp.simecon/
├── data/
│   ├── api/
│   │   ├── ApiClient.kt
│   │   ├── ApiService.kt
│   │   └── AuthInterceptor.kt
│   ├── models/
│   │   ├── User.kt
│   │   ├── Dato.kt
│   │   ├── LoginRequest.kt
│   │   ├── LoginResponse.kt
│   │   └── ApiResponse.kt
│   └── repository/
│       ├── AuthRepository.kt
│       └── DatosRepository.kt
├── ui/
│   ├── login/
│   │   ├── LoginActivity.kt
│   │   └── LoginViewModel.kt
│   └── main/
│       ├── MainActivity.kt
│       └── MainViewModel.kt
└── utils/
    ├── TokenManager.kt
    └── Resource.kt
```

---

## 🔧 Código Kotlin

### 1. Models (Modelos de Datos)

#### `User.kt`
```kotlin
package com.tuapp.simecon.data.models

data class User(
    val id: Int,
    val username: String,
    val usertype: String
)
```

#### `Dato.kt`
```kotlin
package com.tuapp.simecon.data.models

import com.google.gson.annotations.SerializedName

data class Dato(
    val curp: String,
    val nombre: String,
    @SerializedName("apellido_paterno")
    val apellidoPaterno: String,
    @SerializedName("apellido_materno")
    val apellidoMaterno: String,
    val clase: String?,
    @SerializedName("lugar_de_nacimiento")
    val lugarNacimiento: String?,
    val domicilio: String?,
    val ocupacion: String?,
    @SerializedName("nombre_del_padre")
    val nombrePadre: String?,
    @SerializedName("nombre_de_la_madre")
    val nombreMadre: String?,
    @SerializedName("estado_civil")
    val estadoCivil: String?,
    @SerializedName("grado_de_estudios")
    val gradoEstudios: String?,
    val matricula: String?,
    val status: String,
    @SerializedName("acta_nacimiento")
    val actaNacimiento: Boolean,
    @SerializedName("copia_curp")
    val copiaCurp: Boolean,
    @SerializedName("certificado_estudios")
    val certificadoEstudios: Boolean,
    @SerializedName("comprobante_domicilio")
    val comprobanteDomicilio: Boolean,
    val fotografias: Boolean,
    @SerializedName("created_at")
    val createdAt: String?,
    @SerializedName("updated_at")
    val updatedAt: String?
) {
    val nombreCompleto: String
        get() = "$nombre $apellidoPaterno $apellidoMaterno".trim()
}
```

#### `LoginRequest.kt`
```kotlin
package com.tuapp.simecon.data.models

data class LoginRequest(
    val username: String,
    val password: String
)
```

#### `LoginResponse.kt`
```kotlin
package com.tuapp.simecon.data.models

data class LoginResponse(
    val success: Boolean,
    val message: String,
    val token: String,
    val user: User
)
```

#### `ApiResponse.kt`
```kotlin
package com.tuapp.simecon.data.models

data class ApiResponse<T>(
    val success: Boolean,
    val message: String? = null,
    val data: T? = null,
    val total: Int? = null,
    val errors: Map<String, List<String>>? = null
)
```

---

### 2. API Configuration

#### `ApiClient.kt`
```kotlin
package com.tuapp.simecon.data.api

import okhttp3.OkHttpClient
import okhttp3.logging.HttpLoggingInterceptor
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import java.util.concurrent.TimeUnit

object ApiClient {
    // ⚠️ CAMBIAR ESTA IP POR LA IP DE TU SERVIDOR
    private const val BASE_URL = "http://192.168.1.100:8000/api/"
    
    private val loggingInterceptor = HttpLoggingInterceptor().apply {
        level = HttpLoggingInterceptor.Level.BODY
    }
    
    private val okHttpClient = OkHttpClient.Builder()
        .addInterceptor(loggingInterceptor)
        .connectTimeout(30, TimeUnit.SECONDS)
        .readTimeout(30, TimeUnit.SECONDS)
        .writeTimeout(30, TimeUnit.SECONDS)
        .build()
    
    val instance: Retrofit by lazy {
        Retrofit.Builder()
            .baseUrl(BASE_URL)
            .client(okHttpClient)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
    }
    
    fun <T> createService(serviceClass: Class<T>, token: String? = null): T {
        val clientBuilder = OkHttpClient.Builder()
            .addInterceptor(loggingInterceptor)
            .connectTimeout(30, TimeUnit.SECONDS)
            .readTimeout(30, TimeUnit.SECONDS)
            .writeTimeout(30, TimeUnit.SECONDS)
        
        // Agregar token si existe
        if (!token.isNullOrEmpty()) {
            clientBuilder.addInterceptor(AuthInterceptor(token))
        }
        
        val client = clientBuilder.build()
        
        val retrofit = Retrofit.Builder()
            .baseUrl(BASE_URL)
            .client(client)
            .addConverterFactory(GsonConverterFactory.create())
            .build()
        
        return retrofit.create(serviceClass)
    }
}
```

#### `AuthInterceptor.kt`
```kotlin
package com.tuapp.simecon.data.api

import okhttp3.Interceptor
import okhttp3.Response

class AuthInterceptor(private val token: String) : Interceptor {
    override fun intercept(chain: Interceptor.Chain): Response {
        val request = chain.request().newBuilder()
            .addHeader("Authorization", "Bearer $token")
            .addHeader("Accept", "application/json")
            .build()
        return chain.proceed(request)
    }
}
```

#### `ApiService.kt`
```kotlin
package com.tuapp.simecon.data.api

import com.tuapp.simecon.data.models.*
import retrofit2.Response
import retrofit2.http.*

interface ApiService {
    
    // ===== AUTENTICACIÓN =====
    @POST("login")
    suspend fun login(@Body request: LoginRequest): Response<LoginResponse>
    
    @POST("register")
    suspend fun register(@Body request: Map<String, String>): Response<LoginResponse>
    
    @POST("logout")
    suspend fun logout(): Response<ApiResponse<Nothing>>
    
    @GET("me")
    suspend fun getUser(): Response<ApiResponse<User>>
    
    // ===== RECLUTAS =====
    @GET("reclutas")
    suspend fun getReclutas(
        @Query("search") search: String? = null
    ): Response<ApiResponse<List<Dato>>>
    
    @GET("reclutas/{curp}")
    suspend fun getRecluta(@Path("curp") curp: String): Response<ApiResponse<Dato>>
    
    @POST("reclutas")
    suspend fun createRecluta(@Body dato: Map<String, Any?>): Response<ApiResponse<Dato>>
    
    @PUT("reclutas/{curp}")
    suspend fun updateRecluta(
        @Path("curp") curp: String,
        @Body dato: Map<String, Any?>
    ): Response<ApiResponse<Dato>>
    
    @DELETE("reclutas/{curp}")
    suspend fun deleteRecluta(@Path("curp") curp: String): Response<ApiResponse<Nothing>>
    
    @POST("reclutas/{curp}/promover")
    suspend fun promoverRecluta(
        @Path("curp") curp: String,
        @Body body: Map<String, String>
    ): Response<ApiResponse<Dato>>
    
    // ===== RESERVAS =====
    @GET("reserva")
    suspend fun getReservas(
        @Query("search") search: String? = null
    ): Response<ApiResponse<List<Dato>>>
    
    @GET("reserva/{curp}")
    suspend fun getReserva(@Path("curp") curp: String): Response<ApiResponse<Dato>>
    
    @GET("reserva/matricula/{matricula}")
    suspend fun getReservaPorMatricula(
        @Path("matricula") matricula: String
    ): Response<ApiResponse<Dato>>
    
    @PUT("reserva/{curp}")
    suspend fun updateReserva(
        @Path("curp") curp: String,
        @Body dato: Map<String, Any?>
    ): Response<ApiResponse<Dato>>
    
    @GET("reserva/estadisticas")
    suspend fun getEstadisticas(): Response<ApiResponse<Map<String, Any>>>
    
    // ===== DATOS GENERALES =====
    @GET("datos")
    suspend fun getDatos(
        @Query("search") search: String? = null,
        @Query("status") status: String? = null
    ): Response<ApiResponse<List<Dato>>>
    
    @GET("datos/{curp}")
    suspend fun getDato(@Path("curp") curp: String): Response<ApiResponse<Dato>>
    
    @POST("datos")
    suspend fun createDato(@Body dato: Map<String, Any?>): Response<ApiResponse<Dato>>
    
    @PUT("datos/{curp}")
    suspend fun updateDato(
        @Path("curp") curp: String,
        @Body dato: Map<String, Any?>
    ): Response<ApiResponse<Dato>>
    
    @DELETE("datos/{curp}")
    suspend fun deleteDato(@Path("curp") curp: String): Response<ApiResponse<Nothing>>
}
```

---

### 3. Token Manager (Gestión de Token)

#### `TokenManager.kt`
```kotlin
package com.tuapp.simecon.utils

import android.content.Context
import androidx.datastore.core.DataStore
import androidx.datastore.preferences.core.Preferences
import androidx.datastore.preferences.core.edit
import androidx.datastore.preferences.core.stringPreferencesKey
import androidx.datastore.preferences.preferencesDataStore
import kotlinx.coroutines.flow.Flow
import kotlinx.coroutines.flow.map

class TokenManager(private val context: Context) {
    
    companion object {
        private val Context.dataStore: DataStore<Preferences> by preferencesDataStore("auth_prefs")
        private val TOKEN_KEY = stringPreferencesKey("auth_token")
        private val USERNAME_KEY = stringPreferencesKey("username")
        private val USERTYPE_KEY = stringPreferencesKey("usertype")
    }
    
    suspend fun saveToken(token: String) {
        context.dataStore.edit { preferences ->
            preferences[TOKEN_KEY] = token
        }
    }
    
    suspend fun saveUserData(username: String, usertype: String) {
        context.dataStore.edit { preferences ->
            preferences[USERNAME_KEY] = username
            preferences[USERTYPE_KEY] = usertype
        }
    }
    
    fun getToken(): Flow<String?> {
        return context.dataStore.data.map { preferences ->
            preferences[TOKEN_KEY]
        }
    }
    
    fun getUsername(): Flow<String?> {
        return context.dataStore.data.map { preferences ->
            preferences[USERNAME_KEY]
        }
    }
    
    fun getUsertype(): Flow<String?> {
        return context.dataStore.data.map { preferences ->
            preferences[USERTYPE_KEY]
        }
    }
    
    suspend fun clearToken() {
        context.dataStore.edit { preferences ->
            preferences.clear()
        }
    }
}
```

---

### 4. Resource (Manejo de Estados)

#### `Resource.kt`
```kotlin
package com.tuapp.simecon.utils

sealed class Resource<T>(
    val data: T? = null,
    val message: String? = null
) {
    class Success<T>(data: T) : Resource<T>(data)
    class Error<T>(message: String, data: T? = null) : Resource<T>(data, message)
    class Loading<T> : Resource<T>()
}
```

---

### 5. Repository (Capa de Datos)

#### `AuthRepository.kt`
```kotlin
package com.tuapp.simecon.data.repository

import com.tuapp.simecon.data.api.ApiClient
import com.tuapp.simecon.data.api.ApiService
import com.tuapp.simecon.data.models.LoginRequest
import com.tuapp.simecon.data.models.LoginResponse
import com.tuapp.simecon.utils.Resource
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext

class AuthRepository {
    
    private val apiService = ApiClient.instance.create(ApiService::class.java)
    
    suspend fun login(username: String, password: String): Resource<LoginResponse> {
        return withContext(Dispatchers.IO) {
            try {
                val response = apiService.login(LoginRequest(username, password))
                
                if (response.isSuccessful && response.body() != null) {
                    Resource.Success(response.body()!!)
                } else {
                    val errorMessage = when (response.code()) {
                        422 -> "Credenciales incorrectas"
                        500 -> "Error del servidor"
                        else -> "Error desconocido: ${response.code()}"
                    }
                    Resource.Error(errorMessage)
                }
            } catch (e: Exception) {
                Resource.Error("Error de conexión: ${e.localizedMessage}")
            }
        }
    }
    
    suspend fun logout(token: String): Resource<Boolean> {
        return withContext(Dispatchers.IO) {
            try {
                val service = ApiClient.createService(ApiService::class.java, token)
                val response = service.logout()
                
                if (response.isSuccessful) {
                    Resource.Success(true)
                } else {
                    Resource.Error("Error al cerrar sesión")
                }
            } catch (e: Exception) {
                Resource.Error("Error: ${e.localizedMessage}")
            }
        }
    }
}
```

#### `DatosRepository.kt`
```kotlin
package com.tuapp.simecon.data.repository

import com.tuapp.simecon.data.api.ApiClient
import com.tuapp.simecon.data.api.ApiService
import com.tuapp.simecon.data.models.Dato
import com.tuapp.simecon.utils.Resource
import kotlinx.coroutines.Dispatchers
import kotlinx.coroutines.withContext

class DatosRepository(private val token: String) {
    
    private val apiService = ApiClient.createService(ApiService::class.java, token)
    
    suspend fun getReclutas(search: String? = null): Resource<List<Dato>> {
        return withContext(Dispatchers.IO) {
            try {
                val response = apiService.getReclutas(search)
                
                if (response.isSuccessful && response.body() != null) {
                    val body = response.body()!!
                    if (body.success && body.data != null) {
                        Resource.Success(body.data)
                    } else {
                        Resource.Error(body.message ?: "Error desconocido")
                    }
                } else {
                    Resource.Error("Error: ${response.code()}")
                }
            } catch (e: Exception) {
                Resource.Error("Error de conexión: ${e.localizedMessage}")
            }
        }
    }
    
    suspend fun getReservas(search: String? = null): Resource<List<Dato>> {
        return withContext(Dispatchers.IO) {
            try {
                val response = apiService.getReservas(search)
                
                if (response.isSuccessful && response.body() != null) {
                    val body = response.body()!!
                    if (body.success && body.data != null) {
                        Resource.Success(body.data)
                    } else {
                        Resource.Error(body.message ?: "Error desconocido")
                    }
                } else {
                    Resource.Error("Error: ${response.code()}")
                }
            } catch (e: Exception) {
                Resource.Error("Error de conexión: ${e.localizedMessage}")
            }
        }
    }
    
    suspend fun createRecluta(dato: Map<String, Any?>): Resource<Dato> {
        return withContext(Dispatchers.IO) {
            try {
                val response = apiService.createRecluta(dato)
                
                if (response.isSuccessful && response.body() != null) {
                    val body = response.body()!!
                    if (body.success && body.data != null) {
                        Resource.Success(body.data)
                    } else {
                        Resource.Error(body.message ?: "Error al crear recluta")
                    }
                } else {
                    Resource.Error("Error: ${response.code()}")
                }
            } catch (e: Exception) {
                Resource.Error("Error: ${e.localizedMessage}")
            }
        }
    }
    
    suspend fun promoverRecluta(curp: String, matricula: String): Resource<Dato> {
        return withContext(Dispatchers.IO) {
            try {
                val response = apiService.promoverRecluta(curp, mapOf("matricula" to matricula))
                
                if (response.isSuccessful && response.body() != null) {
                    val body = response.body()!!
                    if (body.success && body.data != null) {
                        Resource.Success(body.data)
                    } else {
                        Resource.Error(body.message ?: "Error al promover")
                    }
                } else {
                    Resource.Error("Error: ${response.code()}")
                }
            } catch (e: Exception) {
                Resource.Error("Error: ${e.localizedMessage}")
            }
        }
    }
    
    suspend fun deleteRecluta(curp: String): Resource<Boolean> {
        return withContext(Dispatchers.IO) {
            try {
                val response = apiService.deleteRecluta(curp)
                
                if (response.isSuccessful) {
                    Resource.Success(true)
                } else {
                    Resource.Error("Error al eliminar: ${response.code()}")
                }
            } catch (e: Exception) {
                Resource.Error("Error: ${e.localizedMessage}")
            }
        }
    }
}
```

---

### 6. ViewModel (Lógica de UI)

#### `LoginViewModel.kt`
```kotlin
package com.tuapp.simecon.ui.login

import androidx.lifecycle.LiveData
import androidx.lifecycle.MutableLiveData
import androidx.lifecycle.ViewModel
import androidx.lifecycle.viewModelScope
import com.tuapp.simecon.data.models.LoginResponse
import com.tuapp.simecon.data.repository.AuthRepository
import com.tuapp.simecon.utils.Resource
import kotlinx.coroutines.launch

class LoginViewModel : ViewModel() {
    
    private val repository = AuthRepository()
    
    private val _loginResult = MutableLiveData<Resource<LoginResponse>>()
    val loginResult: LiveData<Resource<LoginResponse>> = _loginResult
    
    fun login(username: String, password: String) {
        viewModelScope.launch {
            _loginResult.value = Resource.Loading()
            val result = repository.login(username, password)
            _loginResult.value = result
        }
    }
}
```

---

### 7. Activity (UI)

#### `LoginActivity.kt`
```kotlin
package com.tuapp.simecon.ui.login

import android.content.Intent
import android.os.Bundle
import android.widget.Toast
import androidx.activity.viewModels
import androidx.appcompat.app.AppCompatActivity
import androidx.lifecycle.lifecycleScope
import com.tuapp.simecon.databinding.ActivityLoginBinding
import com.tuapp.simecon.ui.main.MainActivity
import com.tuapp.simecon.utils.Resource
import com.tuapp.simecon.utils.TokenManager
import kotlinx.coroutines.launch

class LoginActivity : AppCompatActivity() {
    
    private lateinit var binding: ActivityLoginBinding
    private val viewModel: LoginViewModel by viewModels()
    private lateinit var tokenManager: TokenManager
    
    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        binding = ActivityLoginBinding.inflate(layoutInflater)
        setContentView(binding.root)
        
        tokenManager = TokenManager(this)
        
        // Verificar si ya hay un token guardado
        checkExistingToken()
        
        setupObservers()
        setupListeners()
    }
    
    private fun checkExistingToken() {
        lifecycleScope.launch {
            tokenManager.getToken().collect { token ->
                if (!token.isNullOrEmpty()) {
                    // Ya hay sesión activa, ir al MainActivity
                    navigateToMain()
                }
            }
        }
    }
    
    private fun setupObservers() {
        viewModel.loginResult.observe(this) { result ->
            when (result) {
                is Resource.Loading -> {
                    // Mostrar loading
                    binding.btnLogin.isEnabled = false
                    binding.btnLogin.text = "Cargando..."
                }
                is Resource.Success -> {
                    // Login exitoso
                    lifecycleScope.launch {
                        val data = result.data!!
                        tokenManager.saveToken(data.token)
                        tokenManager.saveUserData(data.user.username, data.user.usertype)
                        
                        Toast.makeText(
                            this@LoginActivity,
                            "Bienvenido ${data.user.username}",
                            Toast.LENGTH_SHORT
                        ).show()
                        
                        navigateToMain()
                    }
                }
                is Resource.Error -> {
                    // Error en login
                    binding.btnLogin.isEnabled = true
                    binding.btnLogin.text = "Iniciar Sesión"
                    Toast.makeText(
                        this,
                        result.message ?: "Error desconocido",
                        Toast.LENGTH_LONG
                    ).show()
                }
            }
        }
    }
    
    private fun setupListeners() {
        binding.btnLogin.setOnClickListener {
            val username = binding.etUsername.text.toString().trim()
            val password = binding.etPassword.text.toString().trim()
            
            if (username.isEmpty() || password.isEmpty()) {
                Toast.makeText(this, "Complete todos los campos", Toast.LENGTH_SHORT).show()
                return@setOnClickListener
            }
            
            viewModel.login(username, password)
        }
    }
    
    private fun navigateToMain() {
        startActivity(Intent(this, MainActivity::class.java))
        finish()
    }
}
```

---

## 📄 Layout XML (Ejemplo)

#### `activity_login.xml`
```xml
<?xml version="1.0" encoding="utf-8"?>
<androidx.constraintlayout.widget.ConstraintLayout 
    xmlns:android="http://schemas.android.com/apk/res/android"
    xmlns:app="http://schemas.android.com/apk/res-auto"
    android:layout_width="match_parent"
    android:layout_height="match_parent"
    android:padding="24dp">
    
    <ImageView
        android:id="@+id/ivLogo"
        android:layout_width="120dp"
        android:layout_height="120dp"
        android:src="@drawable/ic_logo"
        app:layout_constraintTop_toTopOf="parent"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"
        android:layout_marginTop="60dp"/>
    
    <TextView
        android:id="@+id/tvTitle"
        android:layout_width="wrap_content"
        android:layout_height="wrap_content"
        android:text="SIMECON"
        android:textSize="28sp"
        android:textStyle="bold"
        android:layout_marginTop="16dp"
        app:layout_constraintTop_toBottomOf="@id/ivLogo"
        app:layout_constraintStart_toStartOf="parent"
        app:layout_constraintEnd_toEndOf="parent"/>
    
    <com.google.android.material.textfield.TextInputLayout
        android:id="@+id/tilUsername"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:hint="Usuario"
        android:layout_marginTop="48dp"
        app:layout_constraintTop_toBottomOf="@id/tvTitle">
        
        <com.google.android.material.textfield.TextInputEditText
            android:id="@+id/etUsername"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:inputType="text"/>
    </com.google.android.material.textfield.TextInputLayout>
    
    <com.google.android.material.textfield.TextInputLayout
        android:id="@+id/tilPassword"
        android:layout_width="match_parent"
        android:layout_height="wrap_content"
        android:hint="Contraseña"
        android:layout_marginTop="16dp"
        app:passwordToggleEnabled="true"
        app:layout_constraintTop_toBottomOf="@id/tilUsername">
        
        <com.google.android.material.textfield.TextInputEditText
            android:id="@+id/etPassword"
            android:layout_width="match_parent"
            android:layout_height="wrap_content"
            android:inputType="textPassword"/>
    </com.google.android.material.textfield.TextInputLayout>
    
    <Button
        android:id="@+id/btnLogin"
        android:layout_width="match_parent"
        android:layout_height="56dp"
        android:text="Iniciar Sesión"
        android:textSize="16sp"
        android:layout_marginTop="32dp"
        app:layout_constraintTop_toBottomOf="@id/tilPassword"/>
    
</androidx.constraintlayout.widget.ConstraintLayout>
```

---

## 🚀 Ejemplo de Uso Completo

### Obtener Lista de Reclutas

```kotlin
class ReclutasFragment : Fragment() {
    
    private lateinit var tokenManager: TokenManager
    private lateinit var repository: DatosRepository
    
    override fun onViewCreated(view: View, savedInstanceState: Bundle?) {
        super.onViewCreated(view, savedInstanceState)
        
        tokenManager = TokenManager(requireContext())
        
        lifecycleScope.launch {
            tokenManager.getToken().collect { token ->
                if (!token.isNullOrEmpty()) {
                    repository = DatosRepository(token)
                    cargarReclutas()
                }
            }
        }
    }
    
    private fun cargarReclutas() {
        lifecycleScope.launch {
            val result = repository.getReclutas()
            
            when (result) {
                is Resource.Success -> {
                    // Mostrar lista de reclutas
                    val reclutas = result.data ?: emptyList()
                    // Actualizar RecyclerView
                }
                is Resource.Error -> {
                    Toast.makeText(
                        requireContext(),
                        result.message,
                        Toast.LENGTH_LONG
                    ).show()
                }
                is Resource.Loading -> {
                    // Mostrar loading
                }
            }
        }
    }
}
```

---

## ⚠️ Notas Importantes

1. **Cambiar la IP del servidor** en `ApiClient.kt` por la IP de tu servidor Laravel
2. **Habilitar ViewBinding** en `build.gradle`:
   ```gradle
   android {
       buildFeatures {
           viewBinding true
       }
   }
   ```
3. **Los booleanos en la API son `true/false`**, no "si"/"no"
4. **Todos los endpoints requieren token**, excepto `/login` y `/register`

---

## ✅ Testing Rápido

Para probar rápidamente la conexión:

```kotlin
lifecycleScope.launch {
    val result = AuthRepository().login("admin", "password")
    when (result) {
        is Resource.Success -> {
            Log.d("TEST", "Token: ${result.data?.token}")
        }
        is Resource.Error -> {
            Log.e("TEST", "Error: ${result.message}")
        }
    }
}
```

---

**¡Tu integración Android está completa! 🎉**
