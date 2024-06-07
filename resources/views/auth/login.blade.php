<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="font-figtree text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8f4f3]">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="py-8">
                    <center>
                        <span class="text-2xl font-semibold">Iniciar Sesión</span>
                    </center>
                </div>

                <div>
                    <label class="block font-medium text-sm text-gray-700" for="email">Email</label>
                    <input id="email" type="email" name="email" placeholder="ejemplo@gmail.com" required autocomplete="email" autofocus
                           class="w-full rounded-md py-2.5 px-4 border text-sm outline-none focus:outline-[#f84525]" />
                </div>

                <div class="mt-4">
                    <label class="block font-medium text-sm text-gray-700" for="password">Contraseña</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" placeholder="Contraseña" required autocomplete="current-password"
                               class="w-full rounded-md py-2.5 px-4 border text-sm outline-none focus:outline-[#f84525]" />
                        <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 focus:outline-none">
                            <i class='bx bx-show-alt text-2xl'></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button class="inline-flex items-center px-4 py-2 bg-[#f84525] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 focus:outline-none focus:ring focus:ring-[#f84525] focus:ring-offset-2 transition ease-in-out duration-150">
                        Ingresar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');
const icon = togglePassword.querySelector('i');

togglePassword.addEventListener('click', function (e) {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // Actualizar el ícono según el tipo
    icon.className = type === 'text' ? 'bx bx-hide' : 'bx bx-show-alt';
});
</script>
</body>
</html>
