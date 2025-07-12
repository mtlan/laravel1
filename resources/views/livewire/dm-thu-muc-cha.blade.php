<div>
    <div class="container-fluid pt-4 px-4">
        <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Quản lý thư mục</h4>
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
                                    Thư mục
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#parentModal">Thêm mới</button>
            </div>

            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-black">Thư mục</h6>
                    <div class="form-outline">
                        <input class="form-control me-1" type="text" style="width: 300px;"
                            wire:model.live.debounce.300ms="search" placeholder="Tìm kiếm theo thư mục ...">
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

                {{-- <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col" width="1%" class="text-center">#</th>
                                <th scope="col" width="10%" class="text-center">Tên</th>
                                <th scope="col" width="15%" class="text-center">Slug</th>
                                <th scope="col" width="10%" class="text-center">Trạng thái</th>
                                <th scope="col" width="15%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($thuMucChas as $thuMucCha)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center"><a
                                            href="{{ route('portal.thumuccon', ['slugCha' => $thuMucCha->slug]) }}">{{ $thuMucCha->ten }}</a>
                                    </td>
                                    <td class="text-center">{{ $thuMucCha->slug }}</td>
                                    <td class="text-center">{!! $thuMucCha->getTrangThai() !!}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-success"
                                            wire:click="edit({{ $thuMucCha->id }})">Sửa</button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="delete({{ $thuMucCha->id }})">Xoá</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    {{ $thuMucChas->appends(request()->input())->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div> --}}

                <div class="container py-4">
                    <div class="row g-3">
                        @foreach ($thuMucChas as $thuMucCha)
                        <div class="col-md-3">
                            <div class="card position-relative">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-folder-fill text-secondary" style="font-size: 24px;"></i>
                                        <a href="{{ route('portal.thumuccon', ['slugCha' => $thuMucCha->slug]) }}" class="link-dark"><span class="text-truncate" style="max-width: 120px;">{{ $thuMucCha->ten }}</span></a>
                                    </div>

                                    <div x-data="{ open: false }" class="position-relative">
                                        <button @click="open = !open" class="btn btn-sm">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>

                                        <div x-show="open" @click.outside="open = false"
                                            class="dropdown-menu show position-absolute end-0 mt-2 p-2 border shadow bg-white"
                                            style="z-index: 1000;">
                                            <button class="dropdown-item" wire:click="edit({{ $thuMucCha->id }})">Sửa</button>
                                            <button class="dropdown-item" style="color: red" wire:click="delete({{ $thuMucCha->id }})">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tạo mới -->
    <div wire:ignore.self class="modal fade" id="parentModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">
                            {{ $parentId ? 'Chỉnh sửa' : 'Thêm mới' }} thư mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <x-label for="ten" field="ten" class="col-6" :required="true">Tên</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="ten" wire:model.defer="ten"
                                    placeholder="Nhập tên thư mục">
                                @error('ten')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
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
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-primary">{{ $parentId ? 'Cập nhật' : 'Thêm mới' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteParentModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá thư mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá thư mục này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-primary" wire:click="deleteParent()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('close-modal', event => {
        $('#parentModal').modal('hide');
        $('#deleteParentModal').modal('hide');
    });

    window.addEventListener('show-edit-modal', event => {
        $('#parentModal').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#deleteParentModal').modal('show');
    });
</script>

<script>
    document.addEventListener('livewire:init', function() {
        $('#parentModal').on('hidden.bs.modal', function() {
            @this.resetFields(); // Reset giá trị Livewire
        });
    });
</script>
