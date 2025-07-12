<?php

namespace App\Livewire;

use App\Models\CmsAttachment;
use App\Models\HdvdlDangKyThongTin;
use App\Models\HdvdlDmNgonNgu;
use App\Models\HdvdlDmNoiCapThe;
use App\Models\HdvdlDmThoiHanThe;
use App\Models\HdvdlHuongDanVien;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Intervention\Image\ImageManager as ImageTool;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class HuongDanViens extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $paginationTheme = 'bootstrap';

    public $searchParam;

    public $hdvdl_ngonngus, $hdvdl_noicapthes, $hdvdl_thoihanthes;

    public $hoTenLot, $ten, $ngaySinh, $gioiTinh, $sdt1, $email1, $diaChi, $cmndSo, $cmndNgayCap, $cmndNoiCap, $soThe, $tuNgay, $denNgay, $trangThai;

    public $tiengChinh_id, $thoiHanThe_id, $noiCapThe_id;

    public $tiengChinh, $noiCapThe, $thoiHanThe;

    public $type;

    public $huongdanvien_edit_id;

    /** Các biến gia hạn thẻ */
    public $giahan_tungay, $giahan_denngay, $giahan_thoihanthe_id, $giahan_invoice;

    private function findHdvdlHuongDanVienOrFail(int $id): HdvdlHuongDanVien
    {
        return HdvdlHuongDanVien::findOrFail($id); // Hoặc User::findOrFail($id) nếu bạn muốn tự động lỗi 404
    }

    public function updatedSearchParam($value)
    {
        $this->resetPage();
    }

    public function rules(): array
    {
        return [
            'giahan_thoihanthe_id' => 'required',
            'giahan_invoice' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'giahan_tungay' => 'required',
            'giahan_denngay' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'giahan_thoihanthe_id.required' => 'Vui lòng chọn thời hạn thẻ',
            'giahan_invoice.required' => 'Vui lòng chọn hình ảnh biên lai',
            'giahan_invoice.mimes' => 'Hình ảnh biên lai không hợp lệ',
            'giahan_tungay.required' => 'Vui lòng chọn ngày bắt đầu',
            'giahan_denngay.required' => 'Vui lòng chọn ngày kết thúc',
        ];
    }

    public function isRequired($field)
    {
        $rules = $this->rules();
        $fieldRules = $rules[$field] ?? '';

        $ruleString = is_array($fieldRules) ? implode('|', $fieldRules) : $fieldRules;

        return str_contains($ruleString, 'required');
    }

    public function updatedGiaHanThoihantheId($value)
    {
        if (empty($value)) {
            $this->giahan_tungay = null;
            $this->giahan_denngay = null;
            $this->giahan_thoihanthe_id = null;
            return;
        }

        $hdvdl_thoihanthe = HdvdlDmThoiHanThe::findOrFail($value);
        $monthValue = intval($hdvdl_thoihanthe->ma);

        if ($hdvdl_thoihanthe && !$this->giahan_tungay) {
            // Nếu không có từ ngày, lấy ngày hiện tại
            $today = Carbon::now();
            $this->giahan_tungay = $today->format('d/m/Y');
            $this->giahan_denngay = $today->copy()->addMonths($monthValue)->format('d/m/Y');
        } else if ($hdvdl_thoihanthe && $this->giahan_tungay) {
            // Nếu có từ ngày, chuyển về Carbon và tính đến ngày
            $tungayCarbon = Carbon::createFromFormat('d/m/Y', $this->giahan_tungay);
            $this->giahan_tungay = $this->giahan_tungay; // Giữ nguyên format d/m/Y
            $this->giahan_denngay = $tungayCarbon->copy()->addMonths($monthValue)->format('d/m/Y');
        }
    }

    public function mount()
    {
        $this->hdvdl_ngonngus = HdvdlDmNgonNgu::where("daxoa", 0)->orderBy("id", "asc")->get();
        $this->hdvdl_noicapthes = HdvdlDmNoiCapThe::where("daxoa", 0)->orderBy("id", "asc")->get();
        $this->hdvdl_thoihanthes = HdvdlDmThoiHanThe::where("daxoa", 0)->orderBy("id", "asc")->get();
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

        return view('livewire.huong-dan-viens', ['huongDanViens' => $huongDanViens, 'dm_ngonngus' => $this->hdvdl_ngonngus, 'dm_noicapthes' => $this->hdvdl_noicapthes, 'dm_thoihanthes' => $this->hdvdl_thoihanthes]);
    }

    public function handle($id, $type = '')
    {
        try {
            $hdv = $this->findHdvdlHuongDanVienOrFail($id);
            $this->hoTenLot = $hdv->ho_tenlot;
            $this->ten = $hdv->ten;
            $this->ngaySinh = Carbon::parse($hdv->ngaysinh)->format('d/m/Y');
            $this->gioiTinh = $hdv->gioitinh;
            $this->sdt1 = $hdv->sdt1;
            $this->email1 = $hdv->email1;
            $this->diaChi = $hdv->diachi;
            $this->cmndSo = $hdv->cmnd_so;
            $this->cmndNgayCap = Carbon::parse($hdv->cmnd_ngaycap)->format('d/m/Y');
            $this->cmndNoiCap = $hdv->cmnd_noicap;
            $this->trangThai = $hdv->trangthai;
            if ($hdv->thedanghoatdong) {
                $this->tiengChinh_id = $hdv->thedanghoatdong->huongdan_tiengchinh;
                $this->tiengChinh = $hdv->thedanghoatdong->tiengchinh ? $hdv->thedanghoatdong->tiengchinh->ten : '';
                $this->noiCapThe_id = $hdv->thedanghoatdong->noicapthe_id;
                $this->noiCapThe = $hdv->thedanghoatdong->noicapthe ? $hdv->thedanghoatdong->noicapthe->ten : '';
                $this->soThe = $hdv->thedanghoatdong->sothe;
                $this->thoiHanThe_id = $hdv->thedanghoatdong->thoihanthe_id;
                $this->thoiHanThe = $hdv->thedanghoatdong->thoihanthe ? $hdv->thedanghoatdong->thoihanthe->ten : '';
            }

            $this->type = $type;
            // $this->tuNgay = $hdv->thedanghoatdong->tungay?->format('d/m/Y');
            // $this->denNgay = $hdv->thedanghoatdong->denngay?->format('d/m/Y');
            $this->huongdanvien_edit_id = $id;

            // $image = CmsAttachment::where('huongdanvien_id', $hdv->id)->where('daxoa', 0)->first();

            // $this->file_original = $image ? $image : null;

            // dump($this->file_original_name);

            $this->dispatch('show-handle-huongdanvien-modal');
        } catch (ModelNotFoundException $e) {
            Log::info('Không tìm thấy hướng dẫn viên: ' . $e->getMessage());
            session()->flash('error', 'Không tìm thấy hướng dẫn viên.');
            $this->dispatch('close-modal'); // Close modal if item not found
        }
    }

    public function update()
    {
        if ($this->type == 'gia_han') {
            $this->validate($this->rules(), $this->messages());
        }

        try {
            if ($this->type == 'chinh_sua') {
                $hdv = $this->findHdvdlHuongDanVienOrFail($this->huongdanvien_edit_id);

                $newYeuCau = new HdvdlDangKyThongTin();
                $newYeuCau->type = $this->type;
                $newYeuCau->huongdanvien_id = $hdv->id;
                $newYeuCau->ho_tenlot = $this->hoTenLot;
                $newYeuCau->ten = $this->ten;
                $newYeuCau->ngaysinh = $this->ngaySinh ? Carbon::createFromFormat('d/m/Y', $this->ngaySinh)->format('Y-m-d') : null;
                $newYeuCau->gioitinh = $this->gioiTinh ?? null;
                $newYeuCau->sdt1 = $this->sdt1;
                $newYeuCau->email1 = $this->email1;
                $newYeuCau->diachi = $this->diaChi ?? null;
                $newYeuCau->cmnd_so = $this->cmndSo;
                $newYeuCau->cmnd_ngaycap = $this->cmndNgayCap ? Carbon::createFromFormat('d/m/Y', $this->cmndNgayCap)->format('Y-m-d') : null;
                $newYeuCau->cmnd_noicap = $this->cmndNoiCap;
                $newYeuCau->sothe = $this->soThe;
                $newYeuCau->noicapthe_id = $this->noiCapThe_id;
                $newYeuCau->huongdan_tiengchinh = $this->tiengChinh_id;
                $newYeuCau->trangthai = 'cho_phe_duyet';
                $newYeuCau->daxoa = 0;
                $newYeuCau->save();

                $this->dispatch(
                    'show-alert',
                    title: 'Thông báo',
                    message: 'Đã yêu cầu chỉnh sửa thông tin - thẻ hướng dẫn viên thành công, vui lòng đợi quản trị viên xác nhận và kiểm duyệt thông tin chỉnh sửa!!',
                    type: 'success'
                );
            } else {
                $hdv = $this->findHdvdlHuongDanVienOrFail($this->huongdanvien_edit_id);

                $yeucau_giahan = new HdvdlDangKyThongTin();
                $yeucau_giahan->huongdanvien_id = $hdv->id;
                $yeucau_giahan->type = $this->type;
                $yeucau_giahan->thoihanthe_id = $this->giahan_thoihanthe_id;
                $yeucau_giahan->tungay = $this->giahan_tungay ? Carbon::createFromFormat('d/m/Y', $this->giahan_tungay)->format('Y-m-d') : null;
                $yeucau_giahan->denngay = $this->giahan_denngay ? Carbon::createFromFormat('d/m/Y', $this->giahan_denngay)->format('Y-m-d') : null;
                $yeucau_giahan->trangthai = 'cho_phe_duyet';
                $yeucau_giahan->daxoa = 0;
                $yeucau_giahan->save();

                /** Xử lý tải lên hình ảnh biên lai */
                if ($this->giahan_invoice) {
                    $image = $this->giahan_invoice;
                    $imageManager = new ImageTool(new GdDriver()); // Hoặc ImagickDriver::class nếu bạn muốn dùng Imagick
                    $originalClientFileName = $image->getClientOriginalName();
                    $extension = $image->getClientOriginalExtension();
                    $hashedFileName = $image->hashName();
                    $fileSize = $image->getSize();
                    $mineType = $image->getMimeType();
                    $targetSubDirectory = 'invoices';

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
                    $attachment->size = $fileSize;
                    $attachment->mime = $mineType;
                    $attachment->ghichu = 'Gia hạn thông tin thẻ hdv id là: ' .  $yeucau_giahan->id;
                    $attachment->ngaytao = Carbon::now()->format('Y-m-d H:i:s');
                    $attachment->nguoitao = Auth::id();
                    $attachment->is_giahan = true;
                    $attachment->dangkythongtin_id = $yeucau_giahan->id;
                    $attachment->trangthai = 1;
                    $attachment->daxoa = 0;
                    $attachment->save();
                }

                $this->dispatch(
                    'show-alert',
                    title: 'Thông báo',
                    message: 'Đã yêu cầu gia hạn thông tin - thẻ hướng dẫn viên thành công, vui lòng đợi quản trị viên xác nhận và kiểm duyệt thông tin gia hạn!!',
                    type: 'success'
                );
            }

            // session()->flash('guest_success', 'Đã yêu cầu chỉnh sửa thông tin - thẻ hướng dẫn viên thành công, vui lòng đợi quản trị viên xác nhận và kiểm duyệt thông tin chỉnh sửa!');
        } catch (Exception $e) {
            Log::info('Có lỗi xảy ra trong quá trình yêu cầu xử lý chỉnh sửa thông tin: ' . $e->getMessage());
            // session()->flash('guest_error', 'Có lỗi xảy ra trong quá trình yêu cầu xử lý chỉnh sửa thông tin, vui lòng thử lại sau!');

            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Có lỗi xảy ra trong quá trình yêu cầu xử lý chỉnh sửa thông tin, vui lòng thử lại sau!!!',
                type: 'error'
            );
        } finally {
            $this->dispatch('close-modal'); // Close modal if)
        }
    }
}
