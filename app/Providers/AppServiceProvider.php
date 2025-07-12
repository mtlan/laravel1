<?php

namespace App\Providers;

use App\Models\ChuyenMuc;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
        //use Illuminate\Pagination\Paginator;
        // Menu - Tạm thời comment để chạy migrations
        
        // $chuyenMucGioiThieus = ChuyenMuc::where('type', 0)->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        // $chuyenMucDichVus = ChuyenMuc::where('type', 1)->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        // $chuyenMucTinTucs = ChuyenMuc::where('type', 2)->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        // view()->share([
        //     'chuyenMucGioiThieus' => $chuyenMucGioiThieus,
        //     'chuyenMucDichVus' => $chuyenMucDichVus,
        //     'chuyenMucTinTucs' => $chuyenMucTinTucs
        // ]);
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
