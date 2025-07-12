<?php

namespace App\Http\Controllers;

use App\Models\HdvdlHuongDanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Spatie\LaravelPdf\Facades\Pdf;

class ExportController extends Controller
{
    /**
     * Helper function để xử lý đường dẫn ảnh
     */
    private function getImagePath($path, $isPdf = false)
    {
        if ($isPdf) {
            return public_path($path);
        }

        // if ($isPdf) {
        //     return Storage::disk('real_public')->path($path);
        // }

        return asset($path);
    }

    /**
     * Hiển thị trang hồ sơ hướng dẫn viên
     */
    public function showGuideProfile($id)
    {
        $hdv = HdvdlHuongDanVien::where('id', $id)->where('daxoa', 0)->first();
        if (!$hdv) {
            return redirect()->back()->with('error', 'Không tìm thấy hướng dẫn viên!');
        }

        $avatarRelativePath = $hdv->attachment?->url;

        // dd($avatarRelativePath);

        $qrcodeRelativePath = $hdv->qrcode?->url;

        // Kiểm tra và xử lý đường dẫn ảnh
        if (!$avatarRelativePath) {
            $avatarPath = $this->getImagePath('frontend/images/noimage.png');
        } else {
            $avatarPath = $this->getImagePath($avatarRelativePath);
            // Kiểm tra file vật lý
            $avatarPhysicalPath = public_path($avatarRelativePath);
            if (!file_exists($avatarPhysicalPath)) {
                Log::warning('File ảnh không tồn tại: ' . $avatarPhysicalPath);
                $avatarPath = $this->getImagePath('frontend/images/noimage.png');
            }
        }

        if (!$qrcodeRelativePath) {
            $qrcodePath = $this->getImagePath('frontend/images/noimage.png');
        } else {
            $qrcodePath = $this->getImagePath($qrcodeRelativePath, false);
        }

        // Dữ liệu mẫu - có thể lấy từ database
        $guideData = [
            'name' => $hdv->getHoVaTen(),
            'dob' => $hdv->ngaysinh ? Carbon::parse($hdv->ngaysinh)->format('d/m/Y') : '---',
            'phone' => $hdv->sdt1,
            'email' => $hdv->email1,
            'address' => $hdv->diachi,
            'card_number' => $hdv->thedanghoatdong?->sothe ? $hdv->thedanghoatdong?->sothe : '---',
            'issue_date' => $hdv->thedanghoatdong?->tungay ? Carbon::parse($hdv->thedanghoatdong?->tungay)->format('d/m/Y') : '---',
            'expiry_date' => $hdv->thedanghoatdong?->denngay ? Carbon::parse($hdv->thedanghoatdong?->denngay)->format('d/m/Y') : '---',
            'avatar' => $avatarPath,
            'qr' => $qrcodePath,
        ];

        return view('portal.export.guide-profile-body-only', compact('guideData'));
    }

    /**
     * Test xuất PDF với template đơn giản
     */
    public function testSimplePDF()
    {
        try {
            // Dữ liệu mẫu
            $guideData = [
                'name' => 'NGUYỄN THỊ MINH ANH',
                'title' => 'Hướng dẫn viên Du lịch Quốc tế',
                'dob' => '15/03/1995',
                'phone' => '0905 123 456',
                'email' => 'minhanh@vietnamtourism.com',
                'address' => '123 Nguyễn Huệ, Quận 1, TP.HCM',
                'card_number' => 'HDV-2024-001',
                'issue_date' => '15/01/2024',
                'expiry_date' => '15/01/2029',
                'status' => 'Đang hoạt động',
            ];

            // Tạo tên file
            $filename = 'test-simple-' . date('Y-m-d-H-i-s') . '.pdf';

            return Pdf::view('portal.export.guide-profile-simple', ['guideData' => $guideData])
                ->format('a4')
                ->margins(15, 15, 15, 15)
                ->name($filename)
                ->download();
        } catch (\Exception $e) {
            Log::error('Simple PDF Export Error: ' . $e->getMessage());
            return back()->with('error', 'Không thể xuất PDF: ' . $e->getMessage());
        }
    }

