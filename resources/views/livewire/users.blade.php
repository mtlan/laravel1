<div>
    <div class="custom-title">
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4 mb-4">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        Quản lý danh sách người dùng
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="custom-contain">
        <div class="container-fluid px-4 mb-2">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addUserModal">Thêm mới</button>
        </div>

        <div class="container-fluid pt-2 px-4">
            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Người dùng</h6>
                    <form class="d-flex">
                        <input class="form-control me-1" type="text" wire:model.live.debounce.300ms="searchKeyword"
                            placeholder="Tìm kiếm theo tên/email ..." aria-label="Search">
                        <button class="btn btn-outline-success text-nowrap" type="submit">Tìm kiếm</button>
                    </form>
                </div>

                @if (session()->has('success'))
                    <div class="alert alert-success text-center">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col" class="text-center min-vw-20">Tên</th>
                                <th scope="col" class="text-center min-vw-20">Email</th>
                                <th scope="col" class="text-center w-25">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">
                                        <a href="#" wire:click.prevent="view({{ $user->id }})"
                                            style="color: rgb(48, 100, 177); cursor: pointer; text-decoration: underline;">
                                            {{ $user->email }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $user->name }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-success"
                                            wire:click="edit({{ $user->id }})">Chỉnh sửa</button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="delete({{ $user->id }})">Xoá</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div style="float: right;">
                                        {{ $users->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tạo mới -->
    <div wire:ignore.self class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="store">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Thêm mới người dùng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <x-label for="nameUser" field="name" class="col-3" :required="$this->isRequired('name')">Tên</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="nameUser" wire:model="name"
                                    placeholder="Nhập tên">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="emailUser" field="email" class="col-3" :required="$this->isRequired('email')">Email</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="emailUser" wire:model="email"
                                    placeholder="Nhập email">
                                @error('email')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="passwordUser" field="password" class="col-3"
                                :required="$this->isRequired('password')">Password</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="passwordUser" wire:model="password"
                                    placeholder="Nhập mât khẩu">
                                @error('password')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="password_confirmationUser" field="password_confirmation" class="col-6"
                                :required="$this->isRequired('password_confirmation')">Xác nhận mật khẩu</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="password_confirmationUser"
                                    wire:model="password_confirmation" placeholder="Xác nhận mật khẩu">
                                @error('password_confirmation')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá người dùng này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-info" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-danger" wire:click="deleteUser()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết -->
    <div wire:ignore.self class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết người dùng</h5>
                    <button type="button" class="btn-close" wire:click="closeViewModal()"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $view_user_id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên người dùng</th>
                                    <td>{{ $view_user_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $view_user_email }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-3">
                    <label for="permission" class="col-12 fw-bold fs-5">Danh sách vai trò của người
                        dùng</label>
                    <div class="col-12">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <tbody>
                                @if ($user_roles)
                                    <tr class="text-center">
                                        <th>Tên</th>
                                    </tr>
                                    @foreach ($user_roles->roles as $user_role)
                                        <tr>
                                            <td class="text-center">{{ $user_role->name }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal assignRole, givePermissionTo for User -->
    <div wire:ignore.self class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chỉnh sửa người dùng
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" class="mb-2">
                        @csrf
                        <div class="form-group mb-2">
                            <x-label for="nameUser" field="name" class="col-3" :required="$this->isRequired('name')">Tên</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="nameUser" wire:model="name"
                                    placeholder="Nhập tên người dùng">
                                @error('name')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="emailUser" field="email" class="col-3" :required="$this->isRequired('email')">Email</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="emailUser" wire:model="email"
                                    placeholder="Nhập địa chỉ email">
                                @error('email')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <button type="submit" class="btn btn-info">Chỉnh sửa</button>
                            </div>
                        </div>
                    </form>

                    <hr class="my-3">

                    @if (session()->has('success_role'))
                        <div class="alert alert-success text-center">
                            {{ session('success_role') }}
                        </div>
                    @endif

                    @if (session()->has('error_role'))
                        <div class="alert alert-danger text-center">
                            {{ session('error_role') }}
                        </div>
                    @endif
                    <form wire:submit.prevent="assignRoleToUser" class="mt-2 mb-2">
                        @csrf
                        <div class="form-group mb-2 mt-2">
                            <label for="permission" class="col-12 fw-bold fs-5">Danh sách vai trò của người
                                dùng</label>
                            <div class="col-12">
                                <table class="table text-start align-middle table-bordered table-hover mb-0">
                                    <tbody>
                                        @if ($user_roles)
                                            @foreach ($user_roles->roles as $user_role)
                                                <tr>
                                                    <td class="text-center">{{ $user_role->name }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            wire:click="removeRole({{ $user_role->id }})">Xoá</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <label for="role" class="col-6">Vai trò(Role)</label>
                            <div class="col-12">
                                <select class="form-control" name="role" id="role" wire:model="role">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                {{-- @error('name')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror --}}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-12">
                                <button type="submit" class="btn btn-info">Chỉ định</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    window.addEventListener('close-modal', event => {
        $('#addUserModal').modal('hide');
        $('#editUserModal').modal('hide');
        $('#deleteUserModal').modal('hide');
        $('#viewUserModal').modal('hide')
    });

    window.addEventListener('show-delete-user-modal', event => {
        $('#deleteUserModal').modal('show');
    });

    window.addEventListener('show-view-user-modal', event => {
        $('#viewUserModal').modal('show');
    })

    window.addEventListener('show-edit-role-modal', event => {
        $('#editUserModal').modal('show');
    })
</script>
