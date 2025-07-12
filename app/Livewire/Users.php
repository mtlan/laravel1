<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Users extends Component
{
    use WithPagination;

    public $paginationTheme = 'bootstrap';

    public $searchKeyword, $name, $email, $password, $password_confirmation;

    public $user_roles;

    public $edit_user_id, $user_delete_id;

    public $view_user_id, $view_user_name, $view_user_email;

    public $show_user_id, $show_user_name, $show_user_email;

    public $role, $permission, $user_permissions;

    private function findUserOrFailt(int $id): ?User
    {
        return User::findOrFail($id); // Hoặc User::findOrFail($id) nếu bạn muốn tự động lỗi 404
    }

    public function updatedSearchKeyword($value)
    {
        $this->resetPage();
    }

    public function resetFields()
    {
        $this->name = '';
        $this->password = '';
        $this->email = '';
        $this->password_confirmation = '';
    }

    public function rules(): array
    {
        $ruleEmail = 'required|email|unique:users,email';
        if ($this->edit_user_id) {
            $ruleEmail .= ',' . $this->edit_user_id;
        } else {
            $ruleEmail .= ',NULL';
        }

        $rules = [
            'name' => 'required',
            'email' => $ruleEmail,
        ];

        if (!$this->edit_user_id) { // Chỉ áp dụng rule password khi tạo mới (edit_user_id không tồn tại)
            $rules['password'] = 'required|min:6|max:10';
            $rules['password_confirmation'] = 'required|min:6|max:10|same:password'; // Sửa confirmed thành same để rõ ràng hơn
        }
        return $rules;
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên nguời dùng',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Vui lòng nhập email hợp lệ',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.max' => 'Mật khẩu không quá 10 ký tự',
            'password_confirmation.confirmed' => 'Xác nhận mật khẩu không khớp với mật khẩu',
            'password_confirmation.required' => 'Vui lòng nhập mật khẩu xác nhận',
            'password_confirmation.min' => 'Mật khẩu xác nhận phải có ít nhất 6 ký tự',
            'password_confirmation.max' => 'Mật khẩu xác nhận không quá 10 ký tự',
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
        $roles = Role::all();
        $permissions = Permission::all();
        $searchKeyword = '%' . $this->searchKeyword . '%';
        $users = User::where('name', 'like', $searchKeyword)->orWhere('email', 'like', $searchKeyword)->orderBy('id', 'desc')->paginate(10);
        return view('livewire.users', ['users' => $users, 'permissions' => $permissions, 'roles' => $roles]);
    }

    public function store()
    {
        // $this->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|min:6|max:10',
        //     'password_confirmation' => 'required|min:6|max:10|confirmed:password',
        // ], [
        //     'name.required' => 'Vui lòng nhập tên nguời dùng',
        //     'email.required' => 'Vui lòng nhập email',
        //     'email.email' => 'Vui lòng nhập email hợp lệ',
        //     'email.unique' => 'Email đã tồn tại',
        //     'password.required' => 'Vui lòng nhập mật khẩu',
        //     'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
        //     'password.max' => 'Mật khẩu không quá 10 ký tự',
        //     'password_confirmation.confirmed' => 'Xác nhận mật khẩu không khớp với mật khẩu',
        //     'password_confirmation.required' => 'Vui lòng nhập mật khẩu xác nhận',
        //     'password_confirmation.min' => 'Mật khẩu xác nhận phải có ít nhất 6 ký tự',
        //     'password_confirmation.max' => 'Mật khẩu xác nhận không quá 10 ký tự',
        // ]);

        $this->validate($this->rules(), $this->messages());

        try {
            $user = new User();
            $user->name = $this->name;
            $user->email = $this->email;
            $user->password = Hash::make($this->password);
            $user->email_verified_at = now();
            $user->save();
            session()->flash('success', 'Thêm mới người dùng thành công!');
            //$this->dispatch('show-alert', title: 'Thành công!', message: 'Thêm mới vai trò thành công!', type: 'success');
        } catch (\Exception $e) {
            session()->flash('error', 'Đã có lỗi xảy ra trong quá trình thêm mới người dùng, mời bạn thao tác lại!');
        } finally {
            $this->resetFields();
            $this->dispatch('close-modal');
        }
    }

    public function edit($id)
    {
        $user = $this->findUserOrFailt($id);
        $this->edit_user_id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        //dd($role);
        $this->user_roles = $user;

        $this->dispatch('show-edit-role-modal');
    }

    public function update()
    {
        $this->validate($this->rules(), $this->messages());

        // $this->validate([
        //     'name' => 'required',
        //     'email' => 'required|email|unique:users,email,' . $this->edit_user_id,
        // ], [
        //     'name.required' => 'Vui lòng nhập tên nguời dùng',
        //     'email.required' => 'Vui lòng nhập email',
        //     'email.email' => 'Vui lòng nhập email hợp lệ',
        //     'email.unique' => 'Email đã tồn tại',
        // ]);

        try {
            $user = $this->findUserOrFailt($this->edit_user_id);
            $user->name = $this->name;
            $user->email = $this->email;
            $user->save();
            session()->flash('success', 'Chỉnh sửa người dùng thành công!');
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Không tìm thấy người dùng để cập nhật.');
        } catch (\Exception $e) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình chỉnh sửa người dùng, vui lòng thao tác lại!');
        } finally {
            $this->resetFields();
            $this->dispatch('close-modal');
        }
    }

    public function assignRoleToUser()
    {
        $user = $this->findUserOrFailt($this->edit_user_id);

        if (empty($this->role)) {
            session()->flash('error_role', 'Vui lòng chọn một vai trò để gán!!');
            return;
        }

        // Kiểm tra người dùng đã có role đó chưa. Nếu có thì thông báo đã tồn tại, ngược lại thì assgin nó vào người dùng
        if ($user->hasRole($this->role)) {
            session()->flash('error_role', 'Role đã tồn tại!');
        } else {
            $user->assignRole($this->role);
            session()->flash('success_role', 'Role đã được thêm vào người dùng thành công!');
        }
    }

    public function delete($id)
    {
        $user = User::where('id', $id)->first();
        $this->user_delete_id = $user->id;

        $this->dispatch('show-delete-user-modal');
    }

    public function deleteUser()
    {
        try {
            $user = $this->findUserOrFailt($this->user_delete_id);
            //dd($user)
            $user->delete();
            session()->flash('success', 'Đã xoá người dùng thành công!');
        } catch (ModelNotFoundException $e) {
            $this->dispatch('show-alert', title: 'Lỗi!', message: 'Không tìm thấy người dùng để xóa.', type: 'error');
        } catch (\Throwable $th) {
            session()->flash('error', 'Có lỗi xảy ra trong quá trình xoá người dùng, vui lòng thao tác lại!');

            // Hide modal after add category
            $this->dispatch('close-modal');
        } finally {
            $this->user_delete_id = null;

            // Hide modal after add category
            $this->dispatch('close-modal');
        }
    }

    public function view($id)
    {
        $user = User::where('id', $id)->first();
        $this->view_user_id = $user->id;
        $this->view_user_name = $user->name;
        $this->view_user_email = $user->email;
        $this->user_roles = $user;
        $this->dispatch('show-view-user-modal');
    }

    public function closeViewModal()
    {
        $this->view_user_id = '';
        $this->view_user_name = '';
        $this->view_user_email = '';
        $this->user_roles = null;
        $this->dispatch('close-modal');
    }

    public function removeRole($id)
    {
        //dd($this);
        $role = Role::where('id', $id)->first();
        $user = $this->user_roles;

        if ($user->hasRole($role)) {
            $user->removeRole($role);
            session()->flash('success_role', 'Đã thu hồi role');
        } else {
            session()->flash('error_role', 'Role không tồn tại');
        }
    }
}
