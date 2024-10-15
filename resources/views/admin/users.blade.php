
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">User Management</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.mahasiswa.clear') }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete all mahasiswa users?');">Clear Mahasiswa Data</button>
    </form>
    <div class="mt-4">
        <a href="{{ route('admin.create_operator') }}" class="btn btn-success">Create New Operator</a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('admin.assign.groups') }}" class="btn btn-primary mb-3">
                    Assign Users to Groups
                </a>
                <a href="{{ route('admin.clearGroups') }}" class="btn btn-danger"
                   onclick="return confirm('Are you sure you want to clear all group data?');">
                   Clear Group Data
                </a>
                <a href="{{ route('admin.users') }}" class="btn btn-success">Add New User</a>
            </div>

            <!-- Mahasiswa Users Table -->
            <h3>Mahasiswa Users</h3>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>NIM</th>
                        <th>Fakultas</th>
                        <th>Prodi</th>
                        <th>File</th>
                        <th>Kelompok</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $user)
                        <tr>
                            <td>{{ ($mahasiswa->currentPage() - 1) * $mahasiswa->perPage() + $loop->iteration }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nim }}</td>
                            <td>{{ $user->fakultas }}</td>
                            <td>{{ $user->prodi }}</td>
                            <td>
                                @if ($user->file)
                                    <a href="{{ asset('storage/' . $user->file) }}" target="_blank">View File</a>
                                @else
                                    No File
                                @endif
                            </td>
                            <td>{{ $user->kelompok }}</td>
                            <td>
                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Edit User">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete User">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $mahasiswa->links('pagination::bootstrap-4') }}
            </div>

            <!-- Admin Users Table -->
            <h3>Admin Users</h3>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>NIM</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($admin as $user)
                        <tr>
                            <td>{{ ($admin->currentPage() - 1) * $admin->perPage() + $loop->iteration }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nim }}</td>
                            <td>
                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Edit User">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete User">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $admin->links('pagination::bootstrap-4') }}
            </div>

            <!-- Operator Users Table -->
            <h3>Operator Users</h3>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>NIM</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($operator as $user)
                        <tr>
                            <td>{{ ($operator->currentPage() - 1) * $operator->perPage() + $loop->iteration }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->nim }}</td>
                            <td>
                                <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-primary btn-sm" title="Edit User">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form action="{{ route('admin.destroy', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');" title="Delete User">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $operator->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush
