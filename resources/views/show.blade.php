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
                <button type="submit" onclick="return confirm('Are you sure? You need to create 3 to delete one.');">Delete</button>
            </form>
        @endif
    @endauth

    {{-- Display error message if it exists --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('zoo.catalog') }}">Back to catalog</a>
</x-layout>
