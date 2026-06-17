<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách tài khoản.
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();

        return view('admin.user-list', compact('users'));
    }

    /**
     * Hiển thị trang thêm tài khoản.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Lưu tài khoản mới.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'role' => [
                'required',
                Rule::in(['admin', 'user']),
            ],
        ], [
            'name.required' => 'Vui lòng nhập tên tài khoản.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

            'role.required' => 'Vui lòng chọn quyền truy cập.',
            'role.in' => 'Quyền truy cập không hợp lệ.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Thêm tài khoản thành công!');
    }

    /**
     * Hiển thị chi tiết tài khoản.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Hiển thị trang chỉnh sửa tài khoản.
     */
    public function edit(User $user)
    {
        return view('admin.user-edit', compact('user'));
    }

    /**
     * Cập nhật tài khoản.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::in(['admin', 'user']),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [
            'name.required' => 'Vui lòng nhập tên tài khoản.',

            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã tồn tại trong hệ thống.',

            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

            'role.required' => 'Vui lòng chọn quyền truy cập.',
            'role.in' => 'Quyền truy cập không hợp lệ.',
        ]);

        $dataUpdate = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $dataUpdate['password'] = Hash::make(
                $validated['password']
            );
        }

        $user->update($dataUpdate);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Cập nhật tài khoản thành công!');
    }

    /**
     * Xóa tài khoản.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'Bạn không thể xóa tài khoản đang đăng nhập!'
                );
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Xóa tài khoản thành công!');
    }
}
