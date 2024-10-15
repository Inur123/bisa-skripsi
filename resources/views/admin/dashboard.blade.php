@include('layouts.navbar')
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total Users</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalUsers }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Mahasiswa</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalMahasiswa }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Admin</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalAdmin }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header">Operator</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $totalOperator }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div>
        <h2>Group Information</h2>
        @foreach ($groupData as $fakultas => $groups)
            <h3>Fakultas: {{ $fakultas }}</h3>
            <p>Total Mahasiswa: {{ $totalMembersPerFakultas[$fakultas]->total ?? 0 }}</p>
            <p>Total Kelompok: {{ $totalGroupsPerFakultas[$fakultas] ?? 0 }}</p>

            @foreach ($groups as $groupIndex => $memberCount)
                <p>Group {{ $groupIndex }}: {{ $memberCount }} Members</p>
            @endforeach
        @endforeach
    </div>
</div>
@endsection
