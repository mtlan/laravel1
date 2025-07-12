    <div>
        <div class="custom-title">
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4 mb-4">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            Danh sách thời hạn thẻ
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4 mb-2">
                @can('create')
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addHdvdlDmThoiHanTheModal">Thêm
                        mới</button>
                @endcan
            </div>

            <div class="container-fluid pt-2 px-4">
                <div class="text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Thời hạn thẻ</h6>

                        <div class="d-flex flex-grow-1 search-box ms-3" style="max-width: 500px; min-width: 300px;">
                            <input class="form-control serch me-1 flex-grow-1" type="text"
                                wire:model.live.debounce.300ms="searchParam" placeholder="Tìm kiếm theo tên, mã ..."
                                aria-label="Search">
                            <i class="ri-search-line search-icon"></i>
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
                                    <th scope="col" class="text-center">Mã</th>
                                    <th scope="col" class="text-center">Trạng thái</th>
                                    <th scope="col" class="text-center w-25">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($hdvdl_dm_thoi_han_thes as $hdvdl_dm_thoi_han_the)
                                    <tr>
                                        <td class="text-center">
                                            <a href="#"
                                                wire:click.prevent="view({{ $hdvdl_dm_thoi_han_the->id }})"
                                                style="color: rgb(48, 100, 177); cursor: pointer; text-decoration: underline;">
                                                {{ $hdvdl_dm_thoi_han_the->ten }}
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $hdvdl_dm_thoi_han_the->ma }}</td>
                                        <td class="text-center">
                                            @if ($hdvdl_dm_thoi_han_the->trangthai == 1)
                                                <span class="badge bg-success">Đang hoạt động</span>
                                            @else
                                                <span class="badge bg-warning">Tạm ngưng</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @can('edit')
                                                <button class="btn btn-sm btn-success"
                                                    wire:click="edit({{ $hdvdl_dm_thoi_han_the->id }})">Sửa</button>
                                            @endcan

                                            @can('delete')
                                                <button class="btn btn-sm btn-outline-danger"
                                                    wire:click="delete({{ $hdvdl_dm_thoi_han_the->id }})">Xoá</button>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <div style="float: right;">
                                            {{ $hdvdl_dm_thoi_han_thes->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }}
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
        <div wire:ignore.self class="modal fade" id="addHdvdlDmThoiHanTheModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="store">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title text-black" id="exampleModalLabel">Thêm mới thời hạn thẻ</h5>
                            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-2">
                                <x-label for="tenThoiHanThe" field="ten" class="col-3"
                                    :required="$this->isRequired('ten')">Tên</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="tenThoiHanThe" wire:model="ten"
                                        placeholder="Nhập tên">
                                    @error('ten')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <x-label for="maThoiHanThe" field="ma" class="col-3"
                                    :required="$this->isRequired('ma')">Tên</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="maThoiHanThe" wire:model="ma"
                                        placeholder="Nhập mã">
                                    @error('ma')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <x-label for="trangThaiThoiHanThe" field="trangthai" class="col-3"
                                    :required="$this->isRequired('trangthai')">Tên</x-label>
                                <div class="col-12">
                                    <select class="form-select" wire:model="trangthai" id="trangThaiThoiHanThe">
                                        <option value="1">Đang hoạt động</option>
                                        <option value="0">Tạm ngưng</option>
                                    </select>
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
        <div wire:ignore.self class="modal fade" id="editHdvdlDmThoiHanTheModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Chỉnh sửa thời hạn thẻ</h5>
                        <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal"
                            wire:click="closeModal()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="update" class="mb-2">
                            @csrf
                            <div class="form-group mb-2">
                                <x-label for="tenThoiHanThe" field="ten" class="col-3"
                                    :required="$this->isRequired('ten')">Tên</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="namepermission" wire:model="ten"
                                        placeholder="Nhập tên">
                                    @error('ten')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <x-label for="maThoiHanThe" field="ma" class="col-3"
                                    :required="$this->isRequired('ma')">Tên</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="maThoiHanThe" wire:model="ma"
                                        placeholder="Nhập mã">
                                    @error('ma')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <x-label for="trangThaiThoiHanThe" field="trangthai" class="col-3"
                                    :required="$this->isRequired('trangthai')">Tên</x-label>
                                <div class="col-12">
                                    <select class="form-select" wire:model="trangthai" id="trangThaiThoiHanThe">
                                        <option value="1">Đang hoạt động</option>
                                        <option value="0">Tạm ngưng</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-info">Chỉnh sửa</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal xoá -->
        <div wire:ignore.self class="modal fade" id="deleteHdvdlDmThoiHanTheModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Xoá thời hạn thẻ</h5>
                        <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <h5 class="text-black">Bạn chắc chắn muốn xoá thời hạn thẻ này??</h5>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-sm btn-primary" data-bs-dismiss="modal" aria-label="Close">Huỷ
                            bỏ</button>
                        <button class="btn btn-sm btn-danger" wire:click="deleteDmNgonNgu()">Xác nhận</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal chi tiết -->
        <div wire:ignore.self class="modal fade" id="viewHdvdlDmThoiHanTheModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết thời hạn thẻ</h5>
                        <button type="button" class="btn btn-close btn-danger"
                            wire:click="closeViewModal()"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $view_hdvdl_dm_thoi_han_the_id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên</th>
                                    <td>{{ $view_hdvdl_dm_thoi_han_the_ten }}</td>
                                </tr>
                                <tr>
                                    <th>Mã</th>
                                    <td>{{ $view_hdvdl_dm_thoi_han_the_ma }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if ($view_hdvdl_dm_thoi_han_the_trangthai == 1)
                                            <span class="badge bg-success">Đang hoạt động</span>
                                        @else
                                            <span class="badge bg-warning">Tạm ngưng</span>
                                        @endif
                                    </td>
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
            $('#addHdvdlDmThoiHanTheModal').modal('hide');
            $('#editHdvdlDmThoiHanTheModal').modal('hide');
            $('#deleteHdvdlDmThoiHanTheModal').modal('hide');
            $('#viewHdvdlDmThoiHanTheModal').modal('hide');
        });

        window.addEventListener('show-edit-hdvdl-dm-thoi-han-the-modal', event => {
            $('#editHdvdlDmThoiHanTheModal').modal('show');
        })

        window.addEventListener('show-delete-hdvdl-dm-thoi-han-the-modal', event => {
            $('#deleteHdvdlDmThoiHanTheModal').modal('show');
        });

        window.addEventListener('show-view-hdvdl-dm-thoi-han-the-modal', event => {
            $('#viewHdvdlDmThoiHanTheModal').modal('show');
        })
    </script>
