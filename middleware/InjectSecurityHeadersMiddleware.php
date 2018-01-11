<?php

namespace Vannut\Security\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Response;

class InjectSecurityHeadersMiddleware
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

        $response = $next($request);

        if (!$response instanceof SymfonyResponse) {
            $response = new Response($response);
        }

        $cspHeaderName = 'Content-Security-Policy';
        $csp = [
            "default-src 'self';",
            "script-src 'self' code.jquery.com https://www.googletagmanager.com https://www.google-analytics.com  'nonce-123456';",
            "img-src 'self'  https://server.arcgisonline.com https://booot.be https://booot.vannut.net https://www.google-analytics.com ;",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com;",
            "font-src 'self' https://fonts.gstatic.com/;",
            "media-src 'self' https://booot.be;",
            "frame-src 'self' https://www.facebook.com http://nu.nl example.com;",
            "child-src 'self' https://www.facebook.com http://nu.nl example.com;",
            "report-uri /csp_report_parser;"
        ];

        $response->headers->set($cspHeaderName, implode(' ', $csp));
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        return $response;

    }
}
