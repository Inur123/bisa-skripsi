@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Operator</h1>

    <form action="{{ route('admin.store_operator') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="kelompok">Kelompok</label>
            <input type="text" class="form-control" id="kelompok" name="kelompok">
        </div>

        <div class="form-group">
            <label for="fakultas">Fakultas</label>
            <input type="text" class="form-control" id="fakultas" name="fakultas">
        </div>

        <div class="form-group">
            <label for="prodi">Prodi</label>
            <input type="text" class="form-control" id="prodi" name="prodi">
        </div>

        <div class="form-group">
            <label for="file">Upload File</label>
            <input type="file" class="form-control-file" id="file" name="file">
        </div>

        <p class="text-muted">Password is set to <strong>'password'</strong> by default.</p>

        <button type="submit" class="btn btn-primary">Create Operator</button>
    </form>
</div>
@endsection
