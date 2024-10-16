<x-layout>
        <h1>Zoo Catalogus</h1>

        <ul>
            @foreach($animals as $animal)
                <li>
                    <strong>Naam:</strong> {{ $animal->name }}<br>
                    <strong>Soort:</strong> {{ $animal->species }}<br>
                    <strong>Habitat:</strong> {{ $animal->habitat }}<br>
                </li>
            @endforeach
        </ul>


</x-layout>
