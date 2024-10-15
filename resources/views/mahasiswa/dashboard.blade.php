@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Welcome, {{ $user->name }}!</h1>
    <p class="lead mb-4">This is your dashboard.</p>

    <h2 class="mb-3">Pemandu</h2>
    <div class="card mb-4">
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item">
                    <strong>Nama:</strong>
                    @if ($operator)
                        {{ $operator->name }} <!-- Display operator's name -->
                    @else
                        No operator assigned to your group.
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <h2 class="mb-3">Your Details</h2>
    <div class="card">
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                <li class="list-group-item"><strong>NIM:</strong> {{ $user->nim }}</li>
                <li class="list-group-item"><strong>Fakultas:</strong> {{ $user->fakultas }}</li>
                <li class="list-group-item"><strong>Prodi:</strong> {{ $user->prodi }}</li>
                <li class="list-group-item"><strong>Kelompok:</strong> {{ $user->kelompok }}</li>

                <!-- Display file upload preview -->
                <li class="list-group-item">
                    <strong>Uploaded File:</strong>
                    @if($user->file)
                        @php
                            $extension = pathinfo($user->file, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $user->file) }}" alt="Current file" class="img-thumbnail" style="max-width: 100px; max-height: 100px;">
                                <p>File name: {{ basename($user->file) }}</p>
                            </div>
                        @elseif($extension === 'pdf')
                            <div class="mb-2">
                                <embed src="{{ asset('storage/' . $user->file) }}" type="application/pdf" width="200" height="200" class="border rounded">
                                <p>File name: {{ basename($user->file) }}</p>
                            </div>
                        @else
                            <p>Current file type: {{ $extension }}</p>
                            <p class="text-muted">Preview not available for this file type.</p>
                            <p>File name: {{ basename($user->file) }}</p>
                        @endif
                    @else
                        <p>No file uploaded.</p>
                    @endif
                </li>
            </ul>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('mahasiswa.edit', $user->id) }}" class="btn btn-primary">Edit Data</a>
    </div>
</div>
@endsection
