<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Folder
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
        $user = Auth::user();
        $folder=$request->folder_id;
        $folders = $user->folders;

        if(!$user->admin && !$folders->contains('id',$folder)) abort(403, 'Unauthorized action');
        return $next($request);
    }
}
