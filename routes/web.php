<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;

Route::view('/welcome', 'welcome');

Route::get('/test-write', function () {
    $path = public_path('filedinhkem/test.txt');

    try {
        file_put_contents($path, 'Test ghi file!');
        return 'Ghi file thành công!';
    } catch (\Exception $e) {
        return 'Lỗi: ' . $e->getMessage();
    }
});

Route::prefix('portal')->middleware(['auth'])->name('portal.')->group(function () {
    Route::get('/', [PortalController::class, 'index'])->name('dashboard');

    // Quản lý danh sách người dùng
    Route::get('users', [PortalController::class, 'userList'])->name('users');

    // Quản lý roles
    Route::get('roles', [PortalController::class, 'roleList'])->name('roles');

    // Quản lý permissions
    Route::get('permissions', [PortalController::class, 'permissionList'])->name('permissions');

    // Quản lý dm ngôn ngữ
    Route::get('dm/ngonngu', [PortalController::class, 'dmNgonNguList'])->name('dm.ngonngu');

    // Quản lý dm nơi cấp thẻ
    Route::get('dm/noicapthe', [PortalController::class, 'dmNoiCapTheList'])->name('dm.noicapthe');

    // Quản lý dm thời hạn thẻ
    Route::get('dm/thoihanthe', [PortalController::class, 'dmThoiHanTheList'])->name('dm.thoihanthe');

    // Quản lý hướng dẫn viên
    Route::get('huongdanvien', [PortalController::class, 'huongDanVienList'])->name('huongdanvien');

    // Quản lý thẻ
    Route::get('the', [PortalController::class, 'theList'])->name('the');

    // Quản lý dm ngôn ngữ
    Route::get('ngonngu', [PortalController::class, 'NgonNguList'])->name('ngonngu');

    // Quản lý chuyên mục
    Route::get('chuyenmuc', [PortalController::class, 'ChuyenMucList'])->name('chuyenmuc');

    // Quản lý tin tức
    Route::get('tukhoa', [PortalController::class, 'TuKhoaList'])->name('tukhoa');

    // Quản lý tin tức
    Route::get('tintuc', [PortalController::class, 'TinTucList'])->name('tintuc');

    // Quản lý tin tức
    Route::get('video', [PortalController::class, 'VideoList'])->name('video');

    // Quản lý thư viện ảnh
    Route::get('banner', [PortalController::class, 'BannerList'])->name('banner');
    Route::get('thumuc', [PortalController::class, 'ThuMucChaList'])->name('thumuccha');
    Route::get('thumuc/{slugCha}', [PortalController::class, 'ThuMucConList'])->name('thumuccon');
    Route::get('thumuc/{slugCha}/{slugCon}', [PortalController::class, 'ThuVienAnhList'])->name('thuvienanh');

    // Quản lý yêu cầu đăng ký / chỉnh sửa / gia hạn thông tin hướng dẫn viên
    Route::get('yeu-cau-dang-ky-thong-tin', [PortalController::class, 'yeuCauDangKyThongTinList'])->name('yeu.cau.dang.ky.thong.tin');

    Route::get('export/guide-profile/pdf', [ExportController::class, 'exportGuideProfilePDF'])->name('export.guide.profile.pdf');
    Route::get('export/guide-profile/body-only', [ExportController::class, 'exportBodyOnlyPDF'])->name('export.guide.profile.body.only');
    // Route::get('export/example-guide-profile', [ExportController::class, 'exampleGuideProfile'])->name('export.example.guide.profile');

    Route::get('export/show-guide-profile', [ExportController::class, 'exampleGuideProfile'])->name('export.show.guide.profile');
    Route::get('export/example-guide-profile', [ExportController::class, 'exportExampleGuideProfile'])->name('export.example.guide.profile');

    // Export hướng dẫn viên
    Route::get('export/huongdanvien', [ExportController::class, 'exportHuongDanVien'])->name('export.huongdanvien');
});

/**
 * Quét QR code để xem thông tin hướng dẫn viên trên web
 */
Route::get('export/guide-profile/{id}', [ExportController::class, 'showGuideProfile'])->name('export.guide.profile');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/', [GuestController::class, 'index'])->name('home');

Route::get('/dang-ky-thong-tin', [GuestController::class, 'dangKyThongTin'])->name('dang.ky.thong.tin');

Route::post('/dang-ky-thong-tin', [GuestController::class, 'submitDangKyThongTin'])->name('post.dang.ky.thong.tin');

Route::get('/export-thong-tin-the-hdv', [GuestController::class, 'exportThongTinTheHdv'])->name('export.thong.tin.the.hdv');

Route::get('/huong-dan-viens', [GuestController::class, 'huongDanVienList'])->name('huong.dan.vien.list');

// Route::get('/huong-dan-vien', [GuestController::class, 'huongDanVienList'])->name('huongDanVienList');
Route::get('/gioi-thieu/{slug}', [GuestController::class, 'GioiThieuPage'])->name('gioi-thieu');
Route::get('/dich-vu/{slug}', [GuestController::class, 'DichVuPage'])->name('dich-vu');
Route::get('/thu-vien', [GuestController::class, 'ThuVien'])->name('thu-vien');
Route::get('/thu-vien', [GuestController::class, 'ThuVien'])->name('thu-vien');
Route::get('thu-vien/{slugCha}', [GuestController::class, 'ThuVienConList'])->name('thu-vien-con');
Route::get('thu-vien/{slugCha}/{slugCon}', [GuestController::class, 'ThuVienAnhList'])->name('thu-vien-anh');

Route::get('/tin-tuc-tuyen-dung', [GuestController::class, 'tinTucSuKien'])->name('tinTucSuKien');

Route::get('/chuyen-muc/{slug}', [GuestController::class, 'chuyenMucList'])->name('chuyen-muc');

Route::get('/chi-tiet/{slug}', [GuestController::class, 'chiTietTin'])->name('chiTietTin');
Route::post('/update-views', [GuestController::class, 'updateViews'])->name('updateViews');
Route::get('/tu-khoa/{tukhoa}', [GuestController::class, 'tuKhoaPage'])->name('tu-khoa');

Route::get('/lien-he', [GuestController::class, 'lienHe'])->name('lienHe');

require __DIR__ . '/auth.php';
