{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 text-center">User Management</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('admin.users') }}" class="btn btn-success">Add New User</a>
            </div>
            <table class="table table-bordered table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Role</th>
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
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->role }}</td>
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
                            <td>{{ $user->kelompok }}</td> <!-- Corrected the case of 'kelompok' -->
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

            <!-- Pagination -->
            {{-- <div class="d-flex justify-content-center">
                {{ $users->links() }} <!-- Add pagination links -->
            </div> --}}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Include Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endpush
