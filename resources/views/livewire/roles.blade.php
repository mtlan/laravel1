<div>
    <div class="custom-title">
        <div class="container-fluid pt-4 px-4">
            <div class="row g-4 mb-4">
                <nav class="navbar navbar-expand-lg">
                    <div class="container-fluid">
                        Danh sách vai trò
                    </div>
                </nav>
            </div>
        </div>
    </div>

    <div class="custom-contain">
        <div class="container-fluid px-4 mb-2">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addRoleModal">Thêm mới</button>
        </div>

        <div class="container-fluid pt-2 px-4">
            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Vai trò</h6>
                    <form class="d-flex">
                        <input class="form-control me-1" type="text" wire:model.live.debounce.300ms="searchKeyword"
                            placeholder="Tìm kiếm theo tên ..." aria-label="Search">
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
                                <th scope="col" class="text-center min-vw-50">Tên</th>
                                <th scope="col" class="text-center w-25">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="text-center">
                                        <a href="#" wire:click.prevent="view({{ $role->id }})"
                                            style="color: rgb(48, 100, 177); cursor: pointer; text-decoration: underline;">
                                            {{ $role->name }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-success"
                                            wire:click="edit({{ $role->id }})">Chỉnh
                                            sửa</button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="delete({{ $role->id }})">Xoá</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div style="float: right;">
                                        {{ $roles->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }}
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
    <div wire:ignore.self class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="store">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Thêm mới role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <x-label for="nameRole" field="ten" class="col-3" :required="$this->isRequired('name')">Tên role</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="nameRole" wire:model="name"
                                    placeholder="Nhập tên danh mục">
                                @error('name')
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

    <!-- Modal chỉnh sửa -->
    <div wire:ignore.self class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chỉnh sửa vai trò</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" class="mb-2">
                        @csrf
                        <div class="form-group mb-2">
                            <x-label for="nameRole" field="ten" class="col-3" :required="$this->isRequired('name')">Tên role</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="nameRole" wire:model="name"
                                    placeholder="Nhập tên role">
                                @error('name')
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

                    @if (session()->has('success_permission'))
                        <div class="alert alert-success text-center">
                            {{ session('success_permission') }}
                        </div>
                    @endif

                    @if (session()->has('error_permission'))
                        <div class="alert alert-danger text-center">
                            {{ session('error_permission') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="givePermissionToRole" class="mt-2">
                        @csrf
                        <div class="form-group mb-2 mt-2">
                            <label for="permission" class="col-12 fw-bold fs-5">Danh sách quyền thuộc vai
                                trò</label>
                            <div class="col-12">
                                <table class="table text-start align-middle table-bordered table-hover mb-0">
                                    <tbody>
                                        @if ($role_permissions)
                                            <tr class="text-center">
                                                <th>Tên</th>
                                                <th>Hành động</th>
                                            </tr>
                                            @foreach ($role_permissions->permissions as $role_permission)
                                                <tr>
                                                    <td class="text-center">{{ $role_permission->name }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                            wire:click="revokePermission({{ $role_permission->id }})">Xoá</button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group mb-2 mt-2">
                            <label for="permission" class="col-6">Gán quyền cho vai trò</label>
                            <div class="col-12">
                                <select class="form-control" name="permission" id="permission"
                                    wire:model="permission">
                                    <option value="">--- Chọn quyền ---</option>
                                    @foreach ($permissions as $permission)
                                        <option value="{{ $permission->name }}" data-id="{{ $permission->id }}">
                                            {{ $permission->name }}</option>
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

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá vai trò</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá vai trò này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-outline-info" data-bs-dismiss="modal" aria-label="Close">Huỷ
                        bỏ</button>
                    <button class="btn btn-sm btn-outline-danger" wire:click="deleteRole()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết -->
    <div wire:ignore.self class="modal fade" id="viewRoleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết vai trò</h5>
                    <button type="button" class="btn-close" wire:click="closeViewModal()"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $view_role_id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên role</th>
                                    <td>{{ $view_role_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr class="my-3">
                    <label for="permission" class="col-12 fw-bold fs-5">Danh sách quyền thuộc vai
                        trò</label>
                    <div class="col-12">
                        <table class="table text-start align-middle table-bordered table-hover mb-0">
                            <tbody>
                                @if ($role_permissions)
                                    <tr class="text-center">
                                        <th>Tên</th>
                                    </tr>
                                    @foreach ($role_permissions->permissions as $role_permission)
                                        <tr>
                                            <td class="text-center">{{ $role_permission->name }}</td>
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
</div>

<script>
    window.addEventListener('close-modal', event => {
        $('#addRoleModal').modal('hide');
        $('#editRoleModal').modal('hide');
        $('#deleteRoleModal').modal('hide');
        $('#viewRoleModal').modal('hide');
    });

    window.addEventListener('show-edit-role-modal', event => {
        $('#editRoleModal').modal('show');
    })

    window.addEventListener('show-delete-role-modal', event => {
        $('#deleteRoleModal').modal('show');
    });

    window.addEventListener('show-view-role-modal', event => {
        $('#viewRoleModal').modal('show');
    })
</script>
