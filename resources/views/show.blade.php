<x-layout>
    <h1>{{ $animal->name }}</h1>
    <p>Species: {{ $animal->species }}</p>
    <p>Habitat: {{ $animal->habitat }}</p>

    @auth
        @if (Auth::id() === $animal->user_id)
            <a href="{{ route('zoo.edit', $animal->id) }}"> Edit</a>
            <form action="{{ route('zoo.destroy', $animal->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('Are you sure you want to delete this animal??');">Verwijderen</button>
            </form>
        @endif
    @endauth


    <a href="{{ route('zoo.catalog') }}">Terug naar catalogus</a>
</x-layout>
