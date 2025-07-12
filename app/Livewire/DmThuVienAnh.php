<?php

namespace App\Livewire;

use App\Models\ParentDirectory;
use App\Models\PhotoGallery;
use App\Models\SubFolder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManager as ImageTool;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class DmThuVienAnh extends Component
{

    use WithPagination, WithFileUploads;
    public $paginationTheme = 'bootstrap';

    public $hinhanhs = [];
    public $slugCha, $slugCon, $thuMucCha, $thuMucCon;
    public $trangthai = 1;
    public $photoId, $ten, $original_name;
    public $hinhanh_edit, $hinhanh_exist;
    public $the_delete_id;
    public $search = '';


    public function rules()
    {
        return [
            'hinhanhs.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    protected $messages = [
        'hinhanhs.*.required' => 'Hình ảnh không được để trống.',
        'hinhanhs.*.image' => 'Hình ảnh phải là một tệp hình ảnh.',
        'hinhanhs.*.mimes' => 'Hình ảnh phải có định dạng jpeg, png hoặc jpg.',
        'hinhanhs.*.max' => 'Hình ảnh không được vượt quá 2MB.',
    ];

    public function resetFields()
    {
        $this->hinhanhs = [];
        $this->hinhanh_edit = null;
        $this->hinhanh_exist = null;
        $this->ten = null;
        $this->original_name = null;
        $this->trangthai = 1;
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
            Log::info('Người dùng chưa đăng nhập khi truy cập chức năng ' . $action . ' ảnh.');
            return redirect()->route('login');
        }
    }

    public function mount($slugCha, $slugCon)
    {
        $this->slugCha = $slugCha;
        $this->slugCon = $slugCon;

        $this->thuMucCha = ParentDirectory::where('slug', $slugCha)->first();
        $this->thuMucCon = SubFolder::where('slug', $slugCon)->first();

        if (!$this->thuMucCon || !$this->thuMucCha) {
            abort(404, 'Không tìm thấy thư mục.');
        }
    }

    public function store()
    {
        $this->check_authentication('thêm mới');

        $this->validate();

        try {
            foreach ($this->hinhanhs as $hinhanh) {
                // Tạo tên file mới
                $photo_name = md5($hinhanh->getClientOriginalName() . microtime()) . '.' . $hinhanh->extension();
                $targetPath = 'images/' . $this->thuMucCha->ten . '/' . $this->thuMucCon->ten . '/' . $photo_name;
                $fullPath = public_path($targetPath);

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
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
                    'children_id' => $this->thuMucCon->id,
                    'trangthai' => $this->trangthai
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
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi thêm mới ảnh.',
                type: 'error'
            );

            session()->flash('error', 'Có lỗi xảy ra khi thêm mới ảnh.');
        }

        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $this->check_authentication('chỉnh sửa');

        $photo = PhotoGallery::findOrFail($id);
        $this->photoId = $photo->id;
        $this->ten = $photo->ten;
        $this->original_name = $photo->original_name;
        $this->hinhanh_exist = $photo->url;
        $this->trangthai = $photo->trangthai;

        $this->dispatch('show-edit-modal');
    }

    public function update()
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
                $targetPath = 'images/' . $this->thuMucCha->ten . '/' . $this->thuMucCon->ten . '/' . $photo_name;
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
                'children_id' => $this->thuMucCon->id,
                'trangthai' => $this->trangthai,
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
        $this->check_authentication('xóa');

        try {
            $photo = PhotoGallery::findOrFail($id);
            $this->the_delete_id = $photo->id;
            $this->dispatch('show-delete-modal');
        } catch (\Exception $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy ảnh để xoá.',
                type: 'error'
            );
        }
    }

    public function deletePhoto()
    {
        $this->check_authentication('xóa');

        try {
            $photo = PhotoGallery::findOrFail($this->the_delete_id);

            // Xóa file ảnh nếu tồn tại
            if ($photo->url && file_exists(public_path($photo->url))) {
                unlink(public_path($photo->url));
            }

            // $photo->update(['daxoa' => 1]);
            $photo->delete();

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
                message: 'Có lỗi xảy ra khi xóa ảnh.',
                type: 'error'
            );
        }

        $this->dispatch('close-modal');
    }

    public function removeImage($index)
    {
        if (isset($this->hinhanhs[$index])) {
            unset($this->hinhanhs[$index]);
            $this->hinhanhs = array_values($this->hinhanhs); // reset lại chỉ số
        }
    }

    public function updatingSearch()
    {
        $this->resetPage(); // quay về trang đầu tiên khi search thay đổi
    }

    public function closeViewModal()
    {
        $this->hinhanhs = [];
        $this->hinhanh_edit = null;
        $this->hinhanh_exist = null;
        $this->ten = null;
        $this->original_name = null;
        $this->photoId = null;
        $this->trangthai = 1;
        $this->dispatch('close-modal');
    }

    public function render()
    {
        if (!$this->search) {
            $photo = PhotoGallery::latest()->where("children_id", $this->thuMucCon->id)->where("daxoa", 0)->paginate(20);
        } else {
            $photo = PhotoGallery::latest()->where("children_id", $this->thuMucCon->id)->where("daxoa", 0)->where('ten', 'like', '%' . $this->search . '%')->paginate(20);
        }
        return view('livewire.dm-thu-vien-anh', ['photos' => $photo]);
    }
}
