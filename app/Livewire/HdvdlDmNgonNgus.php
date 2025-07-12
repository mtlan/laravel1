<?php

namespace App\Livewire;

use App\Models\HdvdlDmNgonNgu;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class HdvdlDmNgonNgus extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';

    public $ten, $ma, $trangthai, $daxoa, $searchParam;

    public $hdvdl_dm_ngon_ngu_edit_id, $hdvdl_dm_ngon_ngu_delete_id, $hdvdl_dm_ngon_ngu_show_id;

    public $view_hdvdl_dm_ngon_ngu_id, $view_hdvdl_dm_ngon_ngu_ten, $view_hdvdl_dm_ngon_ngu_ma, $view_hdvdl_dm_ngon_ngu_trangthai;

    private function resetFields(): void
    {
        $this->ten = '';
        $this->ma = '';
        $this->trangthai = null;
    }

    private function findHdvdlDmNgonNguOrFail(int $id): HdvdlDmNgonNgu
    {
        return HdvdlDmNgonNgu::findOrFail($id); // Hoặc User::findOrFail($id) nếu bạn muốn tự động lỗi 404
    }

    public function updatedSearchParam($value)
    {
        $this->resetPage();
    }

    public function rules(): array
    {
        $ruleMa = 'required|unique:hdvdl_dm_ngonngu,ma';
        if ($this->hdvdl_dm_ngon_ngu_edit_id) {
            $ruleMa .= ',' . $this->hdvdl_dm_ngon_ngu_edit_id . ',id,daxoa,0';
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
        $query = HdvdlDmNgonNgu::query();

        $query->where('daxoa', 0);

        if ($this->searchParam) {
            $query->where(function ($q) {
                $q->where('ten', 'like', '%' . strtolower($this->searchParam)  . '%')
                    ->orWhere('ma', 'like', '%' . strtolower($this->searchParam) . '%');
            });
        }

        $hdvdl_dm_ngon_ngus = $query->orderBy('id', 'desc')->paginate(10);

        return view('livewire.hdvdl-dm-ngon-ngus', ['hdvdl_dm_ngon_ngus' => $hdvdl_dm_ngon_ngus]);
    }

    public function store()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $hdvdl_dm_ngon_ngu = new HdvdlDmNgonNgu();
            $hdvdl_dm_ngon_ngu->ten = $this->ten;
            $hdvdl_dm_ngon_ngu->ma = $this->ma;
            $hdvdl_dm_ngon_ngu->trangthai = $this->trangthai != null ? ($this->trangthai == 1 ? true : false) : true; // Default status to 1 if not set
            $hdvdl_dm_ngon_ngu->daxoa = false; // Default to not deleted
            $hdvdl_dm_ngon_ngu->save();

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
            $hdvdl_dm_ngon_ngu = $this->findHdvdlDmNgonNguOrFail($id);

            if (Auth::user()->can('edit', $hdvdl_dm_ngon_ngu)) {
                dd('Có quyền chỉnh sẳ');
            }

            $this->ten = $hdvdl_dm_ngon_ngu->ten;
            $this->ma = $hdvdl_dm_ngon_ngu->ma;
            $this->trangthai = $hdvdl_dm_ngon_ngu->trangthai;
            $this->hdvdl_dm_ngon_ngu_edit_id = $hdvdl_dm_ngon_ngu->id;
            $this->dispatch('show-edit-hdvdl-dm-ngon-ngu-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy ngôn ngữ để chỉnh sửa.');
            $this->dispatch('close-modal'); // Close modal if item not found
        }
    }

    public function update()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $hdvdl_dm_ngon_ngu = $this->findHdvdlDmNgonNguOrFail($this->hdvdl_dm_ngon_ngu_edit_id);
            $hdvdl_dm_ngon_ngu->ten = $this->ten;
            $hdvdl_dm_ngon_ngu->ma = $this->ma;
            $hdvdl_dm_ngon_ngu->trangthai = $this->trangthai;
            $hdvdl_dm_ngon_ngu->save();

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
            $hdvdl_dm_ngon_ngu = $this->findHdvdlDmNgonNguOrFail($id);
            $this->hdvdl_dm_ngon_ngu_delete_id = $hdvdl_dm_ngon_ngu->id;
            $this->dispatch('show-delete-hdvdl-dm-ngon-ngu-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy loại tư liệu để xoá.');
        }
    }

    public function deleteDmNgonNgu()
    {
        try {
            $hdvdl_dm_ngon_ngu = $this->findHdvdlDmNgonNguOrFail($this->hdvdl_dm_ngon_ngu_delete_id);
            $hdvdl_dm_ngon_ngu->daxoa = true;
            $hdvdl_dm_ngon_ngu->save();

            session()->flash('success', 'Đã xoá loại tư liệu thành công!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy loại tư liệu để xoá.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình xoá loại tư liệu, vui lòng thao tác lại!');
        } finally {
            $this->hdvdl_dm_ngon_ngu_delete_id = null;
            $this->dispatch('close-modal');
        }
    }

    public function view($id)
    {
        try {
            $hdvdl_dm_ngon_ngu = $this->findHdvdlDmNgonNguOrFail($id);
            $this->view_hdvdl_dm_ngon_ngu_id = $hdvdl_dm_ngon_ngu->id;
            $this->view_hdvdl_dm_ngon_ngu_ten = $hdvdl_dm_ngon_ngu->ten;
            $this->view_hdvdl_dm_ngon_ngu_ma = $hdvdl_dm_ngon_ngu->ma;
            $this->view_hdvdl_dm_ngon_ngu_trangthai = $hdvdl_dm_ngon_ngu->trangthai;

            $this->dispatch('show-view-hdvdl-dm-ngon-ngu-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy ngôn ngữ để xem.');
        }
    }

    public function closeViewModal()
    {
        $this->view_hdvdl_dm_ngon_ngu_id = '';
        $this->view_hdvdl_dm_ngon_ngu_ten = '';
        $this->view_hdvdl_dm_ngon_ngu_ma = '';
        $this->view_hdvdl_dm_ngon_ngu_trangthai = '';
        $this->dispatch('close-modal');
    }

    public function closeModal()
    {
        $this->resetFields();
        $this->dispatch('close-modal');
    }
}
