<h2>Tambah User</h2>
<form method="POST" action="{{ route('user.store') }}">
    <input type="text" name="name" placeholder="Nama" value="{{ old('name') }}"><br>
    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password"><br>
    <button type="submit">Simpan</button>
</form>
