<x-layout>
    <h1>Edit Profile</h1>

    @if(session('status') === 'profile-updated')
        <p>Your profile has been successfully updated!</p>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Name Field -->
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <!-- Email Field -->
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Password Change Fields -->
        <h2>Change Password</h2>
        <div>
            <label for="current_password">Current Password</label>
            <input type="password" id="current_password" name="current_password" required>
        </div>
        <div>
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirm New Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <!-- Update Button -->
        <button type="submit">Update Profile</button>
    </form>
</x-layout>
