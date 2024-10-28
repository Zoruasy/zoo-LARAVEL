<x-layout>
    <h1>Zoo Catalogus</h1>

    @foreach ($animals as $animal)
        <div>
            <h2>{{ $animal->name }}</h2>
            <a href="{{ route('zoo.show', $animal->id) }}">Bekijk dier</a> <!-- Link naar de detailpagina -->

            @auth
                @if (Auth::id() === $animal->user_id)
                    <a href="{{ route('zoo.edit', $animal->id) }}">Bewerken</a>
                    <form action="{{ route('zoo.destroy', $animal->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Weet je zeker dat je dit dier wilt verwijderen?');">Verwijderen</button>
                    </form>
                @endif
            @endauth
        </div>
    @endforeach

    @auth
        <h2>Voeg een nieuw dier toe</h2>
        <form action="{{ route('zoo.store') }}" method="POST">
            @csrf
            <div>
                <label for="name">Naam:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="species">Soort:</label>
                <input type="text" id="species" name="species" required>
            </div>
            <div>
                <label for="habitat">Habitat:</label>
                <textarea id="habitat" name="habitat" required></textarea>
            </div>
            <button type="submit">Voeg Dier Toe</button>
        </form>
    @endauth
</x-layout>
