<?php
  
namespace App\Http\Middleware;
  
use Closure;
use App;
use Auth;
  
class LanguageManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (session()->has('language')) {
            App::setLocale(session()->get('language'));
        }

        if (session()->has('language-admin')) {
            App::setLocale(session()->get('language-admin'));
        }
          
        return $next($request);
    }
}