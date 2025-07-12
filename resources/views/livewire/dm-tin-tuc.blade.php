<div>
    <div class="container-fluid pt-4 px-4">
        <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Quản lý tin tức</h4>
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
                                    Tin tức
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="text-center rounded p-4">
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-2 col-lg-2 col-xl-auto me-auto">
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#tintucModal">Thêm mới</button>
                    </div><!--end col-->

                    <div class="col-12 col-md-4 col-lg-4 col-xl-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input class="form-control" type="text" wire:model.live.debounce.300ms="search"
                                placeholder="Tìm kiếm theo tên..."
                                aria-label="Search">
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-2 col-xl-3">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-funnel"></i>
                            </span>
                            <select class="form-control" id="select-category" wire:model.live="chuyenMucSelect">
                                <option value="">Chuyên mục</option>
                                @foreach ($chuyenmucs as $chuyenmuc)
                                    <option value="{{ $chuyenmuc->id }}">{{ $chuyenmuc->ten }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!--end col-->
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

                <div class="list-group">
                    @foreach ($tintucs as $tintuc)
                        <div class="list-group-item py-3">
                            <div class="row g-3 align-items-start">
                                <!-- Ảnh đại diện -->
                                <div class="col-md-2 col-4">
                                    <img src="{{ asset($tintuc->hinhanh) }}" alt="..." class="img-fluid rounded"
                                        style="height: 70px; object-fit: cover;">
                                </div>

                                <!-- Nội dung -->
                                <div class="col-md-10 col-8">
                                    <!-- Tiêu đề và chuyên mục -->
                                    <div class="d-flex flex-column flex-md-row justify-content-between mb-1">
                                        <h5 class="text-primary mb-1 me-2">{{ $tintuc->ten }}</h5>
                                        <div class="text-muted">
                                            @foreach ($tintuc->chuyenmucs as $chuyenmuc)
                                                <span class="badge bg-info">{{ $chuyenmuc->ten }}</span>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="d-flex">
                                        <p class="mb-1 small"><strong>Mô tả:</strong>
                                            {{ str($tintuc->mota)->words(10) }}
                                    </div>
                                    <div class="d-flex">
                                        <span class="small"><strong>Ngày tạo:</strong>
                                            {{ \Carbon\Carbon::parse($tintuc->created_at)->format('d/m/Y') }}</span>
                                    </div>

                                    <!-- Từ khóa -->
                                    <div class="d-flex flex-wrap align-items-center mb-2 small">
                                        <strong class="me-1">Từ khóa:</strong>
                                        @if ($tintuc->tukhoa)
                                            @foreach (explode(',', $tintuc->tukhoa) as $tukhoa)
                                                <span class="badge bg-secondary me-1 mb-1">{{ $tukhoa }}</span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">Chưa có từ khóa</span>
                                        @endif
                                    </div>

                                    <!-- Trạng thái và nút thao tác -->
                                    <div class="d-flex justify-content-between flex-wrap mt-2">
                                        <div>{!! $tintuc->getTrangThai() !!}</div>
                                        <div class="mt-2 mt-md-0">
                                            <button class="btn btn-sm btn-outline-info"
                                                wire:click="view({{ $tintuc->id }})">Xem</button>
                                            <button class="btn btn-sm btn-outline-success"
                                                wire:click="edit({{ $tintuc->id }})">Sửa</button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="delete({{ $tintuc->id }})">Xoá</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <br>
                    {{ $tintucs->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal tạo mới -->
    <div wire:ignore.self class="modal fade" id="tintucModal" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">
                            {{ $tintucId ? 'Sửa tin tức' : 'Thêm mới tin tức' }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <x-label for="ten" field="ten" class="col-6" :required="true">Tên</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="ten" wire:model.defer="ten"
                                    placeholder="Nhập tên tin tức">
                                @error('ten')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="col-12" x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true; progress = 0"
                                x-on:livewire-upload-finish="progress = 100; setTimeout(() => { uploading = false; }, 1500);"
                                x-on:livewire-upload-cancel="uploading = false; progress = 0"
                                x-on:livewire-upload-error="uploading = false; progress = 0"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <x-label for="hinhanhUpload" field="hinhanh" class="col-6" :required="true">Hình
                                    ảnh</x-label>
                                <div x-show="uploading">
                                    <progress max="100" x-bind:value="progress" class="me-2"></progress>
                                    <span x-text="progress + '%'"></span>
                                </div>

                                <input wire:model="hinhanh" x-show="!uploading" class="form-control"
                                    id="imageUpload" placeholder="Tải ảnh lên" type="file">
                                @if ($hinhanh)
                                    <img width="100px" height="100px" src="{{ $hinhanh->temporaryUrl() }}">
                                @elseif($hinhanhGoc)
                                    <img class="img-fluid" width="100px" height="100px"
                                        src="{{ asset($hinhanhGoc) }}">
                                @endif
                                @error('hinhanh')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="mota" field="mota" class="col-6" :required="true">Mô tả</x-label>
                            <div class="col-12">
                                <textarea class="form-control" id="mota" wire:model.defer="mota" placeholder="Nhập mô tả tin tức"
                                    rows="3"></textarea>
                                @error('mota')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="noidung" field="noidung" class="col-6" :required="true">Nội
                                dung</x-label>
                            <div class="col-12" wire:ignore>
                                <textarea class="form-control" id="noidung" wire:model.defer="noidung" placeholder="Nhập nội dung tin tức"
                                    rows="3"></textarea>
                            </div>
                            @error('noidung')
                                <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <div class="col-12" x-data="{ uploading: false, progress: 0 }"
                                x-on:livewire-upload-start="uploading = true; progress = 0"
                                x-on:livewire-upload-finish="progress = 100; setTimeout(() => { uploading = false; }, 1500);"
                                x-on:livewire-upload-cancel="uploading = false; progress = 0"
                                x-on:livewire-upload-error="uploading = false; progress = 0"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <x-label for="filedinhkem" field="filedinhkem" class="col-6">Đính kèm file
                                    (PDF)</x-label>

                                <div x-show="uploading">
                                    <progress max="100" x-bind:value="progress" class="me-2"></progress>
                                    <span x-text="progress + '%'"></span>
                                </div>

                                <input wire:model="filedinhkem" x-show="!uploading" class="form-control" id="fileUpload"
                                    placeholder="Tải file PDF lên" type="file" accept=".pdf">

                                @if ($tintucId && isset($tintuc) && $tintuc->attachments && $tintuc->attachments->count())
                                    <div class="mt-2">
                                        <small class="text-muted">File hiện tại:</small>
                                        @foreach ($tintuc->attachments as $attachment)
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="{{ asset($attachment->url) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary mb-1">
                                                    <i class="fas fa-file-pdf me-1"></i>{{ $attachment->ten }}
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger mb-1"
                                                    wire:click="deleteAttachment({{ $tintuc->id }})">
                                                    <i class="fas fa-trash"></i> Xóa file
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="mt-2">
                                        <span class="text-muted">Không có file đính kèm</span>
                                    </div>
                                @endif

                                @error('filedinhkem')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-2">
                            <x-label for="add-select-chuyenmuc" field="chuyenMucList" class="col-6"
                                :required="true">Chuyên mục</x-label>
                            <div class="col-12" id="dropdown-add-chuyen-muc" wire:ignore>
                                <select id="add-select-chuyenmuc" wire:model="chuyenMucList"
                                    class="form-select select2" data-control="select2" data-close-on-select="false"
                                    placeholder="Chọn ngôn ngữ" data-allow-clear="true" multiple="multiple"
                                    style="width: 100%">
                                    @foreach ($chuyenmucs as $chuyenmuc)
                                        <option value="{{ $chuyenmuc->id }}">{{ $chuyenmuc->ten }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('chuyenMucList')
                                <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group mb-2">
                            <x-label for="tukhoa" field="tukhoa" class="col-6">Từ khóa</x-label>
                            <div class="col-12" wire:ignore>
                                <input type="text" class="form-control" wire:model="tukhoa" id="tags">
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
                            class="btn btn-primary">{{ $tintucId ? 'Cập nhật' : 'Thêm mới' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteTinTucModal" tabindex="-1"
        aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá tin tức</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá tin tức này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-primary" wire:click="deleteTinTuc()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết -->
    <div wire:ignore.self class="modal fade" id="viewTinTucModal" tabindex="-1" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết tin tức</h5>
                    <button type="button" class="btn-close" wire:click="closeViewModal()"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <td>{{ $tintucId }}</td>
                            </tr>
                            <tr>
                                <th>Tên tin tức</th>
                                <td>{{ $ten }}</td>
                            </tr>
                            <tr>
                                <th>Hình ảnh</th>
                                <td>{{ $hinhanhGoc }}</td>
                            </tr>
                            <tr>
                                <th>File đính kèm</th>
                                <td>
                                    @if ($tintucId && isset($tintuc) && $tintuc->attachments && $tintuc->attachments->count())
                                        @php $attachment = $tintuc->attachments->first(); @endphp
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ asset($attachment->url) }}" target="_blank"
                                                class="btn btn-sm btn-outline-primary mb-1">
                                                <i class="fas fa-file-pdf me-1"></i>{{ $attachment->ten }}
                                            </a>
                                            {{-- <button type="button" class="btn btn-sm btn-outline-danger mb-1"
                                                wire:click="deleteAttachment({{ $tintuc->id }})">
                                                <i class="fas fa-trash"></i> Xóa file
                                            </button> --}}
                                        </div>
                                    @else
                                        <span class="text-muted">Không có file đính kèm</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Mô tả</th>
                                <td>{{ str($mota)->words(10) }}</td>
                            </tr>
                            <tr>
                                <th>Nội dung</th>
                                <td>{!! str($noidung)->words(50) !!}</td>
                            </tr>
                            {{-- <tr>
                                <th>Ngày tạo</th>
                                <td>{{ \Carbon\Carbon::parse($tintuc->created_at)->format('d/m/Y') }}</td>
                            </tr> --}}
                            <tr>
                                <th>Chuyên mục</th>
                                <td>
                                    @if ($chuyenMucList && count($chuyenMucList) > 0)
                                        @foreach ($chuyenMucList as $chuyenmucId)
                                            @php
                                                $chuyenmuc = \App\Models\ChuyenMuc::find($chuyenmucId);
                                            @endphp
                                            @if ($chuyenmuc)
                                                <span class="badge bg-info">{{ $chuyenmuc->ten }}</span>
                                            @endif
                                        @endforeach
                                    @else
                                        <span class="text-muted">Chưa có chuyên mục</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Từ khóa</th>
                                <td>
                                    @if ($tukhoa1)
                                        @foreach (explode(',', $tukhoa1) as $tk)
                                            <span class="badge bg-secondary">{{ $tk }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">Chưa có từ khóa</span>
                                    @endif
                                </td>
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
    document.addEventListener('livewire:init', function() {
        // Nội dung
        $('#noidung').summernote({
            placeholder: 'Nhập nội dung',
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onChange: function(contents, $editable) {
                    @this.set('noidung', contents);
                }
            }
        });
        Livewire.on('reset-noidung', (event) => {
            $('#noidung').summernote('reset');
        });
        Livewire.on('set-noidung', (data) => {
            $('#noidung').summernote('code', data.noidung || '');
        });

        // Chuyên mục
        $('#add-select-chuyenmuc').select2({
            placeholder: 'Chọn chuyên mục',
            allowClear: true,
            dropdownParent: $('#dropdown-add-chuyen-muc'), // Gắn dropdown vào modal
            width: '100%'
        }).on('change', function(e) {
            var data = $(this).val(); // Lấy giá trị đã chọn
            @this.set('chuyenMucList', data); // Cập nhật thuộc tính Livewire
        });
        Livewire.on('reset-chuyenmuc', () => {
            $('#add-select-chuyenmuc').val(null).trigger('change');
        });
        Livewire.on('set-chuyenmuc', (data) => {
            $('#add-select-chuyenmuc').val(data.chuyenmuc).trigger('change');
        });

        // Từ khóa
        $("#tags").tagsinput({
            // limit 5 tag
            maxTags: 5,
            // give tags same
            allowDuplicates: false,
            cancelConfirmKeysOnEmpty: false,
        });
        $('#tags').on('itemAdded', function() {
            @this.set('tukhoa', $('#tags').val());
        });
        Livewire.on('reset-tukhoa', () => {
            $('#tags').tagsinput('removeAll');
        });
        Livewire.on('set-tukhoa', (data) => {
            if (data.tukhoa) {
                data.tukhoa.split(',').forEach(tag => {
                    console.log('Setting tukhoa:', tag);
                    $('#tags').tagsinput('add', tag);
                });
            }
        });

        $('#tintucModal').on('hidden.bs.modal', function() {
            $('#noidung').summernote('code', ''); // Xóa giá trị CKEditor
            $('#add-select-chuyenmuc').val(null).trigger('change'); // Xóa giá trị Select2
            $('#tags').tagsinput('removeAll'); // Xóa giá trị bootstrap-tagsinput
            @this.resetFields(); // Reset giá trị Livewire
        });
    });
    window.addEventListener('close-modal', event => {
        $('#tintucModal').modal('hide');
        $('#deleteTinTucModal').modal('hide');
        $('#viewTinTucModal').modal('hide');
    });

    window.addEventListener('show-edit-modal', event => {
        $('#tintucModal').modal('show');
    })

    window.addEventListener('show-delete-modal', event => {
        $('#deleteTinTucModal').modal('show');
    });

    window.addEventListener('show-view-modal', event => {
        $('#viewTinTucModal').modal('show');
    })
</script>
