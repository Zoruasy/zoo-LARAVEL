<x-app-layout>
    <h1>Bewerken Dier: {{ $animal->name }}</h1>

    <form action="{{ route('zoo.update', $animal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Naam:</label>
            <input type="text" id="name" name="name" value="{{ old('name', $animal->name) }}" required>
        </div>

        <div>
            <label for="species">Soort:</label>
            <input type="text" id="species" name="species" value="{{ old('species', $animal->species) }}" required>
        </div>

        <div>
            <label for="habitat">Habitat:</label>
            <textarea id="habitat" name="habitat" required>{{ old('habitat', $animal->habitat) }}</textarea>
        </div>

        <button type="submit">Bijwerken</button>
    </form>

    <a href="{{ route('zoo.catalog') }}">Terug naar catalogus</a>
</x-app-layout>
