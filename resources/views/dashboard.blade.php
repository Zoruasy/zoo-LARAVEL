<x-layout>
    <div class="container">
        <h1>Welkom, {{ Auth::user()->name }}!</h1>

        <div>
            <h2>Profielinformatie</h2>
            <p>Email: {{ Auth::user()->email }}</p>
            <a href="{{ route('profile.edit') }}">Bewerk Profiel</a>
        </div>


    </div>
</x-layout>
