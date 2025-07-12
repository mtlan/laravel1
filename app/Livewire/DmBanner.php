<?php

namespace App\Livewire;

use App\Models\PhotoGallery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager as ImageTool;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class DmBanner extends Component
{

    use WithPagination, WithFileUploads;
    public $paginationTheme = 'bootstrap';

    public $ten, $hinhanh, $hinhanhGoc;
    public $trangthai = 1;
    public $bannerId;
    public $the_delete_id;
    public $search = '';


    public function rules() {
        $tenRule = 'required|min:3|max:255|unique:photo_galleries,ten';
        if($this->bannerId) {
            $tenRule = 'required|min:3|max:255|unique:photo_galleries,ten,' . $this->bannerId;
        }

        return [
            'ten' => $tenRule,
            'hinhanh' => $this->bannerId ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    protected $messages = [
        'ten.required' => 'Tên banner không được để trống.',
        'ten.min' => 'Tên banner phải có ít nhất 3 ký tự.',
        'ten.max' => 'Tên banner không được vượt quá 255 ký tự.',
        'ten.unique' => 'Tên banner đã tồn tại.',
        'hinhanh.required' => 'Hình banner không được để trống.',
        'hinhanh.image' => 'Hình banner phải là một tệp hình ảnh.',
        'hinhanh.mimes' => 'Hình banner phải có định dạng jpeg, png hoặc jpg.',
        'hinhanh.max' => 'Hình banner phải nhỏ hơn 2MB.',
    ];

    public function resetFields()
    {
        $this->ten = '';
        $this->hinhanh = '';
        $this->hinhanhGoc = '';
        $this->trangthai = 1;
        $this->bannerId = null;
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
            Log::info('Người dùng chưa đăng nhập khi truy cập chức năng ' . $action . ' banner.');
            return redirect()->route('login');
        }
    }

    public function store()
    {
        $this->check_authentication('thêm mới');

        $this->validate();

        $targetPath = $this->hinhanhGoc; // Mặc định giữ lại banner cũ

        // Nếu có banner mới được upload
        if ($this->hinhanh && $this->hinhanh instanceof \Illuminate\Http\UploadedFile) {
            // Xóa file cũ nếu có
            if ($this->hinhanhGoc && file_exists(public_path($this->hinhanhGoc))) {
                unlink(public_path($this->hinhanhGoc));
            }

            // Tạo tên ảnh mới
            $photo_name = md5($this->hinhanh->getClientOriginalName() . microtime()) . '.' . $this->hinhanh->extension();
            $targetPath = 'images/banners/' . $photo_name;
            $fullPath = public_path($targetPath);

            // Tạo thư mục nếu chưa tồn tại
            if (!file_exists(dirname($fullPath))) {
                mkdir(dirname($fullPath), 0755, true);
            }

            // Resize và lưu
            $manager = new ImageTool(new GdDriver());
            $image = $manager->read($this->hinhanh);
            $image->resize(1600, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $image->save($fullPath); // Đường dẫn tuyệt đối
        }

        try {
            PhotoGallery::updateOrCreate(['id' => $this->bannerId], [
                'ten' => $this->ten,
                'original_name' => $this->hinhanh ? $this->hinhanh->getClientOriginalName() : '',
                'url' => $targetPath,
                'slug' => Str::slug($this->ten),
                'trangthai' => $this->trangthai
            ]);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: $this->bannerId ? 'Cập nhật banner thành công.' : 'Thêm mới banner thành công.',
                type: 'success'
            );
            
            session()->flash('success', $this->bannerId ? 'Cập nhật banner thành công.' : 'Thêm mới banner thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm mới banner: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi thêm mới banner.',
                type: 'error'
            );
            
            session()->flash('error', 'Có lỗi xảy ra khi thêm mới banner.');
        }
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->check_authentication('chỉnh sửa');

        $banner = PhotoGallery::findOrFail($id);
        $this->bannerId = $banner->id;
        $this->ten = $banner->ten;
        $this->hinhanhGoc = $banner->url;
        $this->trangthai = $banner->trangthai;

        $this->dispatch('show-edit-modal');
    }

    public function delete($id)
    {
        $this->check_authentication('xóa');

        try {
            $banner = PhotoGallery::findOrFail($id);
            $this->the_delete_id = $banner->id;
            $this->dispatch('show-delete-modal');
        } catch (\Exception $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy banner để xoá.',
                type: 'error'
            );
        }
    }

    public function deleteBanner()
    {
        $this->check_authentication('xóa');

        try {
            $banner = PhotoGallery::findOrFail($this->the_delete_id);
            
            // Xóa file banner nếu tồn tại
            if ($banner->url && file_exists(public_path($banner->url))) {
                unlink(public_path($banner->url));
            }
            
            $banner->update(['daxoa' => 1]);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Đã xóa banner thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa banner: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi xóa banner.',
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
        $this->bannerId = '';
        $this->ten = '';
        $this->trangthai = 1;
        $this->dispatch('close-modal');
    }
    
    public function render()
    {
        if(!$this->search) {
            $banner = PhotoGallery::latest()->where("children_id", 0)->where("daxoa", 0)->paginate(20);
        } else {
            $banner = PhotoGallery::latest()->where("children_id", 0)->where("daxoa", 0)->where('ten', 'like', '%'.$this->search.'%')->paginate(20);
        }
        return view('livewire.dm-banner', ['banners' => $banner]);
    }
}
