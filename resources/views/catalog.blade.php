<x-layout>
        <h1>Zoo Catalogus</h1>

        <ul>
            @foreach($animals as $animal)
                <li>
                    <a href="{{ route('zoo.show', $animal->id) }}">{{ $animal->name }}</a>
                </li>
            @endforeach
        </ul>


</x-layout>
