<?php

namespace App\Livewire;

use App\Models\HdvdlDangKyThongTin;
use App\Models\HdvdlHuongDanVien;
use App\Models\HdvdlThe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class HdvdlDangKyThongTins extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';

    public $searchParam, $searchType;

    public $hoTenLot, $ten, $ngaySinh, $gioiTinh, $sdt1, $email1, $diaChi, $cmndSo, $cmndNgayCap, $cmndNoiCap, $soThe, $tiengChinh, $noiCapThe, $thoiHanThe, $tuNgay, $denNgay, $trangThai;

    public $tiengChinh_id, $thoiHanThe_id, $noiCapThe_id;

    public $yeucauthongtin_edit_id, $yeucauthongtin_delete_id;

    public $yeucauthongtin_edit_type, $yeucauthongtin_edit_hdv_id;

    public $thongtin_hdv;

    public function updatedSearchParam($value)
    {
        $this->resetPage();
    }

    public function resetFields(): void
    {
        $this->hoTenLot = null;
        $this->ten = null;
        $this->ngaySinh = null;
        $this->gioiTinh = null;
        $this->ngaySinh = null;
        $this->sdt1 = null;
        $this->email1 = null;
        $this->diaChi = null;
        $this->cmndSo = null;
        $this->cmndNgayCap = null;
        $this->cmndNoiCap = null;
        $this->soThe = null;
        $this->tiengChinh = null;
        $this->noiCapThe = null;
        $this->thoiHanThe = null;
        $this->tuNgay = null;
        $this->denNgay = null;
        $this->trangThai = null;
        $this->yeucauthongtin_edit_id = null;
        $this->yeucauthongtin_edit_hdv_id = null;
        $this->yeucauthongtin_edit_type = '';
        $this->thongtin_hdv = null;
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

    private function findHdvdlDangKyThongTinOrFail(int $id): HdvdlDangKyThongTin
    {
        return HdvdlDangKyThongTin::findOrFail($id); // Hoặc User::findOrFail($id) nếu bạn muốn tự động lỗi 404
    }

    public function render()
    {
        $searchParam = '%' . $this->searchParam . '%';

        $yeuCaus = HdvdlDangKyThongTin::where('daxoa', 0)
            ->when($this->searchParam, function ($query) use ($searchParam) {
                return $query->where(function ($q) use ($searchParam) {
                    $q->where('ten', 'like', $searchParam)
                        ->orWhere('email1', 'like', $searchParam)
                        ->orWhere('sdt1', 'like', $searchParam)
                        ->orWhere('cmnd_so', 'like', $searchParam);
                });
            })
            ->when($this->searchType, function ($query) {
                return $query->where('type', $this->searchType);
            })
            ->orderBy('id', 'asc')->paginate(10);

        return view('livewire.hdvdl-dang-ky-thong-tins', ['yeuCaus' => $yeuCaus,]);
    }

    public function edit($id, $type = '')
    {
        $this->check_authentication('phê duyệt');

        try {
            if ($type != 'gia_han') {
                $yeuCau = $this->findHdvdlDangKyThongTinOrFail($id);

                $this->hoTenLot = $yeuCau->ho_tenlot;
                $this->ten = $yeuCau->ten;
                $this->ngaySinh = Carbon::parse($yeuCau->ngaysinh)->format('d/m/Y');
                $this->gioiTinh = $yeuCau->gioitinh;
                $this->sdt1 = $yeuCau->sdt1;
                $this->email1 = $yeuCau->email1;
                $this->diaChi = $yeuCau->diachi;
                $this->cmndSo = $yeuCau->cmnd_so;
                $this->cmndNgayCap = Carbon::parse($yeuCau->cmnd_ngaycap)->format('d/m/Y');
                $this->cmndNoiCap = $yeuCau->cmnd_noicap;
                $this->trangThai = $yeuCau->trangthai;
                $this->tiengChinh = $yeuCau->tiengchinh?->ten;
                $this->tiengChinh_id = $yeuCau->tiengchinh?->id;
                $this->noiCapThe = $yeuCau->noicapthe?->ten;
                $this->noiCapThe_id = $yeuCau->noicapthe?->id;

                $thoiHanThe = $yeuCau->thoihanthe;

                if ($thoiHanThe) {
                    $monthValue = intval($thoiHanThe->ma);
                    $today = Carbon::now();
                    $this->tuNgay = $today->format('d/m/Y');
                    $this->denNgay = $today->copy()->addMonths($monthValue)->format('d/m/Y');
                }

                $this->thoiHanThe = $thoiHanThe ? $thoiHanThe->ten : '';
                $this->thoiHanThe_id = $thoiHanThe ? $thoiHanThe->id : '';
                $this->soThe = $yeuCau->sothe;

                if ($type == 'chinh_sua') {
                    $this->thongtin_hdv = $yeuCau->huongdanvien;
                }
            } else {
                $yeuCau = $this->findHdvdlDangKyThongTinOrFail($id);
                $this->thongtin_hdv = $yeuCau->huongdanvien;
                $thoiHanThe = $yeuCau->thoihanthe;
                $this->thoiHanThe = $thoiHanThe ? $thoiHanThe->ten : '';
                $this->thoiHanThe_id = $thoiHanThe ? $thoiHanThe->id : null;
                $this->tuNgay = $yeuCau->tungay ? Carbon::parse($yeuCau->tungay)->format('d/m/Y') : '';
                $this->denNgay = $yeuCau->denngay ? Carbon::parse($yeuCau->denngay)->format('d/m/Y') : '';
            }


            $this->yeucauthongtin_edit_id = $yeuCau->id;
            $this->yeucauthongtin_edit_hdv_id = $yeuCau->id && $yeuCau->huongdanvien_id ? $yeuCau->huongdanvien_id : null;
            $this->yeucauthongtin_edit_type = $type;

            // dump($this->file_original_name);

            $this->dispatch('show-edit-yeucauthongtin-modal');
        } catch (ModelNotFoundException $e) {
            Log::info('Không tìm thấy yêu cầu đăng ký thông tin để phê duyệt: ' . $e->getMessage());
            session()->flash('error', 'Không tìm thấy yêu cầu đăng ký thông tin.');
            $this->dispatch('close-modal'); // Close modal if item not found
        }
    }

    public function update()
    {
        $this->check_authentication('phê duyệt đăng ký');

        try {
            if ($this->yeucauthongtin_edit_type != 'gia_han') {
                // Sử dụng toán tử 3 ngôi để tạo mới hoặc tìm kiếm hướng dẫn viên
                $huongDanVien = $this->yeucauthongtin_edit_type == 'chinh_sua'
                    ? HdvdlHuongDanVien::findOrFail($this->yeucauthongtin_edit_hdv_id)
                    : new HdvdlHuongDanVien();

                $huongDanVien->ho_tenlot = $this->hoTenLot;
                $huongDanVien->ten = $this->ten;
                $huongDanVien->ngaysinh = $this->ngaySinh ? Carbon::createFromFormat('d/m/Y', $this->ngaySinh)->format('Y-m-d') : null;
                $huongDanVien->gioitinh = $this->gioiTinh ?? null;
                $huongDanVien->sdt1 = $this->sdt1;
                $huongDanVien->email1 = $this->email1;
                $huongDanVien->diachi = $this->diaChi ?? null;
                $huongDanVien->cmnd_So = $this->cmndSo;
                $huongDanVien->cmnd_ngaycap = $this->cmndNgayCap ? Carbon::createFromFormat('d/m/Y', $this->cmndNgayCap)->format('Y-m-d') : null;
                $huongDanVien->cmnd_noicap = $this->cmndNoiCap;
                $huongDanVien->trangthai = 1;
                $huongDanVien->daxoa = 0;
                $huongDanVien->save();

                // Sử dụng toán tử 3 ngôi để tạo mới hoặc tìm kiếm thẻ
                $the_huongdanvien = $this->yeucauthongtin_edit_type == 'chinh_sua'
                    ? HdvdlThe::where('huongdanvien_id', $huongDanVien->id)->first() : new HdvdlThe();

                $the_huongdanvien->huongdanvien_id = $huongDanVien->id;
                $the_huongdanvien->sothe = $this->soThe;
                $the_huongdanvien->noicapthe_id = $this->noiCapThe_id;
                $the_huongdanvien->huongdan_tiengchinh = $this->tiengChinh_id;

                if ($this->yeucauthongtin_edit_type == 'tao_moi') {
                    $the_huongdanvien->thoihanthe_id = $this->thoiHanThe_id ?? null;
                    $huongDanVien->tungay = $this->tuNgay ? Carbon::createFromFormat('d/m/Y', $this->tuNgay)->format('Y-m-d') : null;
                    $huongDanVien->denngay = $this->denNgay ? Carbon::createFromFormat('d/m/Y', $this->denNgay)->format('Y-m-d') : null;
                }

                $the_huongdanvien->trangthai = 1;
                $the_huongdanvien->daxoa = 0;
                $the_huongdanvien->save();

                $yeuCau = $this->findHdvdlDangKyThongTinOrFail($this->yeucauthongtin_edit_id);
                $yeuCau->trangthai = 'da_phe_duyet';
                $yeuCau->save();
            } else {
                $yeuCau = $this->findHdvdlDangKyThongTinOrFail($this->yeucauthongtin_edit_id);

                $the_huongdanvien = $yeuCau->huongdanvien?->thedanghoatdong;
                $the_huongdanvien->thoihanthe_id = $this->thoiHanThe_id;
                $the_huongdanvien->tungay = $this->tuNgay ? Carbon::createFromFormat('d/m/Y', $this->tuNgay)->format('Y-m-d') : null;
                $the_huongdanvien->denngay = $this->denNgay ? Carbon::createFromFormat('d/m/Y', $this->denNgay)->format('Y-m-d') : null;
                $the_huongdanvien->save();

                $yeuCau->trangthai = 'da_phe_duyet';
                $yeuCau->save();
            }

            $message = 'Phê duyệt ' . ($this->yeucauthongtin_edit_type == 'tao_moi' ? 'đăng ký' : ($this->yeucauthongtin_edit_type == 'chinh_sua' ? 'chỉnh sửa' : 'gia hạn')) . ' thông tin thành công!';

            $this->dispatch(
                'show-alert',
                title: 'Thành công',
                message: $message,
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::info('Có lỗi xảy ra trong quá trình phê duyệt đăng ký thông tin: ' . $e->getMessage());

            $message = 'Có lỗi xảy ra trong quá trình phê duyệt ' . ($this->yeucauthongtin_edit_type == 'tao_moi' ? 'đăng ký' : ($this->yeucauthongtin_edit_type == 'chinh_sua' ? 'chỉnh sửa' : 'gia hạn')) . ' thông tin!!';

            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: $message,
                type: 'error'
            );
        } finally {
            $this->resetFields();
            $this->dispatch('close-modal');
        }
    }
}
