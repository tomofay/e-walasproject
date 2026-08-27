<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login E Walas | Admin</title>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logokampak.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Kotak pesan */
        .alert {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            z-index: 9999;
            text-align: center;
            font-size: 16px;
            color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            animation: slideDown 0.5s ease-out;
        }

        .alert-danger {
            background-color: #e74c3c; /* Merah */
        }

        .alert-success {
            background-color: #2ecc71; /* Hijau */
        }

        /* Animasi slide down */
        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        /* Animasi slide up untuk saat pesan hilang */
        @keyframes slideUp {
            from {
                transform: translateY(0);
            }
            to {
                transform: translateY(-100%);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Tampilkan pesan error -->
    @if (session('error'))
        <div class="alert alert-danger" id="alertError">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <!-- Tampilkan pesan success -->
    @if (session('success'))
        <div class="alert alert-success" id="alertSuccess">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="screen">
        <div class="screen__content">
            <form class="login" action="{{ route('loginadmin.store') }}" method="POST">
                @csrf
                <img src="{{ asset('images/logologin.png') }}" alt="Logo" class="login__logo">
                <h2>Login Form Admin</h2>
                <div class="login__field fas fa-user-circle">
                        <i class="login__icon "></i> <!-- Ikon Nama -->
                        <input type="text" name="nama" class="login__input" placeholder="Nama" required>
                    </div>
                    <div class="login__field fas fa-key">
                        <i class="login__icon "></i> <!-- Ikon Password -->
                        <input type="password" name="password" class="login__input" id="password" placeholder="Password" required>
                        <span class="eye-icon" id="togglePassword">
                            <i class="fas fa-eye"></i> <!-- Ikon Mata -->
                        </span>
                    </div>
                 </div>
                <button type="submit" class="button login__submit">
                    <span class="button__text">Log In Now</span>
                    <i class="button__icon fas fa-chevron-right"></i>
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan Font Awesome untuk ikon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- JavaScript untuk menghilangkan pesan setelah 2 detik dengan animasi -->
<script>
    window.onload = function() {
        // Cek jika ada pesan error
        var errorAlert = document.getElementById('alertError');
        var successAlert = document.getElementById('alertSuccess');

        // Jika ada pesan error, sembunyikan setelah 2 detik dengan animasi
        if (errorAlert) {
            setTimeout(function() {
                errorAlert.style.animation = 'slideUp 0.5s ease-out'; // Animasi naik
                setTimeout(function() {
                    errorAlert.style.display = 'none'; // Sembunyikan setelah animasi selesai
                }, 500); // Durasi animasi
            }, 2000); // Tunda selama 2 detik sebelum animasi
        }

        // Jika ada pesan success, sembunyikan setelah 2 detik dengan animasi
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.animation = 'slideUp 0.5s ease-out'; // Animasi naik
                setTimeout(function() {
                    successAlert.style.display = 'none'; // Sembunyikan setelah animasi selesai
                }, 500); // Durasi animasi
            }, 2000); // Tunda selama 2 detik sebelum animasi
        }
    };
</script>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordField = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
        // Cek tipe input, ganti antara password dan text
        const type = passwordField.type === 'password' ? 'text' : 'password';
        passwordField.type = type;

        // Ganti ikon antara mata terbuka dan tertutup
        this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
    });
</script>

</body>
</html>