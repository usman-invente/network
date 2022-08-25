<?php



namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // dd(Auth::user());
        if(Auth::check() && Auth::user()->status)
        {
            $banned = Auth::user()->status == "0"; // "0"= user is banned / "1"= user is unBanned
            Auth::logout();

            if ($banned == 0) {
                $message = 'Your account has been Banned. Please contact administrator.';
            }
            return redirect()->route('login')
                ->with('status',$message)
                ->withErrors(['email' => 'Your account has been Banned. Please contact administrator.'])
            ;
        }
        return $next($request);
    }

}

