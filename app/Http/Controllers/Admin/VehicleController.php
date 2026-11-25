<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function index(): View
    {
        $vehicles = Vehicle::query()
            ->orderByDesc('featured')
            ->orderBy('id')
            ->get();

        return view('admin.vehicles.index', [
            'vehicles' => $vehicles,
        ]);
    }

    public function create(): View
    {
        return view('admin.vehicles.form', [
            'vehicle' => new Vehicle([
                'transmission' => 'Matic',
                'seats' => 7,
                'year' => (int) date('Y'),
                'fuel' => 'Bensin',
                'engine' => '1.5L Dual VVT-i',
                'price_per_day' => 450000,
                'status' => 'tersedia',
                'image_url' => '/images/car-avanza-veloz.jpg',
                'features' => [],
                'featured' => false,
            ]),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateVehicle($request, true);

        $imageUrl = '/images/car-avanza-veloz.jpg';
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('vehicles', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif (! empty($validated['image_url'])) {
            $imageUrl = $validated['image_url'];
        }

        $vehicle = Vehicle::create([
            'created_by' => Auth::id(),
            'name' => trim($validated['name']),
            'category' => trim($validated['category']),
            'transmission' => $validated['transmission'],
            'seats' => (int) $validated['seats'],
            'year' => (int) $validated['year'],
            'fuel' => trim($validated['fuel'] ?? 'Bensin') ?: 'Bensin',
            'engine' => trim($validated['engine'] ?? '1.5L Dual VVT-i') ?: '1.5L Dual VVT-i',
            'price_per_day' => (int) $validated['price_per_day'],
            'status' => $validated['status'],
            'image_url' => $imageUrl,
            'description' => trim((string) ($validated['description'] ?? '')),
            'features' => $this->parseLinesOrCommas($request->input('features')),
            'featured' => $request->boolean('featured'),
        ]);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', "Unit {$vehicle->name} berhasil ditambahkan ke katalog.");
    }

    public function edit(Vehicle $vehicle): View
    {
        return view('admin.vehicles.form', [
            'vehicle' => $vehicle,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $validated = $this->validateVehicle($request, false);

        $imageUrl = $vehicle->image_url;
        if ($request->hasFile('image')) {
            $this->deleteStoredFileIfLocal($vehicle->image_url);
            $path = $request->file('image')->store('vehicles', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif (! empty($validated['image_url']) && $validated['image_url'] !== $vehicle->image_url) {
            $this->deleteStoredFileIfLocal($vehicle->image_url);
            $imageUrl = $validated['image_url'];
        }

        $vehicle->update([
            'name' => trim($validated['name']),
            'category' => trim($validated['category']),
            'transmission' => $validated['transmission'],
            'seats' => (int) $validated['seats'],
            'year' => (int) $validated['year'],
            'fuel' => trim($validated['fuel'] ?? 'Bensin') ?: 'Bensin',
            'engine' => trim($validated['engine'] ?? '1.5L Dual VVT-i') ?: '1.5L Dual VVT-i',
            'price_per_day' => (int) $validated['price_per_day'],
            'status' => $validated['status'],
            'image_url' => $imageUrl,
            'description' => trim((string) ($validated['description'] ?? '')),
            'features' => $this->parseLinesOrCommas($request->input('features')),
            'featured' => $request->boolean('featured'),
        ]);

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', "Data kendaraan {$vehicle->name} berhasil diperbarui.");
    }

    public function toggleStatus(Vehicle $vehicle): RedirectResponse
    {
        $nextStatus = $vehicle->status === 'tersedia' ? 'disewa' : 'tersedia';
        $vehicle->update(['status' => $nextStatus]);

        $label = $nextStatus === 'tersedia' ? 'Tersedia' : 'Sedang Disewa';

        return back()->with('success', "Status {$vehicle->name} diubah menjadi {$label}.");
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        $name = $vehicle->name;
        $this->deleteStoredFileIfLocal($vehicle->image_url);
        $vehicle->delete();

        return redirect()
            ->route('admin.vehicles.index')
            ->with('success', "Unit {$name} berhasil dihapus dari katalog.");
    }

    private function validateVehicle(Request $request, bool $isCreate): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:120'],
            'category' => ['required', 'string', 'min:2', 'max:60'],
            'transmission' => ['required', Rule::in(['Matic', 'Manual'])],
            'seats' => ['required', 'integer', 'min:2', 'max:60'],
            'year' => ['required', 'integer', 'min:2005', 'max:2030'],
            'fuel' => ['nullable', 'string', 'max:50'],
            'engine' => ['nullable', 'string', 'max:100'],
            'price_per_day' => ['required', 'integer', 'min:50000', 'max:50000000'],
            'status' => ['required', Rule::in(['tersedia', 'disewa'])],
            'image' => [$isCreate ? 'nullable' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image_url' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string', 'max:5000'],
            'features' => ['nullable'],
            'featured' => ['nullable', 'boolean'],
        ], [
            'name.required' => 'Nama kendaraan wajib diisi.',
            'name.min' => 'Nama kendaraan minimal 3 karakter.',
            'category.required' => 'Kategori kendaraan wajib diisi.',
            'transmission.in' => 'Transmisi harus Matic atau Manual.',
            'seats.integer' => 'Kapasitas kursi harus berupa angka.',
            'price_per_day.min' => 'Tarif sewa per hari minimal Rp 50.000.',
            'image.image' => 'File foto kendaraan harus berupa gambar.',
            'image.mimes' => 'Format foto kendaraan hanya mendukung JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran foto kendaraan maksimal 5 MB.',
        ]);
    }

    private function parseLinesOrCommas(mixed $input): array
    {
        if (is_array($input)) {
            $items = $input;
        } else {
            $items = preg_split('/\r\n|\r|\n|,/', (string) $input) ?: [];
        }

        return collect($items)
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => $item !== '')
            ->take(20)
            ->values()
            ->all();
    }

    private function deleteStoredFileIfLocal(?string $url): void
    {
        if (! $url || ! str_starts_with($url, '/storage/')) {
            return;
        }

        $relativePath = substr($url, strlen('/storage/'));
        if ($relativePath !== '' && Storage::disk('public')->exists($relativePath)) {
            Storage::disk('public')->delete($relativePath);
        }
    }
}