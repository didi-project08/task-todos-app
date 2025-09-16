@extends('source::_layouts.auth')
@section('content')
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div>
            <div class="mx-auto h-12 w-auto flex justify-center">
                <svg class="h-12 w-12 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Masuk ke Akun Anda
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau 
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    daftar akun baru
                </a>
            </p>
        </div>

        <!-- Form Login -->
        <form class="mt-8 space-y-6" id="loginForm" action="{{ route('login-validate') }}" method="POST">
            @csrf
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <ul class="list-disc list-inside text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="space-y-4">
                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" name="email" type="email" autocomplete="email"
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 
                                placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 
                                focus:border-indigo-500 sm:text-sm"
                        placeholder="Alamat Email" value="{{ old('email') }}">
                    <span class="text-red-500 text-xs hidden mt-1" id="emailError"></span>
                </div>
                
                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password"
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 
                                placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 
                                focus:border-indigo-500 sm:text-sm"
                        placeholder="Password">
                    <span class="text-red-500 text-xs hidden mt-1" id="passwordError"></span>
                </div>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" id="submitBtn"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent 
                            text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 
                            focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                            transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <span id="buttonText">Masuk</span>
                </button>
            </div>

            <div class="flex justify-end items-end">
                <a href="{{ route('welcome') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-200 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Check Laravel Version
                </a>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const $form = $('#loginForm');
            const $submitBtn = $('#submitBtn');
            const $buttonText = $('#buttonText');
            const $email = $('#email');
            const $password = $('#password');
            const $emailError = $('#emailError');
            const $passwordError = $('#passwordError');

            // Validasi format email
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Validasi form
            function validateForm() {
                let isValid = true;
                const email = $email.val().trim();
                const password = $password.val();

                // Reset error messages
                $emailError.hide();
                $passwordError.hide();

                // Validasi email
                if (!email) {
                    $emailError.text('Email harus diisi').show();
                    isValid = false;
                } else if (!isValidEmail(email)) {
                    $emailError.text('Format email tidak valid').show();
                    isValid = false;
                }

                // Validasi password
                if (!password) {
                    $passwordError.text('Password harus diisi').show();
                    isValid = false;
                } else if (password.length < 6) {
                    $passwordError.text('Password minimal 6 karakter').show();
                    isValid = false;
                }

                return isValid;
            }

            // Real-time validation
            $email.on('input', function() {
                const email = $(this).val().trim();
                $emailError.hide();
                
                if (email && !isValidEmail(email)) {
                    $emailError.text('Format email tidak valid').show();
                }
            });

            $password.on('input', function() {
                const password = $(this).val();
                $passwordError.hide();
                
                if (password && password.length < 6) {
                    $passwordError.text('Password minimal 6 karakter').show();
                }
            });

            // Form submission
            $form.on('submit', function(e) {
                e.preventDefault();
                
                if (validateForm()) {
                    // Show loading state
                    $submitBtn.prop('disabled', true);
                    $buttonText.html(`
                        <span class="flex items-center">
                            <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </span>
                    `);

                    // Simulate API call atau langsung submit
                    setTimeout(() => {
                        this.submit();
                    }, 1000);
                }
            });

            // Enter key to submit
            $form.on('keypress', function(e) {
                if (e.which === 13) {
                    $(this).submit();
                }
            });

            // Auto focus on email field
            $email.focus();

            // Show/hide password functionality (optional)
            const $passwordField = $password;
            const $showPasswordBtn = $(`
                <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </button>
            `);

            $passwordField.after($showPasswordBtn);
            $passwordField.css('padding-right', '45px');

            $showPasswordBtn.on('click', function() {
                const type = $passwordField.attr('type') === 'password' ? 'text' : 'password';
                $passwordField.attr('type', type);
                
                // Ganti icon
                if (type === 'text') {
                    $(this).html(`
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                        </svg>
                    `);
                } else {
                    $(this).html(`
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    `);
                }
            });
        });
    </script>
@endsection