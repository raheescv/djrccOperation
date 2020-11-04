<?php
namespace App\Http\Middleware;
use Closure;
use Spatie\Activitylog\Models\Activity;
class ActivityLog
{
    public function handle($request, Closure $next)
    {
        \ActivityLog::addToLog('');
        return $next($request);
    }
}
