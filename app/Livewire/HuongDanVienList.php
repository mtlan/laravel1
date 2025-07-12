<?php

namespace App\Livewire;

use Illuminate\Support\Str;

use App\Models\HdvdlDmNgonNgu;
use App\Models\HdvdlDmNoiCapThe;
use App\Models\HdvdlThe;
use Livewire\Component;
use Livewire\WithPagination;

class HuongDanVienList extends Component
{
    use WithPagination;
    public $paginationTheme = 'bootstrap';

    public $noiCapThes;
    public $ngonNgus;
    // lấy giá trị từ form
    public $selectNoiCapThe;
    public $selectNgonNgu;
    public $hoTens;
    public $soThes;

    public function mount()
    {
        $this->noiCapThes = HdvdlDmNoiCapThe::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        $this->ngonNgus = HdvdlDmNgonNgu::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
    }

    public function updatingSelectNoiCapThe()
    {
        $this->resetPage();
    }

    public function updatingSelectNgonNgu()
    {
        $this->resetPage();
    }

    public function updatingHoTens()
    {
        $this->resetPage();
    }

    public function updatingSoThes()
    {
        $this->resetPage();
    }


    public function render()
    {
        $query = HdvdlThe::query()
            ->where('trangthai', 1)
            ->where('daxoa', 0)
            ->orderBy('id', 'asc')
            ->with(['noicapthe', 'tiengchinh', 'huongdanvien']); // eager load trước

        if ($this->selectNoiCapThe) {
            $query->where('noicapthe_id', $this->selectNoiCapThe);
        }

        if ($this->selectNgonNgu) {
            $query->where('huongdan_tiengchinh', $this->selectNgonNgu);
        }

        if ($this->hoTens) {
            $query->whereHas('huongdanvien', function ($q) {
                $keyword = '%' . Str::lower($this->hoTens) . '%';
                $q->whereRaw("LOWER(CONCAT(ho_tenlot, ' ', ten)) LIKE ?", [$keyword]);
            });
        }

        if ($this->soThes) {
            $query->where('sothe', 'like', '%' . $this->soThes . '%');
        }

        $theHuongDanViens = $query->paginate(10);
        return view('livewire.huong-dan-vien-list', compact('theHuongDanViens'));
    }
}
