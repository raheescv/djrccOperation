<?php

namespace App\Http\Middleware;
use Closure;
class Auditing
{
  public function handle($request, Closure $next)
  {
    // \App\Models\Profile::disableAuditing();
    \App\Models\Reminder::disableAuditing();
    \App\Models\Task::disableAuditing();
    // \App\Models\User::disableAuditing();
    \App\Models\UserType::disableAuditing();
    \App\Models\UserTypePrivilege::disableAuditing();
    return $next($request);
  }
}
