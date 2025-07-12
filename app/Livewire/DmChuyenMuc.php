<?php

namespace App\Livewire;

use App\Models\ChuyenMuc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class DmChuyenMuc extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';

    public $ten, $type, $daxoa;
    public $trangthai = 1;
    public $chuyenmucId;
    public $the_delete_id;
    public $search = '';


    public function rules() {
        $tenRule = 'required|min:3|max:255|unique:chuyen_muc,ten';
        if($this->chuyenmucId) {
            $tenRule = 'required|min:3|max:255|unique:chuyen_muc,ten,' . $this->chuyenmucId;
        }

        return [
            'ten' => $tenRule
        ];
    }

    protected $messages = [
        'ten.required' => 'Tên chuyên mục không được để trống.',
        'ten.min' => 'Tên chuyên mục phải có ít nhất 3 ký tự.',
        'ten.max' => 'Tên chuyên mục không được vượt quá 255 ký tự.',
        'ten.unique' => 'Tên chuyên mục đã tồn tại.',
        'type.required' => 'Vui lý nhập loại chuyên mục.'
    ];

    public function resetFields()
    {
        $this->ten = '';
        $this->type = '';
        $this->trangthai = 1;
        $this->chuyenmucId = null;
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
            Log::info('Người dùng chưa đăng nhập khi truy cập chức năng ' . $action . ' chuyên mục.');
            return redirect()->route('login');
        }
    }

    public function store()
    {
        $this->check_authentication('thêm mới');

        $this->validate();

        try {
            ChuyenMuc::updateOrCreate(['id' => $this->chuyenmucId], [
                'ten' => $this->ten,
                'slug' => Str::slug($this->ten),
                'type' => $this->type,
                'trangthai' => $this->trangthai
            ]);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: $this->chuyenmucId ? 'Cập nhật chuyên mục thành công.' : 'Thêm mới chuyên mục thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm mới chuyên mục: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi thêm mới chuyên mục.',
                type: 'error'
            );
        }
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->check_authentication('chỉnh sửa');

        $chuyenmuc = ChuyenMuc::findOrFail($id);
        $this->chuyenmucId = $chuyenmuc->id;
        $this->ten = $chuyenmuc->ten;
        $this->type = $chuyenmuc->type;
        $this->trangthai = $chuyenmuc->trangthai;

        $this->dispatch('show-edit-modal');
    }

    public function view($id)
    {
        $this->check_authentication('xem chi tiết');

        $chuyenmuc = ChuyenMuc::findOrFail($id);
        $this->chuyenmucId = $chuyenmuc->id;
        $this->ten = $chuyenmuc->ten;
        $this->type = $chuyenmuc->getType();
        $this->trangthai = $chuyenmuc->getTrangThai();

        $this->dispatch('show-view-modal');
    }

    public function delete($id)
    {
        try {
            $chuyenmuc = ChuyenMuc::findOrFail($id);
            $this->the_delete_id = $chuyenmuc->id;
            $this->dispatch('show-delete-modal');
        } catch (\Exception $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy chuyên mục để xoá.',
                type: 'error'
            );
        }
    }

    public function deleteChuyenMuc()
    {
        $this->check_authentication('xóa');

        try {
            $chuyenmuc = ChuyenMuc::findOrFail($this->the_delete_id);
            // $chuyenmuc->update(['daxoa' => 1]);
            $chuyenmuc->delete();

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Đã xóa chuyên mục thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa chuyên mục: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi xóa chuyên mục.',
                type: 'error'
            );
        }

        $this->dispatch('close-modal');
    }

    public function updatingSearch()
    {
        $this->resetPage(); // quay về trang đầu tiên khi search thay đổi
    }

    public function closeViewModal()
    {
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function render()
    {
        if(!$this->search) {
            $chuyenMuc = ChuyenMuc::latest()->where("daxoa", 0)->paginate(20);
        } else {
            $chuyenMuc = ChuyenMuc::latest()->where("daxoa", 0)->where('ten', 'like', '%'.$this->search.'%')->paginate(20);
        }
        return view('livewire.dm-chuyen-muc',['chuyenmucs' => $chuyenMuc]);
    }
}
