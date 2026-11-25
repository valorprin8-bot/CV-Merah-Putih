<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function edit(): View
    {
        return view('admin.account.edit', [
            'admin' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:120'],
            'email' => [
                'required',
                'string',
                'email',
                'max:160',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'current_password' => ['nullable', 'required_with:new_password', 'string'],
            'new_password' => ['nullable', 'confirmed', Password::min(8)],
        ], [
            'name.required' => 'Nama administrator wajib diisi.',
            'email.required' => 'Email login wajib diisi.',
            'email.unique' => 'Email tersebut sudah digunakan oleh akun lain.',
            'current_password.required_with' => 'Masukkan kata sandi saat ini untuk mengganti kata sandi.',
            'new_password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
            'new_password.min' => 'Kata sandi baru minimal 8 karakter.',
        ]);

        if (! empty($validated['new_password'])) {
            if (! Hash::check((string) $validated['current_password'], $user->password)) {
                return back()
                    ->withInput($request->only('name', 'email'))
                    ->with('error', 'Kata sandi saat ini tidak sesuai.');
            }

            $user->password = $validated['new_password'];
        }

        $user->name = trim($validated['name']);
        $user->email = Str::lower(trim($validated['email']));
        $user->save();

        return redirect()
            ->route('admin.account.edit')
            ->with('success', 'Data akun administrator berhasil diperbarui.');
    }
}