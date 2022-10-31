<?php

namespace Modules\User\Http\Middleware;

use App\Jobs\UserAgentLocationApiCall;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class UserAgentLog
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

        if($request->ip() && $request->server('HTTP_USER_AGENT'))
        {
            $log = \Modules\User\Entities\UserAgentLog::query()
                ->firstOrCreate([
                    'user_id' => Auth::check() ? Auth::user()->id : null,
                    'ip' => $request->ip() ?? null,
                    'agent' => $request->server('HTTP_USER_AGENT') ?? null
                ],[
                    'user_id' => Auth::check() ? Auth::user()->id : null,
                    'ip' => $request->ip() ?? null,
                    'agent' => $request->server('HTTP_USER_AGENT') ?? null
                ]);

            $log->updated_at = Carbon::now();
            $log->save();

            if(empty($log->location) && $request->ip())
            {
                try{
                    UserAgentLocationApiCall::dispatch($log,$request->ip);
                }catch (\Exception $exception)
                {

                }
            }
        }
        return $next($request);
    }
}
