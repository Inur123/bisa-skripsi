@extends('layouts.app')
@section('navbar')
    @include('layouts.navbar')
@endsection
@section('sidebar')
    @include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1>Admin Dashboard</h1>
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Mahasiswa</h5>
                    <p class="card-text">{{ $totalMahasiswa }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Admin</h5>
                    <p class="card-text">{{ $totalAdmin }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Operator</h5>
                    <p class="card-text">{{ $totalOperator }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">User Registration Graph</h5>
                    <canvas id="registrationChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @foreach ($groupData as $fakultas => $groups)
            <div class="col-lg-4 mt-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Fakultas {{ $fakultas }}</h5>
                        <p>Total Anggota = {{ $totalMembersPerFakultas[$fakultas]->total ?? 0 }}</p>
                        <p>Total Kelompok = {{ $totalGroupsPerFakultas[$fakultas] ?? 0 }}</p>
                        <hr style="border: none; height: 2px; background-color: #2142cc;">
                        @foreach ($groups as $groupIndex => $memberCount)
                            <p>Kelompok {{ $groupIndex }}= {{ $memberCount }} Anggota</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('registrationChart').getContext('2d');

    // Prepare data for the chart
    const labels = @json($registrations->pluck('date')); // Dates of registrations
    const data = @json($registrations->pluck('count')); // Counts of registrations

    const registrationChart = new Chart(ctx, {
        type: 'line', // You can change this to 'bar', 'pie', etc.
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Registrations',
                data: data,
                borderColor: '#2142cc',
                backgroundColor: '#95A5E8FF',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Number of Registrations'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                }
            }
        }
    });
</script>


@endsection
