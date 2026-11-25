<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CompanyProfile;
use App\Models\Service;
use App\Models\TermsSection;
use App\Models\Vehicle;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::query()
            ->orderByDesc('featured')
            ->orderBy('id')
            ->get();

        $totalVehicles = $vehicles->count();
        $availableVehicles = $vehicles->where('status', 'tersedia')->count();
        $rentedVehicles = $totalVehicles - $availableVehicles;

        $totalArticles = Article::query()->count();
        $publishedArticles = Article::query()->where('status', 'published')->count();
        $totalServices = Service::query()->count();

        $termsSections = TermsSection::query()->get();
        $totalTermsClauses = $termsSections->sum(function (TermsSection $section): int {
            return is_array($section->items) ? count($section->items) : 0;
        });

        $profile = CompanyProfile::query()->first();

        return view('admin.dashboard', [
            'profile' => $profile,
            'vehicles' => $vehicles,
            'stats' => [
                'totalVehicles' => $totalVehicles,
                'availableVehicles' => $availableVehicles,
                'rentedVehicles' => $rentedVehicles,
                'publishedArticles' => $publishedArticles,
                'totalArticles' => $totalArticles,
                'totalServices' => $totalServices,
                'totalTermsClauses' => $totalTermsClauses,
            ],
        ]);
    }
}