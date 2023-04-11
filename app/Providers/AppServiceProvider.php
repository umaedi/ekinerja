<?php

namespace App\Providers;

use App\Models\Pegawai;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Gate::define('subadmin', function (Pegawai $pegawai) {
        //     return $pegawai->role === 3;
        // });
    }
}
