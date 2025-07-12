<?php

namespace App\Livewire;

use App\Models\ChuyenMuc;
use App\Models\ParentDirectory;
use App\Models\PhotoGallery;
use App\Models\SubFolder;
use App\Models\Video;
use Livewire\Component;
use Livewire\WithPagination;

class ThuVienAnh extends Component
{
    use WithPagination;

    // public $folders = [];
    public $search = '';
    public $slugCha, $slugCon, $thuMucCha, $thuMucCon;

    public function updatingSearch()
    {
        $this->resetPage(); // reset về trang 1 khi gõ từ khóa mới
    }

    public function mount($slugCha = null, $slugCon = null)
    {
        $this->slugCha = $slugCha;
        $this->slugCon = $slugCon;

        if ($slugCha) {
            $this->thuMucCha = ParentDirectory::where('slug', $slugCha)->first();
            if (!$this->thuMucCha) {
                abort(404, 'Không tìm thấy thư mục cha.');
            }
        }
    
        if ($slugCon) {
            $this->thuMucCon = SubFolder::where('slug', $slugCon)->first();
            if (!$this->thuMucCon) {
                abort(404, 'Không tìm thấy thư mục con.');
            }
        }
    }

    public function render()
    {
        $data = [
            'chuyenMucs' => ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->get(),
            'videoNoiBat' => Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first(),
            'videos' => Video::where('trangthai', 1)->where('daxoa', 0)->limit(3)->get(),
            'thuMucChas' => null,
            'thuMucCons' => null,
            'hinhanhs' => null,
        ];

        if (!$this->slugCha && !$this->slugCon) {
            $data['thuMucChas'] = ParentDirectory::where('daxoa', 0)
                ->when($this->search, fn($q) => $q->where('ten', 'like', "%$this->search%"))
                ->orderByDesc('id')
                ->paginate(20);
        }

        if ($this->slugCha && !$this->slugCon) {
            // Kiểm tra xem có ảnh nào trong thư mục cha không
            $anhTrongThuMucCha = PhotoGallery::where('parent_id', $this->thuMucCha->id)
                ->where('trangthai', 1)
                ->where('daxoa', 0)
                ->exists();

            if ($anhTrongThuMucCha) {
                // Nếu có ảnh trong thư mục cha, hiển thị ảnh
                $data['hinhanhs'] = PhotoGallery::where('parent_id', $this->thuMucCha->id)
                    ->where('trangthai', 1)
                    ->where('daxoa', 0)
                    ->when($this->search, fn($q) => $q->where('ten', 'like', "%$this->search%"))
                    ->orderByDesc('id')
                    ->paginate(20);
            } else {
                // Nếu không có ảnh trong thư mục cha, hiển thị thư mục con
                $data['thuMucCons'] = SubFolder::where('parent_id', $this->thuMucCha->id)
                    ->where('daxoa', 0)
                    ->when($this->search, fn($q) => $q->where('ten', 'like', "%$this->search%"))
                    ->orderByDesc('id')
                    ->paginate(20);
            }
        }

        if ($this->slugCha && $this->slugCon) {
            $data['hinhanhs'] = PhotoGallery::where('children_id', $this->thuMucCon->id)
                ->where('trangthai', 1)
                ->where('daxoa', 0)
                ->when($this->search, fn($q) => $q->where('ten', 'like', "%$this->search%"))
                ->orderByDesc('id')
                ->paginate(20);
        }

        return view('livewire.thu-vien-anh', $data);
    }
}
