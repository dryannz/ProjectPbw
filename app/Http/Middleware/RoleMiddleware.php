<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    private array $hrdAllowedRouteNames = [
        'dashboard',
        'barang.index',
        'customer.index',
        'petugas.index',
        'purchaseorder.index',
        'invoice.index',
        'suratjalan.index',
    ];

    private array $allowedRoles = ['admin', 'hrd'];
    private array $readOnlyRoles = ['hrd'];

    public function handle(Request $request, Closure $next): Response
    {
        $jabatan = strtolower(trim(auth()->user()->jabatan ?? ''));
        $isKnownRole = collect($this->allowedRoles)
            ->contains(fn($r) => str_contains($jabatan, $r));

        if (!$isKnownRole) {
            abort(403, 'Role Anda tidak memiliki akses ke sistem ini.');
        }

        $isReadOnly = collect($this->readOnlyRoles)
            ->contains(fn($r) => str_contains($jabatan, $r));

        if ($isReadOnly) {
            if (!in_array($request->method(), ['GET', 'HEAD'])) {
                abort(403, 'Anda hanya memiliki akses untuk melihat data.');
            }
            $currentRoute = $request->route()?->getName();
            if ($currentRoute && !in_array($currentRoute, $this->hrdAllowedRouteNames)) {
                abort(403, 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return $next($request);
    }
}
