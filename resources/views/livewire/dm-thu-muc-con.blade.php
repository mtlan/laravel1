@php
use Illuminate\Support\Facades\Storage;
@endphp

<div>
    <div class="container-fluid pt-4 px-4">
        <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Quản lý thư mục con</h4>
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
                                    Thư mục con
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#childrenModal">Thêm thư mục</button>
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#photoModal">Thêm ảnh</button>
            </div>

            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 text-black">Thư mục con</h6>
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

                <div class="container py-4">
                    <div class="row g-3">
                        @foreach ($thuMucCons as $thuMucCon)
                        <div class="col-md-3">
                            <div class="card position-relative">
                                <div class="card-body d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-folder-fill text-secondary" style="font-size: 24px;"></i>
                                        <a href="{{ route('portal.thuvienanh', ['slugCha' => $thuMucCha->slug, 'slugCon' => $thuMucCon->slug]) }}" class="link-dark"><span class="text-truncate" style="max-width: 120px;">{{ $thuMucCon->ten }}</span></a>
                                    </div>

                                    <div x-data="{ open: false }" class="position-relative">
                                        <button @click="open = !open" class="btn btn-sm">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>

                                        <div x-show="open" @click.outside="open = false"
                                            class="dropdown-menu show position-absolute end-0 mt-2 p-2 border shadow bg-white"
                                            style="z-index: 1000;">
                                            <button class="dropdown-item" wire:click="edit({{ $thuMucCon->id }})">Sửa</button>
                                            <button class="dropdown-item" style="color: red" wire:click="delete({{ $thuMucCon->id }})">Xóa</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Phần hiển thị ảnh -->
            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-black">Thư viện ảnh</h6>
                </div>

                <div class="container">
                    <div class="row">
                        @foreach ($photos as $photo)
                            <div class="col-md-3">
                                <div class="card">
                                    <img class="card-img-top img-fluid" src="{{ asset($photo->url) }}"
                                        alt="Card image cap">
                                    <div class="card-header">
                                        <h4 class="card-title mb-2">{{ $photo->ten }}</h4>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <p class="card-text mb-0">
                                            {!! $photo->getTrangThai() !!}
                                        </p>
                                        <div x-data="{ open: false }" class="position-relative">
                                            <button @click="open = !open" class="btn btn-sm">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>

                                            <div x-show="open" @click.outside="open = false"
                                                class="dropdown-menu show position-absolute end-0 mt-2 p-2 border shadow bg-white"
                                                style="z-index: 1000;">
                                                <button class="dropdown-item"
                                                    wire:click="editPhoto({{ $photo->id }})">Sửa</button>
                                                <button class="dropdown-item" style="color: red"
                                                    wire:click="deletePhoto({{ $photo->id }})">Xóa</button>
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
    <div wire:ignore.self class="modal fade" id="childrenModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">
                            {{ $childrenId ? 'Chỉnh sửa' : 'Thêm mới' }} thư mục con</h5>
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
                        <button type="submit" class="btn btn-primary">{{ $childrenId ? 'Cập nhật' : 'Thêm mới' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal tạo mới ảnh -->
    <div wire:ignore.self class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="storePhoto" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">
                            Thêm mới ảnh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <div class="col-12" x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true; progress = 0"
                                x-on:livewire-upload-finish="progress = 100; setTimeout(() => { uploading = false; }, 1500);"
                                x-on:livewire-upload-cancel="uploading = false; progress = 0"
                                x-on:livewire-upload-error="uploading = false; progress = 0"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">

                                <x-label for="hinhanhUpload" field="hinhanhs" class="col-6" :required="true">Hình
                                    ảnh</x-label>

                                <div x-show="uploading">
                                    <progress max="100" x-bind:value="progress" class="me-2"></progress>
                                    <span x-text="progress + '%'"></span>
                                </div>

                                <input wire:model.defer="hinhanhs" x-show="!uploading" multiple class="form-control"
                                    id="imageUpload" type="file">

                                @if ($hinhanhs)
                                    @foreach ($hinhanhs as $index => $image)
                                        <ul class="list-unstyled mb-0">
                                            <li class="mt-2">
                                                <div class="border rounded">
                                                    <div class="d-flex p-2">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar-sm bg-light rounded">
                                                                <img data-dz-thumbnail=""
                                                                    class="img-fluid rounded d-block"
                                                                    src="{{ $image->temporaryUrl() }}" alt="">
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <div class="pt-1">
                                                                <h5 class="fs-md mb-1">&nbsp;</h5>
                                                            </div>
                                                        </div>
                                                        <div class="flex-shrink-0 ms-3">
                                                            <button type="button"
                                                                wire:click="removeImage({{ $index }})"
                                                                class="btn btn-sm btn-danger">Xóa</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    @endforeach

                                @endif

                                @error('hinhanhs.*')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <x-label for="trangThaiAnh" field="trangThaiAnh" class="col-6" :required="true">Trạng
                                thái</x-label>
                            <div class="col-12">
                                <select id="trangThaiAnh" wire:model="trangThaiAnh" class="form-select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm ngưng</option>
                                </select>
                                @error('trangThaiAnh')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal chỉnh sửa ảnh -->
    <div wire:ignore.self class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="updatePhoto">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">
                            Cập nhật ảnh</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <div class="col-12" x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true; progress = 0"
                                x-on:livewire-upload-finish="progress = 100; setTimeout(() => { uploading = false; }, 1500);"
                                x-on:livewire-upload-cancel="uploading = false; progress = 0"
                                x-on:livewire-upload-error="uploading = false; progress = 0"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">

                                <x-label for="hinhanhUpload" field="hinhanh_edit" class="col-6"
                                    :required="true">Hình
                                    ảnh</x-label>

                                <div x-show="uploading">
                                    <progress max="100" x-bind:value="progress" class="me-2"></progress>
                                    <span x-text="progress + '%'"></span>
                                </div>

                                <input wire:model.defer="hinhanh_edit" x-show="!uploading"
                                    class="form-control" id="imageUpload" type="file">

                                @if ($hinhanh_exist)
                                    <div class="mb-2">
                                        <img src="{{ asset($hinhanh_exist) }}" alt="Ảnh hiện tại"
                                            style="max-width: 200px;">
                                    </div>
                                @endif

                                @error('hinhanh_edit')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group mb-2">
                            <x-label for="trangThaiAnh" field="trangThaiAnh" class="col-6" :required="true">Trạng
                                thái</x-label>
                            <div class="col-12">
                                <select id="trangThaiAnh" wire:model="trangThaiAnh" class="form-select">
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm ngưng</option>
                                </select>
                                @error('trangThaiAnh')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cập nhật ảnh</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteChildrenModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá thư mục con</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá thư mục con này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-primary" wire:click="deleteChildren()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xoá ảnh -->
    <div wire:ignore.self class="modal fade" id="deletePhotoModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá ảnh</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá ảnh này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-primary" wire:click="deletePhotoConfirm()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener('close-modal', event => {
        $('#childrenModal').modal('hide');
        $('#photoModal').modal('hide');
        $('#editPhotoModal').modal('hide');
        $('#deleteChildrenModal').modal('hide');
        $('#deletePhotoModal').modal('hide');
        
    });

    window.addEventListener('show-edit-modal', event => {
        $('#childrenModal').modal('show');
    })

    window.addEventListener('show-edit-photo-modal', event => {
        $('#editPhotoModal').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#deleteChildrenModal').modal('show');
    });

    window.addEventListener('show-delete-photo-modal', event => {
        $('#deletePhotoModal').modal('show');
    });
</script>

<script>
    document.addEventListener('livewire:init', function() {
        $('#childrenModal').on('hidden.bs.modal', function() {
            @this.resetFields(); // Reset giá trị Livewire
        });
        
        $('#photoModal').on('hidden.bs.modal', function() {
            @this.resetFields(); // Reset giá trị Livewire
        });
        
        $('#editPhotoModal').on('hidden.bs.modal', function() {
            @this.resetFields(); // Reset giá trị Livewire
        });
    });
</script>
