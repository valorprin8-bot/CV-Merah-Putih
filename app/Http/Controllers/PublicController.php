<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\CompanyProfile;
use App\Models\Service;
use App\Models\TermsSection;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        $profile = $this->getProfile();

        $allVehicles = Vehicle::query()
            ->orderByDesc('featured')
            ->orderBy('id')
            ->get();

        $featuredVehicles = $allVehicles->take(4);
        $availableCount = $allVehicles->where('status', 'tersedia')->count();
        $lowestPrice = $allVehicles->min('price_per_day') ?? 350000;

        $services = Service::query()->ordered()->get();
        $latestArticles = Article::query()->published()->take(3)->get();

        return view('public.home', [
            'profile' => $profile,
            'vehicles' => $allVehicles,
            'featuredVehicles' => $featuredVehicles,
            'availableCount' => $availableCount,
            'lowestPrice' => $lowestPrice,
            'services' => $services,
            'latestArticles' => $latestArticles,
        ]);
    }

    public function vehicles(Request $request): View
    {
        $profile = $this->getProfile();

        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', 'all');
        $transmission = (string) $request->query('transmission', 'all');

        $query = Vehicle::query()
            ->orderByDesc('featured')
            ->orderBy('id');

        if (in_array($status, ['tersedia', 'disewa'], true)) {
            $query->where('status', $status);
        } else {
            $status = 'all';
        }

        if (in_array($transmission, ['Matic', 'Manual'], true)) {
            $query->where('transmission', $transmission);
        } else {
            $transmission = 'all';
        }

        if ($search !== '') {
            $query->where(function ($subQuery) use ($search): void {
                $subQuery
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('transmission', 'like', "%{$search}%")
                    ->orWhere('year', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $vehicles = $query->get();

        return view('public.vehicles.index', [
            'profile' => $profile,
            'vehicles' => $vehicles,
            'filters' => [
                'q' => $search,
                'status' => $status,
                'transmission' => $transmission,
            ],
            'totalAllVehicles' => Vehicle::query()->count(),
        ]);
    }

    public function vehicleShow(Vehicle $vehicle): View
    {
        $profile = $this->getProfile();

        $otherVehicles = Vehicle::query()
            ->where('id', '!=', $vehicle->id)
            ->orderByDesc('featured')
            ->orderBy('id')
            ->take(3)
            ->get();

        return view('public.vehicles.show', [
            'profile' => $profile,
            'vehicle' => $vehicle,
            'otherVehicles' => $otherVehicles,
        ]);
    }

    public function services(): View
    {
        $profile = $this->getProfile();
        $services = Service::query()->ordered()->get();
        $termsSections = TermsSection::query()->ordered()->get();

        return view('public.services', [
            'profile' => $profile,
            'services' => $services,
            'termsSections' => $termsSections,
        ]);
    }

    public function blog(Request $request): View
    {
        $profile = $this->getProfile();

        $search = trim((string) $request->query('q', ''));
        $category = trim((string) $request->query('category', 'all'));

        $categories = Article::query()
            ->where('status', 'published')
            ->select('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $query = Article::query()->published();

        if ($category !== '' && $category !== 'all') {
            $query->where('category', $category);
        } else {
            $category = 'all';
        }

        if ($search !== '') {
            $query->where(function ($subQuery) use ($search): void {
                $subQuery
                    ->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->get();

        return view('public.blog.index', [
            'profile' => $profile,
            'articles' => $articles,
            'categories' => $categories,
            'filters' => [
                'q' => $search,
                'category' => $category,
            ],
        ]);
    }

    public function articleShow(Article $article): View
    {
        if ($article->status !== 'published') {
            abort(404);
        }

        $profile = $this->getProfile();

        $relatedArticles = Article::query()
            ->published()
            ->where('id', '!=', $article->id)
            ->take(3)
            ->get();

        return view('public.blog.show', [
            'profile' => $profile,
            'article' => $article,
            'relatedArticles' => $relatedArticles,
        ]);
    }

    public function about(): View
    {
        $profile = $this->getProfile();

        return view('public.about', [
            'profile' => $profile,
        ]);
    }

    private function getProfile(): CompanyProfile
    {
        return CompanyProfile::query()->firstOrCreate(
            ['id' => 1],
            [
                'company_name' => 'CV. Merah Putih',
                'tagline' => 'Solusi Transportasi & Rental Mobil Terpercaya di Depok',
                'description' => 'CV. Merah Putih adalah perusahaan penyedia jasa sewa dan rental kendaraan roda empat yang berpusat di Jalan Jati No. 23, Depok.',
                'address' => 'Jalan Jati No. 23, Depok, Jawa Barat 16411',
                'phone' => '0812-8899-2323',
                'whatsapp' => '6281288992323',
                'email' => 'info@cvmerahputih-rental.co.id',
                'operating_hours' => 'Senin - Minggu: 07.00 - 22.00 WIB (Layanan Darurat 24 Jam)',
                'vision' => 'Menjadi perusahaan jasa rental mobil terdepan di Kota Depok dan Jabodetabek.',
                'missions' => [],
                'maps_url' => 'https://maps.google.com/?q=Jalan+Jati+No.+23+Depok+Jawa+Barat+16411',
                'logo_url' => '',
                'hero_image_url' => '/images/hero-garage.jpg',
                'about_image_url' => '/images/hero-garage.jpg',
            ]
        );
    }
}