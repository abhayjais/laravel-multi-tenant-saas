<?php

// app/Http/Middleware/EnsureCompanyIsSet.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCompanyIsSet
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->current_company_id) {
            return response()->json(['message' => 'Please set an active company first.'], 403);
        }
        return $next($request);
    }
}
