<h2>Edit User</h2>
<form method="POST" action="{{ route('user.update', $user->id) }}">
    @method('PUT')
    <input type="text" name="name" value="{{ old('name', $user->name) }}"><br>
    <input type="email" name="email" value="{{ old('email', $user->email) }}"><br>
    <input type="password" name="password" placeholder="Password Baru (opsional)"><br>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"><br>
    <button type="submit">Update</button>
</form>
