<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
 * (Middleware) يتحقق من صلاحية المدير:
 * 1. يتأكد أن المستخدم مسجل دخول.
 * 2. يتأكد من وجود علاقة "دور" للمستخدم.
 * 3. يسمح بالمرور فقط إذا كان اسم الدور هو 'ادمين'.
 * 4.
 */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->role && Auth::user()->role->name === 'admin') {
            return $next($request);
        }

        //  يوجه غير المصرح لهم إلى الصفحة الرئيسية مع رسالة خطأ.
        return redirect('/')->with('error', 'Unauthorized access.');
    }
}
