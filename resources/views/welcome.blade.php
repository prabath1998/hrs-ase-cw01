<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hotel Reservation System</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- Include any other CSS files you create later -->
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Rooms</a></li>
                <li><a href="#">Contact</a></li>
                @if (Route::has('login'))
                    @auth
                        <li><a href="{{ url('/home') }}">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}">Login</a></li>
                        @if (Route::has('register'))
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @endif
                    @endauth
                @endif
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h1>Welcome to Our Hotel</h1>
            <p>Book your stay with us and experience luxury.</p>
            <a href="#" class="btn-primary">Book Now</a>
        </section>

        <section class="features">
            <h2>Hotel Features</h2>
            <!-- Add feature descriptions here -->
        </section>

        <section class="room-types">
            <h2>Room Types</h2>
            <!-- Add room type showcases here -->
        </section>

        <section class="testimonials">
            <h2>What Our Guests Say</h2>
            <!-- Add testimonials here -->
        </section>
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Hotel Reservation System. All rights reserved.</p>
        <!-- Add contact info and social media links here -->
    </footer>
</body>
</html>
