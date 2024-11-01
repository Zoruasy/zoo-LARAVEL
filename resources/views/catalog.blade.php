<x-layout>
    <h1>Zoo Catalogus</h1>

    <!-- Filterformulier -->
    <form action="{{ route('zoo.catalog') }}" method="GET">
        <!-- Zoekbalk -->
        <div>
            <label for="search">Search:</label>
            <input type="text" id="search" name="search" value="{{ request('search') }}">
        </div>

        <!-- Filter op soort -->
        <div>
            <label for="species">Species:</label>
            <select id="species" name="species">
                <option value="">-- Choose species --</option>
                @foreach ($speciesOptions as $species)
                    <option value="{{ $species->species }}" {{ request('species') == $species->species ? 'selected' : '' }}>
                        {{ $species->species }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter op habitat -->
        <div>
            <label for="habitat">Habitat:</label>
            <select id="habitat" name="habitat">
                <option value="">-- Choose habitat --</option>
                @foreach ($habitatOptions as $habitat)
                    <option value="{{ $habitat->habitat }}" {{ request('habitat') == $habitat->habitat ? 'selected' : '' }}>
                        {{ $habitat->habitat }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filterknop -->
        <button type="submit">Filter</button>
    </form>

    <!-- Lijst van dieren -->
    @foreach ($animals as $animal)
        <div>
            <h2>{{ $animal->name }}</h2>
            <!-- Afbeelding van het dier -->
            <img src="{{ asset('images/' . $animal->image) }}" alt="{{ $animal->name }}" style="width: 200px; height: auto;">

            <a href="{{ route('zoo.show', $animal->id) }}">See this animal!</a> <!-- Link naar de detailpagina -->

            @auth
                @if (Auth::id() === $animal->user_id)
                    <a href="{{ route('zoo.edit', $animal->id) }}">Edit</a>

                    <!-- Toggle Button for Active/Inactive Status -->
                    <form action="{{ route('animals.toggleStatus', $animal->id) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">
                            {{ $animal->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>

                    <form action="{{ route('zoo.destroy', $animal->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to delete this animal?');">Verwijderen</button>
                    </form>
                @endif
            @endauth
        </div>
    @endforeach

    @auth
        <h2>Add new animal</h2>
        <form action="{{ route('zoo.store') }}" method="POST">
            @csrf
            <div>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div>
                <label for="species">Species:</label>
                <input type="text" id="species" name="species" required>
            </div>
            <div>
                <label for="habitat">Habitat:</label>
                <textarea id="habitat" name="habitat" required></textarea>
            </div>
            <button type="submit">Add new animal</button>
        </form>
    @endauth
</x-layout>
