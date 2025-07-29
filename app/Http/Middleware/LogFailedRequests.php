<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Activitylog\Models\Activity;

class LogFailedRequests
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        $status = $response->getStatusCode();

        if ($status !== 200) {
            $message = $this->extractMessage($response, $status);

            activity()
                ->causedBy(auth()->check() ? auth()->user() : null)
                ->withProperties([
                    'method' => $request->method(),
                    'url' => $request->fullUrl(),
                    'status' => $status,
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                ])
                ->log("Non-200 Response [$status]: $message");
        }

        return $response;
    }

    protected function extractMessage(Response $response, int $status): string
    {
        $content = $response->getContent();

        if ($this->isJson($content)) {
            $decoded = json_decode($content, true);
            return $decoded['message'] ?? json_encode($decoded);
        }

        // Default fallback: known messages for common codes
        return match ($status) {
            401 => 'Unauthorized',
            403 => 'Forbidden',
            422 => 'Validation Error',
            500 => 'Internal Server Error',
            default => "Unexpected Error",
        };
    }

    protected function isJson($string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
