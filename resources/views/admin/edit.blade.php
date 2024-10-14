@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-center">Edit User</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="operator" {{ $user->role === 'operator' ? 'selected' : '' }}>Operator</option>
                        <option value="mahasiswa" {{ $user->role === 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $user->nim) }}">
                </div>

                <div class="form-group">
                    <label for="fakultas">Fakultas</label>
                    <input type="text" class="form-control" id="fakultas" name="fakultas" value="{{ old('fakultas', $user->fakultas) }}">
                </div>

                <div class="form-group">
                    <label for="prodi">Prodi</label>
                    <input type="text" class="form-control" id="prodi" name="prodi" value="{{ old('prodi', $user->prodi) }}">
                </div>

                <div class="form-group">
                    <label for="file">File</label>
                    <input type="file" class="form-control" id="file" name="file">
                    @if ($user->file)
                        <p class="mt-2">Current File: <a href="{{ asset('storage/' . $user->file) }}" target="_blank">View File</a></p>
                    @endif
                </div>

                <div class="form-group">
                    <label for="kelompok">Kelompok</label>
                    <input type="text" class="form-control" id="kelompok" name="kelompok" value="{{ old('kelompok', $user->kelompok) }}">
                </div>

                <button type="submit" class="btn btn-primary">Update User</button>
                <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
