@extends('layouts.master2')
@section('css')
@endsection
@section('content')
    <div class="d-md-flex">
        <div class="w-40 bg-style h-100vh page-style">
            <div class="page-content">
                <div class="page-single-content">
                    <div class="card-body text-white py-5 px-8 text-center">
                        <a href="{{ url('/users/home-page') }}"><img src="{{ URL::asset('assets/images/png/3.png') }}"
                                alt="img" class=" text-center supplier-logo"></a>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .input-group {
                display: flex;
                align-items: stretch;
            }

            .input-group-addon {
                padding: 6px 12px;
                background-color: #eee;
                border: 1px solid #ccc;
                border-right: none;
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 48px;
            }

            .input-wrapper {
                position: relative;
                flex: 1;
            }

            .input-wrapper input {
                width: 100%;
                height: 100%;
                padding: 6px 40px 6px 12px;
                border: 1px solid #ccc;
                border-left: none;
                box-sizing: border-box;
                font-size: 14px;
            }

            .toggle-password {
                position: absolute;
                top: 50%;
                right: 10px;
                transform: translateY(-50%);
                cursor: pointer;
                height: 20px;
                width: 20px;
                fill: #888;
            }
        </style>

        <div class="w-80 page-content">
            <div class="page-single-content">
                <div class="card-body p-6">
                    <div class="row">
                        <div class="col-md-8 mx-auto d-block">
                            <div class="">
                                <h1 class="mb-2">Smart Schools Login</h1>
                                <p class="text-muted">Sign into your account</p>
                            </div>

                            @include('sweetalert::alert')

                            @if (Session::get('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif

                            @if (Session::get('fail'))
                                <div class="alert alert-danger">
                                    {{ Session::get('fail') }}
                                </div>
                            @endif

                            <form action="{{ route('auth-user-check') }}" method="POST">
                                @csrf

                                <div class="input-group mb-3">
                                    <span class="input-group-addon">
                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24"
                                            viewBox="0 0 24 24" width="24">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M12 16c-2.69 0-5.77 1.28-6 2h12c-.2-.71-3.3-2-6-2z" opacity=".3" />
                                            <circle cx="12" cy="8" opacity=".3" r="2" />
                                            <path
                                                d="M12 14c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H6zm6-6c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z" />
                                        </svg>
                                    </span>


                                    <input type="email" id="email" name="email" class="form-control"
                                        placeholder="Email" required
                                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                                        title="Please enter a valid email address." value="{{ old('email') }}">

                                </div>
                                <span class="text-danger">
                                    @error('email')
                                        {{ $message }}
                                    @enderror
                                </span>

                                <div class="input-group mb-4">
                                    <span class="input-group-addon">

                                        <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="20"
                                            width="20" viewBox="0 0 24 24">
                                            <g fill="none">
                                                <path d="M0 0h24v24H0V0z" />
                                                <path d="M0 0h24v24H0V0z" opacity=".87" />
                                            </g>
                                            <path d="M6 20h12V10H6v10zm6-7c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2z"
                                                opacity=".3" />
                                            <path
                                                d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0
                                                                                                                                                                                    2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1
                                                                                                                                                                                    0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z" />
                                        </svg>
                                    </span>

                                    <div class="input-wrapper">
                                        <input type="password" class="form-control" placeholder="Password" id="password">
                                        <svg class="toggle-password" onclick="togglePassword('password', this)"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                            <path
                                                d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11
                                                                                                                                                                                    11-7.5c-1.73-4.39-6-7.5-11-7.5zm0
                                                                                                                                                                                    13c-2.76 0-5-2.24-5-5s2.24-5
                                                                                                                                                                                    5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66
                                                                                                                                                                                    0-3 1.34-3 3s1.34 3 3 3
                                                                                                                                                                                    3-1.34 3-3-1.34-3-3-3z" />
                                        </svg>
                                    </div>
                                </div>

                                <span class="text-danger">
                                    @error('password')
                                        {{ $message }}
                                    @enderror
                                </span>

                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{ url('/users/forgot-password') }}"
                                            class="btn btn-link box-shadow-0 px-0">Forgot
                                            password?</a>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary btn-block" id="login_button">
                                            <i class="fe fe-arrow-right"></i> Login
                                        </button>

                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="alert alert-info text-center" role="alert">
                                            <strong>New here?</strong> Click below to create your account.
                                            <br>
                                            <a href="{{ url('/users/register') }}" class="btn btn-secondary mt-2">
                                                <i class="fe fe-user-plus"></i> Register Here
                                            </a>
                                        </div>
                                    </div>

                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function togglePassword(fieldId, icon) {
            const input = document.getElementById(fieldId);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        $(document).ready(function() {
            $('#login_button').on('click', function(e) {
                e.preventDefault();

                var button = $(this);
                button.prop('disabled', true).html('<i class="fe fe-arrow-right"></i> Logging in...');

                let email = $('#email').val();
                let password = $('#password').val();

                $('#email').removeClass('is-invalid is-valid');
                $('#password').removeClass('is-invalid is-valid');

                let errorMessages = [];

                const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                if (!email) {
                    errorMessages.push("Email is required.");
                    $('#email').addClass('is-invalid');
                } else if (!emailRegex.test(email)) {
                    errorMessages.push("Please enter a valid email address.");
                    $('#email').addClass('is-invalid');
                } else {
                    $('#email').addClass('is-valid');
                }

                if (!password) {
                    errorMessages.push("Password is required.");
                    $('#password').addClass('is-invalid');
                } else {
                    $('#password').addClass('is-valid');
                }

                if (errorMessages.length > 0) {
                    let errorList = '<ul>';
                    errorMessages.forEach((err, i) => {
                        errorList += `<li>${i + 1}. ${err}</li>`;
                    });
                    errorList += '</ul>';

                    Swal.fire({
                        title: 'Validation Error',
                        html: errorList,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    button.prop('disabled', false).html('<i class="fe fe-arrow-right"></i> Login');
                    return;
                }

                $.ajax({
                    url: "{{ route('auth-user-check') }}",
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email,
                        password: password
                    },
                    success: function(response) {
                        if (response.status) {
                            window.location.href = response.redirect_url
                        } else {

                            Swal.fire({
                                title: response.title ?? 'Login Failed',
                                text: response.message ??
                                    'We don’t recognize the email or password you provided.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then(() => {

                                $('#login_button').prop('disabled', false).html(
                                    '<i class="fe fe-arrow-right"></i> Login');
                            });
                        }
                    },
                    error: function(data) {

                        try {
                            const response = data.responseJSON;
                            if (response && response.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    html: response.message,
                                    confirmButtonText: 'OK'
                                });
                            } else {
                                $('body').html(data
                                    .responseText);
                            }
                        } catch (e) {
                            $('body').html(data.responseText);
                        }

                        $('#login_button').prop('disabled', false).html(
                            '<i class="fe fe-arrow-right"></i> Login');
                    }
                });

            });
        });
    </script>
@endsection
