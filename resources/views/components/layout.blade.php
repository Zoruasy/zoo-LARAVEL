<!-- resources/views/components/layout.blade.php -->
<div class="container">


    <!-- Toon iets voor ingelogde gebruikers -->
    @auth
        <p>Hallo, {{ Auth::user()->name }}! Bedankt voor het inloggen.</p>
        <p>Hier is exclusieve content alleen voor ingelogde gebruikers.</p>
    @endauth

    <!-- Toon iets voor niet-ingelogde gebruikers -->
    @guest

        <a href="{{ route('login') }}">Inloggen</a>
        <a href="{{ route('register') }}">Registreren</a>
        <a href="/">Home</a>
        <a href="/catalog">Catalogus</a>
    @endguest

    {{ $slot }}  <!-- Dit toont de inhoud die in de component is ingevoegd -->
</div>
