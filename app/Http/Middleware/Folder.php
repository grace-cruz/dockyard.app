<?php

namespace App\Http\Middleware;

use Vinkla\Hashids\Facades\Hashids;
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
        $ids = Hashids::decode($request->folder_id);
        $folder = !empty($ids) ? $ids[0] : 0;
        $folders = $user->folders;

        if(!$user->admin && !$folders->contains('id',$folder)) abort(403, 'Unauthorized action');
        return $next($request);
    }
}
