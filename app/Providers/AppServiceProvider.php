<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Override mail configuration from database if settings table exists
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                $settings = \App\Models\Setting::where('key', 'like', 'mail_%')->pluck('value', 'key');
                
                if ($settings->isNotEmpty()) {
                    config([
                        'mail.default' => 'smtp', // Force use SMTP if configured
                        'mail.mailers.smtp.host' => $settings->get('mail_host') ?? config('mail.mailers.smtp.host'),
                        'mail.mailers.smtp.port' => $settings->get('mail_port') ?? config('mail.mailers.smtp.port'),
                        'mail.mailers.smtp.username' => $settings->get('mail_username') ?? config('mail.mailers.smtp.username'),
                        'mail.mailers.smtp.password' => $settings->get('mail_password') ?? config('mail.mailers.smtp.password'),
                        'mail.mailers.smtp.encryption' => $settings->get('mail_encryption') ?? config('mail.mailers.smtp.encryption'),
                        'mail.from.address' => $settings->get('mail_from_address') ?? config('mail.from.address'),
                        'mail.from.name' => $settings->get('mail_from_name') ?? config('mail.from.name'),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Avoid breaking artisan commands during migration or if DB is down
        }
    }
}
