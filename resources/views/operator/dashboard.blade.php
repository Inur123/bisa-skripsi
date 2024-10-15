@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, Operator!</h1>
    <p>This is the operator dashboard.</p>

    <h2>Students in Your Group</h2>

    @if ($students->isEmpty())
        <p>No students found in your group.</p>
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
                                    <i class="fas fa-file-download"></i> Download
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
