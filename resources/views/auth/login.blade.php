<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sign In</title>
    <link rel="stylesheet" href="{{ asset('loginstyle.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-left">
                <img src="{{ asset('images/LOGO.PNG') }}" alt="Logo" class="logo-img">
            </div>

            <div class="auth-right">
                <h1 class="auth-title">Iniciar sesión</h1>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-row field">
                        <div class="field-label">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Usuario:</span>
                        </div>

                        <div class="input-wrapper">
                            <x-text-input id="username" class="underlined-input" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" placeholder="Introduce tu usuario" />
                            <x-input-error :messages="$errors->get('username')" class="input-error" />
                        </div>
                    </div>

                    <div class="form-row field">
                        <div class="field-label">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            <span>Contraseña:</span>
                        </div>

                        <div class="input-wrapper">
                            <x-text-input id="password" class="underlined-input" type="password" name="password" required autocomplete="current-password" placeholder="Introduce tu contraseña" />
                            <button type="button" class="password-toggle" onclick="togglePassword()" aria-label="Mostrar contraseña">
                                <i class="fa fa-eye"></i>
                            </button>
                            <x-input-error :messages="$errors->get('password')" class="input-error" />
                        </div>
                    </div>

                    <div style="margin-top: 20px; display: flex; justify-content: center;">
                        <button type="submit" class="primary-btn">
                            {{ __('Iniciar sesión') }}
                        </button>
                    </div>
                </form>

<script>
function togglePassword(){
    const p = document.getElementById('password');
    if(!p) return;
    const btn = event.currentTarget || null;
    if(p.type === 'password'){ p.type = 'text'; if(btn) btn.querySelector('i').className='fa fa-eye-slash'; }
    else { p.type = 'password'; if(btn) btn.querySelector('i').className='fa fa-eye'; }
}
</script>
            </div>
        </div>
    </div>
</body>
</html>
