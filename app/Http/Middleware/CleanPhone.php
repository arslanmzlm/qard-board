<?php

namespace App\Http\Middleware;

use App\Helpers\Mutators;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CleanPhone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $data = $request->all();

        $this->modifyNestedData($data, 'phone', function ($value) {
            return Mutators::cleanPhone($value);
        });

        $this->modifyNestedData($data, 'contact_phone', function ($value) {
            return Mutators::cleanPhone($value);
        });

        $request->merge($data);

        return $next($request);
    }

    /**
     * @param array $data
     * @param string $key
     * @param callable $callback
     * @return void
     */
    private function modifyNestedData(array &$data, string $key, callable $callback): void
    {
        foreach ($data as $arrayKey => &$value) {
            if (is_array($value)) {
                $this->modifyNestedData($value, $key, $callback);
            } elseif ($key === $arrayKey) {
                $value = $callback($value);
            }
        }
    }
}
