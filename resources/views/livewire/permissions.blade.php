    <div>
        <div class="custom-title">
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4 mb-4">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            Danh sách quyền
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4 mb-2">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addPermissionModal">Thêm mới</button>
            </div>

            <div class="container-fluid pt-2 px-4">
                <div class="text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Quyền</h6>
                        <div class="d-flex"> {{-- Thay <form> bằng <div> nếu không cần submit form truyền thống --}}
                            <input class="form-control me-1" type="text"
                                wire:model.live.debounce.300ms="searchKeyword" placeholder="Tìm kiếm theo tên ..."
                                aria-label="Search">
                            {{-- Nút Search có thể giữ lại hoặc bỏ đi nếu tìm kiếm đã là "live" --}}
                            <button class="btn btn-outline-success text-nowrap" type="button">Tìm kiếm</button>
                        </div>
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
                                @foreach ($permissions as $permission)
                                    <tr>
                                        <td class="text-center">
                                            <a href="#" wire:click.prevent="view({{ $permission->id }})"
                                                style="color: rgb(48, 100, 177); cursor: pointer; text-decoration: underline;">
                                                {{ $permission->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success"
                                                wire:click="edit({{ $permission->id }})">Chỉnh
                                                sửa</button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="delete({{ $permission->id }})">Xoá</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <div style="float: right;">
                                            {{ $permissions->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }}
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
        <div wire:ignore.self class="modal fade" id="addPermissionModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Thêm mới quyền</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="store">
                            <div class="form-group mb-2">
                                <x-label for="namePermission" field="name" class="col-3" :required="$this->isRequired('name')">Tên
                                    quyền</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="namePermission" wire:model="name"
                                        placeholder="Nhập tên quyền">
                                    @error('name')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Thêm quyền</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal chỉnh sửa -->
        <div wire:ignore.self class="modal fade" id="editPermissionModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Chỉnh sửa permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="update" class="mb-2">
                            @csrf
                            <div class="form-group mb-2">
                                <x-label for="namePermission" field="name" class="col-3" :required="$this->isRequired('name')">Tên
                                    quyền</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="namepermission" wire:model="name"
                                        placeholder="Nhập tên quyền">
                                    @error('name')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info">Chỉnh sửa quyền</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal xoá -->
        <div wire:ignore.self class="modal fade" id="deletePermissionModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Xoá quyền</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <h5 class="text-black">Bạn chắc chắn muốn xoá quyền này??</h5>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close">Huỷ
                            bỏ</button>
                        <button class="btn btn-sm btn-danger" wire:click="deletePermission()">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal chi tiết -->
        <div wire:ignore.self class="modal fade" id="viewPermissionModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết quyền</h5>
                        <button type="button" class="btn-close" wire:click="closeViewModal()"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $view_permission_id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên permission</th>
                                    <td>{{ $view_permission_name }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('close-modal', event => {
            $('#addPermissionModal').modal('hide');
            $('#editPermissionModal').modal('hide');
            $('#deletePermissionModal').modal('hide');
            $('#viewPermissionModal').modal('hide');
        });

        window.addEventListener('show-edit-permission-modal', event => {
            $('#editPermissionModal').modal('show');
        })

        window.addEventListener('show-delete-permission-modal', event => {
            $('#deletePermissionModal').modal('show');
        });

        window.addEventListener('show-view-permission-modal', event => {
            $('#viewPermissionModal').modal('show');
        })
    </script>
