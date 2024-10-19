<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

     public function handle(Request $request, Closure $next): Response
     {
         // Handle preflight (OPTIONS) requests
         if ($request->getMethod() === "OPTIONS") {
             $response = response('', 200);
             $response->headers->set('Access-Control-Allow-Origin', '*');
             $response->headers->set('Access-Control-Allow-Methods', '*');
             $response->headers->set('Access-Control-Allow-Headers', '*');
             $response->headers->set('Access-Control-Allow-Credentials', 'true');
             
             // Log the preflight response
             Log::info('Preflight response: ', ['headers' => $response->headers->all()]);
             
             return $response;
         }
     
         // Handle the actual request
         $response = $next($request);
     
         // Add CORS headers to the response
         $response->headers->set('Access-Control-Allow-Origin', '*');
         $response->headers->set('Access-Control-Allow-Methods', '*');
         $response->headers->set('Access-Control-Allow-Headers', '*');
         $response->headers->set('Access-Control-Allow-Credentials', 'true');
     
         // Log the actual response
         Log::info('Actual response: ', [
             'status' => $response->getStatusCode(),
             'headers' => $response->headers->all(),
             'content' => $response->getContent(),
         ]);
     
         return $response;
     }


}
