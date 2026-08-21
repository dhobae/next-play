<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (!$request->is('admin*') && $request->isMethod('GET') && !$request->expectsJson()) {
            $visitorId = $request->cookie('site_visitor_id') ?: (string) Str::uuid();

            Visitor::updateOrCreate(
                ['visitor_id' => $visitorId],
                ['last_seen_at' => now()]
            );

            if (!$request->cookie('site_visitor_id')) {
                $response->withCookie(cookie('site_visitor_id', $visitorId, 60 * 24 * 365));
            }
        }

        return $response;
    }
}