{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <title>Portal - Bootstrap 5 Admin Dashboard Template</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- FontAwesome JS -->
    <script defer src="{{ asset('template/assets/plugins/fontawesome/js/all.min.js') }}"></script>
    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('template/assets/css/portal.css') }}">
</head>

<body class="app app-signup p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4">
                        <a class="app-logo" href="#">
                            <img class="logo-icon me-2" src="{{ asset('template/assets/images/logo-masta24.png') }}" alt="logo">
                        </a>
                    </div>
                    <h2 class="auth-heading text-center mb-4">Daftar</h2>
                    <div class="auth-form-container text-start mx-auto">
                        <form id="registerForm" class="auth-form text-black" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Alert Container for Errors -->
                            <div id="error-alert" class="alert alert-danger" style="display: none;"></div>

                            <!-- Step 1 -->
                            <div id="step-1">
                                <div class="mb-2">
                                    <label for="name">Nama Lengkap</label>
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Nama Lengkap" required>
                                </div>
                                <div class="mb-2">
                                    <label for="email">Email</label>
                                    <input id="email" name="email" type="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="mb-2">
                                    <label for="nohp">No Hp</label>
                                    <input id="nohp" name="nohp" type="number" class="form-control" placeholder="No Hp" required>
                                </div>
                                <div class="mb-2">
                                    <label for="alamat">Alamat</label>
                                    <input id="alamat" name="alamat" type="text" class="form-control" placeholder="Alamat" required>
                                </div>
                                <div class="mb-2">
                                    <label for="jeniskelamin">Jenis Kelamin</label>
                                    <select id="jeniskelamin" name="jeniskelamin" class="form-control" required>
                                        <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <button type="button" class="btn app-btn-primary w-100" onclick="nextStep()">Next</button>
                            </div>

                            <!-- Step 2 -->
                            <div id="step-2" style="display: none;">
                                <div class="mb-2">
                                    <label for="nim">NIM</label>
                                    <input id="nim" name="nim" type="number" class="form-control" placeholder="NIM" required>
                                </div>
                                <div class="mb-2">
                                    <label for="fakultas">Fakultas</label>
                                    <select id="fakultas" name="fakultas" class="form-control" required>
                                        <option value="" disabled selected>Pilih Fakultas</option>
                                        <option value="Teknik">Teknik</option>
                                        <option value="fai">FAI</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="prodi">Prodi</label>
                                    <select id="prodi" name="prodi" class="form-control" required>
                                        <option value="" disabled selected>Pilih Prodi</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="file">Surat Kesehatan</label>
                                    <input id="file" name="file" type="file" class="form-control" required>
                                </div>
                                <div class="mb-2">
                                    <label for="password">Password</label>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="mb-2">
                                    <label for="password-confirm">Confirm Password</label>
                                    <input id="password-confirm" name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" required>
                                </div>
                                <div id="password-error" class="text-danger mb-3" style="display: none;">Passwords do not match</div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn app-btn-secondary w-100 me-2" onclick="prevStep()">Previous</button>
                                    <button type="submit" class="btn app-btn-primary w-100">Daftar</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <footer class="app-auth-footer">
                    <div class="container text-center py-3">
                        <small class="copyright">Designed with <i class="fas fa-heart" style="color: #ff4e21;"></i> by Panitia Mastamaru 2025</small>
                    </div>
                </footer>
            </div>
        </div>
        <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
            <div class="auth-background-holder"></div>
            <div class="auth-background-mask"></div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        let currentStep = 1;

        function nextStep() {
            if (validateStep(currentStep)) {
                currentStep++;
                updateStep();
            }
        }

        function prevStep() {
            if (currentStep > 1) {
                currentStep--;
                updateStep();
            }
        }

        function updateStep() {
            document.getElementById('step-1').style.display = currentStep === 1 ? 'block' : 'none';
            document.getElementById('step-2').style.display = currentStep === 2 ? 'block' : 'none';
        }

        function validateStep(step) {
            if (step === 1) {
                const name = document.getElementById('name').value;
                const email = document.getElementById('email').value;
                const nohp = document.getElementById('nohp').value;
                const alamat = document.getElementById('alamat').value;
                const jeniskelamin = document.getElementById('jeniskelamin').value;

                if (!name || !email || !nohp || !alamat || !jeniskelamin) {
                    alert('Isi semua data pada langkah pertama.');
                    return false;
                }
            }
            return true;
        }
    </script>
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
</body>
</html> --}}


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Portal - Bootstrap 5 Admin Dashboard Template</title>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portal - Bootstrap 5 Admin Dashboard Template For Developers">
    <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- FontAwesome JS -->
    <script defer src="{{ asset('template/assets/plugins/fontawesome/js/all.min.js') }}"></script>
    <!-- App CSS -->
    <link id="theme-style" rel="stylesheet" href="{{ asset('template/assets/css/portal.css') }}">
