@extends('layouts.app')

@section('navbar')
    @include('layouts.navbar')
@endsection

@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1>Pengumuman List</h1>


<!-- Modal Create Announcement -->
<div id="createAnnouncementModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center hidden">
    <div class="bg-white p-6 rounded-lg w-1/3">
        <h2 class="text-2xl font-semibold mb-4">Create Announcement</h2>
        <form action="{{ route('admin.store_announcement') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control w-full px-3 py-2 border rounded-md" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" rows="4" class="form-control w-full px-3 py-2 border rounded-md" required></textarea>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Target Role</label>
                <select name="role" id="role" class="form-select w-full px-3 py-2 border rounded-md" required>
                    <option value="operator">Operator</option>
                    <option value="mahasiswa">Mahasiswa</option>
                </select>
            </div>
            <div class="flex justify-between">
                <button type="submit" class="btn btn-primary text-white py-2 px-4 rounded-md bg-green-500 hover:bg-green-700 focus:outline-none focus:ring focus:ring-green-300">
                    Create Announcement
                </button>

            </div>
        </form>
    </div>
</div>


    <!-- Announcements Table -->
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Role</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($announcements as $announcement)
                <tr>
                    <td>{{ $announcement->title }}</td>
                    <td>{{ $announcement->content }}</td>
                    <td>{{ ucfirst($announcement->role) }}</td>
                    <td>
                        @if($announcement->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <!-- Toggle Active/Inactive -->
                        <form action="{{ route('admin.toggle_announcement_status', $announcement->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-secondary">
                                @if($announcement->is_active)
                                    Turn Off
                                @else
                                    Turn On
                                @endif
                            </button>
                        </form>

                        <!-- Delete Button -->
                        <form action="{{ route('admin.destroy_announcement', $announcement->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
