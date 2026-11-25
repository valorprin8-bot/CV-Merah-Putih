<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.articles.index', [
            'articles' => $articles,
        ]);
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'article' => new Article([
                'category' => 'Promo Spesial',
                'published_at' => now()->toDateString(),
                'author' => Auth::user()?->name ?? 'Tim CV. Merah Putih',
                'status' => 'published',
                'image_url' => '/images/blog-puncak-trip.jpg',
            ]),
            'isEdit' => false,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateArticle($request);

        $imageUrl = '/images/blog-puncak-trip.jpg';
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif (! empty($validated['image_url'])) {
            $imageUrl = $validated['image_url'];
        }

        $article = Article::create([
            'admin_id' => Auth::id(),
            'title' => trim($validated['title']),
            'category' => trim($validated['category']),
            'excerpt' => trim($validated['excerpt']),
            'content' => trim($validated['content']),
            'image_url' => $imageUrl,
            'published_at' => $validated['published_at'],
            'author' => trim($validated['author'] ?? 'Tim CV. Merah Putih') ?: 'Tim CV. Merah Putih',
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Artikel \"{$article->title}\" berhasil dipublikasikan.");
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', [
            'article' => $article,
            'isEdit' => true,
        ]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $validated = $this->validateArticle($request);

        $imageUrl = $article->image_url;
        if ($request->hasFile('image')) {
            $this->deleteStoredFileIfLocal($article->image_url);
            $path = $request->file('image')->store('articles', 'public');
            $imageUrl = '/storage/' . $path;
        } elseif (! empty($validated['image_url']) && $validated['image_url'] !== $article->image_url) {
            $this->deleteStoredFileIfLocal($article->image_url);
            $imageUrl = $validated['image_url'];
        }

        $article->update([
            'title' => trim($validated['title']),
            'category' => trim($validated['category']),
            'excerpt' => trim($validated['excerpt']),
            'content' => trim($validated['content']),
            'image_url' => $imageUrl,
            'published_at' => $validated['published_at'],
            'author' => trim($validated['author'] ?? 'Tim CV. Merah Putih') ?: 'Tim CV. Merah Putih',
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Artikel \"{$article->title}\" berhasil diperbarui.");
    }

    public function destroy(Article $article): RedirectResponse
    {
        $title = $article->title;
        $this->deleteStoredFileIfLocal($article->image_url);
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', "Artikel \"{$title}\" berhasil dihapus.");
    }

    private function validateArticle(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'min:5', 'max:180'],
            'category' => ['required', 'string', 'min:2', 'max:80'],
            'excerpt' => ['required', 'string', 'min:10', 'max:1000'],
            'content' => ['required', 'string', 'min:20'],
            'published_at' => ['required', 'date'],
            'author' => ['nullable', 'string', 'max:120'],
            'status' => ['required', Rule::in(['published', 'draft'])],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image_url' => ['nullable', 'string', 'max:500'],
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'title.min' => 'Judul artikel minimal 5 karakter.',
            'excerpt.min' => 'Ringkasan artikel minimal 10 karakter.',
            'content.min' => 'Isi artikel minimal 20 karakter.',
            'published_at.date' => 'Tanggal terbit tidak valid.',
            'image.image' => 'Cover artikel harus berupa file gambar.',
            'image.mimes' => 'Format gambar cover hanya mendukung JPG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar cover maksimal 5 MB.',
        ]);
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