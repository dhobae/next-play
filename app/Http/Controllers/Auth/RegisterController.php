<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationOtpMail;
use App\Models\PendingRegistration;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/admin/beranda';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $code = (string) random_int(100000, 999999);

        PendingRegistration::updateOrCreate(
            ['email' => $request->email],
            [
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'otp' => Hash::make($code),
                'expires_at' => Carbon::now()->addMinutes(10),
                'attempts' => 0,
            ]
        );

        Mail::to($request->email)->send(new RegistrationOtpMail($code));

        session(['registration.email' => $request->email]);

        return redirect()->route('register.verify')
            ->with('status', 'Kode verifikasi telah dikirim ke email Anda.');
    }

    public function showVerificationForm()
    {
        abort_unless(session()->has('registration.email'), 404);

        return view('auth.verify-registration', [
            'email' => session('registration.email'),
        ]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'digits:6'],
        ]);

        $pending = PendingRegistration::where('email', session('registration.email'))->first();

        if (!$pending) {
            return redirect()->route('register')->withErrors([
                'email' => 'Sesi registrasi tidak ditemukan. Silakan daftar kembali.',
            ]);
        }

        if ($pending->expires_at->isPast()) {
            $pending->delete();

            return back()->withErrors(['code' => 'Kode OTP sudah kedaluwarsa. Silakan daftar kembali.']);
        }

        if ($pending->attempts >= 5) {
            return back()->withErrors(['code' => 'Batas percobaan OTP sudah tercapai. Silakan daftar kembali.']);
        }

        if (!Hash::check($request->code, $pending->otp)) {
            $pending->increment('attempts');

            return back()->withErrors(['code' => 'Kode OTP tidak valid.']);
        }

        $user = User::create([
            'name' => $pending->name,
            'email' => $pending->email,
            'password' => $pending->password,
        ]);

        $pending->delete();
        session()->forget('registration.email');
        Auth::login($user);

        return redirect($this->redirectPath());
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
