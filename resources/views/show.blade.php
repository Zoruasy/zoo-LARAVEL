<x-layout>
    <h1>Zoo Catalogus</h1>

    <ul>
        @section('content')
            <h1>{{ $animal->name }}</h1>
            <p>Soort: {{ $animal->species }}</p>
            <p>Habitat: {{ $animal->habitat }}</p>

    </ul>


</x-layout>
