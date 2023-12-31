<?php

namespace App\Providers;

use App\Interfaces\IUserRepository;
use App\Repositories\UserRepository;
use App\Interfaces\IProductRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ITransactionRepository;
use App\Repositories\TransactionRepository;
use App\Interfaces\ITransactionDetailRepository;
use App\Repositories\TransactionDetailRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(ITransactionDetailRepository::class, TransactionDetailRepository::class);
        $this->app->bind(ITransactionRepository::class, TransactionRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
