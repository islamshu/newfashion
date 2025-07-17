<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfUnauthenticatedClient
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('client')->check()) {
              session()->flash('login_required', true);
            session()->flash('alert_message', __('يجب تسجيل الدخول أولاً'));
            return redirect('/'); // تحويل للصفحة الرئيسية إذا غير مسجل
        }

        return $next($request);
    }
}
