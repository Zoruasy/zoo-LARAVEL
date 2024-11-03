<x-layout>
    <div class="container">
        @if(auth()->user() && auth()->user()->role === 'gebruiker')
            <h1>Admin Dashboard</h1>
            <div class="alert alert-info">
                Welcome to the admin dashboard. Here you can perform various management tasks.
            </div>
            <ul>
                <li><a href="{{ route('zoo.catalog') }}">View the Animal Catalog</a></li>
                <li><a href="#manage-users">Manage Users</a></li>
            </ul>
            <div id="manage-users">
                <h2>Manage Users</h2>
                @if(isset($users) && $users->isNotEmpty())
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Admin</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role === 'gebruiker' ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning">
                        No users found.
                    </div>
                @endif
            </div>
        @else
            <h1>Access Denied</h1>
            <div class="alert alert-danger">
                You do not have access to the admin dashboard.
            </div>
        @endif
    </div>
</x-layout>
