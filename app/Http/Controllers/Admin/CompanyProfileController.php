<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyProfileController extends Controller
{
    public function edit(): View
    {
        $profile = CompanyProfile::query()->firstOrCreate(
            ['id' => 1],
            [
                'company_name' => 'CV. Merah Putih',
                'tagline' => 'Solusi Transportasi & Rental Mobil Terpercaya di Depok',
                'description' => '',
                'address' => 'Jalan Jati No. 23, Depok, Jawa Barat 16411',
                'phone' => '0812-8899-2323',
                'whatsapp' => '6281288992323',
                'email' => 'info@cvmerahputih-rental.co.id',
                'operating_hours' => 'Senin - Minggu: 07.00 - 22.00 WIB',
                'vision' => '',
                'missions' => [],
                'maps_url' => 'https://maps.google.com/?q=Jalan+Jati+No.+23+Depok+Jawa+Barat+16411',
                'logo_url' => '',
                'hero_image_url' => '/images/hero-garage.jpg',
                'about_image_url' => '/images/hero-garage.jpg',
            ]
        );

        return view('admin.profile.edit', [
            'profile' => $profile,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $profile = CompanyProfile::query()->findOrFail(1);

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'min:2', 'max:150'],
            'tagline' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'address' => ['required', 'string', 'min:5', 'max:255'],
            'phone' => ['required', 'string', 'min:6', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:160'],
            'operating_hours' => ['required', 'string', 'min:4', 'max:180'],
            'vision' => ['required', 'string', 'min:10'],
            'missions' => ['nullable'],
            'maps_url' => ['nullable', 'url:http,https', 'max:500'],
            'logo_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'hero_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'about_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ], [
            'company_name.required' => 'Nama perusahaan wajib diisi.',
            'address.required' => 'Alamat perusahaan wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'email.email' => 'Format email perusahaan tidak valid.',
            'maps_url.url' => 'URL Google Maps harus diawali http:// atau https://.',
            'logo_file.image' => 'Logo harus berupa file gambar.',
            'logo_file.mimes' => 'Format logo hanya mendukung JPG, PNG, atau WebP.',
            'logo_file.max' => 'Ukuran file logo maksimal 5 MB.',
            'hero_image_file.image' => 'Foto hero harus berupa file gambar.',
            'hero_image_file.mimes' => 'Format foto hero hanya mendukung JPG, PNG, atau WebP.',
            'hero_image_file.max' => 'Ukuran file foto hero maksimal 5 MB.',
            'about_image_file.image' => 'Foto profil harus berupa file gambar.',
            'about_image_file.mimes' => 'Format foto profil hanya mendukung JPG, PNG, atau WebP.',
            'about_image_file.max' => 'Ukuran file foto profil maksimal 5 MB.',
        ]);

        // 1. Kelola Upload / Hapus Logo Perusahaan
        $logoUrl = (string) ($profile->logo_url ?? '');
        if ($request->boolean('remove_logo')) {
            $this->deleteStoredFileIfLocal($logoUrl);
            $logoUrl = '';
        }
        if ($request->hasFile('logo_file')) {
            $this->deleteStoredFileIfLocal($logoUrl);
            $path = $request->file('logo_file')->store('company', 'public');
            $logoUrl = '/storage/' . $path;
        }

        // 2. Kelola Upload / Reset Foto Hero Beranda
        $heroImageUrl = (string) ($profile->hero_image_url ?: '/images/hero-garage.jpg');
        if ($request->boolean('reset_hero_image')) {
            $this->deleteStoredFileIfLocal($heroImageUrl);
            $heroImageUrl = '/images/hero-garage.jpg';
        }
        if ($request->hasFile('hero_image_file')) {
            $this->deleteStoredFileIfLocal($heroImageUrl);
            $path = $request->file('hero_image_file')->store('company', 'public');
            $heroImageUrl = '/storage/' . $path;
        }

        // 3. Kelola Upload / Reset Foto Halaman Tentang Kami
        $aboutImageUrl = (string) ($profile->about_image_url ?: '/images/hero-garage.jpg');
        if ($request->boolean('reset_about_image')) {
            $this->deleteStoredFileIfLocal($aboutImageUrl);
            $aboutImageUrl = '/images/hero-garage.jpg';
        }
        if ($request->hasFile('about_image_file')) {
            $this->deleteStoredFileIfLocal($aboutImageUrl);
            $path = $request->file('about_image_file')->store('company', 'public');
            $aboutImageUrl = '/storage/' . $path;
        }

        $missions = $this->parseMissions($request->input('missions'));

        $profile->update([
            'updated_by' => Auth::id(),
            'company_name' => trim($validated['company_name']),
            'tagline' => trim($validated['tagline']),
            'description' => trim($validated['description']),
            'address' => trim($validated['address']),
            'phone' => trim($validated['phone']),
            'whatsapp' => $this->normalizeWhatsApp($validated['whatsapp'] ?? $validated['phone']),
            'email' => trim($validated['email']),
            'operating_hours' => trim($validated['operating_hours']),
            'vision' => trim($validated['vision']),
            'missions' => $missions,
            'maps_url' => trim((string) ($validated['maps_url'] ?? '')),
            'logo_url' => $logoUrl,
            'hero_image_url' => $heroImageUrl,
            'about_image_url' => $aboutImageUrl,
        ]);

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profil perusahaan beserta logo dan aset gambar berhasil diperbarui.');
    }

    private function parseMissions(mixed $input): array
    {
        if (is_array($input)) {
            $items = $input;
        } else {
            $items = preg_split('/\r\n|\r|\n/', (string) $input) ?: [];
        }

        return collect($items)
            ->map(fn ($item) => trim((string) $item))
            ->filter(fn ($item) => $item !== '')
            ->take(12)
            ->values()
            ->all();
    }

    private function normalizeWhatsApp(string $raw): string
    {
        $digits = preg_replace('/\D+/', '', $raw) ?? '';
        if ($digits === '') {
            return '6281288992323';
        }
        if (str_starts_with($digits, '0')) {
            return '62' . substr($digits, 1);
        }
        if (str_starts_with($digits, '62')) {
            return $digits;
        }

        return '62' . $digits;
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