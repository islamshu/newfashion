<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureClientIsActive
{
    public function handle(Request $request, Closure $next)
    {
        $client = Auth::guard('client')->user();

        if ($client && !$client->is_active) {
            Auth::guard('client')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            session()->flash('alert_message', __('تم تعطيل حسابك. يرجى التواصل مع الإدارة.'));
            return redirect('/');
        }

        return $next($request);
    }
}
