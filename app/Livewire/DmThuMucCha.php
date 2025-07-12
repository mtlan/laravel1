<?php

namespace App\Livewire;

use App\Models\ParentDirectory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class DmThuMucCha extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';

    public $ten;
    public $trangthai = 1;
    public $parentId;
    public $the_delete_id;
    public $search = '';


    public function rules() {
        $tenRule = 'required|min:3|max:255|unique:parent_directories,ten';
        if($this->parentId) {
            $tenRule = 'required|min:3|max:255|unique:parent_directories,ten,' . $this->parentId;
        }

        return [
            'ten' => $tenRule
        ];
    }

    protected $messages = [
        'ten.required' => 'Tên thư mục không được để trống.',
        'ten.min' => 'Tên thư mục phải có ít nhất 3 ký tự.',
        'ten.max' => 'Tên thư mục không được vượt quá 255 ký tự.',
        'ten.unique' => 'Tên thư mục đã tồn tại.',
    ];

    public function resetFields()
    {
        $this->ten = '';
        $this->trangthai = 1;
        $this->parentId = null;
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
            Log::info('Người dùng chưa đăng nhập khi truy cập chức năng ' . $action . ' thư mục.');
            return redirect()->route('login');
        }
    }

    public function store()
    {
        $this->check_authentication('thêm mới');

        $this->validate();

        try {
            ParentDirectory::updateOrCreate(['id' => $this->parentId], [
                'ten' => $this->ten,
                'slug' => Str::slug($this->ten),
                'trangthai' => $this->trangthai
            ]);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: $this->parentId ? 'Cập nhật thư mục thành công.' : 'Thêm mới thư mục thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm mới thư mục: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi thêm mới thư mục.',
                type: 'error'
            );
        }
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->check_authentication('chỉnh sửa');

        $thuMucCha = ParentDirectory::findOrFail($id);
        $this->parentId = $thuMucCha->id;
        $this->ten = $thuMucCha->ten;
        $this->trangthai = $thuMucCha->trangthai;

        $this->dispatch('show-edit-modal');
    }

    public function delete($id)
    {
        try {
            $thuMucCha = ParentDirectory::findOrFail($id);
            $this->the_delete_id = $thuMucCha->id;
            $this->dispatch('show-delete-modal');
        } catch (\Exception $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy thư mục để xoá.',
                type: 'error'
            );
        }
    }

    public function deleteParent()
    {
        $this->check_authentication('xóa');

        try {
            $thuMucCha = ParentDirectory::findOrFail($this->the_delete_id);
            $thuMucCha->update(['daxoa' => 1]);
            // $thư mụcAnh->delete();

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Đã xóa thư mục thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa thư mục: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi xóa thư mục.',
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
        $this->parentId = '';
        $this->ten = '';
        $this->trangthai = 1;
        $this->dispatch('close-modal');
    }

    public function render()
    {
        if(!$this->search) {
            $thuMucCha = ParentDirectory::latest()->where("daxoa", 0)->paginate(20);
        } else {
            $thuMucCha = ParentDirectory::latest()->where("daxoa", 0)->where('ten', 'like', '%'.$this->search.'%')->paginate(20);
        }
        return view('livewire.dm-thu-muc-cha', ['thuMucChas' => $thuMucCha]);
    }
}
