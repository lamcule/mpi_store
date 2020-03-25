<?php

namespace Modules\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\App\Entities\App;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user_id = Auth::id();
        $app_id = $request->id;
        $app = App::find($app_id);
        if ($app->user_id !== $user_id) {
            return redirect()->back()->with('status','Không có quyền cập nhật ứng dụng!');
        }
        return $next($request);
    }
}
