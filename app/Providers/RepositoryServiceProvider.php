<?php

namespace App\Providers;

use App\Interfaces\Invoices\Archives\ArchiveRepositoryInterface;
use App\Interfaces\Invoices\Attachments\AttachmentRepositoryInterface;
use App\Interfaces\Invoices\InvoiceRepositoryInterface;
use App\Interfaces\Invoices\Reports\ReportRepositoryInterface;
use App\Interfaces\Products\ProductRepositoryInterface;
use App\Interfaces\Roles\RoleRepositoryInterface;
use App\Interfaces\Sections\SectionRepositoryInterface;
use App\Interfaces\Users\UserRepositoryInterface;
use App\Repositories\Invoices\Archives\ArchiveRepository;
use App\Repositories\Invoices\Attachments\AttachmentRepository;
use App\Repositories\Invoices\InvoiceRepository;
use App\Repositories\Invoices\Reports\ReportRepository;
use App\Repositories\Products\ProductRepository;
use App\Repositories\Roles\RoleRepository;
use Illuminate\Support\ServiceProvider;
use  App\Repositories\Sections\SectionRepository;
use App\Repositories\Users\UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->bind(InvoiceRepositoryInterface::class , InvoiceRepository::class);

        $this->app->bind(ArchiveRepositoryInterface::class , ArchiveRepository::class);

        $this->app->bind(AttachmentRepositoryInterface::class , AttachmentRepository::class);

        $this->app->bind(ReportRepositoryInterface::class , ReportRepository::class);
        
        $this->app->bind(ProductRepositoryInterface::class , ProductRepository::class);
        
        $this->app->bind(SectionRepositoryInterface::class , SectionRepository::class);

        $this->app->bind(RoleRepositoryInterface::class , RoleRepository::class);

        $this->app->bind(UserRepositoryInterface::class , UserRepository::class);

    }
}
