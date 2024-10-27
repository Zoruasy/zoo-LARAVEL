<x-layout>
    <h1>Zoo Catalogus</h1>

    @foreach ($animals as $animal)
        <div>

                <h2>{{ $animal->name }}</h2>
                <p>{{ $animal->description }}</p>
                <a href="{{ route('zoo.show', $animal->id) }}">Bekijk dier</a>


            @auth
                <!-- Controleer of de ingelogde gebruiker de eigenaar is, anders krijg je de link niet te zien -->
                @if (Auth::id() === $animal->user_id)
                    <a href="{{ route('animals.edit', $animal->id) }}">Bewerken</a>
                @endif
            @endauth

        </div>
    @endforeach
</x-layout>
