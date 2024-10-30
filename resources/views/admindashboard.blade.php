
<x-layout>

@section('content')
    <div class="container">
        <h1>Admin Dashboard</h1>

        <div class="alert alert-info">
            Welkom bij het admin dashboard. Hier kun je de verschillende beheertaken uitvoeren.
        </div>


        <ul>
            <li><a href="{{ route('zoo.catalog') }}">Bekijk de dieren catalogus</a></li>
            <li><a href="#">Beheer gebruikers</a></li>
            <li><a href="#">Andere admin-taken</a></li>
        </ul>
    </div>
@endsection
</x-layout>
