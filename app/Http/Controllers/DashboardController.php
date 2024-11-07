<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $counts = [
            'company' => Company::count(),
            'active_company' => Company::where('state', Company::STATE_ACTIVE)->count(),
            'passive_company' => Company::where('state', Company::STATE_PASSIVE)->count(),
            'created_company' => Company::where('state', Company::STATE_CREATED)->count(),
        ];

        return Inertia::render('Dashboard', [
            'counts' => $counts,
        ]);
    }
}
