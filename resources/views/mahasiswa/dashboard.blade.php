@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ $user->name }}!</h1>
    <p>This is your dashboard.</p>

    <h2>Your Details</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Name:</strong> {{ $user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>Fakultas:</strong> {{ $user->fakultas }}</li>
        <li class="list-group-item"><strong>Kelompok:</strong> {{ $user->kelompok }}</li>
    </ul>
</div>
@endsection
