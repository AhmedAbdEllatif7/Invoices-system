<?php

namespace App\Providers;

use App\Interfaces\Invoices\InvoiceRepositoryInterface;
use App\Repositories\Invoices\InvoiceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(InvoiceRepositoryInterface::class , InvoiceRepository::class);

    }
}
