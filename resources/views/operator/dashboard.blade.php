@extends('layouts.app')
@section('navbar')
@include('layouts.navbar')
@endsection
@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1>Welcome, {{ $operator->name }}!</h1>
    @if($announcements->isNotEmpty())
    <h3 class="mb-3">Pengumuman</h3>
    <div class="card mb-4">
        <div class="card-body">
            @foreach($announcements as $announcement)
                <div class="alert alert-primary">
                    <h5>{{ $announcement->title }}</h5>
                    <p>{{ $announcement->content }}</p>
                </div>
            @endforeach
        </div>
    </div>
@else
    @endif
    <p>Halaman ini adalah dashboard pemandu.</p>

    <h2>Data Mahasiswa Kelompok Kamu</h2>

    @if ($students->isEmpty())
        <p>Maaf belum ada mahasiswa yang masuk ke kelompok kamu</p>
    @else
        <p>Total Students: {{ $students->count() }}</p> <!-- Display total number of students -->

        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>NIM</th>
                    <th>Email</th>
                    <th>Kelompok</th>
                    <th>Fakultas</th>
                    <th>Prodi</th>
                    <th>File</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($students as $index => $student)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->nim }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->kelompok }}</td>
                        <td>{{ $student->fakultas }}</td>
                        <td>{{ $student->prodi }}</td>
                        <td>
                            @if ($student->file)
                                <a href="{{ asset('storage/' . $student->file) }}" class="btn btn-info btn-sm" target="_blank">
                                    <i class="fas fa-file-download"></i> Lihat File
                                </a>
                            @else
                                No file available
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
