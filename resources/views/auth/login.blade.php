@extends('layouts.app')

@section('content')
@php
    $remainingLockout = (int) (
        $lockoutSeconds ?? session('lockout_seconds', 0)
    );
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Đăng nhập
                </div>

                <div class="card-body">
                    @if($remainingLockout > 0)
                        <div class="alert alert-danger text-center"
                             id="lockout-alert"
                             role="alert">

                            <i class="bi bi-lock-fill me-1"></i>

                            Đăng nhập đang bị khóa tạm thời.

                            <br>

                            Vui lòng thử lại sau

                            <strong>
                                <span id="countdown">
                                    {{ $remainingLockout }}
                                </span>
                                giây
                            </strong>.
                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('login') }}"
                          id="login-form">
                        @csrf

                        <div class="row mb-3">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-end">
                                Địa chỉ email
                            </label>

                            <div class="col-md-6">
                                <input id="email"
                                       type="email"
                                       class="form-control
                                       @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}"
                                       required
                                       autocomplete="email"
                                       autofocus>

                                @error('email')
                                    <span class="invalid-feedback"
                                          role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-end">
                                Mật khẩu
                            </label>

                            <div class="col-md-6">
                                <input id="password"
                                       type="password"
                                       class="form-control
                                       @error('password') is-invalid @enderror"
                                       name="password"
                                       required
                                       autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback"
                                          role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="remember"
                                           id="remember"
                                           {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label"
                                           for="remember">
                                        Ghi nhớ đăng nhập
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit"
                                        id="login-button"
                                        class="btn btn-primary"
                                        @disabled($remainingLockout > 0)>
                                    <i class="bi bi-box-arrow-in-right me-1"></i>
                                    Đăng nhập
                                </button>

                                @if(Route::has('password.request'))
                                    <a class="btn btn-link"
                                       href="{{ route('password.request') }}">
                                        Quên mật khẩu?
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($remainingLockout > 0)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let seconds = @json($remainingLockout);

        const countdownElement =
            document.getElementById('countdown');

        const loginButton =
            document.getElementById('login-button');

        const lockoutAlert =
            document.getElementById('lockout-alert');

        const endTime = Date.now() + seconds * 1000;

        const timer = setInterval(function () {
            seconds = Math.max(
                0,
                Math.ceil((endTime - Date.now()) / 1000)
            );

            if (countdownElement) {
                countdownElement.textContent = seconds;
            }

            if (seconds <= 0) {
                clearInterval(timer);

                if (loginButton) {
                    loginButton.disabled = false;
                }

                if (lockoutAlert) {
                    lockoutAlert.classList.remove('alert-danger');
                    lockoutAlert.classList.add('alert-success');

                    lockoutAlert.innerHTML =
                        '<i class="bi bi-unlock-fill me-1"></i>' +
                        'Thời gian khóa đã kết thúc. ' +
                        'Bạn có thể đăng nhập lại.';
                }
            }
        }, 250);
    });
</script>
@endif
@endsection
