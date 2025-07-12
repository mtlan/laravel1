<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class Roles extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';

    public $name, $permission, $role_permissions, $searchKeyword;

    public $role_edit_id, $role_delete_id, $role_show_id, $give_permission_id;

    public $view_role_id, $view_role_name, $view_role_guard_name;

    private function findRoleOrFail(int $id): Role
    {
        return Role::findOrFail($id);
    }

    public function resetFields()
    {
        $this->name = '';
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
        $roles = Role::where('name', 'like', $searchKeyword)->orderBy('id', 'desc')->paginate(10);
        $permissions = Permission::all();

        return view('livewire.roles', ['roles' => $roles, 'permissions' => $permissions]);
    }

    public function store()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $role = new Role();
            $role->name = $this->name;
            $role->guard_name = 'web';
            $role->save();

            session()->flash('success', 'Tạo mới role thành công!');

            $this->resetFields();

            //$this->dispatch('show-alert', title: 'Thành công!', message: 'Thêm mới vai trò thành công!', type: 'success');
        } catch (\Exception $e) {
            session()->flash('error', 'Đã có lỗi xảy ra trong quá trình thêm mới vai trò, mời bạn thao tác lại!');

            $this->resetFields();
        } finally {
            $this->dispatch('close-modal');
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        //dd($role);
        $this->name = $role->name;
        $this->role_edit_id = $role->id;

        // Permission hiện có của role
        $this->role_permissions = $role;

        $this->dispatch('show-edit-role-modal');
    }

    public function update()
    {
        $this->validate($this->rules(), $this->messages());

        try {
            $role = Role::where('id', $this->role_edit_id)->first();
            $role->name = $this->name;
            $role->save();

            session()->flash('success', 'Chỉnh sửa role thành công!');

            $this->resetFields();
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình chỉnh sửa role, vui lòng thao tác lại!');

            $this->resetFields();
        } finally {
            $this->dispatch('close-modal');
        }
    }

    public function givePermissionToRole()
    {
        // dd($this->permission);

        $role = $this->findRoleOrFail($this->role_edit_id);

        if (empty($this->permission)) {
            session()->flash('error_permission', 'Vui lòng chọn một quyền để gán!!');
            return;
        }

        if ($role->hasPermissionTo($this->permission)) {
            session()->flash('error_permission', 'Quyền đã tồn tại');
        } else {
            $role->givePermissionTo($this->permission);
            $this->permission = null;
            session()->flash('success_permission', 'Đã gán quyền cho vai trò thành công!');
            if ($this->role_permissions && $this->role_permissions->id == $role->id) {
                $this->role_permissions->load('permissions');
            }
        }
    }

    public function revokePermission($id)
    {
        $role = $this->role_permissions;
        $permission = Permission::where('id', $id)->first();

        //dd($permission);

        if ($role->hasPermissionTo($permission)) {
            $role->revokePermissionTo($permission);
            session()->flash('success_permission', 'Đã xóa quyền cho vai trò thành công!');
            if ($this->role_permissions && $this->role_permissions->id == $role->id) {
                $this->role_permissions->load('permissions');
            }
        } else {
            session()->flash('error_permission', 'Permission không tồn tại');
        }
    }

    public function delete($id)
    {
        $role = Role::where('id', $id)->first();
        $this->role_delete_id = $role->id;

        $this->dispatch('show-delete-role-modal');
    }

    public function deleteRole()
    {
        try {
            $role = Role::where('id', $this->role_delete_id)->first();
            $role->delete();
            session()->flash('success', 'Đã xoá role thành công!');
        } catch (\Throwable $th) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình xoá role, vui lòng thao tác lại!');
        } finally {
            $this->role_delete_id = null;
            $this->dispatch('close-modal');
        }
    }

    public function view($id)
    {
        $role = Role::where('id', $id)->first();
        $this->view_role_id = $role->id;
        $this->view_role_name = $role->name;
        $this->role_permissions = $role;
        $this->dispatch('show-view-role-modal');
    }

    public function closeViewModal()
    {
        $this->view_role_id = '';
        $this->view_role_name = '';
        $this->dispatch('close-modal');
    }
}
