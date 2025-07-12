<div>
    <div class="container-fluid pt-4 px-4">
        {{-- <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Danh sách hướng dẫn viên du lịch</h4>
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
                                    Hướng dẫn viên
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Danh sách hướng dẫn viên du lịch</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item">Trang chủ</li>
                            <li class="breadcrumb-item active">Hướng dẫn viên</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card" style="min-height: 1000px;">
                    <div class="card-header row align-items-center" style="background-color: #FFF">
                        <div class="col">
                            <h5 class="card-title mb-0" style="white-space: nowrap;">Hướng dẫn viên</h5>
                        </div>
                        <div class="col-md-auto col-12 ms-md-auto mt-2 mt-md-0">
                            <div class="d-flex align-items-center search-box" style="min-width: 400px; max-width: 600px;">
                                <input class="form-control serch me-1 w-100" type="text"
                                    wire:model.live.debounce.500ms="searchParam"
                                    placeholder="Tìm kiếm theo số thẻ, CCCD/CMND, email, sđt, ..."
                                    aria-label="Search"
                                    style="max-width: 400px;">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table text-start align-middle table-striped table-bordered table-hover">
                                <thead>
                                    <tr class="text-white">
                                        <th scope="col" width="10%" class="text-center">Ảnh thẻ</th>
                                        <th scope="col" width="15%" class="text-center">Tên</th>
                                        <th scope="col" width="10%" class="text-center">Số thẻ</th>
                                        <th scope="col" width="20%" class="text-center">CMND/CCCD</th>
                                        <th scope="col" width="20%" class="text-center">Số điện thoại</th>
                                        <th scope="col" width="10%" class="text-center">Trạng thái</th>
                                        <th scope="col" width="15%" class="text-center">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($huongDanViens as $huongDanVien)
                                        <tr>
                                            <td class="text-center">
                                                @php
                                                    $image = App\Models\CmsAttachment::where(
                                                        'huongdanvien_id',
                                                        $huongDanVien->id,
                                                    )
                                                        ->where('daxoa', 0)
                                                        ->where('type', 1)
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
                                            <td class="text-center">{{ $huongDanVien->sdt1 }}</td>
                                            <td class="text-center">{!! $huongDanVien->getTrangThai() !!}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-primary"
                                                    wire:click="handle({{ $huongDanVien->id }}, 'chinh_sua')">Sửa</button>
                                                <button class="btn btn-sm btn-info"
                                                    wire:click="handle({{ $huongDanVien->id }}, 'gia_han')">Gia
                                                    hạn</button>
                                                {{-- <button class="btn btn-sm btn-outline-danger"
                                                    wire:click="delete({{ $huongDanVien->id }})">Xoá</button> --}}
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                                {{-- <tfoot>
                                    <tr>
                                        <td colspan="12">
                                            <div style="float: right;">
                                                {{ $huongDanViens->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }}
                                            </div>
                                        </td>
                                    </tr>
                                </tfoot> --}}
                            </table>
                        </div>
                    </div>
                    <div class="card-footer" style="background-color: #FFF">
                        <div style="float: right;">
                            {{ $huongDanViens->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }}
                        </div>
                    </div>
                </div>
                {{-- <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-black">Hướng dẫn viên</h6>
                    <div class="d-flex flex-grow-1 search-box ms-3" style="max-width: 500px; min-width: 300px;">
                        <input class="form-control serch me-1 flex-grow-1" type="text"
                            wire:model.live.debounce.300ms="searchParam"
                            placeholder="Tìm kiếm theo tên, số thẻ, số điện thoại, CCCD/CMND, email ..."
                            aria-label="Search">
                        <i class="ri-search-line search-icon"></i>
                    </div>
                </div> --}}



            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="handleHuongDanVienModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">
                        @if ($type == 'chinh_sua')
                            Chỉnh sửa thông tin hướng dẫn viên
                        @else
                            Gia hạn thẻ hướng dẫn viên
                        @endif
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent="update" method="POST" class="position-relative ">
                        @csrf
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Họ và tên đệm</label>
                                    <input type="text" wire:model="hoTenLot" class="form-control"
                                        placeholder="Nhập họ và tên đệm" {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                    @error('ho_tenlot')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Tên</label>
                                    <input type="text" wire:model="ten" class="form-control"
                                        placeholder="Nhập tên" {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                    @error('ten')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Ngày sinh</label>
                                    <input id="ngaysinh" wire:model="ngaySinh" type="text" class="form-control"
                                        placeholder="Nhập ngày sinh" {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label for="gioiTinh" class="form-label text-black fs-7 mb-3">Giới tính</label>
                                    @if ($type == 'chinh_sua')
                                        <select id="gioiTinh" wire:model="gioiTinh" class="form-select"
                                            {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                            <option value="">Chọn giới tính</option>
                                            <option value="1">Nam</option>
                                            <option value="2">Nữ</option>
                                        </select>
                                        @error('gioitinh')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    @else
                                        @if ($gioiTinh == 1)
                                            <div class="form-control">Nam</div>
                                        @elseif($gioiTinh == 2)
                                            <div class="form-control">Nữ</div>
                                        @else
                                            <div class="form-control">Chưa cập nhật</div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Số điện thoại</label>
                                    <input type="text" wire:model="sdt1" class="form-control"
                                        placeholder="Nhập số điện thoại" {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                    @error('sdt1')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Email</label>
                                    <input type="email" wire:model="email1" class="form-control"
                                        placeholder="Nhập email" {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                    @error('email1')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Số CCCD/CMND</label>
                                    <input type="text" wire:model="cmndSo" class="form-control"
                                        placeholder="Nhập số CCCD/CMND" {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                    @error('cmnd_so')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Địa chỉ</label>
                                    <input type="text" wire:model="diaChi" class="form-control"
                                        placeholder="Nhập địa chỉ" {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                    @error('diachi')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Ngày cấp CCCD/CMND</label>
                                    <input id="cmnd_ngaycap" type="text" wire:model="cmndNgayCap"
                                        class="form-control" placeholder="Nhập ngày cấp CCCD/CMND"
                                        {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Nơi cấp CCCD/CMND</label>
                                    <input type="text" wire:model="cmndNoiCap" class="form-control"
                                        placeholder="Nhập nơi cấp CCCD/CMND"
                                        {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Số thẻ</label>
                                    <input type="text" wire:model="soThe" class="form-control"
                                        placeholder="Nhập số thẻ" {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                    @error('sothe')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Thời hạn thẻ</label>
                                    <div class="form-control">{{ $thoiHanThe }}</div>
                                    {{-- @if ($dm_thoihanthes)
                                        
                                    @else
                                        <p>Không có dữ liệu thời hạn thẻ.</p>
                                    @endif --}}
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Nơi cấp thẻ</label>
                                    @if ($dm_noicapthes)
                                        @if ($type == 'chinh_sua')
                                            <select wire:model="noiCapThe_id" class="form-select"
                                                {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                                <option value="">-- Chọn nơi cấp thẻ --</option>
                                                @foreach ($dm_noicapthes as $noicapthe)
                                                    <option value="{{ $noicapthe->id }}">{{ $noicapthe->ten }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('noicapthe_id')
                                                <span class="text-danger"
                                                    style="font-size: 15px">{{ $message }}</span>
                                            @enderror
                                        @else
                                            <div class="form-control">{{ $noiCapThe }}</div>
                                        @endif
                                    @else
                                        <p>Không có dữ liệu nơi cấp thẻ.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Ngôn ngữ chính</label>
                                    @if ($dm_ngonngus)
                                        @if ($type == 'chinh_sua')
                                            <select wire:model="tiengChinh_id" class="form-select"
                                                {{ $type != 'chinh_sua' ? 'readonly' : '' }}>
                                                <option value="">-- Chọn ngôn ngữ chính --</option>
                                                @foreach ($dm_ngonngus as $ngonngu)
                                                    <option value="{{ $ngonngu->id }}">{{ $ngonngu->ten }}</option>
                                                @endforeach
                                            </select>
                                            @error('huongdan_tiengchinh')
                                                <span class="text-danger"
                                                    style="font-size: 15px">{{ $message }}</span>
                                            @enderror
                                        @else
                                            <div class="form-control">{{ $tiengChinh }}</div>
                                        @endif
                                    @else
                                        <p>Không có dữ liệu ngôn ngữ.</p>
                                    @endif
                                </div>
                            </div>

                            @if ($type == 'gia_han')
                                <hr class="my-3">
                                <h3 class="text-black fs-5 mb-3">Thông tin thẻ gia hạn</h3>
                                <div class="row">
                                    <div class="col-12 form-group">
                                        <x-label for="giahan_thoihanthe_id" field="giahan_thoihanthe_id"
                                            class="col-6" :required="$this->isRequired('giahan_thoihanthe_id')">Thời hạn thẻ</x-label>
                                        <select id="giahan_thoihanthe_id" wire:model.live="giahan_thoihanthe_id"
                                            class="form-select">
                                            <option value="">-- Chọn thời hạn thẻ--</option>
                                            @foreach ($dm_thoihanthes as $thoihanthe)
                                                <option value="{{ $thoihanthe->id }}">{{ $thoihanthe->ten }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('giahan_thoihanthe_id')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <x-label for="giahan_tungay" field="giahan_tungay" class="col-6"
                                                :required="$this->isRequired('giahan_tungay')">Từ ngày</x-label>
                                            <input type="text" class="form-control" id="giahan_tungay"
                                                wire:model="giahan_tungay">
                                        </div>
                                    </div>
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <div class="form-group">
                                            <x-label for="giahan_denngay" field="giahan_denngay" class="col-6"
                                                :required="$this->isRequired('giahan_denngay')">Đến ngày</x-label>
                                            <input type="text" class="form-control" id="giahan_denngay"
                                                wire:model="giahan_denngay">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mb-2" x-data="{ uploading: false, progress: 0 }"
                                        x-on:livewire-upload-start="uploading = true; progress = 0"
                                        x-on:livewire-upload-finish="progress = 100; setTimeout(() => { uploading = false; }, 1500);"
                                        x-on:livewire-upload-cancel="uploading = false; progress = 0"
                                        x-on:livewire-upload-error="uploading = false; progress = 0"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <x-label for="giahan_invoice" field="giahan_invoice" class="col-6"
                                            :required="$this->isRequired('giahan_invoice')">Hình ảnh biên lai</x-label>
                                        <div x-show="uploading">
                                            <progress max="100" x-bind:value="progress"
                                                class="me-2"></progress>
                                            <span x-text="progress + '%'"></span>
                                        </div>

                                        <input wire:model.defer="giahan_invoice" x-show="!uploading"
                                            class="form-control" id="giahan_invoice" placeholder="Tải ảnh lên"
                                            type="file">
                                        @error('giahan_invoice')
                                            <span class="text-danger"
                                                style="font-size: 11.5px">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            @endif

                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-warning btn-hover-secondery text-capitalize mt-2 w-auto contact-btn">{{ $type == 'chinh_sua' ? 'Chỉnh sửa' : 'Gia hạn' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Function helper để khởi tạo flatpickr
    function initializeFlatpickr() {
        // Khởi tạo flatpickr cho ngày sinh
        if (document.getElementById('ngaysinh')) {
            flatpickr('#ngaysinh', {
                dateFormat: 'd/m/Y',
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    @this.set('ngaySinh', dateStr);
                }
            });
        }

        // Khởi tạo flatpickr cho ngày cấp CMND
        if (document.getElementById('cmnd_ngaycap')) {
            flatpickr('#cmnd_ngaycap', {
                dateFormat: 'd/m/Y',
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    @this.set('cmndNgayCap', dateStr);
                }
            });
        }

        // Khởi tạo flatpickr cho từ ngày gia hạn
        if (document.getElementById('giahan_tungay')) {
            flatpickr('#giahan_tungay', {
                dateFormat: 'd/m/Y',
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    @this.set('giahan_tungay', dateStr);
                }
            });
        }

        // Khởi tạo flatpickr cho đến ngày gia hạn
        if (document.getElementById('giahan_denngay')) {
            flatpickr('#giahan_denngay', {
                dateFormat: 'd/m/Y',
                allowInput: true,
                onChange: function(selectedDates, dateStr, instance) {
                    @this.set('giahan_denngay', dateStr);
                }
            });
        }
    }

    document.addEventListener('livewire:init', function() {
        /** Khởi tạo flatpickr cho modal handle hướng dẫn viên */
        $('#handleHuongDanVienModal').on('shown.bs.modal', function() {
            setTimeout(() => {
                initializeFlatpickr();
            }, 100);
        });


    });

    window.addEventListener('close-modal', event => {
        $('#handleHuongDanVienModal').modal('hide');

        // $('#addHdvdlHdvModal').modal('hide');
        // $('#deleteHdvdlHdvModal').modal('hide');
        // $('#viewHdvdlHdvModal').modal('hide');
        // $('#manageTheModal').modal('hide');
    });

    window.addEventListener('show-handle-huongdanvien-modal', event => {
        $('#handleHuongDanVienModal').modal('show');

        // Khởi tạo flatpickr cho các input date khi modal hiển thị
        setTimeout(() => {
            initializeFlatpickr();
        }, 100); // Delay 100ms để đảm bảo DOM đã được render
    })

    // Khởi tạo lại flatpickr khi Livewire component được cập nhật
    window.addEventListener('livewire:updated', event => {
        // Chỉ khởi tạo lại nếu modal đang hiển thị
        if ($('#handleHuongDanVienModal').hasClass('show')) {
            setTimeout(() => {
                initializeFlatpickr();
            }, 50);
        }
    });

    // window.addEventListener('show-edit-huongdanvien-modal', event => {
    //     $('#editHdvdlHdvModal').modal('show');
    // })

    // window.addEventListener('show-delete-huongdanvien-modal', event => {
    //     $('#deleteHdvdlHdvModal').modal('show');
    // });

    // window.addEventListener('show-view-huongdanvien-modal', event => {
    //     $('#viewHdvdlHdvModal').modal('show');
    // })
</script>
