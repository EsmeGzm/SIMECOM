<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMECOM</title>
    <link rel="icon" href="{{ asset('images/logo-tepos.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('homestyle.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="hero">
    <div class="container hero-inner">
        <div class="left">
            <h1>Bienvenido</h1>
            <p>Nos alegra verte otra vez<br>¡Tu espacio te estaba esperando!</p>
        </div>
        <div class="right">
            <img src="{{ asset('images/LOGO.PNG') }}" alt="Logo" class="logo-img">
        </div>
    </div>

    <!-- GIF de carga en esquina inferior derecha, tamaño reducido -->
    <div id="loading" style="position:fixed;right:20px;bottom:20px;z-index:1000;display:flex;align-items:center;justify-content:center;">
        <img src="{{ asset('images/loading.gif') }}" alt="Cargando..." style="width:56px;height:56px;display:block;">
    </div>

    <script>
        (function(){
            const delaySeconds = 5; // tiempo antes de redirigir
            setTimeout(()=> {
                window.location.href = "{{ route('login') }}";
            }, delaySeconds * 1000);
        })();
    </script>
</body>
</html>