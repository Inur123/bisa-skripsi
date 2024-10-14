@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $user->name }}!</h1> <!-- Display the user's name -->
    <p>Email: {{ $user->email }}</p> <!-- Display the user's email -->
    <p>Role: {{ $user->role }}</p> <!-- Display the user's role -->
    <p>NIM: {{ $user->nim }}</p> <!-- Display the user's NIM, assuming it's a column in your users table -->
    <p>Fakultas: {{ $user->fakultas }}</p> <!-- Display user's faculty -->
    <p>Prodi: {{ $user->prodi }}</p> <!-- Display user's study program -->
    <p>Kelompok: {{ $user->kelompok ?? 'Not Assigned' }}</p> <!-- Display user's group, or indicate if not assigned -->

    <p>This is the mahasiswa dashboard.</p>
</div>
@endsection
