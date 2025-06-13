<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Override method untuk menampilkan pesan sukses setelah reset password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */

    protected function sendResetResponse(Request $request, $response)
    {
        return redirect($this->redirectTo)
            ->with('status', trans($response));
    }

    protected function resetPassword($user, $password)
{
    $user->password = bcrypt($password);
    $user->setRememberToken(Str::random(60));
    $user->save();

    event(new PasswordReset($user));
    // Tidak memanggil $this->guard()->login($user);
}
protected function showResetForm(Request $request, $token = null)
{
    if (!$token) {
        return redirect()->route('password.request')->with('error', 'Token tidak valid atau sudah kadaluarsa.');
    }
    return view('auth.passwords.reset')->with(
        ['token' => $token, 'email' => $request->email]
    );
}

}
