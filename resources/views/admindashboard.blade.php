<x-layout>
    <div class="container">
        @if(auth()->user() && auth()->user()->isAdmin())
            <h1>Admin Dashboard</h1>

            <div class="alert alert-info">
                Welcome to the admin dashboard. Here you can perform various management tasks.
            </div>

            <ul>
                <li><a href="{{ route('zoo.catalog') }}">View the Animal Catalog</a></li>
                <li><a href="#">Manage Users</a></li>
                <li><a href="#">Other Admin Tasks</a></li>
            </ul>
        @else
            <h1>Access Denied</h1>
            <div class="alert alert-danger">
                You do not have access to the admin dashboard.
            </div>
        @endif
    </div>
</x-layout>
