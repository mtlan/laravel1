<div>
    <div class="container-fluid pt-4 px-4">
        <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Quản lý chuyên mục</h4>
                            </div>
                        </nav>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="page-header-breadcrumb " style="float: right">
                            <ul class="breadcrumb breadcrumb-title">
                                <li class="breadcrumb-item">
                                    <i class="fa fa-tachometer-alt me-1"></i>
                                    Trang chủ
                                </li>
                                <li class="breadcrumb-item active">
                                    <i class="fa-solid fa-cloud me-1"></i>
                                    Portal
                                </li>
                                <li class="breadcrumb-item active">
                                    Chuyên mục
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#chuyenmucModal">Thêm mới</button>
            </div>

            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-black">Chuyên mục</h6>
                    <div class="form-outline">
                        <input class="form-control me-1" type="text" style="width: 300px;"
                            wire:model.live.debounce.300ms="search" placeholder="Tìm kiếm theo chuyên mục ...">
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
                                <th scope="col" width="1%" class="text-center">#</th>
                                <th scope="col" width="10%" class="text-center">Tên</th>
                                <th scope="col" width="10%" class="text-center">Slug</th>
                                <th scope="col" width="10%" class="text-center">Loại</th>
                                <th scope="col" width="10%" class="text-center">Trạng thái</th>
                                <th scope="col" width="10%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($chuyenmucs as $chuyenmuc)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $chuyenmuc->ten }}</td>
                                    <td class="text-center">{{ $chuyenmuc->slug }}</td>
                                    <td class="text-center">{!! $chuyenmuc->getType() !!}</td>
                                    <td class="text-center">{!! $chuyenmuc->getTrangThai() !!}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-info"
                                            wire:click="view({{ $chuyenmuc->id }})">Xem</button>
                                        <button class="btn btn-sm btn-outline-success"
                                            wire:click="edit({{ $chuyenmuc->id }})">Sửa</button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="delete({{ $chuyenmuc->id }})">Xoá</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    {{ $chuyenmucs->appends(request()->input())->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tạo mới -->
    <div wire:ignore.self class="modal fade" id="chuyenmucModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">
                            {{ $chuyenmucId ? 'Chỉnh sửa' : 'Thêm mới' }} chuyên mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <x-label for="ten" field="ten" class="col-6" :required="true">Tên</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="ten" wire:model.defer="ten"
                                    placeholder="Nhập tên chuyên mục">
                                @error('ten')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="type" field="ten" class="col-6" :required="true">Loại chuyên mục</x-label>
                            <div class="col-12">
                                <select id="type" wire:model="type" class="form-select">
                                    <option value="">--Chọn--</option>
                                    <option value="0">Giới thiệu</option>
                                    <option value="1">Dịch vụ</option>
                                    <option value="2">Tin tức - Sự kiện</option>
                                </select>
                                @error('type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="trangthai" field="trangthai" class="col-6" :required="true">Trạng
                                thái</x-label>
                            <div class="col-12">
                                <select id="trangthai" wire:model="trangthai" class="form-select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm ngưng</option>
                                </select>
                                @error('trangthai')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ $chuyenmucId ? 'Cập nhật' : 'Thêm mới' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteChuyenMucModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá chuyên mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá chuyên mục này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-primary" wire:click="deleteChuyenMuc()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết -->
    <div wire:ignore.self class="modal fade" id="viewChuyenMucModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết chuyên mục</h5>
                    <button type="button" class="btn-close" wire:click="closeViewModal()"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <td>{{ $chuyenmucId }}</td>
                            </tr>
                            <tr>
                                <th>Tên chuyên mục</th>
                                <td>{{ $ten }}</td>
                            </tr>
                            <tr>
                                <th>Loại</th>
                                <td>{!! $type !!}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>{!! $trangthai !!} </td>
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
        $('#chuyenmucModal').modal('hide');
        $('#deleteChuyenMucModal').modal('hide');
        $('#viewChuyenMucModal').modal('hide');
    });

    window.addEventListener('show-edit-modal', event => {
        $('#chuyenmucModal').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#deleteChuyenMucModal').modal('show');
    });

    window.addEventListener('show-view-modal', event => {
        $('#viewChuyenMucModal').modal('show');
    })
</script>

<script>
    document.addEventListener('livewire:init', function() {
        $('#chuyenmucModal').on('hidden.bs.modal', function() {
            @this.resetFields(); // Reset giá trị Livewire
        });
    });
</script>
