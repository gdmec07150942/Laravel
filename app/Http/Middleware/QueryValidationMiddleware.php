<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class QueryValidationMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sql = $request->input('sql');

        // Extract the query type (SELECT, INSERT, UPDATE, DELETE, etc.)
        $queryType = strtoupper(substr(trim($sql), 0, 6));

        if ($queryType !== 'SELECT') {
            // Return response with alert if the query is not SELECT
            return response()->json([
                'message' => 'Only SELECT queries are allowed.'
            ], 403); // HTTP 403 Forbidden status
        }

        return $next($request);
    }
}
