    <div>
        <div class="custom-title">
            <div class="container-fluid pt-4 px-4">
                <div class="row g-4 mb-4">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            Danh sách ngôn ngữ
                        </div>
                    </nav>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4 mb-2">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addHdvdlDmNgonNguModal">Thêm
                    mới</button>
            </div>

            <div class="container-fluid pt-2 px-4">
                <div class="text-center rounded p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="mb-0">Ngôn ngữ</h6>
                        <div class="d-flex"> {{-- Thay <form> bằng <div> nếu không cần submit form truyền thống --}}
                            <input class="form-control me-1" type="text" wire:model.live.debounce.300ms="searchParam"
                                placeholder="Tìm kiếm theo tên, mã ..." aria-label="Search">
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
                                    <th scope="col" class="text-center">Mã</th>
                                    <th scope="col" class="text-center">Trạng thái</th>
                                    <th scope="col" class="text-center w-25">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($hdvdl_dm_ngon_ngus as $hdvdl_dm_ngon_ngu)
                                    <tr>
                                        <td class="text-center">{{ $hdvdl_dm_ngon_ngu->ten }}</td>
                                        <td class="text-center">{{ $hdvdl_dm_ngon_ngu->ma }}</td>
                                        <td class="text-center">
                                            @if ($hdvdl_dm_ngon_ngu->trangthai == 1)
                                                <span class="badge bg-success">Đang hoạt động</span>
                                            @else
                                                <span class="badge bg-warning">Tạm ngưng</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-success"
                                                wire:click="edit({{ $hdvdl_dm_ngon_ngu->id }})">Chỉnh
                                                sửa</button>
                                            <button class="btn btn-sm btn-info"
                                                wire:click="view({{ $hdvdl_dm_ngon_ngu->id }})">Chi
                                                tiết</button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="delete({{ $hdvdl_dm_ngon_ngu->id }})">Xoá</button>
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="12">
                                        <div style="float: right;">
                                            {{-- {{ $hdvdl_dm_ngon_ngus->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }} --}}
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
        <div wire:ignore.self class="modal fade" id="addHdvdlDmNgonNguModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form wire:submit.prevent="store">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title text-black" id="exampleModalLabel">Thêm mới ngôn ngữ</h5>
                            <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-2">
                                <x-label for="ten" field="ten" class="col-3" :required="$this->isRequired('ten')">Tên</x-label>

                                {{-- <label for="nameCategory" class="col-3">Tên</label> --}}
                                <div class="col-12">
                                    <input type="text" class="form-control" id="nameCategory" wire:model="ten"
                                        placeholder="Nhập tên">
                                    @error('ten')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <x-label for="ten" field="ten" class="col-3" :required="$this->isRequired('ma')">Mã</x-label>

                                {{-- <label for="nameCategory" class="col-3">Mã</label> --}}
                                <div class="col-12">
                                    <input type="text" class="form-control" id="nameCategory" wire:model="ma"
                                        placeholder="Nhập mã">
                                    @error('ma')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="nameCategory" class="col-3">Trạng thái</label>
                                <div class="col-12">
                                    <select class="form-select" wire:model="trangthai" id="nameCategory">
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
        <div wire:ignore.self class="modal fade" id="editHdvdlDmNgonNguModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Chỉnh sửa ngôn ngữ</h5>
                        <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal"
                            wire:click="closeModal()" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form wire:submit.prevent="update" class="mb-2">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="namepermission" class="col-3">Tên</label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="namepermission" wire:model="ten"
                                        placeholder="Nhập tên">
                                    @error('ten')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="nameCategory" class="col-3">Mã</label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="nameCategory" wire:model="ma"
                                        placeholder="Nhập mã">
                                    @error('ma')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="nameCategory" class="col-3">Trạng thái</label>
                                <div class="col-12">
                                    <select class="form-select" wire:model="trangthai" id="nameCategory">
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
        <div wire:ignore.self class="modal fade" id="deleteHdvdlDmNgonNguModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Xoá ngôn ngữ</h5>
                        <button type="button" class="btn btn-close btn-danger" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-4 pb-4">
                        <h5 class="text-black">Bạn chắc chắn muốn xoá ngôn ngữ này??</h5>
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
        <div wire:ignore.self class="modal fade" id="viewHdvdlDmNgonNguModal" tabindex="-1"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết ngôn ngữ</h5>
                        <button type="button" class="btn btn-close btn-danger"
                            wire:click="closeViewModal()"></button>
                    </div>
                    <div class="modal-body">
                        {{-- <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $view_hdvdl_dm_ngon_ngu_id }}</td>
                                </tr>
                                <tr>
                                    <th>Tên</th>
                                    <td>{{ $view_hdvdl_dm_ngon_ngu_ten }}</td>
                                </tr>
                                <tr>
                                    <th>Mã</th>
                                    <td>{{ $view_hdvdl_dm_ngon_ngu_ma }}</td>
                                </tr>
                                <tr>
                                    <th>Trạng thái</th>
                                    <td>
                                        @if ($view_hdvdl_dm_ngon_ngu_trangthai == 1)
                                            <span class="badge bg-success">Đang hoạt động</span>
                                        @else
                                            <span class="badge bg-warning">Tạm ngưng</span>
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('close-modal', event => {
            $('#addHdvdlDmNgonNguModal').modal('hide');
            $('#editHdvdlDmNgonNguModal').modal('hide');
            $('#deleteHdvdlDmNgonNguModal').modal('hide');
            $('#viewHdvdlDmNgonNguModal').modal('hide');
        });

        window.addEventListener('show-edit-hdvdl-dm-ngon-ngu-modal', event => {
            $('#editHdvdlDmNgonNguModal').modal('show');
        })

        window.addEventListener('show-delete-hdvdl-dm-ngon-ngu-modal', event => {
            $('#deleteHdvdlDmNgonNguModal').modal('show');
        });

        window.addEventListener('show-view-hdvdl-dm-ngon-ngu-modal', event => {
            $('#viewHdvdlDmNgonNguModal').modal('show');
        })
    </script>
