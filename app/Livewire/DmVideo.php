<?php

namespace App\Livewire;

use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class DmVideo extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $paginationTheme = 'bootstrap';

    public $ten, $url, $original_name, $trangthai = 1;
    public $loai_video = '';
    // biến video_file_exist xóa video cũ khi cập nhật lại video mới
    public $embed_code, $video_file, $video_file_exist;
    public $search;
    public $videoId, $the_delete_id;

    public function rules()
    {
        $tenRule = 'required|min:3|max:255|unique:chuyen_muc,ten';
        if ($this->videoId) {
            $tenRule = 'required|min:3|max:255|unique:chuyen_muc,ten,' . $this->videoId;
        }

        $rules = [
            'ten' => $tenRule,
            'loai_video' => 'required|in:1,2',
        ];

        if ($this->loai_video == 1) {
            $rules['embed_code'] = 'required|string';
        }

        if ($this->loai_video == 2) {
            $rules['video_file'] = 'required|file|mimes:mp4|max:102400';
        }

        return $rules;
    }

    protected $messages = [
        'ten.required' => 'Tên video không được để trống.',
        'ten.min' => 'Tên video phải có ít nhất 3 ký tự.',
        'ten.max' => 'Tên video không được vượt quá 255 ký tự.',
        'ten.unique' => 'Tên video đã tồn tại.',
        'loai_video.required' => 'Vui lòng hình thức tạo video.',
        'embed_code.required' => 'Vui lòng nhập mã nhúng YouTube.',
        'video_file.required' => 'Vui lòng tải lên một video.',
        'video_file.mimes' => 'File video phải có định dạng .mp4.',
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
            Log::info('Người dùng chưa đăng nhập khi truy cập chức năng ' . $action . ' video.');
            return redirect()->route('login');
        }
    }


    public function resetFields()
    {
        $this->ten = '';
        $this->trangthai = 1;
        $this->loai_video = '';
        $this->embed_code = '';
        $this->video_file = null;
        $this->videoId = null;
    }

    public function store()
    {
        $this->check_authentication('thêm mới');

        $this->validate();

        // Nếu có video mới được upload
        if ($this->video_file && $this->video_file instanceof \Illuminate\Http\UploadedFile) {

            // Xóa video cũ nếu tồn tại
            if ($this->video_file_exist && file_exists(public_path($this->video_file_exist))) {
                unlink(public_path($this->video_file_exist));
            }

            // Lưu video mới
            $video_name = md5($this->video_file->getClientOriginalName() . microtime()) . '.' . $this->video_file->extension();
            $this->video_file->storeAs('videos', $video_name, 'real_public');
            $targetPath = 'videos/' . $video_name;
            $this->original_name = $this->video_file->getClientOriginalName();
        } else {
            $targetPath = $this->embed_code;
            $this->original_name = "Mã nhúng youtube";
        }

        try {
            Video::updateOrCreate(['id' => $this->videoId], [
                'ten' => $this->ten,
                'original_name' => $this->original_name,
                'url' => $targetPath,
                'trangthai' => $this->trangthai
            ]);

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: $this->videoId ? 'Cập nhật video thành công.' : 'Thêm mới video thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi ' . ($this->videoId ? 'cập nhật' : 'thêm mới') . ' video: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi ' . ($this->videoId ? 'cập nhật' : 'thêm mới') . ' video.',
                type: 'error'
            );
        }

        $this->resetFields();
        $this->dispatch('close-modal');
    }

    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $this->videoId = $video->id;
        $this->ten = $video->ten;

        if (Str::contains($video->url, 'videos/')) {
            $this->loai_video = 2;
            $this->embed_code = null;
            $this->video_file = $video->url;
            // Lưu tạm video cũ nếu tồn tại
            $this->video_file_exist = $video->url;
        } else {
            $this->loai_video = 1;
            $this->embed_code = $video->url;
            $this->video_file = null;
        }
        $this->trangthai = $video->trangthai;
        $this->loai_video = $this->loai_video;

        $this->dispatch('show-edit-modal');
        
    }

    public function view($id)
    {
        $this->check_authentication('xem chi tiết');

        $video = Video::findOrFail($id);
        $this->videoId = $video->id;
        $this->ten = $video->ten;
        $this->original_name = $video->original_name;
        $this->url = $video->url;
        $this->trangthai = $video->getTrangThai();

        $this->dispatch('show-view-modal');
    }

    public function delete($id)
    {
        try {
            $video = Video::findOrFail($id);
            $this->the_delete_id = $video->id;
            if (Str::contains($video->url, 'videos/')) {
                $this->video_file = $video->url;
            } else {
                $this->embed_code = $video->url; // lưu tạm để hiển thị nếu cần
            }
            $this->dispatch('show-delete-modal');
        } catch (\Exception $e) {
            $this->dispatch(
                'show-alert',
                title: 'Thông báo',
                message: 'Không tìm thấy video để xoá.',
                type: 'error'
            );
        }
    }

    public function deleteVideo()
    {
        $this->check_authentication('xóa');

        try {
            $video = Video::findOrFail($this->the_delete_id);
            $video->delete();

            // Xóa ảnh cũ nếu tồn tại
            if ($this->video_file && file_exists(public_path($this->video_file))) {
                unlink(public_path($this->video_file));
            }

            $this->dispatch(
                'show-alert',
                title: 'Thành công!',
                message: 'Đã xóa video thành công.',
                type: 'success'
            );
        } catch (\Exception $e) {
            Log::error('Lỗi khi xóa video: ' . $e->getMessage());
            $this->dispatch(
                'show-alert',
                title: 'Lỗi!',
                message: 'Có lỗi xảy ra khi xóa video.',
                type: 'error'
            );
        }

        $this->dispatch('close-modal');
    }

    public function closeViewModal()
    {
        $this->videoId = '';
        $this->ten = '';
        $this->trangthai = 1;
        $this->loai_video = '';
        $this->embed_code = '';
        $this->video_file = null;
        $this->dispatch('close-modal');
    }

    public function render()
    {
        if (!$this->search) {
            $video = Video::paginate(20);
        } else {
            $video = Video::where('ten', 'like', '%' . $this->search . '%')->paginate(20);
        }
        return view('livewire.dm-video', [
            'videos' => $video
        ]);
    }
}
