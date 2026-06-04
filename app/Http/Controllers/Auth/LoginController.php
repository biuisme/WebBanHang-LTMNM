<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request; // Bắt buộc thêm dòng này để xử lý luồng

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Hàm này tự động chạy ngay sau khi người dùng nhập đúng email/mật khẩu
     */
    protected function authenticated(Request $request, $user)
    {
        // Kiểm tra: Nếu cột role là 'admin' -> Cho vào trang Quản trị
        if ($user->role === 'admin') {
            return redirect('/admin');
        }

        // Nếu là 'user' bình thường -> Đưa ra Trang chủ mua sắm
        return redirect('/');
    }
}
