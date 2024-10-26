<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>


</body>
</html>
<!-- Toon iets voor niet-ingelogde gebruikers -->
@guest
    <a href="{{ route('login') }}">Inloggen</a>
    <a href="{{ route('register') }}">Registreren</a>
    <a href="/">Home</a>
    <a href="/catalog">Catalogus</a>
@endguest
{{ $slot }}  <!-- Dit toont de inhoud die in de component is ingevoegd -->
</div>
