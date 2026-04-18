<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\ErrorReport;
use App\Models\FeatureRequest;
use App\Models\Ticket;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Relations\Relation;

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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        RateLimiter::for('api', function () {
            return Limit::perMinute(60);
        });

        Relation::morphMap([
            'ticket' => Ticket::class,
            'error_report' => ErrorReport::class,
            'feature_request' => FeatureRequest::class,
            'comment' => Comment::class
        ]);
    }
}
