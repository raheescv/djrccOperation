<?php
namespace App\Helpers;
use App\Models\ActivityLog as LogActivityModel;
use Request;
class ActivityLog {
    public static function addToLog($subject) {
        $log = [];
        $log['subject'] = $subject;
        $log['url']     = Request::fullUrl();
        $log['method']  = Request::method();
        $log['ip']      = Request::ip();
        $log['user_id'] = auth()->check() ? auth()->user()->id : 0;
        $log['agent']   = Request::header('user-agent');
        if (!array_intersect(['notifications'], explode('/', $log['url']))) {
            LogActivityModel::create($log);
        }
    }
    public static function logActivityLists() {
        return LogActivityModel::latest()->get();
    }
}