    /**
     * Xuất PDF hồ sơ hướng dẫn viên
     */
    public function exportGuideProfilePDF()
    {
        try {
            // Dữ liệu mẫu đơn giản - không có hình ảnh
            $guideData = [
                'name' => 'NGUYỄN THỊ MINH ANH',
                'title' => 'Hướng dẫn viên Du lịch Quốc tế',
                'dob' => '15/03/1995',
                'phone' => '0905 123 456',
                'email' => 'minhanh@vietnamtourism.com',
                'address' => '123 Nguyễn Huệ, Quận 1, TP.HCM',
                'card_number' => 'HDV-2024-001',
                'issue_date' => '15/01/2024',
                'expiry_date' => '15/01/2029',
                'status' => 'Đang hoạt động',
                // Tạm thời bỏ qua hình ảnh để test
                'avatar' => $this->getImagePath('images/hPFdt3sDGEmdws0yBplHmPCKJxNeQ9AzIdEinnkQ.jpg', true),
                'logo' => $this->getImagePath('frontend/images/logonew.png', true),
                'qr' => $this->getImagePath('frontend/images/noimage.png', true),
            ];

            // Tạo tên file
            $filename = 'ho-so-huong-dan-vien-' . date('Y-m-d-H-i-s') . '.pdf';

            return Pdf::view('portal.export.guide-profile', ['guideData' => $guideData])
                ->format('a4') // Đặt định dạng trang A4
                ->margins(15, 15, 15, 15) // Đặt margins (top, right, bottom, left) - mm
                ->name($filename) // Đặt tên file khi tải xuống
                ->download(); // Bắt đầu quá trình tải xuống

        } catch (\Exception $e) {
            // Log lỗi
            Log::error('PDF Export Error: ' . $e->getMessage());
            Log::error('PDF Export Stack Trace: ' . $e->getTraceAsString());

            // Trả về lỗi
            return back()->with('error', 'Không thể xuất PDF: ' . $e->getMessage());
        }
    }

    /**
     * Xuất PDF chỉ phần body (thông tin hướng dẫn viên và thẻ)
     */
    public function exportBodyOnlyPDF()
    {
        try {
            // Dữ liệu mẫu - có thể lấy từ database
            $guideData = [
                'name' => 'NGUYỄN THỊ MINH ANH',
                'title' => 'Hướng dẫn viên Du lịch Quốc tế',
                'dob' => '15/03/1995',
                'phone' => '0905 123 456',
                'email' => 'minhanh@vietnamtourism.com',
                'address' => '123 Nguyễn Huệ, Quận 1, TP.HCM',
                'card_number' => 'HDV-2024-001',
                'issue_date' => '15/01/2024',
                'expiry_date' => '15/01/2029',
                'status' => 'Đang hoạt động',
                'avatar' => $this->getImagePath('images/hPFdt3sDGEmdws0yBplHmPCKJxNeQ9AzIdEinnkQ.jpg', true),
                'logo' => $this->getImagePath('frontend/images/logonew.png', true),
                'qr' => $this->getImagePath('frontend/images/noimage.png', true),
            ];

            $filename = 'the-huong-dan-vien-' . date('Y-m-d-H-i-s') . '.pdf';

            return Pdf::view('portal.export.guide-profile-body-only', ['guideData' => $guideData])
                ->format('a4')
                ->margins(15, 15, 15, 15)
                ->name($filename)
                ->download();
        } catch (\Exception $e) {
            Log::error('Body Only PDF Export Error: ' . $e->getMessage());
            Log::error('Body Only PDF Export Stack Trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Không thể xuất PDF: ' . $e->getMessage());
        }
    }

