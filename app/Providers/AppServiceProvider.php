<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
Use \Maatwebsite\Excel\Sheet;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('APP_ENV') === 'production')
        {
            \URL::forceScheme('https');
        }

        Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) { 
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        Sheet::macro('styleColumnDimension', function (Sheet $sheet, string $cell, int $width) { 
            $sheet->getDelegate()->getColumnDimension($cell)->setWidth($width);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