</head>
<body class="app app-signup p-0">
    <div class="row g-0 app-auth-wrapper">
        <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
            <div class="d-flex flex-column align-content-end">
                <div class="app-auth-body mx-auto">
                    <div class="app-auth-branding mb-4">
                        <a class="app-logo" href="#">
                            <img class="logo-icon me-2" src="{{ asset('template/assets/images/logo-masta24.png') }}" alt="logo">
                        </a>
                    </div>
                    <h2 class="auth-heading text-center mb-4">Daftar</h2>
                    <div class="auth-form-container text-start mx-auto">
                        <form method="POST" action="{{ route('register') }}" class="text-black" enctype="multipart/form-data">
                            @csrf

                            <!-- Step 1 -->
                            <div id="step-1">
                                <!-- Name Input -->
                                <div class="mb-2">
                                    <label for="name">Nama Lengkap</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Email Input -->
                                <div class="mb-2">
                                    <label for="email">Email</label>
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Nomer HP Input -->
                                <div class="mb-2">
                                    <label for="nohp">Nomer HP</label>
                                    <input id="nohp" type="number"
                                        class="form-control @error('nohp') is-invalid @enderror"
                                        name="nohp" value="{{ old('nohp') }}" required autocomplete="nohp">
                                    @error('nohp')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Alamat Input -->
                                <div class="mb-2">
                                    <label for="alamat">Alamat</label>
                                    <input id="alamat" type="text"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        name="alamat" value="{{ old('alamat') }}" required autocomplete="alamat">
                                    @error('alamat')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Jenis Kelamin Input -->
                                <div class="mb-2">
                                    <label for="jeniskelamin">Jenis Kelamin</label>
                                    <select id="jeniskelamin" class="form-control @error('jeniskelamin') is-invalid @enderror" name="jeniskelamin" required>
                                        <option value="" disabled {{ old('jeniskelamin') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                                        <option value="Laki-Laki" {{ old('jeniskelamin') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ old('jeniskelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                    @error('jeniskelamin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Next Button -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn app-btn-primary w-100" onclick="nextStep()">Next</button>
                                </div>
                                <div class="auth-option text-center pt-2">Sudah punya akun?  <a class="text-link" href="/login" >Login</a>.</div>
                            </div>

                            <!-- Step 2 -->
                            <div id="step-2" style="display: none;">
                                <!-- NIM Input -->
                                <div class="mb-2">
                                    <label for="nim">NIM</label>
                                    <input id="nim" type="number"
                                        class="form-control @error('nim') is-invalid @enderror"
                                        name="nim" value="{{ old('nim') }}" required autocomplete="nim">
                                    @error('nim')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Fakultas Dropdown -->
                                <div class="mb-2">
                                    <label for="fakultas">Fakultas</label>
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

                                <!-- Prodi Dropdown -->
                                <div class="mb-2">
                                    <label for="prodi">Prodi</label>
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

                                <!-- File Upload -->
                                <div class="mb-2">
                                    <label for="file">Surat Kesehatan</label>
                                    <input id="file" type="file"
                                        class="form-control @error('file') is-invalid @enderror"
                                        name="file" required>
                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Password Input -->
                                <div class="mb-2">
                                    <label for="password">Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-2">
                                    <label for="password-confirm">Confirm Password</label>
                                    <input id="password-confirm" type="password"
                                        class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                                <div class="g-recaptcha mb-3" data-sitekey="{{ config('services.recaptcha.sitekey') }}"></div>
                                @error('g-recaptcha-response')
                                    <small class="text-danger ">{{ $message }}</small>
                                @enderror
                                <!-- Submit Button -->
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn app-btn-secondary w-100 me-2" onclick="prevStep()">Previous</button>
                                    <button type="submit" class="btn app-btn-primary w-100">Daftar</button>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
            <footer class="app-auth-footer">
                <div class="container text-center py-3">
                    <small class="copyright">Designed with <span class="sr-only">love</span><i class="fas fa-heart" style="color: #ff4e21;"></i> by <a class="app-link" href="#" target="_blank">Panitia Mastamaru 2025</a> for developers</small>
                </div>
            </footer>
        </div>
    </div>
    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
        <div class="auth-background-holder"></div>
        <div class="auth-background-mask"></div>
    </div>
</div>


<script>
    let currentStep = 1;

    function nextStep() {
        // Hide the current step and show the next one
        document.getElementById('step-1').style.display = 'none';
        document.getElementById('step-2').style.display = 'block';
    }

    function prevStep() {
        // Hide the current step and show the previous one
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-1').style.display = 'block';
    }
</script>
<script src="https://www.google.com/recaptcha/api.js"></script>
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
</body>
</html>
