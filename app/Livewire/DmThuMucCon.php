<?php

namespace App\Livewire;

use App\Models\ParentDirectory;
use App\Models\PhotoGallery;
use App\Models\SubFolder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager as ImageTool;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class DmThuMucCon extends Component
{
    use WithPagination, WithFileUploads;
    public $paginationTheme = 'bootstrap';

    public $ten;
    public $slugCha;
    public $thuMucCha;
    public $parentId;
    public $trangthai = 1;
    public $childrenId;
    public $the_delete_id;
    public $search = '';

    public $hinhanhs = [];
    public $trangThaiAnh = 1;
    public $photoId, $original_name;
    public $hinhanh_edit, $hinhanh_exist;
    public $hinhanh_delete;
    public $photo_delete_id;


    public function rules() {
        $tenRule = 'required|min:3|max:255|unique:sub_folders,ten';
        if($this->childrenId) {
            $tenRule = 'required|min:3|max:255|unique:sub_folders,ten,' . $this->childrenId;
        }

        return [
            'ten' => $tenRule
        ];
    }

    protected $messages = [
        'ten.required' => 'Tên thư mục con không được để trống.',
        'ten.min' => 'Tên thư mục con phải có ít nhất 3 ký tự.',
        'ten.max' => 'Tên thư mục conkhông được vượt quá 255 ký tự.',
        'ten.unique' => 'Tên thư mục conđã tồn tại.',
    ];

    public function resetFields()
    {
        $this->ten = '';
        $this->trangthai = 1;
        $this->childrenId = null;

        $this->hinhanhs = [];
        $this->hinhanh_edit = null;
        $this->hinhanh_exist = null;
        $this->original_name = null;
        $this->trangThaiAnh = 1;
        $this->photoId = null;
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
            Log::info('Người dùng chưa đăng nhập khi truy cập chức năng ' . $action . ' thư mục con.');
            return redirect()->route('login');
        }
    }

    public function mount($slugCha) {
        $this->slugCha = $slugCha;
        $this->thuMucCha = ParentDirectory::where('slug', $slugCha)->first();
        // dump($this->thuMucCha->id);
    }

    public function store()
    {
        $this->check_authentication('thêm mới');

        $this->validate();

        try {
            SubFolder::updateOrCreate(['id' => $this->childrenId], [
                'ten' => $this->ten,
                'slug' => Str::slug($this->ten),
                'parent_id' => $this->thuMucCha->id,
                'trangthai' => $this->trangthai
            ]);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: $this->childrenId ? 'Cập nhật thư mục con thành công.' : 'Thêm mới thư mục con thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm mới thư mục con: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi thêm mới thư mục con.',
                type: 'error'
            );
        }
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function storePhoto()
    {
        $this->check_authentication('thêm mới');

        // Kiểm tra xem có ảnh được upload không
        if (empty($this->hinhanhs)) {
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Vui lòng chọn ít nhất một ảnh để upload.',
                type: 'error'
            );
            return;
        }

        $this->validate([
            'hinhanhs.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'hinhanhs.*.required' => 'Hình ảnh không được để trống.',
            'hinhanhs.*.image' => 'Hình ảnh phải là một tệp hình ảnh.',
            'hinhanhs.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png hoặc jpg.',
            'hinhanhs.*.max' => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        try {
            foreach ($this->hinhanhs as $hinhanh) {
                // Tạo tên file mới
                $photo_name = md5($hinhanh->getClientOriginalName() . microtime()) . '.' . $hinhanh->extension();
                $targetPath = 'images/' . $this->thuMucCha->ten . '/' . $photo_name;
                $fullPath = public_path($targetPath);

                // Tạo thư mục nếu chưa tồn tại
                $directory = dirname($fullPath);
                if (!file_exists($directory)) {
                    if (!mkdir($directory, 0755, true)) {
                        throw new \Exception('Không thể tạo thư mục: ' . $directory);
                    }
                }

                // Resize và lưu ảnh về kích thước 800x533, giữ tỷ lệ khung hình
                $manager = new ImageTool(new GdDriver());
                $image = $manager->read($hinhanh);
                $image->resize(800, 533, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Lưu ảnh đã resize
                $image->save($fullPath);

                PhotoGallery::create([
                    // Lấy tên ảnh không bao gồm đuôi file
                    'ten' => pathinfo($hinhanh->getClientOriginalName(), PATHINFO_FILENAME),
                    'original_name' => $hinhanh->getClientOriginalName(),
                    'url' => $targetPath,
                    'slug' => Str::slug(pathinfo($hinhanh->getClientOriginalName(), PATHINFO_FILENAME)),
                    'parent_id' => $this->thuMucCha->id,
                    'trangthai' => $this->trangThaiAnh
                ]);
            }

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Thêm mới ảnh thành công.',
                type: 'success'
            );

            session()->flash('success', 'Thêm mới ảnh thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm mới ảnh: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi thêm mới ảnh: ' . $e->getMessage(),
                type: 'error'
            );

            session()->flash('error', 'Có lỗi xảy ra khi thêm mới ảnh: ' . $e->getMessage());
        }

        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->check_authentication('chỉnh sửa');

        $thuMucCon = SubFolder::findOrFail($id);
        $this->childrenId = $thuMucCon->id;
        $this->ten = $thuMucCon->ten;
        $this->trangthai = $thuMucCon->trangthai;

        $this->dispatch('show-edit-modal');
    }

    public function editPhoto($id)
    {
        $this->check_authentication('chỉnh sửa');

        $photo = PhotoGallery::findOrFail($id);
        $this->photoId = $photo->id;
        $this->original_name = $photo->original_name;
        $this->hinhanh_exist = $photo->url;
        $this->trangThaiAnh = $photo->trangthai;

        $this->dispatch('show-edit-photo-modal');
    }

    public function removeImage($index)
    {
        if (isset($this->hinhanhs[$index])) {
            unset($this->hinhanhs[$index]);
            $this->hinhanhs = array_values($this->hinhanhs);
        }
    }

    public function updatePhoto()
    {
        $this->check_authentication('cập nhật');

        $this->validate([
            'hinhanh_edit' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'hinhanh_edit.image' => 'Hình ảnh phải là một tệp hình ảnh.',
            'hinhanh_edit.mimes' => 'Hình ảnh phải có định dạng jpeg, png hoặc jpg.',
            'hinhanh_edit.max' => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        try {
            $targetPath = $this->hinhanh_exist; // Mặc định giữ lại ảnh cũ
            $ten = $this->ten;
            $originalName = $this->original_name;
            $slug = Str::slug($ten);

            // Nếu có ảnh mới được upload
            if ($this->hinhanh_edit instanceof UploadedFile) {
                // Xóa ảnh cũ nếu tồn tại
                if ($this->hinhanh_exist && file_exists(public_path($this->hinhanh_exist))) {
                    unlink(public_path($this->hinhanh_exist));
                }

                // Tạo tên file mới
                $photo_name = md5($this->hinhanh_edit->getClientOriginalName() . microtime()) . '.' . $this->hinhanh_edit->extension();
                $targetPath = 'images/' . $this->thuMucCha->ten . $photo_name;
                $fullPath = public_path($targetPath);

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }

                // Resize và lưu ảnh
                $manager = new ImageTool(new GdDriver());
                $image = $manager->read($this->hinhanh_edit);

                $image->resize(800, 533, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $image->save($fullPath);

                // Nếu ảnh mới thì cập nhật lại tên + slug
                $ten = pathinfo($this->hinhanh_edit->getClientOriginalName(), PATHINFO_FILENAME);
                $originalName = $this->hinhanh_edit->getClientOriginalName();
                $slug = Str::slug($ten);
            }

            // Lấy bản ghi hiện tại để update
            $photo = PhotoGallery::findOrFail($this->photoId); // <-- cần có $photoId (id ảnh đang chỉnh sửa)

            $photo->update([
                'ten' => $ten,
                'original_name' => $originalName,
                'url' => $targetPath,
                'slug' => $slug,
                'parent_id' => $this->thuMucCha->id,
                'trangthai' => $this->trangThaiAnh,
            ]);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Cập nhật ảnh thành công.',
                type: 'success'
            );
            $this->resetFields();
            session()->flash('success', 'Cập nhật ảnh thành công.');
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật ảnh: ' . $e->getMessage());

            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi cập nhật ảnh.',
                type: 'error'
            );

            session()->flash('error', 'Có lỗi xảy ra khi cập nhật ảnh.');
        } finally {
            $this->dispatch('close-modal');
        }
    }

    public function delete($id)
    {
        try {
            $thuMucCon = SubFolder::findOrFail($id);
            $this->the_delete_id = $thuMucCon->id;
            $this->dispatch('show-delete-modal');
        } catch (\Exception $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy thư mục con để xoá.',
                type: 'error'
            );
        }
    }

    public function deleteChildren()
    {
        $this->check_authentication('xóa');

        try {
            $thuMucCon = SubFolder::findOrFail($this->the_delete_id);
            $thuMucCon->update(['daxoa' => 1]);
            // $thư mụcAnh->delete();

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Đã xóa thư mục con thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa thư mục con: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi xóa thư mục con.',
                type: 'error'
            );
        }

        $this->dispatch('close-modal');
    }

    public function deletePhoto($id)
    {
        try {
            $photo = PhotoGallery::findOrFail($id);
            $this->photo_delete_id = $photo->id;
            $this->dispatch('show-delete-photo-modal');
        } catch (\Exception $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy ảnh để xoá.',
                type: 'error'
            );
        }
    }

    public function deletePhotoConfirm()
    {
        $this->check_authentication('xóa ảnh');

        try {
            $photo = PhotoGallery::findOrFail($this->photo_delete_id);
            
            // Xóa file ảnh từ storage
            if ($photo->url && Storage::disk('public')->exists($photo->url)) {
                Storage::disk('public')->delete($photo->url);
            }
            
            $photo->update(['daxoa' => 1]);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Đã xóa ảnh thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa ảnh: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi xóa ảnh: ' . $e->getMessage(),
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
        $this->childrenId = '';
        $this->ten = '';
        $this->trangthai = 1;
        $this->dispatch('close-modal');
    }

    public function render()
    {
        if(!$this->search) {
            $thuMucCon = SubFolder::latest()->where("parent_id", $this->thuMucCha->id)->where("daxoa", 0)->paginate(20);
            $photo = PhotoGallery::latest()->where("parent_id", $this->thuMucCha->id)->where("daxoa", 0)->paginate(20);
        } else {
            $thuMucCon = SubFolder::latest()->where("parent_id", $this->thuMucCha->id)->where("daxoa", 0)->where('ten', 'like', '%'.$this->search.'%')->paginate(20);
            $photo = PhotoGallery::latest()->where("parent_id", $this->thuMucCha->id)->where("daxoa", 0)->where('ten', 'like', '%' . $this->search . '%')->paginate(20);
        }
        return view('livewire.dm-thu-muc-con', ['thuMucCons' => $thuMucCon, 'photos' => $photo]);
    }
}
