@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Name Input -->
                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}"
                                    required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Email Input -->
                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}"
                                    required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- NIM Input -->
                        <div class="row mb-3">
                            <label for="nim" class="col-md-4 col-form-label text-md-end">{{ __('NIM') }}</label>
                            <div class="col-md-6">
                                <input id="nim" type="text"
                                    class="form-control @error('nim') is-invalid @enderror"
                                    name="nim" value="{{ old('nim') }}"
                                    required autocomplete="nim">
                                @error('nim')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Fakultas Dropdown -->
                        <div class="row mb-3">
                            <label for="fakultas" class="col-md-4 col-form-label text-md-end">{{ __('Fakultas') }}</label>
                            <div class="col-md-6">
                                <select id="fakultas" name="fakultas"
                                    class="form-control @error('fakultas') is-invalid @enderror" required>
                                    <option value="">-- Select Fakultas --</option>
                                    <option value="Teknik" {{ old('fakultas') == 'Teknik' ? 'selected' : '' }}>TEKNIK</option>
                                    <option value="fai" {{ old('fakultas') == 'fai' ? 'selected' : '' }}>FAI</option>
                                    <option value="Ekonomi" {{ old('fakultas') == 'Ekonomi' ? 'selected' : '' }}>EKONOMI</option>
                                    <option value="Hukum" {{ old('fakultas') == 'Hukum' ? 'selected' : '' }}>HUKUM</option>
                                    <option value="fik" {{ old('fakultas') == 'fik' ? 'selected' : '' }}>FIK</option>
                                    <option value="fisip" {{ old('fakultas') == 'fisip' ? 'selected' : '' }}>FISIP</option>
                                    <option value="fkip" {{ old('fakultas') == 'fkip' ? 'selected' : '' }}>FKIP</option>
                                </select>
                                @error('fakultas')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Prodi Dropdown -->
                        <div class="row mb-3">
                            <label for="prodi" class="col-md-4 col-form-label text-md-end">{{ __('Prodi') }}</label>
                            <div class="col-md-6">
                                <select id="prodi" name="prodi"
                                    class="form-control @error('prodi') is-invalid @enderror" required>
                                    <option value="">-- Select Prodi --</option>
                                </select>
                                @error('prodi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div class="row mb-3">
                            <label for="file" class="col-md-4 col-form-label text-md-end">{{ __('Upload File') }}</label>
                            <div class="col-md-6">
                                <input id="file" type="file"
                                    class="form-control @error('file') is-invalid @enderror"
                                    name="file" required>
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password"
                                    class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fakultasProdiMap = {
            'Teknik': ['Teknik Informatika', 'Teknik Mesin', 'Teknik Elektro'],
            'fai': ['Pgmi', 'Pendidikan Agama Islam', 'Psikologi Islam', 'Ipii', 'Ekonomi Syariah'],
            'Ekonomi': ['S1 Akuntansi', 'Manajemen', 'Ekonomi Pembangunan', 'D3 Akuntansi'],
            'Hukum': ['Ilmu Hukum'],
            'fik': ['Kebidanan', 'Fisioterapi', 'S1 Keperawatan', 'D3 Keperawatan'],
            'fisip': ['Ilmu Pemerintahan', 'Ilmu Komunikasi'],
            'fkip': ['Pendidikan Bahasa Inggris', 'Pendidikan Matematika', 'Ppkn', 'Pgpaud']
        };

        const fakultasSelect = document.getElementById('fakultas');
        const prodiSelect = document.getElementById('prodi');
        const oldFakultas = "{{ old('fakultas') }}";
        const oldProdi = "{{ old('prodi') }}";

        // Populate Prodi based on old Fakultas value
        if (oldFakultas && fakultasProdiMap[oldFakultas]) {
            fakultasProdiMap[oldFakultas].forEach(function (prodi) {
                const option = document.createElement('option');
                option.value = prodi;
                option.textContent = prodi;
                if (prodi === oldProdi) {
                    option.selected = true;
                }
                prodiSelect.appendChild(option);
            });
        }

        fakultasSelect.addEventListener('change', function () {
            const selectedFakultas = this.value;

            // Clear current options
            prodiSelect.innerHTML = '<option value="">-- Select Prodi --</option>';

            if (fakultasProdiMap[selectedFakultas]) {
                fakultasProdiMap[selectedFakultas].forEach(function (prodi) {
                    const option = document.createElement('option');
                    option.value = prodi;
                    option.textContent = prodi;
                    prodiSelect.appendChild(option);
                });
            }
        });
    });
</script>
@endsection