    public function exampleGuideProfile()
    {
        // Dữ liệu mẫu - có thể lấy từ database
        $guideData = [
            'name' => 'NGUYỄN THỊ MINH ANH',
            'title' => 'Hướng dẫn viên Du lịch Quốc tế',
            'cccd' => '1231231231',
            'dob' => '15/03/1995',
            'phone' => '0905 123 456',
            'email' => 'minhanh@vietnamtourism.com',
            'address' => '123 Nguyễn Huệ, Quận 1, TP.HCM',
            'card_number' => 'HDV-2024-001',
            'issue_date' => '15/01/2024',
            'expiry_date' => '15/01/2029',
            'status' => 'Đang hoạt động',
            'avatar' => $this->getImagePath('images/hPFdt3sDGEmdws0yBplHmPCKJxNeQ9AzIdEinnkQ.jpg'),
            'logo' => $this->getImagePath('frontend/images/logonew.png'),
            'qr' => $this->getImagePath('frontend/images/noimage.png'),
            'background-matsau' => $this->getImagePath('images/matsau.jpg'),
            'background-mattruoc' => $this->getImagePath('images/mattruoc.jpg'),
        ];

        return view('portal.export.example-guide-profile', compact('guideData'));
    }

    public function exportExampleGuideProfile()
    {
        ini_set('max_execution_time', 300);
        try {
            $hdvdl_huongdanviens = HdvdlHuongDanVien::where('trangthai', 1)->where('daxoa', 0)->get();
            $guideData = [];
            foreach ($hdvdl_huongdanviens as $hdv) {
                $avatarRelativePath = $hdv->attachment?->url;
                $qrcodeRelativePath = $hdv->qrcode?->url;

                // Kiểm tra và xử lý đường dẫn ảnh
                if (!$avatarRelativePath) {
                    $avatarPath = $this->getImagePath('frontend/images/noimage.png', true);
                } else {
                    $avatarPath = $this->getImagePath($avatarRelativePath, true);
                }

                if (!$qrcodeRelativePath) {
                    $qrcodePath = $this->getImagePath('frontend/images/noimage.png', true);
                } else {
                    $qrcodePath = $this->getImagePath($qrcodeRelativePath, true);
                }

                // Kiểm tra file có tồn tại không
                if (!file_exists($avatarPath)) {
                    Log::warning('File ảnh không tồn tại: ' . $avatarPath);
                    $avatarPath = public_path('frontend/images/noimage.png');
                }

                $guideData[] = [
                    'name' => $hdv->getHoVaTen(),
                    'cccd' => $hdv->cmnd_so,
                    'card_number' => $hdv->thedanghoatdong?->sothe ? $hdv->thedanghoatdong?->sothe : '---',
                    'issue_date' => $hdv->thedanghoatdong?->tungay ? Carbon::parse($hdv->thedanghoatdong?->tungay)->format('d/m/Y') : '---',
                    'expiry_date' => $hdv->thedanghoatdong?->denngay ?  Carbon::parse($hdv->thedanghoatdong?->denngay)->format('d/m/Y') : '---',
                    'avatar' => $avatarPath,
                    'qr_code' => $qrcodePath,
                    'background-matsau' => $this->getImagePath('images/matsau.jpg', true),
                    'background-mattruoc' => $this->getImagePath('images/mattruoc.jpg', true),
                ];
            }

            $filename = 'Danh-sach-the-huong-dan-vien-' . date('Y-m-d-H-i-s') . '.pdf';

            // Thêm session flash message thành công
            session()->flash('export_success', 'Đã xuất thành công ' . count($guideData) . ' thẻ hướng dẫn viên!');

            return Pdf::view('portal.export.example-guide-profile', ['guideData' => $guideData])
                ->format('a4')
                ->margins(15, 15, 15, 15)
                ->name($filename)
                ->download();

            // $html = view('portal.export.example-guide-profile', ['guideData' => $guideData])->render();

            // return Pdf::html($html)
            //     ->format('a4')
            //     ->margins(15, 15, 15, 15)
            //     ->name($filename)
            //     ->download();

            // Browsershot::html(view('portal.export.example-guide-profile', ['guideData' => $guideData])->render())
            //     ->format('a4')
            //     ->margins(15, 15, 15, 15)
            //     ->timeout(120)
            //     ->save($filename);
            // return response()->download($filename);

            // return Pdf::loadView('portal.export.example-guide-profile', ['guideData' => $guideData])
            //     ->setPaper('a4')
            //     ->setWarnings(false)
            //     ->download($filename);
        } catch (\Exception $e) {
            Log::error('Example Guide Profile PDF Export Error: ' . $e->getMessage());
            Log::error('Example Guide Profile PDF Export Stack Trace: ' . $e->getTraceAsString());

            return back()->with('error', 'Không thể xuất PDF: ' . $e->getMessage());
        }
    }

