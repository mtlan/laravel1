<?php

namespace App\Livewire;

use App\Models\CmsAttachment;
use App\Models\HdvdlDmNgonNgu;
use App\Models\HdvdlDmNoiCapThe;
use App\Models\HdvdlDmThoiHanThe;
use App\Models\HdvdlHuongDanTiengPhu;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HdvdlHuongDanVien;
use App\Models\HdvdlThe;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager as ImageTool;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\LaravelPdf\Facades\Pdf;

class HdvdlHuongDanViens extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $paginationTheme = 'bootstrap';

    public $searchParam;

    public $image, $hoTenLot, $ten, $ngaySinh, $gioiTinh, $sdt1, $sdt2, $email1, $email2, $diaChi, $cmndSo, $cmndNgayCap, $cmndNoiCap, $trangThai;

    public $file_original;

    public $ngonNguList = [];

    public $huongdanvien_edit_id, $huongdanvien_delete_id;

    public $view_huongdanvien_image, $view_huongdanvien_hovaten, $view_huongdanvien_ngaysinh, $view_huongdanvien_gioitinh, $view_huongdanvien_sdt1, $view_huongdanvien_email1, $view_huongdanvien_sdt2, $view_huongdanvien_email2, $view_huongdanvien_cmndSo, $view_huongdanvien_cmndNgayCap, $view_huongdanvien_cmndNoiCap, $view_huongdanvien_diachi, $view_huongdanvien_trangThai;

    public $view_huongdanvien_qrcode;

    public $huongdanvien_manage_the_id, $huongdanvien_edit_the_id;

    public $huongdanvien_edit_the = false;

    public $hdvdl_ngonngus, $hdvdl_noicapthes, $hdvdl_thoihanthes;

    public $hdvdl_thoihanthe_id, $hdvdl_ngonnguchinh_id, $hdvdl_noicapthe_id, $sothe, $tungay, $denngay, $trangThaiThe;

    public $the_active, $huongdanvien_thes;

    public $isShowForm = false;

    // Thêm thuộc tính cho chức năng checkAll
    public $selectedItems = [];
    public $selectAll = false;

    public function resetFields(): void
    {
        $this->image = null;
        $this->hoTenLot = '';
        $this->ten = '';
        $this->ngaySinh = null;
        $this->gioiTinh = '';
        $this->sdt1 = '';
        $this->sdt2 = '';
        $this->email1 = '';
        $this->email2 = '';
        $this->diaChi = '';
        $this->cmndSo = '';
        $this->cmndNgayCap = null;
        $this->cmndNoiCap = '';
        $this->trangThai = '';
        $this->ngonNguList = [];
    }

    public function resetTheFields(): void
    {
        $this->isShowForm = false;
        $this->hdvdl_ngonnguchinh_id = null;
        $this->hdvdl_noicapthe_id = null;
        $this->sothe = null;
        $this->hdvdl_thoihanthe_id = null;
        $this->tungay = null;
        $this->denngay = null;
        $this->trangThaiThe = null;
    }

    public function mount()
    {
        $this->hdvdl_ngonngus = HdvdlDmNgonNgu::where("daxoa", 0)->orderBy("id", "asc")->get();
        $this->hdvdl_noicapthes = HdvdlDmNoiCapThe::where("daxoa", 0)->orderBy("id", "asc")->get();
        $this->hdvdl_thoihanthes = HdvdlDmThoiHanThe::where("daxoa", 0)->orderBy("id", "asc")->get();
    }

    public function updatedHdvdlThoihantheId($value)
    {
        if (empty($value)) {
            $this->tungay = null;
            $this->denngay = null;
            $this->hdvdl_thoihanthe_id = null;
            return;
        }

        $hdvdl_thoihanthe = HdvdlDmThoiHanThe::findOrFail($value);
        $monthValue = intval($hdvdl_thoihanthe->ma);

        if ($hdvdl_thoihanthe && !$this->tungay) {
            // Nếu không có từ ngày, lấy ngày hiện tại
            $today = Carbon::now();
            $this->tungay = $today->format('d/m/Y');
            $this->denngay = $today->copy()->addMonths($monthValue)->format('d/m/Y');
        } else if ($hdvdl_thoihanthe && $this->tungay) {
            // Nếu có từ ngày, chuyển về Carbon và tính đến ngày
            $tungayCarbon = Carbon::createFromFormat('d/m/Y', $this->tungay);
            $this->tungay = $this->tungay; // Giữ nguyên format d/m/Y
            $this->denngay = $tungayCarbon->copy()->addMonths($monthValue)->format('d/m/Y');
        }
    }

    private function findHdvdlHuongDanVienOrFail(int $id): HdvdlHuongDanVien
    {
        return HdvdlHuongDanVien::findOrFail($id); // Hoặc User::findOrFail($id) nếu bạn muốn tự động lỗi 404
    }

    private function hasQrCode(int $huongDanVienId): bool
    {
        return CmsAttachment::where('huongdanvien_id', $huongDanVienId)
            ->where('daxoa', 0)
            ->where('type', 2)
            ->where('original_name', 'like', 'QR Code%')
            ->exists();
    }

    private function getQrCodeAttachment(int $huongDanVienId): ?CmsAttachment
    {
        return CmsAttachment::where('huongdanvien_id', $huongDanVienId)
            ->where('daxoa', 0)
            ->where('type', 2)
            ->where('original_name', 'like', 'QR Code%')
            ->first();
    }

    public function updatedSearchParam($value)
    {
        $this->resetPage();
    }

    // Phương thức xử lý khi checkbox checkAll thay đổi
    public function updatedSelectAll($value)
    {
        if ($value) {
            // Nếu check selectAll, lấy tất cả ID của items trong trang hiện tại
            $this->selectedItems = $this->getCurrentPageItems();
        } else {
            // Nếu uncheck selectAll, xóa tất cả selectedItems
            $this->selectedItems = [];
        }
    }

    // Phương thức lấy danh sách ID của items trong trang hiện tại
    private function getCurrentPageItems()
    {
        $searchParam = '%' . $this->searchParam . '%';

        $query = HdvdlHuongDanVien::where('daxoa', 0)->where(function ($query) use ($searchParam) {
            $query->where('ten', 'like', $searchParam)
                ->orWhere('ho_tenlot', 'like', $searchParam)
                ->orWhere('email1', 'like', $searchParam)
                ->orWhere('cmnd_so', 'like', $searchParam)
                ->orWhere('sdt1', 'like', $searchParam)
                ->orWhereHas('danhsachthe', function ($q) use ($searchParam) {
                    $q->where('sothe', 'like', $searchParam);
                });
        })->orderBy('id', 'asc');

        // Lấy tất cả items (không phân trang) để có ID
        $allItems = $query->get();

        // Tính toán items trong trang hiện tại
        $perPage = 10; // Số items mỗi trang
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $currentPageItems = $allItems->slice($offset, $perPage);

        return $currentPageItems->pluck('id')->map(function ($id) {
            return (string) $id;
        })->toArray();
    }

    private function check_authentication($action)
    {
        // Nếu User chưa đăng nhập hoặc không tồn tại id thì redirect về trang login
        if (!Auth::check()) {
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Vui lòng đăng nhập để thực hiện tác vụ này!',
                type: 'error'
            );
            Log::info('Người dùng chưa đăng nhập khi truy cập chức năng ' . $action . ' thẻ hướng dẫn viên.');
            return redirect()->route('login');
        }
    }

    public function rules(): array
    {
        return [
            'ten' => 'required',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'hoTenLot' => 'required',
            'ngaySinh' => 'required',
            'sdt1' => 'required',
            'email1' => 'required',
            'cmndSo' => 'required',
            'cmndNgayCap' => 'required',
            'cmndNoiCap' => 'required',
        ];
    }

    public function updateRules(): array
    {
        return [
            'ten' => 'required',
            'hoTenLot' => 'required',
            'ngaySinh' => 'required',
            'sdt1' => 'required',
            'email1' => 'required',
            'cmndSo' => 'required',
            'cmndNgayCap' => 'required',
            'cmndNoiCap' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'image.required' => 'Vui lòng chọn hình ảnh',
            'image.mimes' => 'Ảnh không hợp lệ',
            'hoTenLot.required' => 'Vui lòng nhập họ và tên lót',
            'ten.required' => 'Vui lòng nhập tên',
            'ngaySinh.required' => 'Vui lòng chọn ngày sinh',
            'sdt1.required' => 'Vui lòng nhập số điện thoại 1',
            'email1.required' => 'Vui lòng nhập email 1',
            'cmndSo.required' => 'Vui lòng nhập số CMND/ Hộ chiếu',
            'cmndNgayCap.required' => 'Vui lòng chọn ngày cấp',
            'cmndNoiCap.required' => 'Vui lòng nhập nơi cấp',
        ];
    }

    public function isRequired($field)
    {
        $rules = $this->rules();
        $fieldRules = $rules[$field] ?? '';

        $ruleString = is_array($fieldRules) ? implode('|', $fieldRules) : $fieldRules;

        return str_contains($ruleString, 'required');
    }

    public function render()
    {
        $searchParam = '%' . $this->searchParam . '%';

        $huongDanViens = HdvdlHuongDanVien::where('daxoa', 0)->where(function ($query) use ($searchParam) {
            $query->where('ten', 'like', $searchParam)
                ->orWhere('ho_tenlot', 'like', $searchParam)
                ->orWhere('email1', 'like', $searchParam)
                ->orWhere('cmnd_so', 'like', $searchParam)
                ->orWhere('sdt1', 'like', $searchParam)
                ->orWhereHas('danhsachthe', function ($q) use ($searchParam) {
                    $q->where('sothe', 'like', $searchParam);
                });
        })->orderBy('id', 'asc')->paginate(10);

        return view('livewire.hdvdl-huong-dan-viens', ['huongDanViens' => $huongDanViens, 'dm_ngonngus' => $this->hdvdl_ngonngus, 'dm_noicapthes' => $this->hdvdl_noicapthes, 'dm_thoihanthes' => $this->hdvdl_thoihanthes]);
    }

    public function store()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $hdv = new HdvdlHuongDanVien();
            $hdv->ho_tenlot = $this->hoTenLot;
            $hdv->ten = $this->ten;
            $hdv->ngaysinh = $this->ngaySinh ? Carbon::createFromFormat('d/m/Y', $this->ngaySinh)->format('Y-m-d') : null;
            $hdv->gioitinh = $this->gioiTinh ?? null;
            $hdv->sdt1 = $this->sdt1;
            $hdv->sdt2 = $this->sdt2 ?? null;
            $hdv->email1 = $this->email1;
            $hdv->email2 = $this->email2 ?? null;
            $hdv->diachi = $this->diaChi ?? null;
            $hdv->cmnd_So = $this->cmndSo;
            $hdv->cmnd_ngaycap = $this->cmndNgayCap ? Carbon::createFromFormat('d/m/Y', $this->cmndNgayCap)->format('Y-m-d') : null;
            $hdv->cmnd_noicap = $this->cmndNoiCap;
            $hdv->trangthai = $this->trangThai ?? 1;
            $hdv->daxoa = 0;
            $hdv->save();

            if (!empty($this->ngonNguList)) {
                foreach ($this->ngonNguList as $ngonNgu) {
                    $hdv_tiengphu = new HdvdlHuongDanTiengPhu();
                    $hdv_tiengphu->huongdanvien_id = $hdv->id;
                    $hdv_tiengphu->ngonngu_id = $ngonNgu;
                    $hdv_tiengphu->trangthai = 1;
                    $hdv_tiengphu->daxoa = 0;
                    $hdv_tiengphu->save();
                }
            }

            if ($this->image) {
                $image = $this->image;
                $imageManager = new ImageTool(new GdDriver()); // Hoặc ImagickDriver::class nếu bạn muốn dùng Imagick
                $originalClientFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $hashedFileName = $image->hashName();
                $fileSize = $image->getSize();
                $mineType = $image->getMimeType();
                $targetSubDirectory = 'images';

                try {
                    // Đọc file ảnh bằng phương thức read() trên instance của ImageManager
                    $image =  $imageManager->read($image->getRealPath());
                    // Resize image to 150x150, maintaining aspect ratio and preventing upscaling
                    $image->resize(150, 150, function ($constraint) { // For Intervention Image v3+
                        $constraint->aspectRatio();
                        $constraint->preventUpsizing(); // Ngăn không cho phóng to ảnh nếu ảnh gốc nhỏ hơn
                    });

                    // Path relative to the 'real_public' disk's root (which is public_path())
                    $imagePathOnRealPublicDisk = $targetSubDirectory . '/' . $hashedFileName;

                    // Save the image content to the 'real_public' disk.
                    // Storage::disk('real_public')->put() will handle directory creation.
                    Storage::disk('real_public')->put($imagePathOnRealPublicDisk, (string) $image->encode());

                    $storedFilePath = $imagePathOnRealPublicDisk;
                    $fileSize = Storage::disk('real_public')->size($storedFilePath); // Get size of the resized image
                } catch (\Exception $e) {
                    Log::error('Error resizing image: ' . $e->getMessage(), ['file' => $originalClientFileName]);
                    // Fallback: store original file if resizing fails
                    // Use 'real_public' disk for fallback storage
                    $storedFilePath = $image->storeAs($targetSubDirectory, $hashedFileName, 'real_public');
                    $fileSize = $image->getSize(); // Use original file size
                }

                $attachment = new CmsAttachment();
                $attachment->huongdanvien_id = $hdv->id;
                $attachment->ten = $hashedFileName;
                $attachment->original_name = $originalClientFileName;
                $attachment->url = 'images/' . $hashedFileName;
                $attachment->type = 1;
                $attachment->size = $fileSize;
                $attachment->mime = $mineType;
                $attachment->ghichu = 'Tạo mới hdv id là: ' .  $hdv->id;
                $attachment->ngaytao = Carbon::now()->format('Y-m-d H:i:s');
                $attachment->nguoitao = Auth::id();
                $attachment->trangthai = 1;
                $attachment->daxoa = 0;
                $attachment->save();
            }

            // Generate QR code
            if (!$this->hasQrCode($hdv->id)) {
                try {
                    /**
                     * Test trên máy local
                     */
                    if (app()->environment('local')) {
                        $ipLocal = "192.168.1.9:8000";
                        $url = "http://" . $ipLocal . "/export/guide-profile/" . $hdv->id;
                    } else {
                        $appUrl = config('app.url');
                        $url = rtrim($appUrl, '/') . "/export/guide-profile/" . $hdv->id;
                    }

                    $qrCode = QrCode::format('png')
                        ->size(200)
                        ->margin(0)
                        ->errorCorrection('M')
                        ->generate($url);

                    $qrFileName = 'qr_code_' . $hdv->id . '.png';
                    $qrFilePath = 'qrcodes/' . $qrFileName;
                    Storage::disk('real_public')->put($qrFilePath, $qrCode);

                    $qrAttachment = new CmsAttachment();
                    $qrAttachment->huongdanvien_id = $hdv->id;
                    $qrAttachment->ten = $qrFileName;
                    $qrAttachment->original_name = 'QR Code - ' . $hdv->getHoVaTen();
                    $qrAttachment->type = 2;
                    $qrAttachment->url = $qrFilePath;
                    $qrAttachment->size = Storage::disk('real_public')->size($qrFilePath);
                    $qrAttachment->mime = 'image/png';
                    $qrAttachment->ghichu = 'QR Code cho hướng dẫn viên ID: ' . $hdv->id;
                    $qrAttachment->ngaytao = Carbon::now()->format('Y-m-d H:i:s');
                    $qrAttachment->nguoitao = Auth::id();
                    $qrAttachment->trangthai = 1;
                    $qrAttachment->daxoa = 0;
                    $qrAttachment->save();
                } catch (\Exception $e) {
                    Log::error('Lỗi khi tạo QR code: ' . $e->getMessage());
                    // Không dừng quá trình tạo hướng dẫn viên nếu QR code lỗi
                }
            }

            session()->flash('success', 'Thêm mới hướng dẫn viên thành công!');
        } catch (\Exception $e) {
            Log::error("Lỗi khi thêm mới hướng dẫn viên: " . $e->getMessage());
            session()->flash('error', 'Đã có lỗi xảy ra trong quá trình thêm mới hướng dẫn viên, mời bạn thao tác lại!');
        } finally {
            $this->resetFields();
            $this->dispatch('close-modal');
        }
    }

    public function edit($id)
    {
        $this->check_authentication('chỉnh sửa');

        try {
            $hdv = $this->findHdvdlHuongDanVienOrFail($id);
            $this->hoTenLot = $hdv->ho_tenlot;
            $this->ten = $hdv->ten;
            $this->ngaySinh = Carbon::parse($hdv->ngaysinh)->format('d/m/Y');
            $this->gioiTinh = $hdv->gioitinh;
            $this->sdt1 = $hdv->sdt1;
            $this->email1 = $hdv->email1;
            $this->sdt2 = $hdv->sdt2;
            $this->email2 = $hdv->email2;
            $this->diaChi = $hdv->diachi;
            $this->cmndSo = $hdv->cmnd_so;
            $this->cmndNgayCap = Carbon::parse($hdv->cmnd_ngaycap)->format('d/m/Y');
            $this->cmndNoiCap = $hdv->cmnd_noicap;
            $this->trangThai = $hdv->trangthai;
            $this->huongdanvien_edit_id = $hdv->id;

            $this->ngonNguList = HdvdlHuongDanTiengPhu::where('huongdanvien_id', $hdv->id)->where('daxoa', 0)->pluck('ngonngu_id')->toArray();

            $image = CmsAttachment::where('huongdanvien_id', $hdv->id)->where('daxoa', 0)->first();

            $this->file_original = $image ? $image : null;

            // dump($this->file_original_name);

            $this->dispatch('show-edit-huongdanvien-modal');
        } catch (ModelNotFoundException $e) {
            Log::info('Không tìm thấy hướng dẫn viên để chỉnh sửa: ' . $e->getMessage());
            session()->flash('error', 'Không tìm thấy hướng dẫn viên để chỉnh sửa.');
            $this->dispatch('close-modal'); // Close modal if item not found
        }
    }

    public function update()
    {
        $this->check_authentication('cập nhật');

        $this->validate($this->updateRules(), $this->messages());

        try {
            $hdv = HdvdlHuongDanVien::where('id', $this->huongdanvien_edit_id)->first();

            // dd($hdv->id);

            $hdv->ho_tenlot = $this->hoTenLot;
            $hdv->ten = $this->ten;
            $hdv->ngaysinh = $this->ngaySinh ? Carbon::createFromFormat('d/m/Y', $this->ngaySinh)->format('Y-m-d') : null;
            $hdv->gioitinh = $this->gioiTinh ?? null;
            $hdv->sdt1 = $this->sdt1;
            $hdv->sdt2 = $this->sdt2 ?? null;
            $hdv->email1 = $this->email1;
            $hdv->email2 = $this->email2 ?? null;
            $hdv->diachi = $this->diaChi ?? null;
            $hdv->cmnd_So = $this->cmndSo;
            $hdv->cmnd_ngaycap = $this->cmndNgayCap ? Carbon::createFromFormat('d/m/Y', $this->cmndNgayCap)->format('Y-m-d') : null;
            $hdv->cmnd_noicap = $this->cmndNoiCap;
            $hdv->trangthai = $this->trangThai ?? 1;
            $hdv->daxoa = 0;
            $hdv->save();

            // Chức năng chỉnh sửa ngôn ngữ phụ
            if (!empty($this->ngonNguList)) {
                // Lấy danh sách ngôn ngữ hiện tại trong db
                $current_ngonnguphu = HdvdlHuongDanTiengPhu::where('huongdanvien_id', $hdv->id)->where('daxoa', 0)->get();

                $existing_ngonnguphu = HdvdlHuongDanTiengPhu::where('huongdanvien_id', $hdv->id)->where('daxoa', 0)->pluck('ngonngu_id')->toArray();

                // Duyệt qua dsach ngôn ngữ hiện tại kiểm tra xem có ngôn ngữ nào không nằm trong dsach ngôn ngữ được gửi xuống thì set daxoa=1
                foreach ($current_ngonnguphu as $ngonnguphu) {
                    if (!in_array($ngonnguphu->ngonngu_id, $this->ngonNguList)) {
                        // dd(1);
                        $ngonnguphu->daxoa = 1;
                        $ngonnguphu->save();
                    }
                }

                foreach ($this->ngonNguList as $ngonNguId) {
                    if (!in_array($ngonNguId, $existing_ngonnguphu)) {
                        $newNgonNgu = new HdvdlHuongDanTiengPhu();
                        $newNgonNgu->huongdanvien_id = $hdv->id;
                        $newNgonNgu->ngonngu_id = $ngonNguId;
                        $newNgonNgu->trangthai = 1;
                        $newNgonNgu->daxoa = 0;
                        $newNgonNgu->save();
                    }
                }
            }

            if (!$this->file_original && $this->image) {
                $image = $this->image;
                $imageManager = new ImageTool(new GdDriver()); // Hoặc ImagickDriver::class nếu bạn muốn dùng Imagick
                $originalClientFileName = $image->getClientOriginalName();
                $extension = $image->getClientOriginalExtension();
                $hashedFileName = $image->hashName();
                $fileSize = $image->getSize();
                $mineType = $image->getMimeType();
                $targetSubDirectory = 'images';

                try {
                    // Đọc file ảnh bằng phương thức read() trên instance của ImageManager
                    $image =  $imageManager->read($image->getRealPath());
                    // Resize image to 150x150, maintaining aspect ratio and preventing upscaling
                    $image->resize(150, 150, function ($constraint) { // For Intervention Image v3+
                        $constraint->aspectRatio();
                        $constraint->preventUpsizing(); // Ngăn không cho phóng to ảnh nếu ảnh gốc nhỏ hơn
                    });

                    // Path relative to the 'real_public' disk's root (which is public_path())
                    $imagePathOnRealPublicDisk = $targetSubDirectory . '/' . $hashedFileName;

                    // Save the image content to the 'real_public' disk.
                    // Storage::disk('real_public')->put() will handle directory creation.
                    Storage::disk('real_public')->put($imagePathOnRealPublicDisk, (string) $image->encode());

                    $storedFilePath = $imagePathOnRealPublicDisk;
                    $fileSize = Storage::disk('real_public')->size($storedFilePath); // Get size of the resized image
                } catch (\Exception $e) {
                    Log::error('Error resizing image: ' . $e->getMessage(), ['file' => $originalClientFileName]);
                    // Fallback: store original file if resizing fails
                    // Use 'real_public' disk for fallback storage
                    $storedFilePath = $image->storeAs($targetSubDirectory, $hashedFileName, 'real_public');
                    $fileSize = $image->getSize(); // Use original file size
                }

                $attachment = new CmsAttachment();
                $attachment->huongdanvien_id = $hdv->id;
                $attachment->ten = $hashedFileName;
                $attachment->original_name = $originalClientFileName;
                $attachment->url = 'images/' . $hashedFileName;
                $attachment->type = 1;
                $attachment->size = $fileSize;
                $attachment->mime = $mineType;
                $attachment->ghichu = 'Tạo mới hdv id là: ' .  $hdv->id;
                $attachment->ngaytao = Carbon::now()->format('Y-m-d H:i:s');
                $attachment->nguoitao = Auth::id();
                $attachment->trangthai = 1;
                $attachment->daxoa = 0;
                $attachment->save();
            }

            // Generate QR code if not exists
            if (!$this->hasQrCode($hdv->id)) {
                try {
                    /**
                     * Test trên máy local
                     */
                    if (app()->environment('local')) {
                        $ipLocal = "192.168.1.9:8000";
                        $url = "http://" . $ipLocal . "/export/guide-profile/" . $hdv->id;
                    } else {
                        $appUrl = config('app.url');
                        $url = rtrim($appUrl, '/') . "/export/guide-profile/" . $hdv->id;
                    }
                    // Chỉ định rõ sử dụng GD driver
                    $qrCode = QrCode::format('png')
                        ->size(200)
                        ->margin(0)
                        ->errorCorrection('M')
                        ->generate($url);

                    $qrFileName = 'qr_code_' . $hdv->id . '.png';
                    $qrFilePath = 'qrcodes/' . $qrFileName;
                    Storage::disk('real_public')->put($qrFilePath, $qrCode);

                    $qrAttachment = new CmsAttachment();
                    $qrAttachment->huongdanvien_id = $hdv->id;
                    $qrAttachment->ten = $qrFileName;
                    $qrAttachment->original_name = 'QR Code - ' . $hdv->getHoVaTen();
                    $qrAttachment->type = 2;
                    $qrAttachment->url = $qrFilePath;
                    $qrAttachment->size = Storage::disk('real_public')->size($qrFilePath);
                    $qrAttachment->mime = 'image/png';
                    $qrAttachment->ghichu = 'QR Code cho hướng dẫn viên ID: ' . $hdv->id;
                    $qrAttachment->ngaytao = Carbon::now()->format('Y-m-d H:i:s');
                    $qrAttachment->nguoitao = Auth::id();
                    $qrAttachment->trangthai = 1;
                    $qrAttachment->daxoa = 0;
                    $qrAttachment->save();
                } catch (\Exception $e) {
                    Log::error('Lỗi khi tạo QR code: ' . $e->getMessage());
                    // Không dừng quá trình tạo hướng dẫn viên nếu QR code lỗi
                }
            }

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Chỉnh sửa hướng dẫn viên thành công!',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error("Lỗi khi chỉnh sửa hướng dẫn viên: " . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Đã có lỗi xảy ra trong quá trình chỉnh sửa hướng dẫn viên, mời bạn thao tác lại!',
                type: 'error'
            );
        } finally {
            $this->dispatch('close-modal');
        }
    }

    public function manageThe($id)
    {
        $this->check_authentication('quản lý thẻ');

        try {
            $hdvdl_huongdanvien = $this->findHdvdlHuongDanVienOrFail($id);
            $this->huongdanvien_manage_the_id = $hdvdl_huongdanvien->id;
            // Lấy DSach thẻ của hướng dẫn viên
            $hdvdl_thes = $hdvdl_huongdanvien->danhsachthe;

            if (!empty($hdvdl_thes)) {
                foreach ($hdvdl_thes as $the) {
                    // KTra cột đến ngày < today thì set cột trạng thái là 0
                    $today = Carbon::now();
                    $tungay = $the->tungay;
                    $denngay = $the->denngay;

                    if ($tungay && $denngay && $denngay < $today) {
                        $the->trangthai = 0;
                        $the->save();
                    }
                }
            }

            // Thẻ đang hoạt động
            $this->huongdanvien_thes = $hdvdl_thes;

            // dump($this->the_active);

            $this->dispatch('show-manage-the-huongdanvien-modal');
        } catch (ModelNotFoundException $e) {
            Log::info('Không tìm thấy hướng dẫn viên để quản lý thẻ: ' . $e->getMessage());
            session()->flash('error', 'Không tìm thấy hướng dẫn viên để quản lý thẻ.');
        } catch (Exception $e) {
            Log::info('Có lỗi xảy ra trong quá trình xử lý quản lý thẻ của hướng dẫn viên: ' . $e->getMessage());
        } finally {
            $this->dispatch('close-modal'); // Close modal if)
        }
    }

    // Thêm thẻ cho hướng dẫn viên
    public function addThe()
    {
        if ($this->huongdanvien_edit_the && $this->huongdanvien_edit_the_id) {
            $this->check_authentication('chỉnh sửa thẻ hướng dẫn viên');
        } else {
            $this->check_authentication('thêm thẻ hướng dẫn viên');
        }

        $ruleSoThe = 'required|unique:hdvdl_the,sothe';
        if ($this->huongdanvien_edit_the) {
            $ruleSoThe .= ',' . $this->huongdanvien_edit_the_id . ',id,daxoa,0';
        } else {
            $ruleSoThe .= ',NULL,id,daxoa,0';
        }

        $this->validate([
            'hdvdl_thoihanthe_id' => 'required',
            'hdvdl_ngonnguchinh_id' => 'required',
            'hdvdl_noicapthe_id' => 'required',
            'sothe' => $ruleSoThe,
            'tungay' => 'required',
            'denngay' => 'required',
        ], [
            'hdvdl_thoihanthe_id.required' => 'Vui lòng chọn thời hạn thẻ',
            'hdvdl_ngonnguchinh_id.required' => 'Vui lòng chọn ngôn ngữ chính',
            'hdvdl_noicapthe_id.required' => 'Vui lòng chọn nơi cấp thẻ',
            'sothe.required' => 'Vui lòng nhập số thẻ',
            'sothe.unique' => 'Số thẻ này đã tồn tại trong hệ thống',
            'tungay.required' => 'Vui lòng chọn ngày cấp',
            'denngay.required' => 'Vui lòng chọn ngày hết hạn',
        ]);

        try {
            $hdvdl_huongdanvien = $this->findHdvdlHuongDanVienOrFail($this->huongdanvien_manage_the_id);

            if ($hdvdl_huongdanvien && $hdvdl_huongdanvien->id && !$this->huongdanvien_edit_the) {
                /**
                 * T/Hiện duyệt qua danh sách thẻ củ và set trangthai = 0(tạm ngưng)
                 */
                $hdvdl_thes = $hdvdl_huongdanvien->danhsachthe;
                if (!empty($hdvdl_thes)) {
                    foreach ($hdvdl_thes as $the) {
                        $the->trangthai = 0;
                        $the->save();
                    }
                }

                /**
                 * T/Hiện add thẻ mới
                 */
                $hdvdl_the = new HdvdlThe();
                $hdvdl_the->huongdanvien_id = $hdvdl_huongdanvien->id;
                $hdvdl_the->thoihanthe_id = $this->hdvdl_thoihanthe_id;
                $hdvdl_the->huongdan_tiengchinh = $this->hdvdl_ngonnguchinh_id;
                $hdvdl_the->noicapthe_id = $this->hdvdl_noicapthe_id;
                $hdvdl_the->sothe = $this->sothe;
                $hdvdl_the->tungay = $this->tungay ? Carbon::createFromFormat('d/m/Y', $this->tungay)->format('Y-m-d') : null;
                $hdvdl_the->denngay = $this->denngay ? Carbon::createFromFormat('d/m/Y', $this->denngay)->format('Y-m-d') : null;
                $hdvdl_the->trangthai = $this->trangThaiThe ? $this->trangThaiThe : 1;
                $hdvdl_the->daxoa = 0;
                $hdvdl_the->save();

                session()->flash('success', 'Thêm thẻ cho hướng dẫn viên thành công!');
            } else {
                if ($this->trangThaiThe == 1) {
                    $hdvdl_thes = $hdvdl_huongdanvien->danhsachthe;
                    if (!empty($hdvdl_thes)) {
                        foreach ($hdvdl_thes as $the) {
                            if ($the->id != $this->huongdanvien_edit_the_id) {
                                $the->trangthai = 0;
                                $the->save();
                            }
                        }
                    }
                }

                /**
                 * T/Hiện edit thẻ
                 */
                $hdvdl_the = HdvdlThe::where('id', $this->huongdanvien_edit_the_id)->where('daxoa', 0)->first();
                $hdvdl_the->thoihanthe_id = $this->hdvdl_thoihanthe_id;
                $hdvdl_the->huongdan_tiengchinh = $this->hdvdl_ngonnguchinh_id;
                $hdvdl_the->noicapthe_id = $this->hdvdl_noicapthe_id;
                $hdvdl_the->sothe = $this->sothe;
                $hdvdl_the->tungay = $this->tungay ? Carbon::createFromFormat('d/m/Y', $this->tungay)->format('Y-m-d') : null;
                $hdvdl_the->denngay = $this->denngay ? Carbon::createFromFormat('d/m/Y', $this->denngay)->format('Y-m-d') : null;
                $hdvdl_the->trangthai = $this->trangThaiThe;
                $hdvdl_the->save();

                session()->flash('success', 'Chỉnh sửa thẻ hướng dẫn viên thành công!');
            }
        } catch (ModelNotFoundException $modelException) {
            Log::info('Không tìm thấy hướng dẫn viên để thêm thẻ: ' . $modelException->getMessage());
            session()->flash('error', 'Không tìm thấy hướng dẫn viên để thêm thẻ.');
        } catch (Exception $e) {
            Log::info('Có lỗi xảy ra trong quá trình thêm thẻ cho hướng dẫn viên hoặc Không tìm thấy hướng dẫn viên: ' . $e->getMessage());
            session()->flash('error', 'Có lỗi xảy ra trong quá trình thêm thẻ cho hướng dẫn viên hoặc Không tìm thấy hướng dẫn viên.');
        } finally {
            $this->hdvdl_thoihanthe_id = null;
            $this->hdvdl_ngonnguchinh_id = null;
            $this->hdvdl_noicapthe_id = null;
            $this->sothe = null;
            $this->tungay = null;
            $this->denngay = null;
            $this->trangThaiThe = null;
            $this->huongdanvien_manage_the_id = null;
            $this->huongdanvien_edit_the_id = null;
            $this->huongdanvien_edit_the = false;

            $this->dispatch('close-modal');
        }
    }

    public function showAddThe()
    {
        $this->isShowForm = true;

        $hdvdl_huongdanvien = $this->findHdvdlHuongDanVienOrFail($this->huongdanvien_manage_the_id);
        $hdvdl_thegannhat = $hdvdl_huongdanvien->thegannhat;
        $this->hdvdl_ngonnguchinh_id = $hdvdl_thegannhat ? $hdvdl_thegannhat->huongdan_tiengchinh : null;
        $this->hdvdl_thoihanthe_id = $hdvdl_thegannhat ? $hdvdl_thegannhat->thoihanthe_id : null;
        $this->hdvdl_noicapthe_id = $hdvdl_thegannhat ? $hdvdl_thegannhat->noicapthe_id : null;
        $this->sothe = $hdvdl_thegannhat ? $hdvdl_thegannhat->sothe : null;

        // Sử dụng method mới từ model để tính toán ngày mặc định
        $this->tungay = $hdvdl_huongdanvien->getDefaultCardStartDate();
        $this->denngay = $hdvdl_thegannhat ? Carbon::parse($hdvdl_thegannhat->denngay)->format('d/m/Y') : null;
        $this->trangThaiThe = $hdvdl_thegannhat ? $hdvdl_thegannhat->trangthai : null;

        /**
         * dispatch 1 event từ server mỗi khi form thẻ chưa tungay và denngay sẵn sàng cho client-side js lắng nge event và khởi tạo flatpickr
         */
        $this->dispatch('the-form-ready');
    }

    public function editThe($id)
    {
        $this->check_authentication('chỉnh sửa thẻ');

        $this->isShowForm = true;

        try {
            $hdvdl_the = HdvdlThe::where('id', $id)->where('daxoa', 0)->first();
            $this->hdvdl_ngonnguchinh_id = $hdvdl_the->huongdan_tiengchinh;
            $this->hdvdl_noicapthe_id = $hdvdl_the->noicapthe_id;
            $this->sothe = $hdvdl_the->sothe;
            $this->hdvdl_thoihanthe_id = $hdvdl_the->thoihanthe_id;
            $this->tungay = Carbon::parse($hdvdl_the->tungay)->format('d/m/Y');
            $this->denngay = Carbon::parse($hdvdl_the->denngay)->format('d/m/Y');
            $this->trangThaiThe = $hdvdl_the->trangthai;
            // $this->huongdanvien_manage_the_id = $hdvdl_the->id;
            $this->huongdanvien_edit_the_id = $hdvdl_the->id;
            $this->huongdanvien_edit_the = true;

            $this->dispatch('the-form-ready');
        } catch (ModelNotFoundException $e) {
            Log::info('Không tìm thấy thẻ để chỉnh sửa: ' . $e->getMessage());
            session()->flash('error', 'Không tìm thấy thẻ hướng dẫn viên để chỉnh sửa.');
        } catch (Exception $e) {
            Log::info('Có lỗi xảy ra trong quá trình xử lý quản lý thẻ của hướng dẫn viên: ' . $e->getMessage());
        }
    }

    private function refreshHuongDanVienThesList(int $huongDanVienId): void
    {
        try {
            $hdvdl_huongdanvien = $this->findHdvdlHuongDanVienOrFail($huongDanVienId);
            // Lấy danh sách thẻ chưa bị xóa mềm
            $active_thes = $hdvdl_huongdanvien->danhsachthe;

            if ($active_thes->isNotEmpty()) {
                foreach ($active_thes as $the_item) {
                    $today = Carbon::now();
                    // Đảm bảo denngay được parse chính xác
                    $denngay_date = $the_item->denngay;
                    if (is_string($denngay_date)) {
                        try {
                            $denngay_date = Carbon::parse($denngay_date);
                        } catch (\Exception $e) {
                            Log::error("Lỗi parse ngày denngay cho thẻ ID {$the_item->id}: " . $e->getMessage());
                            continue; // Bỏ qua thẻ này nếu ngày không hợp lệ
                        }
                    }

                    if ($denngay_date instanceof Carbon && $the_item->tungay && $denngay_date->lt($today)) {
                        if ($the_item->trangthai != 0) { // Chỉ cập nhật nếu trạng thái chưa phải là Tạm ngưng
                            $the_item->trangthai = 0;
                            $the_item->save();
                        }
                    }
                }
            }
            $this->huongdanvien_thes = $hdvdl_huongdanvien->danhsachthe;
        } catch (ModelNotFoundException $e) {
            Log::error("Không tìm thấy HDV (ID: {$huongDanVienId}) khi làm mới danh sách thẻ: " . $e->getMessage());
            $this->huongdanvien_thes = collect(); // Gán danh sách rỗng nếu có lỗi
            session()->flash('the-error', 'Không thể tải lại danh sách thẻ: Hướng dẫn viên không tồn tại.');
        } catch (\Exception $e) {
            Log::error("Lỗi khi làm mới danh sách thẻ cho HDV ID {$huongDanVienId}: " . $e->getMessage());
            $this->huongdanvien_thes = collect();
            session()->flash('the-error', 'Có lỗi xảy ra khi tải lại danh sách thẻ.');
        }
    }

    public function deleteThe($id)
    {
        $this->check_authentication('xóa thẻ');

        try {
            $hdvdl_the = HdvdlThe::where('id', $id)->where('daxoa', 0)->first();
            $hdvdl_the->daxoa = 1;
            $hdvdl_the->save();

            session()->flash('the-success', 'Xóa thẻ hướng dẫn viên thành công!');

            // Làm mới danh sách thẻ trong modal nếu huongdanvien_manage_the_id được thiết lập
            if ($this->huongdanvien_manage_the_id) {
                $this->refreshHuongDanVienThesList($this->huongdanvien_manage_the_id);
            }
        } catch (ModelNotFoundException $e) {
            Log::info('Không tìm thấy thẻ để xóa: ' . $e->getMessage());
            session()->flash('the-error', 'Không tìm thấy thẻ hướng dẫn viên để xóa.');
        } catch (Exception $e) {
            Log::info('Có lỗi xảy ra trong quá trình xử lý quản lý thẻ - xóa thẻ của hướng dẫn viên: ' . $e->getMessage());
            session()->flash('the-error', 'Có lỗi xảy ra trong quá trình xóa thẻ.');
        }
    }

    public function removeFile(int $id): void
    {
        try {
            $attachment = CmsAttachment::findOrFail($id);
            $filePath = $attachment->url;

            // Xóa file vật lý từ storage nếu đường dẫn tồn tại
            if ($filePath && Storage::disk('real_public')->exists($filePath)) {
                Storage::disk('real_public')->delete($filePath);
            }

            // Cập nhật lại thông tin file trong database
            $attachment->daxoa = 1; // Hoặc tên file mặc định nếu cần
            $attachment->save();
            $this->file_original = null; // Reset tên file hiển thị trên form
            session()->flash('success_file', 'Đã xoá file tư liệu và thông tin liên quan thành công!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error_file', 'Không tìm thấy tư liệu để xoá file.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa file: ' . $e->getMessage(), ['media_file_id' => $id, 'exception' => $e]);
            session()->flash('error_file', 'Có lỗi xảy ra trong quá trình xóa file. Vui lòng thử lại.');
        }
        // Giữ modal edit mở để người dùng có thể tải file mới lên nếu muốn
        $this->dispatch('show-edit-huongdanvien-modal');
    }

    public function delete($id)
    {
        $hdv = HdvdlHuongDanVien::where('id', $id)->first();
        $this->huongdanvien_delete_id = $hdv->id;

        $this->dispatch('show-delete-huongdanvien-modal');
    }

    public function deleteHdvdl()
    {
        try {
            $hdv = HdvdlHuongDanVien::where('id', $this->huongdanvien_delete_id)->first();
            $hdv->daxoa = 1;
            $hdv->save();

            session()->flash('success', 'Đã xoá hướng dẫn viên thành công!');
            $this->dispatch('close-modal');
        } catch (\Exception $th) {
            session()->flash('success', 'Có lỗi xảy ra trong quá trình xoá hướng dẫn viên!');
            $this->dispatch('close-modal');
        }
    }

    public function view($id)
    {
        $huongdanvien = HdvdlHuongDanVien::where('id', $id)->where('daxoa', 0)->first();

        $image = CmsAttachment::where('huongdanvien_id', $huongdanvien->id)->where('daxoa', 0)->first();

        if ($image) {
            $this->view_huongdanvien_image = $image->url;
        } else {
            $this->view_huongdanvien_image = null;
        }

        $this->view_huongdanvien_hovaten = $huongdanvien->getHoVaTen();
        $this->view_huongdanvien_ngaysinh = Carbon::parse($huongdanvien->ngaysinh)->format('d/m/Y');
        $this->view_huongdanvien_gioitinh = $huongdanvien->gioitinh;
        $this->view_huongdanvien_sdt1 = $huongdanvien->sdt1;
        $this->view_huongdanvien_email1 = $huongdanvien->email1;
        $this->view_huongdanvien_sdt2 = $huongdanvien->sdt2 ?? '';
        $this->view_huongdanvien_email2 = $huongdanvien->email2 ?? '';
        $this->view_huongdanvien_cmndSo = $huongdanvien->cmnd_so;
        $this->view_huongdanvien_cmndNgayCap = Carbon::parse($huongdanvien->cmnd_ngaycap)->format('d/m/Y');
        $this->view_huongdanvien_cmndNoiCap = $huongdanvien->cmnd_noicap;
        $this->view_huongdanvien_diachi = $huongdanvien->diachi ?? '';
        $this->view_huongdanvien_trangThai = $huongdanvien->getTrangThai();

        if ($this->hasQrCode($huongdanvien->id)) {
            $this->view_huongdanvien_qrcode = $huongdanvien->qrcode->url;
        } else {
            $this->generateQrCode($huongdanvien->id);
            $this->view_huongdanvien_qrcode = $huongdanvien->qrcode->url;
        }

        $this->dispatch('show-view-huongdanvien-modal');
    }

    public function closeViewModal()
    {
        $this->view_huongdanvien_image = '';
        $this->view_huongdanvien_hovaten = '';
        $this->view_huongdanvien_ngaysinh = '';
        $this->view_huongdanvien_gioitinh = '';
        $this->view_huongdanvien_sdt1 = '';
        $this->view_huongdanvien_email1 = '';
        $this->view_huongdanvien_sdt2 = '';
        $this->view_huongdanvien_email2 = '';
        $this->view_huongdanvien_cmndSo = '';
        $this->view_huongdanvien_cmndNgayCap = '';
        $this->view_huongdanvien_cmndNoiCap = '';
        $this->view_huongdanvien_diachi = '';
        $this->view_huongdanvien_trangThai = '';
        $this->view_huongdanvien_qrcode = null;
        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->resetTheFields();
        $this->dispatch('close-modal');
    }

    public function generateQrCode($id)
    {
        $this->check_authentication('tạo QR code');

        try {
            $hdv = $this->findHdvdlHuongDanVienOrFail($id);

            if ($this->hasQrCode($hdv->id)) {
                $this->dispatch(
                    'show-alert',
                    title: 'Thông báo!',
                    message: 'Hướng dẫn viên này đã có QR code!',
                    type: 'info'
                );
                return;
            }

            // Generate QR code
            if (!$this->hasQrCode($hdv->id)) {
                try {
                    /**
                     * Test trên máy local
                     */
                    if (app()->environment('local')) {
                        $ipLocal = "192.168.1.9:8000";
                        $url = "http://" . $ipLocal . "/export/guide-profile/" . $hdv->id;
                    } else {
                        $appUrl = config('app.url');
                        $url = rtrim($appUrl, '/') . "/export/guide-profile/" . $hdv->id;
                    }
                    // Chỉ định rõ sử dụng GD driver
                    $qrCode = QrCode::format('png')
                        ->size(200)
                        ->margin(0)
                        ->errorCorrection('M')
                        ->generate($url);

                    $qrFileName = 'qr_code_' . $hdv->id . '.png';
                    $qrFilePath = 'qrcodes/' . $qrFileName;
                    Storage::disk('real_public')->put($qrFilePath, $qrCode);

                    $qrAttachment = new CmsAttachment();
                    $qrAttachment->huongdanvien_id = $hdv->id;
                    $qrAttachment->ten = $qrFileName;
                    $qrAttachment->original_name = 'QR Code - ' . $hdv->getHoVaTen();
                    $qrAttachment->type = 2;
                    $qrAttachment->url = $qrFilePath;
                    $qrAttachment->size = Storage::disk('real_public')->size($qrFilePath);
                    $qrAttachment->mime = 'image/png';
                    $qrAttachment->ghichu = 'QR Code cho hướng dẫn viên ID: ' . $hdv->id;
                    $qrAttachment->ngaytao = Carbon::now()->format('Y-m-d H:i:s');
                    $qrAttachment->nguoitao = Auth::id();
                    $qrAttachment->trangthai = 1;
                    $qrAttachment->daxoa = 0;
                    $qrAttachment->save();



                    $this->dispatch(
                        'show-alert',
                        title: 'Thành công!',
                        message: 'Đã tạo QR code cho hướng dẫn viên thành công!',
                        type: 'success'
                    );
                } catch (\Exception $e) {
                    Log::error("Lỗi khi tạo QR code cho hướng dẫn viên: " . $e->getMessage());
                    $this->dispatch(
                        'show-alert',
                        title: 'Lỗi!',
                        message: 'Đã có lỗi xảy ra trong quá trình tạo QR code, mời bạn thử lại!',
                        type: 'error'
                    );
                }
            }
        } catch (ModelNotFoundException $e) {
            Log::info('Không tìm thấy hướng dẫn viên để tạo QR code: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Không tìm thấy hướng dẫn viên để tạo QR code.',
                type: 'error'
            );
        } catch (\Exception $e) {
            Log::error("Lỗi khi tạo QR code cho hướng dẫn viên: " . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Đã có lỗi xảy ra trong quá trình tạo QR code, mời bạn thử lại!',
                type: 'error'
            );
        }
    }

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
     * Chức năng In thẻ của hướng dẫn viên
     */
    public function exportTheHdvdl()
    {
        $this->check_authentication('xuất thẻ');

        if (empty($this->selectedItems)) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo!',
                message: 'Vui lòng chọn ít nhất một hướng dẫn viên để in thẻ!',
                type: 'warning'
            );
            return;
        }

        try {
            $huongDanViens = HdvdlHuongDanVien::whereIn('id', $this->selectedItems)
                ->with(['thedanghoatdong'])
                ->get();

            $guideData = [];
            foreach ($huongDanViens as $hdv) {
                // Lấy ảnh thẻ
                $image = CmsAttachment::where('huongdanvien_id', $hdv->id)
                    ->where('type', 1)
                    ->where('daxoa', 0)
                    ->first();

                // Lấy QR code
                $qrcode = CmsAttachment::where('huongdanvien_id', $hdv->id)
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

            $filename = 'Danh-sach-the-huong-dan-vien-' . date('d-m-Y-H-i-s') . '.pdf';

            // Trong Livewire, chúng ta cần redirect đến route để download
            $ids = implode(',', $this->selectedItems);
            return redirect()->route('portal.export.huongdanvien', ['ids' => $ids]);
        } catch (\Exception $e) {
            Log::error("Lỗi khi xuất thẻ hướng dẫn viên: " . $e->getMessage());

            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Đã có lỗi xảy ra trong quá trình xuất thẻ hướng dẫn viên, vui lòng thử lại sau!',
                type: 'error'
            );
        }
    }

    public function deleteSelected()
    {
        $this->selectedItems = [];
        $this->selectAll = false;
    }
}
