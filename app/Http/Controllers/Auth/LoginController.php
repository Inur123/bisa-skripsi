<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login identifier to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'nim';  // Use NIM as the login identifier
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin( $request)
    {
        $request->validate(
            [
                'nim' => ['required', 'numeric', 'exists:users,nim'],
                'password' => ['required', 'string', 'min:8'], // Validasi untuk password
                'g-recaptcha-response' => ['required'],
            ],
            [
                'nim.required' => 'NIM harus diisi.',
                'nim.numeric' => 'NIM harus berupa angka.',
                'nim.exists' => 'NIM tidak ditemukan.',
                'password.required' => 'Password wajib diisi.',
                'password.min' => 'Password harus memiliki minimal 8 karakter.',
                'g-recaptcha-response.required' => 'Captcha wajib diisi.',
            ]
        );

        // Verifikasi reCAPTCHA
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        $recaptchaData = $response->json();

        if (!$recaptchaData['success']) {
            return redirect()->back()
                ->withErrors(['g-recaptcha-response' => 'Verifikasi Captcha gagal. Silakan coba lagi.'])
                ->withInput();
        }
    }

}
