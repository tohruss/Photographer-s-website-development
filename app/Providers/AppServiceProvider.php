<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\ResetPassword;

class AppServiceProvider extends ServiceProvider
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
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Подтвердите ваш email')
                ->line('Нажмите кнопку ниже, чтобы подтвердить ваш email.')
                ->action('Подтвердить email', $url);
        });

        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject('Сброс пароля')
                ->line('Вы получили это письмо, потому что мы получили запрос на сброс пароля для вашей учётной записи.')
                ->action('Сбросить пароль', $url)
                ->line('Если вы не запрашивали сброс пароля, просто проигнорируйте это письмо.');
        });
    }
}
