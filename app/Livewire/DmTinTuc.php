<?php

namespace App\Livewire;

use App\Models\ChuyenMuc;
use App\Models\CmsAttachment;
use App\Models\TinTuc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Intervention\Image\ImageManager as ImageTool;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class DmTinTuc extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $paginationTheme = 'bootstrap';

    public $tinTuc, $chuyenMuc, $tuKhoa;
    public $ten, $hinhanh, $hinhanhGoc, $mota, $noidung;
    public $filedinhkem, $filedinhkemGoc;
    public $chuyenMucList = [];
    public $tukhoa;
    public $trangthai = 1;
    public $tintucId;
    public $the_delete_id;
    public $search;
    public $chuyenMucSelect;
    public $attachmentId;
    public $tukhoa1;

    public function rules()
    {
        $tenRule = 'required|min:3|max:255|unique:tin_tuc,ten';
        if ($this->tintucId) {
            $tenRule = 'required|min:3|max:255|unique:tin_tuc,ten,' . $this->tintucId;
        }

        return [
            'ten' => $tenRule,
            'mota' => 'required',
            'noidung' => 'required',
            'hinhanh' => $this->tintucId ? 'nullable|image|mimes:jpeg,png,jpg' : 'required|image|mimes:jpeg,png,jpg',
            'filedinhkem' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'chuyenMucList' => 'required|array',
        ];
    }

    protected $messages = [
        'ten.required' => 'Tên không được để trống.',
        'ten.min' => 'Tên phải có ít nhất 3 ký tự.',
        'ten.max' => 'Tên không được vượt quá 255 ký tự.',
        'ten.unique' => 'Tên đã tồn tại.',
        'mota.required' => 'Mô tả không được để trống.',
        'noidung.required' => 'Nội dung không được để trống.',
        'hinhanh.required' => 'Hình ảnh không được để trống.',
        'hinhanh.image' => 'Hình ảnh phải là một tệp hình ảnh.',
        'hinhanh.mimes' => 'Hình ảnh phải có định dạng jpeg, png hoặc jpg.',
        'filedinhkem.file' => 'File đính kèm phải là một tệp tin.',
        'filedinhkem.mimes' => 'File đính kèm phải có định dạng PDF.',
        'filedinhkem.max' => 'File đính kèm không được vượt quá 5MB.',
        'chuyenMucList.required' => 'Chuyên mục không được để trống.',
    ];

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
            Log::info('Người dùng chưa đăng nhập khi truy cập chức năng ' . $action . ' tin tức.');
            return redirect()->route('login');
        }
    }

    public function resetFields()
    {
        $this->ten = '';
        $this->mota = '';
        $this->noidung = '';
        $this->hinhanh = '';
        $this->hinhanhGoc = '';
        $this->filedinhkem = '';
        $this->filedinhkemGoc = '';
        $this->chuyenMucList = [];
        $this->tukhoa = '';
        $this->trangthai = 1;
        $this->tintucId = null;
        $this->attachmentId = null;
    }

    public function store()
    {
        $this->check_authentication('thêm mới');
        
        $this->validate();

        try {
            // Nếu có ảnh mới được upload
            if ($this->hinhanh && $this->hinhanh instanceof \Illuminate\Http\UploadedFile) {
                // Tạo tên file mới
                $photo_name = md5($this->hinhanh->getClientOriginalName() . microtime()) . '.' . $this->hinhanh->extension();
                $targetPath = 'images/' . $photo_name;
                $fullPath = public_path($targetPath);

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }

                // Resize và lưu ảnh về kích thước 800x533, giữ tỷ lệ khung hình
                $manager = new ImageTool(new GdDriver());
                $image = $manager->read($this->hinhanh);
                $image->resize(800, 533, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Lưu ảnh đã resize
                $image->save($fullPath);
            }

            $tintuc = new TinTuc();
            $tintuc->ten = $this->ten;
            $tintuc->hinhanh = $targetPath;
            $tintuc->slug = Str::slug($this->ten);
            $tintuc->mota = $this->mota;
            $tintuc->noidung = $this->noidung;
            $tintuc->tukhoa = $this->tukhoa;
            $tintuc->trangthai = $this->trangthai;
            $tintuc->save();

            // Nếu có file đính kèm mới được upload
            if ($this->filedinhkem && $this->filedinhkem instanceof \Illuminate\Http\UploadedFile) {
                try {
                    $file_name = md5($this->filedinhkem->getClientOriginalName() . microtime()) . '.' . $this->filedinhkem->extension();
                    $targetFilePath = 'filedinhkem/' . $file_name;

                    // Kiểm tra và tạo thư mục filedinhkem
                    $attachmentDir = public_path('filedinhkem');
                    if (!file_exists($attachmentDir)) {
                        if (!mkdir($attachmentDir, 0775, true)) {
                            throw new \Exception('Không thể tạo thư mục filedinhkem');
                        }
                    }
                    
                    // Lưu file đính kèm trực tiếp
                    $this->filedinhkem->storeAs('filedinhkem', $file_name, 'real_public');

                    // Tạo bản ghi CmsAttachment
                    $attachment = new CmsAttachment();
                    $attachment->ten = $file_name;
                    $attachment->original_name = $this->filedinhkem->getClientOriginalName();
                    $attachment->url = $targetFilePath;
                    $attachment->tintuc_id = $tintuc->id;
                    $attachment->save();
                
                } catch (\Exception $e) {
                    Log::error('Lỗi khi upload file PDF: ' . $e->getMessage());
                    throw new \Exception('Không thể upload file PDF: ' . $e->getMessage());
                }
            }

            $tintuc->chuyenmucs()->sync($this->chuyenMucList);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Thêm mới tin tức thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi thêm mới tin tức: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra: ' . $e->getMessage(),
                type: 'error'
            );
        }

        $this->resetFields();
        $this->dispatch('reset-chuyenmuc');
        $this->dispatch('reset-noidung');
        $this->dispatch('reset-tukhoa');
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $tintuc = TinTuc::findOrFail($id);
        $this->tintucId = $tintuc->id;
        $this->ten = $tintuc->ten;
        $this->mota = $tintuc->mota;
        $this->noidung = $tintuc->noidung;
        $this->hinhanhGoc = $tintuc->hinhanh;
        // KHÔNG LẤY filedinhkemGoc từ tin_tuc nữa
        $this->filedinhkemGoc = null;
        $this->chuyenMucList = $tintuc->chuyenmucs->pluck('id')->toArray();
        $this->tukhoa = $tintuc->tukhoa;
        $this->trangthai = $tintuc->trangthai;

        $this->dispatch('set-chuyenmuc', chuyenmuc: $this->chuyenMucList);
        $this->dispatch('set-noidung', noidung: $this->noidung);
        $this->dispatch('set-tukhoa', tukhoa: $this->tukhoa);
        $this->dispatch('show-edit-modal');
    }

    public function update()
    {
        $this->check_authentication('chỉnh sửa');
        
        $this->validate();

        try {
            // Tìm tin tức cần cập nhật
            $tintuc = TinTuc::findOrFail($this->tintucId);
            
            $targetPath = $this->hinhanhGoc; // Mặc định giữ lại ảnh cũ
            
            // Nếu có ảnh mới được upload
            if ($this->hinhanh && $this->hinhanh instanceof \Illuminate\Http\UploadedFile) {
                // Xóa ảnh cũ nếu tồn tại
                if ($this->hinhanhGoc && file_exists(public_path($this->hinhanhGoc))) {
                    unlink(public_path($this->hinhanhGoc));
                }

                // Tạo tên file mới
                $photo_name = md5($this->hinhanh->getClientOriginalName() . microtime()) . '.' . $this->hinhanh->extension();
                $targetPath = 'images/' . $photo_name;
                $fullPath = public_path($targetPath);

                // Tạo thư mục nếu chưa tồn tại
                if (!file_exists(dirname($fullPath))) {
                    mkdir(dirname($fullPath), 0755, true);
                }

                // Resize và lưu ảnh về kích thước 800x533, giữ tỷ lệ khung hình
                $manager = new ImageTool(new GdDriver());
                $image = $manager->read($this->hinhanh);
                $image->resize(800, 533, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Lưu ảnh đã resize
                $image->save($fullPath);
            }

            // Cập nhật thông tin tin tức
            $tintuc->ten = $this->ten;
            $tintuc->hinhanh = $targetPath;
            $tintuc->slug = Str::slug($this->ten);
            $tintuc->mota = $this->mota;
            $tintuc->noidung = $this->noidung;
            $tintuc->tukhoa = $this->tukhoa;
            $tintuc->trangthai = $this->trangthai;
            $tintuc->save();

            // Nếu có file đính kèm mới được upload
            if ($this->filedinhkem && $this->filedinhkem instanceof \Illuminate\Http\UploadedFile) {
                try {
                    // Xóa file đính kèm cũ nếu có
                    $oldAttachment = $tintuc->attachments()->first();
                    if ($oldAttachment) {
                        if ($oldAttachment->url && file_exists(public_path($oldAttachment->url))) {
                            unlink(public_path($oldAttachment->url));
                        }
                        $oldAttachment->delete();
                    }

                    $file_name = md5($this->filedinhkem->getClientOriginalName() . microtime()) . '.' . $this->filedinhkem->extension();
                    $targetFilePath = 'filedinhkem/' . $file_name;

                    // Kiểm tra và tạo thư mục filedinhkem
                    $attachmentDir = public_path('filedinhkem');
                    if (!file_exists($attachmentDir)) {
                        if (!mkdir($attachmentDir, 0775, true)) {
                            throw new \Exception('Không thể tạo thư mục filedinhkem');
                        }
                    }
                    
                    // Lưu file đính kèm trực tiếp
                    $this->filedinhkem->storeAs('filedinhkem', $file_name, 'real_public');

                    // Tạo bản ghi CmsAttachment
                    $attachment = new CmsAttachment();
                    $attachment->ten = $file_name;
                    $attachment->original_name = $this->filedinhkem->getClientOriginalName();
                    $attachment->url = $targetFilePath;
                    $attachment->tintuc_id = $tintuc->id;
                    $attachment->save();
                    
                } catch (\Exception $e) {
                    Log::error('Lỗi khi upload file PDF: ' . $e->getMessage());
                    throw new \Exception('Không thể upload file PDF: ' . $e->getMessage());
                }
            }

            $tintuc->chuyenmucs()->sync($this->chuyenMucList);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Cập nhật tin tức thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi cập nhật tin tức: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra: ' . $e->getMessage(),
                type: 'error'
            );
        }

        $this->resetFields();
        $this->dispatch('reset-chuyenmuc');
        $this->dispatch('reset-noidung');
        $this->dispatch('reset-tukhoa');
        $this->dispatch('close-modal');
    }

    public function view($id)
    {
        $this->check_authentication('xem chi tiết');

        $tintuc = TinTuc::findOrFail($id);
        $this->tintucId = $tintuc->id;
        $this->ten = $tintuc->ten;
        $this->hinhanhGoc = $tintuc->hinhanh;
        // KHÔNG LẤY filedinhkemGoc từ tin_tuc nữa
        $this->filedinhkemGoc = null;
        $this->mota = $tintuc->mota;
        $this->noidung = $tintuc->noidung;
        $this->tukhoa1 = $tintuc->tukhoa;
        $this->chuyenMucList = $tintuc->chuyenmucs->pluck('id')->toArray();
        $this->trangthai = $tintuc->getTrangThai();

        $this->dispatch('show-view-modal');
    }

    public function delete($id)
    {
        try {
            $tintuc = TinTuc::findOrFail($id);
            $this->the_delete_id = $tintuc->id;
            $this->hinhanhGoc = $tintuc->hinhanh;
            $this->dispatch('show-delete-modal');
        } catch (\Exception $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy tin tức để xoá.',
                type: 'error'
            );
        }
    }

    public function deleteTinTuc()
    {
        $this->check_authentication('xóa');

        try {
            $tintuc = TinTuc::findOrFail($this->the_delete_id);
            
            // Xóa file đính kèm nếu có
            $attachment = $tintuc->attachments()->first();
            if ($attachment) {
                if ($attachment->url && file_exists(public_path($attachment->url))) {
                    unlink(public_path($attachment->url));
                }
                $attachment->delete();
            }
            
            // Xóa ảnh cũ nếu tồn tại
            if ($this->hinhanhGoc && file_exists(public_path($this->hinhanhGoc))) {
                unlink(public_path($this->hinhanhGoc));
            }
            
            $tintuc->delete();

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Đã xóa tin tức thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa tin tức: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi xóa tin tức.',
                type: 'error'
            );
        }
        $this->resetFields();
        $this->dispatch('close-modal');
    }

    // Xóa file đính kèm riêng lẻ cho 1 tin tức
    public function deleteAttachment($tintucId)
    {
        $tintuc = TinTuc::findOrFail($tintucId);
        $attachment = $tintuc->attachments()->first();
        if ($attachment) {
            if ($attachment->url && file_exists(public_path($attachment->url))) {
                unlink(public_path($attachment->url));
            }
            $attachment->delete();
            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Đã xóa file đính kèm thành công.',
                type: 'success'
            );
        } else {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy file đính kèm để xóa.',
                type: 'error'
            );
        }
    }

    public function updatingSearch()
    {
        $this->resetPage(); // quay về trang đầu tiên khi search thay đổi
    }

    public function closeViewModal()
    {
        $this->tintucId = '';
        $this->ten = '';
        $this->mota = '';
        $this->noidung = '';
        $this->hinhanh = '';
        $this->filedinhkem = '';
        $this->filedinhkemGoc = '';
        $this->chuyenMucList = [];
        $this->trangthai = 1;
        $this->tukhoa = '';
        $this->attachmentId = '';
        $this->dispatch('close-modal');
    }

    public function render()
    {
        $this->chuyenMuc = ChuyenMuc::where('trangthai', 1)->where('daxoa', 0)->get();
        // if (!$this->search) {
        //     $tinTuc = TinTuc::latest()->paginate(20);
        // } else {
        //     $tinTuc = TinTuc::latest()->where('ten', 'like', '%' . $this->search . '%')
        //         ->orWhere('mota', 'like', '%' . $this->search . '%')
        //         ->orWhere('noidung', 'like', '%' . $this->search . '%')->paginate(20);
        // }
        $query = TinTuc::query()->latest();

        // Nếu có từ khóa tìm kiếm
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('ten', 'like', '%' . $this->search . '%')
                    ->orWhere('mota', 'like', '%' . $this->search . '%')
                    ->orWhere('noidung', 'like', '%' . $this->search . '%');
            });
        }

        // Nếu có chuyên mục được chọn
        if ($this->chuyenMucSelect) {
            $query->whereHas('chuyenMucs', function ($q) {
                $q->where('chuyen_muc.id', $this->chuyenMucSelect);
            });
        }

        $tinTuc = $query->paginate(20);
        return view('livewire.dm-tin-tuc', [
            'tintucs' => $tinTuc,
            'chuyenmucs' => $this->chuyenMuc
        ]);
    }
}
