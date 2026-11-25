<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\TermsSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ServiceController extends Controller
{
    private const ALLOWED_ICONS = [
        'UserCheck',
        'KeyRound',
        'Plane',
        'Building2',
        'Car',
        'ShieldCheck',
        'MapPin',
        'Clock',
        'HeartHandshake',
        'Briefcase',
    ];

    public function index(): View
    {
        $services = Service::query()->ordered()->get();
        $termsSections = TermsSection::query()->ordered()->get();

        return view('admin.services.index', [
            'services' => $services,
            'termsSections' => $termsSections,
            'allowedIcons' => self::ALLOWED_ICONS,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateService($request);
        $highlights = $this->parseLines($request->input('highlights'));

        if (count($highlights) === 0) {
            return back()
                ->withInput()
                ->with('error', 'Minimal masukkan 1 poin keunggulan layanan.');
        }

        $nextOrder = (int) $validated['sort_order'];
        if ($nextOrder <= 0) {
            $nextOrder = ((int) Service::query()->max('sort_order')) + 1;
        }

        $service = Service::create([
            'created_by' => Auth::id(),
            'title' => trim($validated['title']),
            'subtitle' => trim($validated['subtitle']),
            'icon' => $validated['icon'],
            'description' => trim($validated['description']),
            'highlights' => $highlights,
            'sort_order' => $nextOrder,
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Paket layanan \"{$service->title}\" berhasil ditambahkan.");
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->validateService($request);
        $highlights = $this->parseLines($request->input('highlights'));

        if (count($highlights) === 0) {
            return back()
                ->withInput()
                ->with('error', 'Minimal masukkan 1 poin keunggulan layanan.');
        }

        $service->update([
            'title' => trim($validated['title']),
            'subtitle' => trim($validated['subtitle']),
            'icon' => $validated['icon'],
            'description' => trim($validated['description']),
            'highlights' => $highlights,
            'sort_order' => (int) $validated['sort_order'],
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Paket layanan \"{$service->title}\" berhasil diperbarui.");
    }

    public function destroy(Service $service): RedirectResponse
    {
        $title = $service->title;
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Paket layanan \"{$title}\" berhasil dihapus.");
    }

    public function updateTerms(Request $request): RedirectResponse
    {
        $rawSections = $request->input('sections', []);

        if (! is_array($rawSections) || count($rawSections) === 0) {
            return back()
                ->with('error', 'Minimal harus terdapat 1 kelompok Syarat & Ketentuan Umum.');
        }

        $cleanedSections = [];
        foreach (array_values($rawSections) as $index => $section) {
            $title = trim((string) ($section['title'] ?? ''));
            $items = $this->parseLines($section['items'] ?? '');
            $serviceId = ! empty($section['service_id']) ? (int) $section['service_id'] : null;

            if (mb_strlen($title) < 3) {
                $num = $index + 1;
                return back()
                    ->withInput()
                    ->with('error', "Judul bagian ketentuan #{$num} minimal 3 karakter.");
            }

            if (count($items) === 0) {
                return back()
                    ->withInput()
                    ->with('error', "Bagian \"{$title}\" minimal harus memiliki 1 poin ketentuan.");
            }

            if ($serviceId !== null && ! Service::query()->whereKey($serviceId)->exists()) {
                $serviceId = null;
            }

            $cleanedSections[] = [
                'service_id' => $serviceId,
                'updated_by' => Auth::id(),
                'title' => $title,
                'items' => array_slice($items, 0, 20),
                'sort_order' => $index + 1,
            ];
        }

        DB::transaction(function () use ($cleanedSections): void {
            TermsSection::query()->delete();

            foreach ($cleanedSections as $row) {
                TermsSection::create($row);
            }
        });

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Syarat & Ketentuan Umum Penyewaan berhasil disimpan dan disinkronkan.');
    }

    private function validateService(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:160'],
            'subtitle' => ['required', 'string', 'min:2', 'max:120'],
            'icon' => ['required', Rule::in(self::ALLOWED_ICONS)],
            'description' => ['required', 'string', 'min:10', 'max:3000'],
            'highlights' => ['required'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
        ], [
            'title.required' => 'Judul paket layanan wajib diisi.',
            'title.min' => 'Judul paket layanan minimal 3 karakter.',
            'subtitle.required' => 'Label singkat layanan wajib diisi.',
            'description.min' => 'Deskripsi layanan minimal 10 karakter.',
            'highlights.required' => 'Keunggulan layanan wajib diisi.',
        ]);
    }

    private function parseLines(mixed $input): array
    {
        if (is_array($input)) {
            $lines = $input;
        } else {
            $lines = preg_split('/\r\n|\r|\n/', (string) $input) ?: [];
        }

        return collect($lines)
            ->map(fn ($line) => trim((string) $line))
            ->filter(fn ($line) => $line !== '')
            ->take(20)
            ->values()
            ->all();
    }
}