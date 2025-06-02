<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        $currentPath = $request->path();

        Log::info('----------------------------------------------------');
        Log::info('AUTHENTICATE: Attempting redirection.');
        Log::info('Current Path for redirection check: [' . $currentPath . ']');

        $isExactAdminPath = $request->is('admin');
        Log::info('Check $request->is(\'admin\'): [' . ($isExactAdminPath ? 'TRUE' : 'FALSE') . ']');

        $isAdminSubPath = $request->is('admin/*');
        Log::info('Check $request->is(\'admin/*\'): [' . ($isAdminSubPath ? 'TRUE' : 'FALSE') . ']');

        $pathStartsWithAdminSlash = Str::startsWith($currentPath, 'admin/');
        Log::info('Check Str::startsWith($currentPath, \'admin/\'): [' . ($pathStartsWithAdminSlash ? 'TRUE' : 'FALSE') . ']');

        $pathIsExactlyAdmin = ($currentPath === 'admin');
        Log::info('Check $currentPath === \'admin\': [' . ($pathIsExactlyAdmin ? 'TRUE' : 'FALSE') . ']');

        if (! $request->expectsJson()) {
            if ($pathIsExactlyAdmin || $pathStartsWithAdminSlash) {
                Log::info('Redirecting to route: admin.login');
                Log::info('----------------------------------------------------');
                return route('admin.login'); // pastikan route ini ada
            }

            Log::info('Redirecting to route: login (default user)');
            Log::info('----------------------------------------------------');
            return route('login'); // pastikan route('login') mengarah ke login pengguna
        }

        Log::info('Request expects JSON, no redirection performed.');
        Log::info('----------------------------------------------------');
        return null;
    }
}
