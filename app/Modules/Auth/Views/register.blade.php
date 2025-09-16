@extends('source::_layouts.auth')
@section('content')
    <div class="max-w-md w-full space-y-8">
        <!-- Header -->
        <div>
            <div class="mx-auto h-12 w-auto flex justify-center">
                <svg class="h-12 w-12 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Buat Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Atau 
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    masuk ke akun yang sudah ada
                </a>
            </p>
        </div>

        <!-- Form Register -->
        <form class="mt-8 space-y-6" id="registerForm" action="{{ route('register-validate') }}" method="POST">
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

            <div class="space-y-4">
                <!-- Nama Lengkap -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                    <input id="name" name="name" type="text" autocomplete="name"
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 
                                placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 
                                focus:border-indigo-500 sm:text-sm"
                        placeholder="Nama lengkap Anda" value="{{ old('name') }}">
                    <span class="text-red-500 text-xs hidden" id="nameError"></span>
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                    <input id="email" name="email" type="email" autocomplete="email"
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 
                                placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 
                                focus:border-indigo-500 sm:text-sm"
                        placeholder="alamat@email.com" value="{{ old('email') }}">
                    <span class="text-red-500 text-xs hidden" id="emailError"></span>
                </div>
                
                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"
                        class="appearance-none relative block w-full px-3 py-3 border border-gray-300 
                                placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 
                                focus:border-indigo-500 sm:text-sm"
                        placeholder="Minimal 8 karakter">
                    <div class="mt-1 text-xs text-gray-500" id="passwordRequirements">
                        Password harus mengandung minimal 8 karakter, huruf besar, huruf kecil, dan angka
                    </div>
                    <span class="text-red-500 text-xs hidden" id="passwordError"></span>
                </div>
                
                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Ulangi Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                            class="appearance-none relative block w-full px-3 py-3 border border-gray-300 
                                    placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 
                                    focus:border-indigo-500 sm:text-sm"
                            placeholder="Ketik ulang password">
                        <span class="text-red-500 text-xs hidden" id="passwordConfirmError"></span>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-900">
                        Saya menyetujui 
                        <a href="#" class="text-indigo-600 hover:text-indigo-500">syarat dan ketentuan</a>
                    </label>
                </div>
                <span class="text-red-500 text-xs hidden" id="termsError"></span>

                <!-- Submit Button -->
                <div>
                    <button type="submit" id="submitBtn"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent 
                                text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 
                                focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 
                                transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                        </span>
                        Daftar Akun
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Elements
            const $form = $('#registerForm');
            const $submitBtn = $('#submitBtn');
            const $password = $('#password');
            const $passwordConfirm = $('#password_confirmation');
            
            // Error spans
            const $nameError = $('#nameError');
            const $emailError = $('#emailError');
            const $passwordError = $('#passwordError');
            const $passwordConfirmError = $('#passwordConfirmError');
            const $termsError = $('#termsError');
            
            // Validation functions
            function validateName() {
                const name = $('#name').val().trim();
                if (name.length < 3) {
                    $nameError.text('Nama harus minimal 3 karakter').show();
                    return false;
                }
                $nameError.hide();
                return true;
            }
            
            function validateEmail() {
                const email = $('#email').val().trim();
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if (!emailRegex.test(email)) {
                    $emailError.text('Format email tidak valid').show();
                    return false;
                }
                $emailError.hide();
                return true;
            }
            
            function validatePassword() {
                const password = $password.val();
                const hasUpperCase = /[A-Z]/.test(password);
                const hasLowerCase = /[a-z]/.test(password);
                const hasNumber = /[0-9]/.test(password);
                const hasMinLength = password.length >= 8;
                
                if (!hasMinLength) {
                    $passwordError.text('Password minimal 8 karakter').show();
                    return false;
                }
                if (!hasUpperCase) {
                    $passwordError.text('Password harus mengandung huruf besar').show();
                    return false;
                }
                if (!hasLowerCase) {
                    $passwordError.text('Password harus mengandung huruf kecil').show();
                    return false;
                }
                if (!hasNumber) {
                    $passwordError.text('Password harus mengandung angka').show();
                    return false;
                }
                
                $passwordError.hide();
                return true;
            }
            
            function validatePasswordConfirm() {
                const password = $password.val();
                const passwordConfirm = $passwordConfirm.val();
                
                if (password !== passwordConfirm) {
                    $passwordConfirmError.text('Password tidak sama').show();
                    return false;
                }
                $passwordConfirmError.hide();
                return true;
            }
            
            function validateTerms() {
                const isChecked = $('#terms').is(':checked');
                if (!isChecked) {
                    $termsError.text('Anda harus menyetujui syarat dan ketentuan').show();
                    return false;
                }
                $termsError.hide();
                return true;
            }
            
            function validateForm() {
                const isNameValid = validateName();
                const isEmailValid = validateEmail();
                const isPasswordValid = validatePassword();
                const isPasswordConfirmValid = validatePasswordConfirm();
                const isTermsValid = validateTerms();
                
                return isNameValid && isEmailValid && isPasswordValid && isPasswordConfirmValid && isTermsValid;
            }
            
            // Real-time validation
            $('#name').on('input', validateName);
            $('#email').on('input', validateEmail);
            $password.on('input', function() {
                validatePassword();
                validatePasswordConfirm();
            });
            $passwordConfirm.on('input', validatePasswordConfirm);
            $('#terms').on('change', validateTerms);
            
            // Form submission
            $form.on('submit', function(e) {
                e.preventDefault();
                
                if (validateForm()) {
                    // Show loading state
                    $submitBtn.prop('disabled', true).html(`
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </span>
                        Mendaftarkan...
                    `);
                    
                    // Submit form
                    this.submit();
                }
            });
            
            // Password strength indicator (optional)
            $password.on('input', function() {
                const password = $(this).val();
                let strength = 0;
                
                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[a-z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                
                const strengthText = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'][strength - 1] || '';
                const strengthColor = ['text-red-500', 'text-orange-500', 'text-yellow-500', 'text-green-500', 'text-green-600'][strength - 1] || '';
                
                $('#passwordRequirements').html(`
                    Kekuatan password: <span class="${strengthColor} font-medium">${strengthText}</span>
                `);
            });
        });
    </script>
@endsection