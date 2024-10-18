<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        //--------------------------------------------
        // O Fortify permite que você determine qual será a sua página (view) de login com a função abaixo.
        // Toda vez que for acessado a rota de login, o Fortify será o responsável por chamar essa função automaticamente.
        // Essa função também é chamada quando for definido o middleware auth, que identificará se o usuário não está autenticado
        // Se o usuário não estiver autenticado, o Fortify então chamará essa função automaticamente.
        //--------------------------------------------
        Fortify::loginView(function () {
            return view('auth.login');
        });

        //--------------------------------------------
        // O Fortify permite que você determine qual será a sua página (view) de register (registro de novo usuário) com a função abaixo.
        // Devemos especificar a função abaixo para determinar qual será a view a ser chamada para registrar novos usuários
        //--------------------------------------------
        Fortify::registerView(function () {
            return view('auth.register');
        });

        //--------------------------------------------
        // O Fortify permite que você determine qual será a sua página (view) de forgot-password (Esqueci minha senha) com a função abaixo.
        // Devemos especificara view a ser chamada para recadastrar senha de usuário
        //--------------------------------------------
        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.forgot-password');
        });

        //--------------------------------------------
        // Função que será chamada quando o usuário utilizar o recurso (esqueci minha senha) e receber o link no e-mail para resetar a senha
        // Quando o usuário clicar no link, essa função será acionada e ele será redirecionado para uma nova página (view) para registrar a nova senha
        // Essa função precisa receber o $request como argumento e passar para a view esse request, para saber quem é o usuário que está solicitando essa nova senha
        //--------------------------------------------
        Fortify::resetPasswordView(function ($request) {
            return view('auth.reset-password', ['request' => $request]);
        });
    }
}
