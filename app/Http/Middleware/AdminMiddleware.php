<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()
                ->route('login')
                ->with('error', 'Bạn cần đăng nhập để tiếp tục!');
        }

        if ($request->user()->role !== 'admin') {
            return redirect()
                ->route('home')
                ->with(
                    'error',
                    '403 Forbidden: Bạn không có quyền truy cập khu vực quản trị!'
                );
        }

        return $next($request);
    }
}