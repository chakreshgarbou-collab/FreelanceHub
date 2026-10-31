<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Pages are hidden from search engines unless a page says otherwise -->
    <meta name="robots" content="@yield('robots', 'noindex, nofollow')">
    <title>@yield('title', 'FreelanceHub')</title>
    <link rel="stylesheet" href="{{ asset('css/freelancehub.css') }}">
</head>
<body>

<nav class="navbar">
    <a href="/" class="logo">FREELANCE<span>HUB</span></a>
    <div class="nav-links">
        <a href="#">Dashboard</a>
        <a href="#">Browse Services</a>
    </div>
    <div class="nav-right">
        @auth
            <a href="#">Sign out</a>
            <a href="/freelancer/profile/edit" class="avatar" title="My profile">
                {{ collect(explode(' ', auth()->user()->name))->map(fn ($w) => strtoupper(substr($w, 0, 1)))->take(2)->implode('') }}
            </a>
        @else
            <a href="#" class="btn btn-outline">Sign in</a>
        @endauth
    </div>
</nav>

@yield('content')

</body>
</html>