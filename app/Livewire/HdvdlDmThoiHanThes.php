<?php

namespace App\Livewire;

use App\Models\HdvdlDmThoiHanThe;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class HdvdlDmThoiHanThes extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';

    public $ten, $ma, $trangthai, $daxoa, $searchParam;

    public $hdvdl_dm_thoi_han_the_edit_id, $hdvdl_dm_thoi_han_the_delete_id, $hdvdl_dm_thoi_han_the_show_id;

    public $view_hdvdl_dm_thoi_han_the_id, $view_hdvdl_dm_thoi_han_the_ten, $view_hdvdl_dm_thoi_han_the_ma, $view_hdvdl_dm_thoi_han_the_trangthai;

    private function resetFields(): void
    {
        $this->ten = '';
        $this->ma = '';
        $this->trangthai = null;
    }

    private function findHdvdlDmThoiHanTheOrFail(int $id): HdvdlDmThoiHanThe
    {
        return HdvdlDmThoiHanThe::findOrFail($id); // Hoặc User::findOrFail($id) nếu bạn muốn tự động lỗi 404
    }

    public function updatedSearchParam($value)
    {
        $this->resetPage();
    }

    public function rules(): array
    {
        $ruleMa = 'required|unique:hdvdl_dm_thoihanthe,ma';
        if ($this->hdvdl_dm_thoi_han_the_edit_id) {
            $ruleMa .= ',' . $this->hdvdl_dm_thoi_han_the_edit_id . ',id,daxoa,0';
        } else {
            $ruleMa .= ',NULL,id,daxoa,0';
        }
        return [
            'ten' => 'required',
            'ma' => $ruleMa,
        ];
    }

    protected function messages(): array
    {
        return [
            'ten.required' => 'Vui lòng nhập tên',
            'ma.required' => 'Vui lòng nhập mã',
            'ma.unique' => 'Mã này đã tồn tại trong hệ thống.',
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
        $query = HdvdlDmThoiHanThe::query();

        $query->where('daxoa', 0);

        if ($this->searchParam) {
            $query->where(function ($q) {
                $q->where('ten', 'like', '%' . strtolower($this->searchParam)  . '%')
                    ->orWhere('ma', 'like', '%' . strtolower($this->searchParam) . '%');
            });
        }

        $hdvdl_dm_thoi_han_thes = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.hdvdl-dm-thoi-han-thes', ['hdvdl_dm_thoi_han_thes' => $hdvdl_dm_thoi_han_thes]);
    }

    public function store()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $hdvdl_dm_thoi_han_the = new HdvdlDmThoiHanThe();
            $hdvdl_dm_thoi_han_the->ten = $this->ten;
            $hdvdl_dm_thoi_han_the->ma = $this->ma;
            $hdvdl_dm_thoi_han_the->trangthai = $this->trangthai != null ? ($this->trangthai == 1 ? true : false) : true; // Default status to 1 if not set
            $hdvdl_dm_thoi_han_the->daxoa = false; // Default to not deleted
            $hdvdl_dm_thoi_han_the->save();

            session()->flash('success', 'Thêm mới ngôn ngữ thành công!');
        } catch (\Exception $e) {
            // Log lỗi chi tiết
            Log::error('Lỗi khi lưu ngôn ngữ mới : ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            session()->flash('error', 'Đã có lỗi xảy ra trong quá trình thêm mới ngôn ngữ, mời bạn thao tác lại!');
        } finally {
            $this->resetFields();

            $this->dispatch('close-modal');
        }
    }

    public function edit($id)
    {
        try {
            $hdvdl_dm_thoi_han_the = $this->findHdvdlDmThoiHanTheOrFail($id);
            $this->ten = $hdvdl_dm_thoi_han_the->ten;
            $this->ma = $hdvdl_dm_thoi_han_the->ma;
            $this->trangthai = $hdvdl_dm_thoi_han_the->trangthai;
            $this->hdvdl_dm_thoi_han_the_edit_id = $hdvdl_dm_thoi_han_the->id;
            $this->dispatch('show-edit-hdvdl-dm-thoi-han-the-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy ngôn ngữ để chỉnh sửa.');
            $this->dispatch('close-modal'); // Close modal if item not found
        }
    }

    public function update()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $hdvdl_dm_thoi_han_the = $this->findHdvdlDmThoiHanTheOrFail($this->hdvdl_dm_thoi_han_the_edit_id);
            $hdvdl_dm_thoi_han_the->ten = $this->ten;
            $hdvdl_dm_thoi_han_the->ma = $this->ma;
            $hdvdl_dm_thoi_han_the->trangthai = $this->trangthai;
            $hdvdl_dm_thoi_han_the->save();

            $this->resetFields();
            session()->flash('success', 'Chỉnh sửa ngôn ngữ thành công!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy ngôn ngữ để cập nhật.');
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình chỉnh sửa ngôn ngữ, vui lòng thao tác lại!');
        } finally {
            $this->dispatch('close-modal');
        }
    }

    public function delete($id)
    {
        try {
            $hdvdl_dm_thoi_han_the = $this->findHdvdlDmThoiHanTheOrFail($id);
            $this->hdvdl_dm_thoi_han_the_delete_id = $hdvdl_dm_thoi_han_the->id;
            $this->dispatch('show-delete-hdvdl-dm-thoi-han-the-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy loại tư liệu để xoá.');
        }
    }

    public function deleteDmNgonNgu()
    {
        try {
            $hdvdl_dm_thoi_han_the = $this->findHdvdlDmThoiHanTheOrFail($this->hdvdl_dm_thoi_han_the_delete_id);
            $hdvdl_dm_thoi_han_the->daxoa = true;
            $hdvdl_dm_thoi_han_the->save();

            session()->flash('success', 'Đã xoá loại tư liệu thành công!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy loại tư liệu để xoá.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình xoá loại tư liệu, vui lòng thao tác lại!');
        } finally {
            $this->hdvdl_dm_thoi_han_the_delete_id = null;
            $this->dispatch('close-modal');
        }
    }

    public function view($id)
    {
        try {
            $hdvdl_dm_thoi_han_the = $this->findHdvdlDmThoiHanTheOrFail($id);
            $this->view_hdvdl_dm_thoi_han_the_id = $hdvdl_dm_thoi_han_the->id;
            $this->view_hdvdl_dm_thoi_han_the_ten = $hdvdl_dm_thoi_han_the->ten;
            $this->view_hdvdl_dm_thoi_han_the_ma = $hdvdl_dm_thoi_han_the->ma;
            $this->view_hdvdl_dm_thoi_han_the_trangthai = $hdvdl_dm_thoi_han_the->trangthai;

            $this->dispatch('show-view-hdvdl-dm-thoi-han-the-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy ngôn ngữ để xem.');
        }
    }

    public function closeViewModal()
    {
        $this->view_hdvdl_dm_thoi_han_the_id = '';
        $this->view_hdvdl_dm_thoi_han_the_ten = '';
        $this->view_hdvdl_dm_thoi_han_the_ma = '';
        $this->view_hdvdl_dm_thoi_han_the_trangthai = '';
        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->dispatch('close-modal');
    }
}
