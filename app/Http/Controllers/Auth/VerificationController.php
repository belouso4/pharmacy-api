<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

//use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verify(Request $request, User $user)
    {
       if (! URL::hasValidSignature($request)) {
           return response()->json(["errors" => [
               "message" => "Недействительная ссылка на подтверждение"
           ]], 422);

       }

        if ($user->hasVerifiedEmail()) {
            return response()->json(["errors" => [
                "message" => "Адрес электронной почты уже подтвержден"
            ]], 422);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return response()->json(["message" => "Электронная почта успешно подтверждена"], 200);
    }

    public function resend(Request $request)
    {
        dd('asdasda');

        $this->validate($request, [
            'email' => ['email', 'required']
        ]);

        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return response()->json(["errors" => [
                "message" => "Не удалось найти пользователя с этим адресом электронной почты"
            ]], 422);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json(["errors" => [
                "message" => "Адрес электронной почты уже подтвержден"
            ]], 422);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(["status" => "Ссылка для подтверждения отправлена​повторно"]);
    }
}
