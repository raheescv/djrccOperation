<?php
namespace App\Http\Middleware;
use Closure;
use View;
use App\Models\User;
use App\Models\Profile;
use App\Models\Settings;
use App\Models\Reminder;
use Illuminate\Support\Facades\Route;
class StartSession
{
    public function handle($request, Closure $next)
    {
        $user_id=session('user_id');
        if(!$user_id)
        {
            return redirect()->action('UsersController@SignIn');
        }
        $Reminder=Reminder::orderBy('date','asc')->where('date','>',date('Y-m-d'))->get()->take(5);
        $current_url=explode('.', Route::getCurrentRoute()->getName())[0];
        $User=User::find($user_id);
        $Profile=Profile::first();
        $Settings=Settings::first();
        View::share('LoggedUser',$User);
        View::share('Profile',$Profile);
        View::share('Reminder',$Reminder);
        View::share('Settings',$Settings);
        return $next($request);
    }
    public function terminate($request, $response)
    {
    }
}
