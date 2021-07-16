<?php

namespace App\Providers;

use App\Services\Auth\AuthService;
use App\Services\Auth\IAuthService;
use App\Services\Encryption\EncryptionService;
use App\Services\Encryption\IEncryptionService;
use Illuminate\Support\ServiceProvider;
use App\Services\Responses\IResponseService;
use App\Services\Responses\ResponseService;
use App\Services\ThirdParty\SocialMedia\Github\IGithubService;
use App\Services\ThirdParty\SocialMedia\Github\GithubService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(IEncryptionService::class, EncryptionService::class);
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->singleton(IResponseService::class, ResponseService::class);
        $this->app->singleton(IGithubService::class, GithubService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
