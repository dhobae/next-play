<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\EmailChangeOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $pendingEmailChange = Cache::get($this->emailChangeCacheKey());

        return view('admin.profile.index', [
            'user' => Auth::user(),
            'emailChangePending' => $pendingEmailChange !== null,
            'pendingEmail' => $pendingEmailChange['email'] ?? null,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $request->user()->update(['password' => $request->password]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    public function sendEmailOtp(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
        ]);

        $code = (string) random_int(100000, 999999);
        Cache::put($this->emailChangeCacheKey(), [
            'email' => $validated['email'],
            'otp' => Hash::make($code),
            'attempts' => 0,
        ], now()->addMinutes(10));

        Mail::to($validated['email'])->send(new EmailChangeOtpMail($code));

        return back()->with('success', 'Kode OTP telah dikirim ke email baru.');
    }

    public function verifyEmailOtp(Request $request)
    {
        $request->validate(['otp' => ['required', 'digits:6']]);

        $key = $this->emailChangeCacheKey();
        $pending = Cache::get($key);

        if (!$pending) {
            return back()->withErrors(['otp' => 'Kode OTP sudah kedaluwarsa. Kirim kode baru.']);
        }

        if ($pending['attempts'] >= 5) {
            Cache::forget($key);

            return back()->withErrors(['otp' => 'Batas percobaan OTP sudah tercapai. Kirim kode baru.']);
        }

        if (!Hash::check($request->otp, $pending['otp'])) {
            $pending['attempts']++;
            Cache::put($key, $pending, now()->addMinutes(10));

            return back()->withErrors(['otp' => 'Kode OTP tidak valid.']);
        }

        $request->user()->update(['email' => $pending['email']]);
        Cache::forget($key);

        return back()->with('success', 'Email berhasil diverifikasi dan diperbarui.');
    }

    private function emailChangeCacheKey(): string
    {
        return 'profile.email-change.' . Auth::id();
    }
}