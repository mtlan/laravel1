<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;

class Permissions extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';

    public $name, $permission, $searchKeyword;

    public $permission_edit_id, $permission_delete_id, $permission_show_id;

    public $view_permission_id, $view_permission_name;

    private function resetFields(): void
    {
        $this->name = '';
    }

    private function findPermissionOrFail(int $id): Permission
    {
        return Permission::findOrFail($id); // Hoặc User::findOrFail($id) nếu bạn muốn tự động lỗi 404
    }

    public function updatedSearchKeyword($value)
    {
        $this->resetPage();
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên',
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
        $searchKeyword = '%' . $this->searchKeyword . '%';
        $permissions = Permission::where('name', 'like', $searchKeyword)->orderBy('id', 'desc')->paginate(10);

        return view('livewire.permissions', ['permissions' => $permissions]);
    }

    public function store()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $permission = new Permission();
            $permission->name = $this->name;
            $permission->guard_name = 'web';
            $permission->save();

            session()->flash('success', 'Thêm mới quyền thành công!');

            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Đã có lỗi xảy ra trong quá trình thêm mới quyền, mời bạn thao tác lại!');

            $this->resetFields();
        } finally {
            $this->dispatch('close-modal');
        }
    }

    public function edit($id)
    {
        try {
            $permission = $this->findPermissionOrFail($id);
            $this->name = $permission->name;
            $this->permission_edit_id = $permission->id;
            $this->dispatch('show-edit-permission-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy quyền để chỉnh sửa.');
            $this->dispatch('close-modal'); // Close modal if item not found
        }
    }

    public function update()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $permission = $this->findPermissionOrFail($this->permission_edit_id);
            $permission->name = $this->name;
            $permission->save();
            $this->resetFields();
            session()->flash('success', 'Chỉnh sửa quyền thành công!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy quyền để cập nhật.');
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình chỉnh sửa quyền, vui lòng thao tác lại!');
        } finally {
            $this->dispatch('close-modal');
        }
    }

    public function delete($id)
    {
        try {
            $permission = $this->findPermissionOrFail($id);
            $this->permission_delete_id = $permission->id;
            $this->dispatch('show-delete-permission-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy quyền để xoá.');
        }
    }

    public function deletePermission()
    {
        try {
            $permission = $this->findPermissionOrFail($this->permission_delete_id);
            $permission->delete();
            session()->flash('success', 'Đã xoá quyền thành công!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy quyền để xoá.');
        } catch (\Throwable $th) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình xoá quyền, vui lòng thao tác lại!');
        } finally {
            $this->permission_delete_id = null;
            $this->dispatch('close-modal');
        }
    }

    public function view($id)
    {
        try {
            $permission = $this->findPermissionOrFail($id);
            $this->view_permission_id = $permission->id;
            $this->view_permission_name = $permission->name;
            $this->dispatch('show-view-permission-modal');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy quyền để xem.');
        }
    }

    public function closeViewModal()
    {
        $this->view_permission_id = '';
        $this->view_permission_name = '';
        $this->dispatch('close-modal');
    }
}
