<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    private const MAX_ATTEMPTS = 5;
    private const ATTEMPT_WINDOW_SECONDS = 300;
    private const LOCKOUT_SECONDS = 900;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function showLoginForm()
    {
        $lockoutSeconds = 0;

        $email = session('login_lockout_email');
        $ipAddress = session('login_lockout_ip');

        if ($email && $ipAddress) {
            $lockoutKey = $this->makeLockoutKey(
                $email,
                $ipAddress
            );

            $lockoutSeconds = RateLimiter::availableIn(
                $lockoutKey
            );

            if ($lockoutSeconds <= 0) {
                session()->forget([
                    'login_lockout_email',
                    'login_lockout_ip',
                ]);

                $lockoutSeconds = 0;
            }
        }

        return view('auth.login', compact('lockoutSeconds'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
            ],
            'password' => [
                'required',
                'string',
            ],
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
        ]);

        $email = Str::lower(
            trim($request->input('email'))
        );

        $ipAddress = $request->ip();

        $attemptsKey = $this->makeAttemptsKey(
            $email,
            $ipAddress
        );

        $lockoutKey = $this->makeLockoutKey(
            $email,
            $ipAddress
        );

        if (RateLimiter::tooManyAttempts($lockoutKey, 1)) {
            $seconds = RateLimiter::availableIn($lockoutKey);

            session()->put(
                'login_lockout_email',
                $email
            );

            session()->put(
                'login_lockout_ip',
                $ipAddress
            );

            return redirect()
                ->route('login')
                ->withInput([
                    'email' => $email,
                ])
                ->withErrors([
                    'email' => 'Quyền đăng nhập đang bị khóa tạm thời. '
                        . "Vui lòng thử lại sau {$seconds} giây.",
                ])
                ->with('lockout_seconds', $seconds);
        }

        $credentials = [
            'email' => $email,
            'password' => $request->input('password'),
        ];

        if (Auth::attempt(
            $credentials,
            $request->boolean('remember')
        )) {
            $request->session()->regenerate();

            RateLimiter::clear($attemptsKey);
            RateLimiter::clear($lockoutKey);

            session()->forget([
                'login_lockout_email',
                'login_lockout_ip',
            ]);

            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()
                    ->route('admin.dashboard')
                    ->with(
                        'success',
                        'Đăng nhập quản trị thành công!'
                    );
            }

            return redirect()
                ->route('home')
                ->with(
                    'success',
                    'Đăng nhập thành công!'
                );
        }

        RateLimiter::hit(
            $attemptsKey,
            self::ATTEMPT_WINDOW_SECONDS
        );

        $attempts = RateLimiter::attempts($attemptsKey);

        if ($attempts >= self::MAX_ATTEMPTS) {
            RateLimiter::clear($attemptsKey);

            RateLimiter::hit(
                $lockoutKey,
                self::LOCKOUT_SECONDS
            );

            session()->put(
                'login_lockout_email',
                $email
            );

            session()->put(
                'login_lockout_ip',
                $ipAddress
            );

            return redirect()
                ->route('login')
                ->withInput([
                    'email' => $email,
                ])
                ->withErrors([
                    'email' => 'Bạn đã nhập sai thông tin đăng nhập '
                        . self::MAX_ATTEMPTS
                        . ' lần. Quyền đăng nhập đã bị khóa tạm thời. '
                        . 'Vui lòng thử lại sau '
                        . self::LOCKOUT_SECONDS
                        . ' giây.',
                ])
                ->with(
                    'lockout_seconds',
                    self::LOCKOUT_SECONDS
                );
        }

        $remaining = self::MAX_ATTEMPTS - $attempts;

        return redirect()
            ->route('login')
            ->withInput([
                'email' => $email,
            ])
            ->withErrors([
                'email' => 'Email hoặc mật khẩu không chính xác. '
                    . "Bạn còn {$remaining} lần thử.",
            ]);
    }

    private function makeBaseKey(
        string $email,
        string $ipAddress
    ): string {
        $identity = Str::lower(trim($email))
            . '|'
            . $ipAddress;

        return 'login:' . sha1($identity);
    }

    private function makeAttemptsKey(
        string $email,
        string $ipAddress
    ): string {
        return $this->makeBaseKey(
            $email,
            $ipAddress
        ) . ':attempts';
    }

    private function makeLockoutKey(
        string $email,
        string $ipAddress
    ): string {
        return $this->makeBaseKey(
            $email,
            $ipAddress
        ) . ':lockout';
    }
}
