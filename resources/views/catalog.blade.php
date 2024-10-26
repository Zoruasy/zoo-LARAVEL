<x-layout>
    <h1>Zoo Catalogus</h1>

    @foreach ($animals as $animal)
        <div>
            <h2>
                <a href="{{ route('animals.show', $animal->id) }}">{{ $animal->name }}</a> <!-- Link naar de detailpagina -->
            </h2>
            <p>{{ $animal->description }}</p>


            @auth
            <a href="{{ route('animals.edit', $animal->id) }}">Bewerken</a> <!-- Link naar bewerken -->
            @endauth
        </div>
    @endforeach
</x-layout>
