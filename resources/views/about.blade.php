<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel Blog - Home</title>
    <link rel="stylesheet" href="{{asset('homestyle.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="/" class="logo">Lara<span>Blog</span></a>
                <div class="nav-links">
                    <a href="{{route('home')}}" class="active">Home</a>
                    <a href="">Blog</a>
                    <a href="{{route('about')}}" class="active">Acerca De</a>
                    <a href="{{route('contact')}}" class="active">Contacto</a>
                    @if (Route::has('login'))
                    @auth
                        <a
                            href="{{route('dashboard')}}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                        >
                            Dashboard
                        </a>
                    @else
                    <a href="{{route('login')}}">Login</a>
                    @endauth

                    @endif
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Welcome to LaraBlog</h1>
            <p>Discover amazing articles, tutorials, and insights about web development, Laravel, and modern PHP practices.</p>
            <a href="/blog" class="btn btn-primary">Browse Articles</a>
        </div>
    </section>

    <!-- Featured Posts -->
    <div class="container">
        <h2 class="section-title">Acerca de</h2>
        <div class="featured-posts">
            <!-- Post 1 -->
            <div class="post-card">
                <div class="post-image">
                    <img src="https://via.placeholder.com/600x400?text=Laravel+Tips" alt="Laravel Tips">
                </div>
                <div class="post-content">
                    <div class="post-meta">
                        <span>May 15, 2023</span>
                        <span>5 min read</span>
                    </div>
                    <h3 class="post-title">Visitanos en </h3>
                    <p class="post-excerpt">Learn how to write cleaner, more efficient Laravel code with these practical tips...</p>
                    <a href="/post/10-laravel-tips" class="read-more">Read More →</a>
                </div>
            </div>

            <!-- Post 2 -->
            <div class="post-card">
                <div class="post-image">
                    <img src="https://via.placeholder.com/600x400?text=Eloquent" alt="Eloquent ORM">
                </div>
                <div class="post-content">
                    <div class="post-meta">
                        <span>April 28, 2023</span>
                        <span>8 min read</span>
                    </div>
                    <h3 class="post-title">Nos ubicamos</h3>
                    <p class="post-excerpt">A deep dive into Laravel's Eloquent ORM and how to effectively use relationships...</p>
                    <a href="/post/mastering-eloquent" class="read-more">Read More →</a>
                </div>
            </div>

            <!-- Post 3 -->
            <div class="post-card">
                <div class="post-image">
                    <img src="https://via.placeholder.com/600x400?text=Livewire" alt="Laravel Livewire">
                </div>
                <div class="post-content">
                    <div class="post-meta">
                        <span>April 10, 2023</span>
                        <span>6 min read</span>
                    </div>
                    <h3 class="post-title">Saludos desde el aula 16</h3>
                    <p class="post-excerpt">Create dynamic interfaces without writing JavaScript using Laravel Livewire...</p>
                    <a href="/post/livewire-guide" class="read-more">Read More →</a>
                </div>
            </div>
        </div>

    </footer>
</body>
</html>