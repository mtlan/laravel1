<?php

namespace App\Livewire;

use App\Models\HdvdlDmNgonNgu;
use App\Models\HdvdlDmNoiCapThe;
use App\Models\HdvdlDmThoiHanThe;
use App\Models\HdvdlHuongDanVien;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\HdvdlThe;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HdvdlThes extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $paginationTheme = 'bootstrap';

    public $searchParam;

    public $hdvdl_huongdanviens, $hdvdl_ngonngus, $hdvdl_noicapthes, $hdvdl_thoihanthes;

    public $tungay, $denngay;

    public $hdvdl_huongdanvien_id, $hdvdl_ngonnguchinh_id, $sothe, $hdvdl_noicapthe_id, $hdvdl_thoihanthe_id, $trangthai;

    public $the_edit_id, $the_delete_id;

    public $view_the_id, $view_the_huongdanvien, $view_the_ngonnguchinh, $view_the_sothe, $view_the_noicapthe, $view_the_thoihanthe, $view_the_tungay, $view_the_denngay, $view_the_trangthai;

    public function resetFields(): void
    {
        $this->hdvdl_huongdanvien_id = null;
        $this->hdvdl_ngonnguchinh_id = null;
        $this->hdvdl_noicapthe_id = null;
        $this->tungay = null;
        $this->denngay = null;
        $this->sothe = null;
        $this->hdvdl_thoihanthe_id = null;
        $this->trangthai = null;
    }

    private function findHdvdlTheOrFail(int $id): HdvdlThe
    {
        return HdvdlThe::findOrFail($id); // Hoặc User::findOrFail($id) nếu bạn muốn tự động lỗi 404
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

        if ($hdvdl_thoihanthe) {
            $monthValue = intval($hdvdl_thoihanthe->ma);
            $today = Carbon::now();
            $this->tungay = $today->format('d/m/Y');
            $this->denngay = $today->copy()->addMonths($monthValue)->format('d/m/Y');
        }
    }

    public function updatedSearchParam($value)
    {
        $this->resetPage();
    }


    public function mount()
    {
        $this->hdvdl_huongdanviens = HdvdlHuongDanVien::where("daxoa", 0)->orderBy("id", "asc")->get();
        $this->hdvdl_ngonngus = HdvdlDmNgonNgu::where("daxoa", 0)->orderBy("id", "asc")->get();
        $this->hdvdl_noicapthes = HdvdlDmNoiCapThe::where("daxoa", 0)->orderBy("id", "asc")->get();
        $this->hdvdl_thoihanthes = HdvdlDmThoiHanThe::where("daxoa", 0)->orderBy("id", "asc")->get();
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
        $ruleSoThe = 'required|unique:hdvdl_the,sothe';
        if ($this->the_edit_id) {
            $ruleSoThe .= ',' . $this->the_edit_id . ',id,daxoa,0';
        } else {
            $ruleSoThe .= ',NULL,id,daxoa,0';
        }
        return [
            'hdvdl_huongdanvien_id' => 'required',
            'hdvdl_ngonnguchinh_id' => 'required',
            'sothe' => $ruleSoThe,
            'hdvdl_noicapthe_id' => 'required',
            'hdvdl_thoihanthe_id' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'hdvdl_huongdanvien_id.required' => 'Vui lòng chọn hướng dẫn viên',
            'hdvdl_ngonnguchinh_id.required' => 'Vui lòng chọn ngôn ngữ chính',
            'sothe.required' => 'Vui lòng nhập số thẻ',
            'sothe.unique' => 'Số thẻ này đã tồn tại trong hệ thống',
            'hdvdl_noicapthe_id.required' => 'Vui lòng chọn nơi cấp thẻ',
            'hdvdl_thoihanthe_id.required' => 'Vui lòng chọn thời hạn thẻ',
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
        $hdvdl_thes_query = HdvdlThe::query()->where('daxoa', 0);

        if (!empty($this->searchParam)) {
            $searchParam = '%' . $this->searchParam . '%';
            $hdvdl_thes_query->where(function ($query) use ($searchParam) {
                $query->where('sothe', 'like', $searchParam) // Search by card number
                    ->orWhereHas('huongdanvien', function ($q) use ($searchParam) {
                        // Search by guide's name (ho_tenlot + ' ' + ten)
                        // Using LOWER for case-insensitive search and CONCAT_WS to handle NULLs
                        $fullNameExpression = DB::raw("LOWER(CONCAT_WS(' ', ho_tenlot, ten))");
                        $q->where($fullNameExpression, 'like', strtolower($searchParam));
                    })->orWhereHas('tiengchinh', function ($q) use ($searchParam) {
                        // Search by guide's name (ho_tenlot + ' ' + ten)
                        // Using LOWER for case-insensitive search and CONCAT_WS to handle NULLs
                        $q->where(DB::raw("LOWER(ten)"), 'like', strtolower($searchParam));
                    })->orWhereHas('thoihanthe', function ($q) use ($searchParam) {
                        // Search by guide's name (ho_tenlot + ' ' + ten)
                        // Using LOWER for case-insensitive search and CONCAT_WS to handle NULLs
                        $q->where(DB::raw("LOWER(ten)"), 'like', strtolower($searchParam));
                    })->orWhereHas('noicapthe', function ($q) use ($searchParam) {
                        // Search by guide's name (ho_tenlot + ' ' + ten)
                        // Using LOWER for case-insensitive search and CONCAT_WS to handle NULLs
                        $q->where(DB::raw("LOWER(ten)"), 'like', strtolower($searchParam));
                    });
            });
        }

        $hdvdl_thes = $hdvdl_thes_query->orderBy('id', 'asc')->paginate(10);

        return view('livewire.hdvdl-thes', ['hdvdl_thes' => $hdvdl_thes, 'hdvdl_huongdanviens' => $this->hdvdl_huongdanviens, 'hdvdl_ngonngus' => $this->hdvdl_ngonngus, 'hdvdl_noicapthes' => $this->hdvdl_noicapthes, 'hdvdl_thoihanthes' => $this->hdvdl_thoihanthes]);
    }

    public function store()
    {
        $this->check_authentication('thêm mới');

        $this->validate($this->rules(), $this->messages());

        try {
            $hdvdl_the = new HdvdlThe();
            $hdvdl_the->huongdanvien_id = $this->hdvdl_huongdanvien_id;
            $hdvdl_the->huongdan_tiengchinh = $this->hdvdl_ngonnguchinh_id;
            $hdvdl_the->sothe = $this->sothe;
            $hdvdl_the->noicapthe_id = $this->hdvdl_noicapthe_id;
            $hdvdl_the->thoihanthe_id = $this->hdvdl_thoihanthe_id;
            $hdvdl_the->tungay = $this->tungay ? Carbon::createFromFormat('d/m/Y', $this->tungay)->format('Y-m-d') : null;
            $hdvdl_the->denngay = $this->denngay ? Carbon::createFromFormat('d/m/Y', $this->denngay)->format('Y-m-d') : null;
            $hdvdl_the->trangthai = $this->trangthai ?? 1;
            $hdvdl_the->daxoa = 0;
            $hdvdl_the->save();

            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Thêm mới thẻ hướng dẫn viên thành công!',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error("Lỗi khi thêm mới thẻ hướng dẫn viên: " . $e->getMessage());

            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Đã có lỗi xảy ra trong quá trình thêm mới thẻ hướng dẫn viên, mời bạn thao tác lại!',
                type: 'error'
            );
        } finally {
            $this->resetFields();
            $this->dispatch('close-modal');
        }
    }

    public function edit($id)
    {
        $this->check_authentication('chỉnh sửa');

        try {
            $hdvdl_the = $this->findHdvdlTheOrFail($id);
            $this->hdvdl_huongdanvien_id = $hdvdl_the->huongdanvien_id;
            $this->hdvdl_ngonnguchinh_id = $hdvdl_the->huongdan_tiengchinh;
            $this->sothe = $hdvdl_the->sothe;
            $this->hdvdl_noicapthe_id = $hdvdl_the->noicapthe_id;
            $this->hdvdl_thoihanthe_id = $hdvdl_the->thoihanthe_id;
            $this->tungay = $hdvdl_the->tungay->format('d/m/Y');
            $this->denngay = $hdvdl_the->denngay->format('d/m/Y');
            $this->trangthai = $hdvdl_the->trangthai;
            $this->denngay = $hdvdl_the->denngay->format('d/m/Y');
            $this->trangthai = $hdvdl_the->trangthai;
            $this->the_edit_id = $hdvdl_the->id;

            $this->dispatch('show-edit-the-modal');
        } catch (ModelNotFoundException $e) {
            Log::info('Không tìm thấy thẻ hướng dẫn viên để chỉnh sửa: ' . $e->getMessage());

            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy thẻ để chỉnh sửa.',
                type: 'error'
            );
            $this->dispatch('close-modal'); // Close modal if item not found
        }
    }

    public function update()
    {
        $this->check_authentication('cập nhật');

        $this->validate($this->rules(), $this->messages());

        try {
            $hdvdl_the = $this->findHdvdlTheOrFail($this->the_edit_id);
            $hdvdl_the->huongdanvien_id = $this->hdvdl_huongdanvien_id;
            $hdvdl_the->huongdan_tiengchinh = $this->hdvdl_ngonnguchinh_id;
            $hdvdl_the->sothe = $this->sothe;
            $hdvdl_the->noicapthe_id = $this->hdvdl_noicapthe_id;
            $hdvdl_the->thoihanthe_id = $this->hdvdl_thoihanthe_id;
            $hdvdl_the->tungay = $this->tungay ? Carbon::createFromFormat('d/m/Y', $this->tungay)->format('Y-m-d') : null;
            $hdvdl_the->denngay = $this->denngay ? Carbon::createFromFormat('d/m/Y', $this->denngay)->format('Y-m-d') : null;
            $hdvdl_the->trangthai = $this->trangthai ?? 1;
            $hdvdl_the->save();

            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Chỉnh sửa thẻ hướng dẫn viên thành công!',
                type: 'success'
            );
        } catch (ModelNotFoundException $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy thẻ để cập nhật.',
                type: 'error'
            );
        } catch (\Exception $e) {
            Log::info('Lỗi khi chỉnh sửa thẻ hướng dẫn viên: ' . $e->getMessage());

            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Có lỗi xảy ra trong quá trình chỉnh sửa thẻ hướng dẫn viên, vui lòng thao tác lại!',
                type: 'error'
            );
        } finally {
            $this->resetFields();
            $this->dispatch('close-modal');
        }
    }

    public function delete($id)
    {
        try {
            $hdvdl_the = $this->findHdvdlTheOrFail($id);
            $this->the_delete_id = $hdvdl_the->id;
            $this->dispatch('show-delete-the-modal');
        } catch (ModelNotFoundException $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy thẻ để xoá.',
                type: 'error'
            );
        }
    }

    public function deleteThe()
    {
        $this->check_authentication('xóa');

        try {
            $hdvdl_the = $this->findHdvdlTheOrFail($this->the_delete_id);
            $hdvdl_the->daxoa = 1;
            $hdvdl_the->save();

            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Đã xoá thẻ thành công!',
                type: 'success'
            );
        } catch (ModelNotFoundException $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy thẻ để xoá.',
                type: 'error'
            );
        } catch (\Throwable $th) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Có lỗi xảy ra trong quá trình xoá thẻ, vui lòng thao tác lại!',
                type: 'error'
            );
        } finally {
            $this->resetFields();
            $this->dispatch('close-modal');
        }
    }

    public function view($id)
    {
        $this->check_authentication('xem chi tiết');

        try {
            $hdvdl_the = $this->findHdvdlTheOrFail($id);
            $this->view_the_id = $hdvdl_the->id;
            $this->view_the_huongdanvien = $hdvdl_the->huongdanvien->ten;
            $this->view_the_ngonnguchinh = $hdvdl_the->tiengchinh->ten;
            $this->view_the_sothe = $hdvdl_the->sothe;
            $this->view_the_noicapthe = $hdvdl_the->noicapthe->ten;
            $this->view_the_thoihanthe = $hdvdl_the->thoihanthe->ten;
            $this->view_the_tungay = $hdvdl_the->tungay->format('d/m/Y');
            $this->view_the_denngay = $hdvdl_the->denngay->format('d/m/Y');
            $this->view_the_trangthai = $hdvdl_the->getTrangThai();
            $this->dispatch('show-view-the-modal');
        } catch (ModelNotFoundException $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy thẻ để xem.',
                type: 'error'
            );
        }
    }

    public function closeViewModal()
    {
        $this->view_the_id = '';
        $this->view_the_huongdanvien = '';
        $this->view_the_ngonnguchinh = '';
        $this->view_the_sothe = '';
        $this->view_the_noicapthe = '';
        $this->view_the_thoihanthe = '';
        $this->view_the_tungay = '';
        $this->view_the_denngay = '';
        $this->view_the_trangthai = '';
        $this->dispatch('close-modal');
    }
}
