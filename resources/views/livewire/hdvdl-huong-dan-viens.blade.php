<div>
    <div class="container-fluid pt-4 px-4">
        <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Quản lý hướng dẫn viên du lịch</h4>
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
                                    Hướng dẫn viên
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4">
                @can('create')
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addHdvdlHdvModal">Thêm mới</button>
                @endcan

                @can('export_pdf')
                    <div style="float: right;">
                        @if (count($selectedItems) > 0)
                            <div class="d-inline-block ms-3">
                                <button class="btn btn-outline-danger ms-2" wire:click="deleteSelected">Xóa đã
                                    chọn</button>
                            </div>
                        @endif

                        <button class="btn btn-outline-primary" wire:click="exportTheHdvdl">In thẻ
                            ({{ $selectedItems ? count($selectedItems) : 0 }})</button>
                    </div>
                @endcan
            </div>

            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-black">Hướng dẫn viên</h6>
                    <div class="d-flex flex-grow-1 search-box ms-3" style="max-width: 500px; min-width: 300px;">

                        <input class="form-control serch me-1 flex-grow-1" type="text"
                            wire:model.live.debounce.300ms="searchParam"
                            placeholder="Tìm kiếm theo tên, số thẻ, số điện thoại, CCCD/CMND, email ..."
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
                        <thead class="table-active">
                            <tr class="text-white">
                                <th scope="col" width="2%">
                                    <div class="form-check text-center">
                                        <input class="form-check-input" type="checkbox" wire:model.live="selectAll"
                                            id="checkAll">
                                        <label class="form-check-label" for="checkAll"></label>
                                    </div>
                                </th>
                                <th scope="col" width="10%" class="text-center">Ảnh thẻ</th>
                                <th scope="col" width="15%" class="text-center">Tên</th>
                                <th scope="col" width="10%" class="text-center">Số thẻ</th>
                                <th scope="col" width="20%" class="text-center">CCCD</th>
                                <th scope="col" width="15%" class="text-center">Trạng thái</th>
                                <th scope="col" width="15%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($huongDanViens as $huongDanVien)
                                <tr>
                                    <td>
                                        <div class="form-check text-center">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.live="selectedItems" value="{{ $huongDanVien->id }}"
                                                name="chk_child">
                                            <label class="form-check-label"></label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        @php
                                            $image = App\Models\CmsAttachment::where(
                                                'huongdanvien_id',
                                                $huongDanVien->id,
                                            )
                                                ->where('type', 1)
                                                ->where('daxoa', 0)
                                                ->first();
                                        @endphp

                                        @if ($image)
                                            <img src="{{ asset($image->url) }}" alt="Ảnh thẻ" width="70px"
                                                style="width: 75px; height: 112.5px;">
                                        @else
                                            {{ 'Không có ảnh' }}
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="#" wire:click.prevent="view({{ $huongDanVien->id }})"
                                            style="color: rgb(48, 100, 177); cursor: pointer; text-decoration: underline;">
                                            {{ $huongDanVien->ho_tenlot }}
                                            {{ $huongDanVien->ten }}
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        {{ $huongDanVien->thedanghoatdong?->sothe }}</td>
                                    <td class="text-center">{{ $huongDanVien->cmnd_so }}</td>
                                    <td class="text-center">{!! $huongDanVien->getTrangThai() !!}</td>
                                    <td class="text-center">
                                        @can('manage_the')
                                            <button class="btn btn-sm btn-outline-primary"
                                                wire:click="manageThe({{ $huongDanVien->id }})">Thẻ</button>
                                        @endcan

                                        @can('edit')
                                            <button class="btn btn-sm btn-outline-success"
                                                wire:click="edit({{ $huongDanVien->id }})">Sửa</button>
                                        @endcan

                                        @can('delete')
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="delete({{ $huongDanVien->id }})">Xoá</button>
                                        @endcan
                                    </td>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div style="float: right;">
                                        {{ $huongDanViens->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }}
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
    <div wire:ignore.self class="modal fade" id="addHdvdlHdvModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Thêm mới hướng dẫn viên</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-2" x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true; progress = 0"
                                x-on:livewire-upload-finish="progress = 100; setTimeout(() => { uploading = false; }, 1500);"
                                x-on:livewire-upload-cancel="uploading = false; progress = 0"
                                x-on:livewire-upload-error="uploading = false; progress = 0"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <x-label for="imageUpload" field="image" class="col-6" :required="$this->isRequired('image')">Hình
                                    ảnh</x-label>
                                <div x-show="uploading">
                                    <progress max="100" x-bind:value="progress" class="me-2"></progress>
                                    <span x-text="progress + '%'"></span>
                                </div>

                                <input wire:model.defer="image" x-show="!uploading" class="form-control"
                                    id="imageUpload" placeholder="Tải ảnh lên" type="file">
                                @error('image')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="hoTenLot" field="hoTenLot" class="col-6" :required="$this->isRequired('imahoTenLotge')">Họ và tên
                                    đệm</x-label>
                                <input type="text" class="form-control" id="hoTenLot" wire:model="hoTenLot"
                                    placeholder="Nhập họ và tên lót">
                                @error('hoTenLot')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="ten" field="ten" class="col-6" :required="$this->isRequired('ten')">Tên</x-label>
                                <input type="text" class="form-control" id="ten" wire:model="ten"
                                    placeholder="Nhập tên">
                                @error('ten')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- <div class="form-group">
                            <label for="image" class="col-6">Hình ảnh</label>
                            <div class="col-12">
                                <input type="file" class="form-control" id="image" wire:model="image"
                                    name="image">
                                @error('image')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="ngaySinh" field="ngaySinh" class="col-6" :required="$this->isRequired('ngaySinh')">Ngày
                                    sinh</x-label>
                                <input type="text" class="form-control" id="ngaySinh" wire:model="ngaySinh"
                                    placeholder="Nhập ngày sinh">
                                @error('ngaySinh')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="gioiTinh" field="gioiTinh" class="col-6" :required="$this->isRequired('gioiTinh')">Giới
                                    tính</x-label>
                                <select id="gioiTinh" wire:model="gioiTinh" class="form-select">
                                    <option value="">Chọn giới tính</option>
                                    <option value="1">Nam</option>
                                    <option value="2">Nữ</option>
                                </select>
                                @error('gioiTinh')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="sdt1" field="sdt1" class="col-6" :required="$this->isRequired('sdt1')">Số điện thoại
                                    1</x-label>
                                <input type="text" class="form-control" id="sdt1" wire:model="sdt1"
                                    placeholder="Nhập số điện thoại 1">
                                @error('sdt1')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="email1" field="email1" class="col-6" :required="$this->isRequired('email1')">Email
                                    1</x-label>
                                <input type="text" class="form-control" id="email1" wire:model="email1"
                                    placeholder="Nhập email 1">
                                @error('email1')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="sdt2" field="sdt2" class="col-6" :required="$this->isRequired('sdt2')">Số điện thoại
                                    2</x-label>
                                <input type="text" class="form-control" id="sdt2" wire:model="sdt2"
                                    placeholder="Nhập số điện thoại 2">
                                @error('sdt2')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="email2" field="email2" class="col-6" :required="$this->isRequired('email2')">Email
                                    2</x-label>
                                <input type="text" class="form-control" id="email2" wire:model="email2"
                                    placeholder="Nhập email 2">
                                @error('email2')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="diaChi" field="diaChi" class="col-6" :required="$this->isRequired('diaChi')">Địa
                                    chỉ</x-label>
                                <input type="text" class="form-control" id="diaChi" wire:model="diaChi"
                                    placeholder="Nhập địa chỉ">
                                @error('diaChi')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="cmndSo" field="cmndSo" class="col-6" :required="$this->isRequired('cmndSo')">Số
                                    CCCD</x-label>
                                <input type="text" class="form-control" id="cmndSo" wire:model="cmndSo"
                                    placeholder="Nhập số CCCD">
                                @error('cmndSo')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="cmndNgayCap" field="cmndNgayCap" class="col-6" :required="$this->isRequired('cmndNgayCap')">Ngày
                                    cấp CCCD</x-label>
                                <input type="text" class="form-control" id="cmndNgayCap" wire:model="cmndNgayCap"
                                    placeholder="Nhập ngày cấp CCCD">
                                {{-- <input type="date" class="form-control" id="cmndNgayCap" wire:model="cmndNgayCap"
                                    placeholder="Nhập ngày cấp CMND/ Hộ chiếu"> --}}
                                @error('cmndNgayCap')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="cmndNoiCap" field="cmndNoiCap" class="col-6" :required="$this->isRequired('cmndNoiCap')">Nơi
                                    cấp CCCD</x-label>
                                <input type="text" class="form-control" id="cmndNoiCap" wire:model="cmndNoiCap"
                                    placeholder="Nhập nơi cấp CCCD">
                                @error('cmndNoiCap')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2" id="dropdown-add-ngon-ngu" wire:ignore>
                                <x-label for="add-select-user" field="ngonNguList" class="col-6"
                                    :required="$this->isRequired('ngonNguList')">Ngôn
                                    ngữ phụ</x-label>
                                <select id="add-select-user" wire:model="ngonNguList"
                                    class="form-select form-select-sm form-select-solid" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn ngôn ngữ"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach ($dm_ngonngus as $dm_ngonngu)
                                        <option value="{{ $dm_ngonngu->id }}">{{ $dm_ngonngu->ten }}</option>
                                    @endforeach
                                </select>
                                @error('ngonNguList')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="trangThai" field="trangThai" class="col-6" :required="$this->isRequired('trangThai')">Trạng
                                    thái</x-label>
                                <select id="trangThai" wire:model="trangThai" class="form-select">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm ngưng</option>
                                </select>
                                @error('trangThai')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Thêm mới</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal chỉnh sửa -->
    <div wire:ignore.self class="modal fade" id="editHdvdlHdvModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chỉnh sửa hướng dẫn viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" class="mb-2">
                        @csrf
                        {{-- @if (session()->has('message'))
                            <div class="alert alert-success text-center">
                                {{ session('message') }}
                            </div>
                        @endif --}}
                        <div class="row">
                            <div class="col-12 mb-2" x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true; progress = 0"
                                x-on:livewire-upload-finish="progress = 100; setTimeout(() => { uploading = false; }, 1500);"
                                x-on:livewire-upload-cancel="uploading = false; progress = 0"
                                x-on:livewire-upload-error="uploading = false; progress = 0"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <x-label for="imageUpload" field="image" class="col-6" :required="$this->isRequired('image')">Hình
                                    ảnh</x-label>
                                <div x-show="uploading">
                                    <progress max="100" x-bind:value="progress" class="me-2"></progress>
                                    <span x-text="progress + '%'"></span>
                                </div>

                                @if (session()->has('success_file'))
                                    <div class="alert alert-success text-center">
                                        {{ session('success_file') }}
                                    </div>
                                @endif

                                @if (session()->has('error_file'))
                                    <div class="alert alert-danger text-center">
                                        {{ session('error_file') }}
                                    </div>
                                @endif
                                @if ($file_original)
                                    <div class="mt-2">
                                        <div class="alert alert-info d-flex justify-content-between align-items-center p-2"
                                            wire:key="file-preview">
                                            {{-- <span class="me-2"
                                                style="word-break: break-all;">{{ $file_original->original_name }}</span> --}}
                                            <img src="{{ asset($file_original->url) }}" alt=""
                                                class="img-fluid" style="width: 30%; height: 30%;" />
                                            <button type="button" class="btn-close" aria-label="Remove file"
                                                title="Xóa file này"
                                                wire:click="removeFile({{ $file_original->id }})"></button>
                                        </div>
                                    </div>
                                @else
                                    <input wire:model.defer="image" x-show="!uploading" class="form-control"
                                        id="imageUpload" placeholder="Tải ảnh lên" type="file">
                                    @error('image')
                                        <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                    @enderror
                                @endif
                            </div>
                        </div>
                        {{-- <div class="form-group">
                            <label for="image" class="col-6">Hình ảnh</label>
                            <div class="col-12">
                                <input type="file" class="form-control" id="image" wire:model="image"
                                    name="image">
                                @error('image')
                                    <span class="text-danger" style="font-size: 11.5px">{{ $message }}</span>
                                @enderror
                            </div>
                            @if ($oldImage || $oldImage != null)
                                <div class="col-12">
                                    <img src="{{ asset($oldImage->url) }}" alt=""
                                        style="width: 75px; height: 112.5px;" class="img-fluid">
                                    <button type="button" class="btn btn-sm btn-danger" wire:click="deleteImage">Xoá
                                        ảnh</button>
                                </div>
                            @endif
                        </div> --}}
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="hoTenLot" field="hoTenLot" class="col-6" :required="$this->isRequired('hoTenLot')">Họ và tên
                                    đệm</x-label>
                                <input type="text" class="form-control" id="hoTenLot" wire:model="hoTenLot"
                                    placeholder="Nhập họ và tên lót">
                                @error('hoTenLot')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="ten" field="ten" class="col-6"
                                    :required="$this->isRequired('ten')">Tên</x-label>
                                <input type="text" class="form-control" id="ten" wire:model="ten"
                                    placeholder="Nhập tên">
                                @error('ten')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="ngaySinh" field="ngaySinh" class="col-6" :required="$this->isRequired('ngaySinh')">Ngày
                                    sinh</x-label>
                                <input type="text" class="form-control" id="ngaySinh" wire:model="ngaySinh"
                                    placeholder="Nhập ngày sinh">
                                @error('ngaySinh')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="gioiTinh" field="gioiTinh" class="col-6" :required="$this->isRequired('gioiTinh')">Giới
                                    tính</x-label>
                                <select id="gioiTinh" wire:model="gioiTinh" class="form-select">
                                    <option value="">Chọn giới tính</option>
                                    <option value="1">Nam</option>
                                    <option value="2">Nữ</option>
                                </select>
                                @error('gioiTinh')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="sdt1" field="sdt1" class="col-6" :required="$this->isRequired('sdt1')">Số điện
                                    thoại
                                    1</x-label>
                                <input type="text" class="form-control" id="sdt1" wire:model="sdt1"
                                    placeholder="Nhập số điện thoại 1">
                                @error('sdt1')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="email1" field="email1" class="col-6" :required="$this->isRequired('email1')">Email
                                    1</x-label>
                                <input type="text" class="form-control" id="email1" wire:model="email1"
                                    placeholder="Nhập email 1">
                                @error('email1')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="sdt2" field="sdt2" class="col-6" :required="$this->isRequired('sdt2')">Số điện
                                    thoại
                                    2</x-label>
                                <input type="text" class="form-control" id="sdt2" wire:model="sdt2"
                                    placeholder="Nhập số điện thoại 2">
                                @error('sdt2')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="email2" field="email2" class="col-6" :required="$this->isRequired('email2')">Email
                                    2</x-label>
                                <input type="text" class="form-control" id="email2" wire:model="email2"
                                    placeholder="Nhập email 2">
                                @error('email2')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="diaChi" field="diaChi" class="col-6" :required="$this->isRequired('diaChi')">Địa
                                    chỉ</x-label>
                                <input type="text" class="form-control" id="diaChi" wire:model="diaChi"
                                    placeholder="Nhập địa chỉ">
                                @error('diaChi')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="cmndSo" field="cmndSo" class="col-6" :required="$this->isRequired('cmndSo')">Số
                                    CCCD</x-label>
                                <input type="text" class="form-control" id="cmndSo" wire:model="cmndSo"
                                    placeholder="Nhập số CCCD">
                                @error('cmndSo')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <x-label for="cmndNgayCap" field="cmndNgayCap" class="col-6" :required="$this->isRequired('cmndNgayCap')">Ngày
                                    cấp CCCD</x-label>
                                <input type="text" class="form-control" id="cmndNgayCap" wire:model="cmndNgayCap"
                                    placeholder="Nhập ngày cấp CCCD">
                                @error('cmndNgayCap')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="cmndNoiCap" field="cmndNoiCap" class="col-6" :required="$this->isRequired('cmndNoiCap')">Nơi
                                    cấp CCCD</x-label>
                                <input type="text" class="form-control" id="cmndNoiCap" wire:model="cmndNoiCap"
                                    placeholder="Nhập nơi cấp CCCD">
                                @error('cmndNoiCap')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2" id="dropdown-edit-ngon-ngu" wire:ignore>
                                <x-label for="edit-select-user" field="ngonNguList" class="col-6"
                                    :required="$this->isRequired('ngonNguList')">Ngôn ngữ phụ</x-label>
                                <select id="edit-select-user" wire:model="ngonNguList" class="form-select select2"
                                    data-control="select2" data-close-on-select="false" placeholder="Chọn ngôn ngữ"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach ($dm_ngonngus as $dm_ngonngu)
                                        <option value="{{ $dm_ngonngu->id }}">{{ $dm_ngonngu->ten }}</option>
                                    @endforeach
                                </select>
                                @error('ngonNguList')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-2">
                                <x-label for="trangThai" field="trangThai" class="col-6" :required="$this->isRequired('trangThai')">Trạng
                                    thái</x-label>
                                <select id="trangThai" wire:model="trangThai" class="form-select">
                                    <option value="">Chọn trạng thái</option>
                                    <option value="1">Hoạt động</option>
                                    <option value="0">Tạm ngưng</option>
                                </select>
                                @error('trangThai')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
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

    <!-- Modal chỉnh sửa -->
    <div wire:ignore.self class="modal fade" id="manageTheModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">

            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title text-black" id="exampleModalLabel">Quản lý thẻ hướng dẫn viên</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    @if ($isShowForm)
                        <hr class="my-3">
                        <label for="permission"
                            class="col-12 fw-bold fs-5">{{ $huongdanvien_edit_the ? 'Chỉnh sửa' : 'Thêm mới' }}
                            thẻ</label>
                        <div class="mt-3">
                            @if (session()->has('success_file'))
                                <div class="alert alert-success text-center">
                                    {{ session('success_file') }}
                                </div>
                            @endif

                            @if (session()->has('error_file'))
                                <div class="alert alert-danger text-center">
                                    {{ session('error_file') }}
                                </div>
                            @endif
                            <form wire:submit.prevent="addThe" class="mb-2">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="hdvdl_ngonnguchinh_id" class="form-label">Ngôn ngữ chính</label>
                                        <select id="hdvdl_ngonnguchinh_id" wire:model="hdvdl_ngonnguchinh_id"
                                            class="form-select">
                                            <option value="">-- Chọn ngôn ngữ chính --</option>
                                            @foreach ($dm_ngonngus as $ngonngu)
                                                <option value="{{ $ngonngu->id }}">{{ $ngonngu->ten }}</option>
                                            @endforeach
                                        </select>
                                        @error('hdvdl_ngonnguchinh_id')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="sothe" class="form-label">Số thẻ</label>
                                        <input type="text" class="form-control" id="sothe"
                                            wire:model.defer="sothe" placeholder="Nhập số thẻ">
                                        @error('sothe')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="hdvdl_noicapthe_id" class="form-label">Nơi cấp thẻ</label>
                                        <select id="hdvdl_noicapthe_id" wire:model="hdvdl_noicapthe_id"
                                            class="form-select">
                                            <option value="">-- Chọn nơi cấp thẻ--</option>
                                            @foreach ($dm_noicapthes as $noicapthe)
                                                <option value="{{ $noicapthe->id }}">{{ $noicapthe->ten }}</option>
                                            @endforeach
                                        </select>
                                        @error('hdvdl_noicapthe_id')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="hdvdl_thoihanthe_id" class="form-label">Thời hạn thẻ</label>
                                        <select id="hdvdl_thoihanthe_id" wire:model.live="hdvdl_thoihanthe_id"
                                            class="form-select">
                                            <option value="">-- Chọn thời hạn thẻ--</option>
                                            @foreach ($dm_thoihanthes as $thoihanthe)
                                                <option value="{{ $thoihanthe->id }}">{{ $thoihanthe->ten }}</option>
                                            @endforeach
                                        </select>
                                        @error('hdvdl_thoihanthe_id')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- @if ($hdvdl_thoihanthe_id)
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="tungay" class="form-label">Từ ngày</label>
                                            <input type="text" class="form-control" id="tungay"
                                                wire:model="tungay">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="denngay" class="form-label">Đến ngày</label>
                                            <input type="text" class="form-control" id="denngay"
                                                wire:model="denngay">
                                        </div>
                                    </div>
                                @endif --}}

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="tungay" class="form-label">Từ ngày</label>
                                        <input type="text" class="form-control" id="tungay"
                                            wire:model="tungay">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="denngay" class="form-label">Đến ngày</label>
                                        <input type="text" class="form-control" id="denngay"
                                            wire:model="denngay">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2" wire:ignore>
                                        <label for="trangThai" class="form-label">Trạng thái</label>
                                        <select id="trangThai" wire:model="trangThaiThe" class="form-select">
                                            <option value="">Chọn trạng thái</option>
                                            <option value="1">Hoạt động</option>
                                            <option value="0">Tạm ngưng</option>
                                        </select>
                                        @error('trangThaiThe')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group mt-3 mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        {{ $huongdanvien_edit_the ? 'Lưu thay đổi' : 'Thêm thẻ' }} </button>
                                </div>
                            </form>
                        </div>
                    @endif

                    @if ($huongdanvien_thes)
                        <hr class="my-3">
                        <label for="permission" class="col-12 fw-bold fs-5">Danh sách thẻ hưóng dẫn
                            viên</label>

                        @can('create_the')
                            <div class="mt-3">
                                <button class="btn btn-info" wire:click="showAddThe">Thêm mới</button>
                            </div>
                        @endcan

                        @if (session()->has('the-success'))
                            <div class="alert alert-success text-center">
                                {{ session('the-success') }}
                            </div>
                        @endif

                        @if (session()->has('the-error'))
                            <div class="alert alert-danger text-center">
                                {{ session('the-error') }}
                            </div>
                        @endif

                        <div class="table-responsive mt-3">
                            <table class="table text-start align-middle table-bordered table-hover mb-0">
                                <thead>
                                    <tr class="text-white">
                                        <th scope="col" width="15%" class="text-center">Ngôn ngữ chính
                                        </th>
                                        <th scope="col" width="10%" class="text-center">Số thẻ</th>
                                        <th scope="col" width="10%" class="text-center">Nơi cấp thẻ</th>
                                        <th scope="col" width="15%" class="text-center">Thời hạn thẻ
                                        </th>
                                        <th scope="col" width="10%" class="text-center">Từ ngày</th>
                                        <th scope="col" width="10%" class="text-center">Đến ngày</th>
                                        <th scope="col" width="10%" class="text-center">Trạng thái</th>
                                        <th scope="col" width="10%" class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($huongdanvien_thes as $the)
                                        <tr>
                                            <td class="text-center">{{ $the->tiengchinh?->ten }}</td>
                                            <td class="text-center">{{ $the->sothe }}</td>
                                            <td class="text-center">{{ $the->noicapthe?->ten }}</td>
                                            <td class="text-center">{{ $the->thoihanthe?->ten }}</td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($the->tungay)->format('d/m/Y') }}
                                            </td>
                                            <td class="text-center">
                                                {{ \Carbon\Carbon::parse($the->denngay)->format('d/m/Y') }}</td>
                                            <td class="text-center">{!! $the->getTrangThai() !!}</td>
                                            <td class="text-center">
                                                @can('edit_the')
                                                    <button class="btn btn-sm btn-outline-success"
                                                        wire:click="editThe({{ $the->id }})">Sửa</button>
                                                @endcan

                                                @can('delete_the')
                                                    <button class="btn btn-sm btn-outline-danger"
                                                        wire:click="deleteThe({{ $the->id }})">Xoá</button>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteHdvdlHdvModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá hướng dẫn viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá hướng dẫn viên này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-primary" wire:click="deleteHdvdl()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết -->
    <div wire:ignore.self class="modal fade" id="viewHdvdlHdvModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết hướng dẫn viên</h5>
                    <button type="button" class="btn-close" wire:click="closeViewModal()"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Ảnh thẻ</th>
                                <td>
                                    @if ($view_huongdanvien_image != null)
                                        <img src="{{ asset($view_huongdanvien_image) }}" alt="Ảnh thẻ"
                                            width="70px" style="width: 112.5px; height: 112.5px;">
                                    @else
                                        {{ 'Không có ảnh' }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Mã QR code</th>
                                <td>
                                    @if ($view_huongdanvien_qrcode)
                                        <img src="{{ asset($view_huongdanvien_qrcode) }}" alt="Mã QR code"
                                            width="70px" style="width: 112.5px; height: 112.5px;">
                                    @else
                                        {{ 'Không tồn tại QR code' }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Họ và tên</th>
                                <td>{{ $view_huongdanvien_hovaten }}</td>
                            </tr>
                            <tr>
                                <th>Ngày sinh</th>
                                <td>{{ $view_huongdanvien_ngaysinh }}</td>
                            </tr>
                            <tr>
                                <th>Giới tính</th>
                                <td>{{ $view_huongdanvien_gioitinh == 1 ? 'Nam' : 'Nữ' }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại 1</th>
                                <td>{{ $view_huongdanvien_sdt1 }}</td>
                            </tr>
                            <tr>
                                <th>Email 1</th>
                                <td>{{ $view_huongdanvien_email1 }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại 2</th>
                                <td>{{ $view_huongdanvien_sdt2 }}</td>
                            </tr>
                            <tr>
                                <th>Email 2</th>
                                <td>{{ $view_huongdanvien_email2 }}</td>
                            </tr>
                            <tr>
                                <th>Số CMND/CCCD</th>
                                <td>{{ $view_huongdanvien_cmndSo }}</td>
                            </tr>
                            <tr>
                                <th>Ngày cấp</th>
                                <td>{{ $view_huongdanvien_cmndNgayCap }}</td>
                            </tr>
                            <tr>
                                <th>Nơi cấp</th>
                                <td>{{ $view_huongdanvien_cmndNoiCap }}</td>
                            </tr>
                            <tr>
                                <th>Địa chỉ</th>
                                <td>{{ $view_huongdanvien_diachi }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>{!! $view_huongdanvien_trangThai !!}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /*
    Lắng nghe event đã dispatch ở livewire class để khởi tạo flatpickr
    */
    window.addEventListener('the-form-ready', event => {
        // Đợi một chút để Livewire cập nhật DOM hoàn toàn
        setTimeout(initManageTheFlatpickr, 50);
    });

    /*
    Init flatpickr
    */
    function initManageTheFlatpickr() {
        flatpickr('#tungay', {
            dateFormat: 'd/m/Y', // Định dạng ngày Việt nam
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Gửi ngày đã chọn về Livewire component
                @this.set('tungay', dateStr);
            }
        })

        flatpickr('#denngay', {
            dateFormat: 'd/m/Y', // Định dạng ngày Việt nam
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Gửi ngày đã chọn về Livewire component
                @this.set('denngay', dateStr);
            }
        })
    }

    document.addEventListener('livewire:init', function() {
        /** Chức năng tạo mới hdvdl */
        $('#addHdvdlHdvModal').on('shown.bs.modal', function() {
            $('#add-select-user').select2({
                placeholder: 'Chọn ngôn ngữ',
                allowClear: true,
                dropdownParent: $('#dropdown-add-ngon-ngu') // Gắn dropdown vào modal
            }).on('change', function(e) {
                var data = $(this).val(); // Lấy giá trị đã chọn
                @this.set('ngonNguList', data); // Cập nhật thuộc tính Livewire
            });
        });

        /** Chức năng chỉnh sửa hdvdl */
        $('#editHdvdlHdvModal').on('shown.bs.modal', function() {
            $('#edit-select-user').select2({
                placeholder: 'Chọn ngôn ngữ',
                allowClear: true,
                dropdownParent: $('#dropdown-edit-ngon-ngu') // Gắn dropdown vào modal
            }).on('change', function(e) {
                var editData = $(this).val(); // Lấy giá trị đã chọn
                @this.set('ngonNguList', editData); // Cập nhật thuộc tính Livewire
            });
        });

        /** Reset multiselect(select2) và các ô input trong modal khi đóng modal */
        $('#editHdvdlHdvModal').on('hidden.bs.modal', function() {
            $('#add-users-select').val(null).trigger('change'); // Xóa giá trị Select2
            @this.resetFields(); // Reset giá trị Livewire
        });

        $('#addHdvdlHdvModal').on('hidden.bs.modal', function() {
            $('#add-users-select').val(null).trigger('change'); // Xóa giá trị Select2
            @this.resetFields(); // Reset giá trị Livewire
        });
        /** END Reset multiselect(select2) và các ô input trong modal khi đóng modal */

        $('#manageTheModal').on('hidden.bs.modal', function() {
            @this.resetTheFields(); // Reset giá trị Livewire
        });

        flatpickr('#ngaySinh', {
            dateFormat: 'd/m/Y', // Định dạng ngày Việt nam
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Gửi ngày đã chọn về Livewire component
                @this.set('ngaySinh', dateStr);
            }
        })

        flatpickr('#cmndNgayCap', {
            dateFormat: 'd/m/Y', // Định dạng ngày Việt nam
            allowInput: true,
            onChange: function(selectedDates, dateStr, instance) {
                // Gửi ngày đã chọn về Livewire component
                @this.set('cmndNgayCap', dateStr);
            }
        })


    });

    window.addEventListener('close-modal', event => {
        $('#addHdvdlHdvModal').modal('hide');
        $('#editHdvdlHdvModal').modal('hide');
        $('#deleteHdvdlHdvModal').modal('hide');
        $('#viewHdvdlHdvModal').modal('hide');
        $('#manageTheModal').modal('hide');
    });

    window.addEventListener('show-manage-the-huongdanvien-modal', event => {
        $('#manageTheModal').modal('show');
    })

    window.addEventListener('show-edit-huongdanvien-modal', event => {
        $('#editHdvdlHdvModal').modal('show');
    })

    window.addEventListener('show-delete-huongdanvien-modal', event => {
        $('#deleteHdvdlHdvModal').modal('show');
    });

    window.addEventListener('show-view-huongdanvien-modal', event => {
        $('#viewHdvdlHdvModal').modal('show');
    })

    // Thêm JavaScript cho chức năng checkAll
    document.addEventListener('livewire:init', function() {
        // Lắng nghe sự kiện khi selectedItems thay đổi
        Livewire.on('selectedItemsUpdated', (data) => {
            console.log('Selected items updated:', data);
        });

        // Lắng nghe sự kiện khi selectAll thay đổi
        Livewire.on('selectAllUpdated', (data) => {
            console.log('Select all updated:', data);
        });
    });
</script>
