\<x-layout>
    <h1>{{ $animal->name }}</h1>
    <p>Soort: {{ $animal->species }}</p>
    <p>Habitat: {{ $animal->habitat }}</p>

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

    <form action="{{ route('animals.toggleFavorite', $animal->id) }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">
            {{ Auth::user()->favorites()->where('animal_id', $animal->id)->exists() ? 'Unfavorite' : 'Favorite' }}
        </button>
    </form>



    <a href="{{ route('zoo.catalog') }}">Terug naar catalogus</a>
</x-layout>
