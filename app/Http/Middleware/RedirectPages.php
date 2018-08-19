<?php

namespace App\Http\Middleware;

use App\Redirect as Model;
use Closure;
use Illuminate\Support\Facades\Redirect;

class RedirectPages
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
        if( $redirect = Model::where('source_url', $request->path() )->first() )
            return Redirect::to( $redirect->redirect_url,  $redirect->type ); 
      
        return $next($request);
    }

}
