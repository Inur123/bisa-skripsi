@extends('layouts.app')
@section('navbar')
@include('layouts.navbar')
@endsection
@section('sidebar')
@include('layouts.sidebar')
@endsection

@section('content')
<div class="container">
    <h1>Edit Your Data</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mahasiswa.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Use PUT method for updating -->

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="nim">NIM</label>
            <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $user->nim) }}" required>
        </div>

        <div class="form-group">
            <label for="fakultas">Fakultas</label>
            <select id="fakultas" name="fakultas" class="form-control" required>
                <option value="">-- Select Fakultas --</option>
                <option value="Teknik" {{ old('fakultas', $user->fakultas) == 'Teknik' ? 'selected' : '' }}>TEKNIK</option>
                <option value="fai" {{ old('fakultas', $user->fakultas) == 'fai' ? 'selected' : '' }}>FAI</option>
                <option value="Ekonomi" {{ old('fakultas', $user->fakultas) == 'Ekonomi' ? 'selected' : '' }}>EKONOMI</option>
                <option value="Hukum" {{ old('fakultas', $user->fakultas) == 'Hukum' ? 'selected' : '' }}>HUKUM</option>
                <option value="fik" {{ old('fakultas', $user->fakultas) == 'fik' ? 'selected' : '' }}>FIK</option>
                <option value="fisip" {{ old('fakultas', $user->fakultas) == 'fisip' ? 'selected' : '' }}>FISIP</option>
                <option value="fkip" {{ old('fakultas', $user->fakultas) == 'fkip' ? 'selected' : '' }}>FKIP</option>
            </select>
        </div>

        <div class="form-group">
            <label for="prodi">Prodi</label>
            <select id="prodi" name="prodi" class="form-control" required>
                <option value="">-- Select Prodi --</option>
                @php
                    $prodiMap = [
                        'Teknik' => ['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro'],
                        'fai' => ['Pgmi', 'Pendidikan Agama Islam', 'Psikologi Islam', 'Ipii', 'Ekonomi Syariah'],
                        'Ekonomi' => ['S1 Akuntansi', 'Manajemen', 'Ekonomi Pembangunan', 'D3 Akuntansi'],
                        'Hukum' => ['Ilmu Hukum'],
                        'fik' => ['Kebidanan', 'Fisioterapi', 'S1 Keperawatan', 'D3 Keperawatan'],
                        'fisip' => ['Ilmu Pemerintahan', 'Ilmu Komunikasi'],
                        'fkip' => ['Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Ppkn', 'Pgpaud'],
                    ];
                    $currentFakultas = old('fakultas', $user->fakultas);
                @endphp

                @if(isset($prodiMap[$currentFakultas]))
                    @foreach($prodiMap[$currentFakultas] as $prodi)
                        <option value="{{ $prodi }}" {{ old('prodi', $user->prodi) == $prodi ? 'selected' : '' }}>{{ $prodi }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group">
            <label for="file">Upload File</label>
            <input type="file" class="form-control-file" id="file" name="file">


            @if($user->file)
                @php
                    $extension = pathinfo($user->file, PATHINFO_EXTENSION);
                @endphp

                @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $user->file) }}" alt="Current file" class="img-thumbnail" style="max-width: 200px;">
                        <p>File name: {{ basename($user->file) }}</p>
                    </div>
                @elseif($extension === 'pdf')
                    <div class="mt-2">
                        <embed src="{{ asset('storage/' . $user->file) }}" type="application/pdf" width="200" height="200" class="border rounded">
                        <p>File name: {{ basename($user->file) }}</p>
                    </div>
                @else
                    <div class="mt-2">
                        <p>Current file type: {{ $extension }}</p>
                        <p class="text-muted">Preview not available for this file type.</p>
                        <p>File name: {{ basename($user->file) }}</p>
                    </div>
                @endif
            @endif
        </div>

        <hr>

        <h3>Change Password</h3>

        <div class="form-group">
            <label for="current_password">Current Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Enter current password (optional)">
                <div class="input-group-append">
                    <span class="input-group-text" id="toggleCurrentPassword">
                        <i class="fas fa-eye-slash" aria-hidden="true"></i> <!-- Default closed eye icon -->
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="new_password">New Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password (optional)">
                <div class="input-group-append">
                    <span class="input-group-text" id="toggleNewPassword">
                        <i class="fas fa-eye-slash" aria-hidden="true"></i> <!-- Default closed eye icon -->
                    </span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <div class="input-group">
                <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirm new password (optional)">
                <div class="input-group-append">
                    <span class="input-group-text" id="toggleConfirmPassword">
                        <i class="fas fa-eye-slash" aria-hidden="true"></i> <!-- Default closed eye icon -->
                    </span>
                </div>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Update Data</button>
        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    const fakultasProdiMap = {
        'Teknik': ['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro'],
        'fai': ['Pgmi', 'Pendidikan Agama Islam','Psikologi Islam','Ipii','Ekonomi Syariah'],
        'Ekonomi': ['S1 Akuntansi', 'Manajemen','Ekonomi Pembangunan','D3 Akuntansi'],
        'Hukum': ['Ilmu Hukum'],
        'fik': ['Kebidanan','Fisioterapi','S1 Keperawatan','D3 Keperawatan'],
        'fisip': ['Ilmu Pemerintahan','Ilmu Komunikasi'],
        'fkip': ['Pendidikan Bahasa Inggris', 'Pendidikan Matematika','Ppkn','Pgpaud']
    };

    document.getElementById('fakultas').addEventListener('change', function() {
        const selectedFakultas = this.value;
        const prodiSelect = document.getElementById('prodi');

        // Clear current options
        prodiSelect.innerHTML = '<option value="">-- Select Prodi --</option>';

        if (fakultasProdiMap[selectedFakultas]) {
            fakultasProdiMap[selectedFakultas].forEach(function(prodi) {
                const option = document.createElement('option');
                option.value = prodi;
                option.textContent = prodi;
                prodiSelect.appendChild(option);
            });
        }
    });
</script>
<script>
    document.querySelectorAll('.input-group-text').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const input = this.parentElement.previousElementSibling;
            const isPassword = input.type === 'password';

            // Toggle input type
            input.type = isPassword ? 'text' : 'password';
            // Toggle icon between eye and eye-slash
            this.querySelector('i').classList.toggle('fa-eye-slash', !isPassword);
            this.querySelector('i').classList.toggle('fa-eye', isPassword);
        });
    });
</script>

@endsection
