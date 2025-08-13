@extends('layouts.adminMasterl')

@section('content')
    <style>
        :root {
            --primary-color: #00A045;
            --primary-hover: #008a3d;
            --text-dark: #0f172a;
            --text-light: #64748b;
            --border-color: #e2e8f0;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 15px 35px rgba(0, 0, 0, 0.2);
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1.5;
            color: var(--text-dark);
        }

        .main-content,
        .page-content,
        .container-fluid {
            padding: 0 !important;
            margin: 0 !important;
            width: 100%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            width: 100%;
            max-width: 480px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }

        .login-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 2.5rem;
            width: 100%;
            box-shadow: var(--shadow-lg);
            animation: fadeIn 0.6s ease-in-out;
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), #3b82f6);
        }

        .login-title {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .login-subtitle {
            color: var(--text-light);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-dark);
        }

        .form-control {
            border-radius: 8px;
            padding: 0.875rem;
            font-size: 1rem;
            border: 1px solid var(--border-color);
            transition: var(--transition);
            width: 100%;
            background-color: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(0, 160, 69, 0.15);
            outline: none;
            background-color: white;
        }

        .btn-submit {
            background: var(--primary-color);
            border: none;
            padding: 0.875rem;
            border-radius: 8px;
            width: 100%;
            font-size: 1rem;
            font-weight: 500;
            color: white;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.5rem;
            box-shadow: var(--shadow-sm);
        }

        .btn-submit:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .alert {
            padding: 0.875rem 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            margin-top: 1.25rem;
        }

        .alert-success {
            background-color: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .forgot-password {
            display: block;
            text-align: right;
            font-size: 0.8125rem;
            color: var(--text-light);
            margin-top: -0.75rem;
            margin-bottom: 1.5rem;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .forgot-password:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 640px) {
            .login-card {
                padding: 2rem 1.5rem;
                border-radius: 12px;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 1.75rem 1.25rem;
            }

            .login-title {
                font-size: 1.375rem;
                margin-bottom: 1.25rem;
            }

            .login-subtitle {
                margin-bottom: 1.5rem;
            }

            .form-control,
            .btn-submit {
                padding: 0.75rem;
            }
        }

        footer {
            display: none !important;
        }
    </style>

    <div class="login-container">
        <div class="login-card">
            <h2 class="login-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                Admin Login
            </h2>
            <p class="login-subtitle">Enter your credentials to access your account</p>

            <form id="loginForm">
                @csrf

                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control"
                        placeholder="Enter your username" required>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control"
                        placeholder="Enter your password" required>
                    {{-- <a href="#" class="forgot-password">Forgot password?</a> --}}
                </div>

                <button type="submit" class="btn-submit">
                    <span class="btn-text">Sign In</span>
                </button>
            </form>

            <div id="responseMessage"></div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                const $btn = $(this).find('.btn-submit');
                const originalText = $btn.find('.btn-text').text();

                // Show loading state
                $btn.prop('disabled', true);
                $btn.find('.btn-text').text('Authenticating...');

                $.ajax({
                    url: "{{ route('admin.login.submit') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.redirect) {
                            window.location.href = response.redirect;
                        } else {
                            // Fallback in case response doesn't contain redirect
                            window.location.href = "{{ route('admin.branches.index') }}";
                        }
                    },
                    error: function(xhr) {
                        let errorMessage = 'Invalid credentials. Please try again.';
                        if (xhr.responseJSON?.errors?.username) {
                            errorMessage = xhr.responseJSON.errors.username[0];
                        } else if (xhr.responseJSON?.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        $('#responseMessage').html(
                            `<div class="alert alert-danger">${errorMessage}</div>`
                        );
                    },
                    complete: function() {
                        // Reset button state
                        $btn.prop('disabled', false);
                        $btn.find('.btn-text').text(originalText);
                    }
                });
            });

            // Add input focus effects
            $('.form-control').on('focus', function() {
                $(this).parent().find('.form-label').css('color', 'var(--primary-color)');
            }).on('blur', function() {
                $(this).parent().find('.form-label').css('color', 'var(--text-dark)');
            });
        });
    </script>
@endsection