    /**
     * Xuất danh sách hướng dẫn viên được chọn
     */
    public function exportHuongDanVien(Request $request)
    {
        try {
            $ids = $request->get('ids');

            if (empty($ids)) {
                return back()->with('error', 'Không có hướng dẫn viên nào được chọn!');
            }

            $idArray = explode(',', $ids);
            $huongDanViens = HdvdlHuongDanVien::whereIn('id', $idArray)
                ->with(['thedanghoatdong'])
                ->get();

            if ($huongDanViens->isEmpty()) {
                return back()->with('error', 'Không tìm thấy hướng dẫn viên nào!');
            }

            $guideData = [];
            foreach ($huongDanViens as $hdv) {
                // Lấy ảnh thẻ
                $image = \App\Models\CmsAttachment::where('huongdanvien_id', $hdv->id)
                    ->where('type', 1)
                    ->where('daxoa', 0)
                    ->first();

                // Lấy QR code
                $qrcode = \App\Models\CmsAttachment::where('huongdanvien_id', $hdv->id)
                    ->where('type', 2)
                    ->where('daxoa', 0)
                    ->where('original_name', 'like', 'QR Code%')
                    ->first();

                $avatarRelativePath = $image?->url;
                $qrcodeRelativePath = $qrcode?->url;

                // Kiểm tra và xử lý đường dẫn ảnh
                if (!$avatarRelativePath) {
                    $avatarPath = $this->getImagePath('frontend/images/noimage.png', true);
                } else {
                    $avatarPath = $this->getImagePath($avatarRelativePath, true);
                }

                if (!$qrcodeRelativePath) {
                    $qrcodePath = $this->getImagePath('frontend/images/noimage.png', true);
                } else {
                    $qrcodePath = $this->getImagePath($qrcodeRelativePath, true);
                }

                // Kiểm tra file có tồn tại không
                if (!file_exists($avatarPath)) {
                    \Illuminate\Support\Facades\Log::warning('File ảnh không tồn tại: ' . $avatarPath);
                    $avatarPath = public_path('frontend/images/noimage.png');
                }

                $guideData[] = [
                    'name' => $hdv->getHoVaTen(),
                    'cccd' => $hdv->cmnd_so,
                    'card_number' => $hdv->thedanghoatdong?->sothe ? $hdv->thedanghoatdong?->sothe : '---',
                    'issue_date' => $hdv->thedanghoatdong?->tungay ? \Carbon\Carbon::parse($hdv->thedanghoatdong?->tungay)->format('d/m/Y') : '---',
                    'expiry_date' => $hdv->thedanghoatdong?->denngay ?  \Carbon\Carbon::parse($hdv->thedanghoatdong?->denngay)->format('d/m/Y') : '---',
                    'avatar' => $avatarPath,
                    'qr_code' => $qrcodePath,
                    'background-matsau' => $this->getImagePath('images/matsau.jpg', true),
                    'background-mattruoc' => $this->getImagePath('images/mattruoc.jpg', true),
                ];
            }

            $filename = 'Danh-sach-the-huong-dan-vien-' . date('d-m-Y-H-i-s') . '.pdf';

            // Thêm session flash message thành công
            session()->flash('export_success', 'Đã xuất thành công ' . count($guideData) . ' thẻ hướng dẫn viên!');

            return Pdf::view('portal.export.example-guide-profile', ['guideData' => $guideData])
                ->format('a4')
                ->margins(15, 15, 15, 15)
                ->name($filename)
                ->download();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Export Huong Dan Vien Error: ' . $e->getMessage());
            return back()->with('error', 'Không thể xuất PDF: ' . $e->getMessage());
        }
    }
}
