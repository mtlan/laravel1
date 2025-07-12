<div>
    <div class="container-fluid pt-4 px-4">
        <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Quản lý video</h4>
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
                                    Video
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#videoModal">Thêm mới</button>
            </div>

            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-black">Video</h6>
                    <div class="form-outline">
                        <input class="form-control me-1 flex-grow-1" type="text"
                            wire:model.live.debounce.300ms="search" placeholder="Tìm kiếm theo video ...">
                    </div>
                    {{-- Nút Search có thể giữ lại hoặc bỏ đi nếu tìm kiếm đã là "live" --}}
                    {{-- <button class="btn btn-outline-success text-nowrap" type="button">Tìm kiếm</button> --}}
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
                    @foreach ($videos as $video)
                        <div class="list-group-item py-3">
                            <div class="row g-3 align-items-start">
                                <!-- Video -->
                                <div class="col-md-2 col-4">
                                    @if(Illuminate\Support\Str::contains($video->url, 'videos/'))
                                        <video width="100%" height="100" src="{{ asset($video->url) }}" controls>
                                    @else
                                        <div class="ratio ratio-16x9" style="max-height: 100px;">
                                            {!!$video->url!!}
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-10 col-8">
                                    <div class="d-flex flex-column flex-md-row justify-content-between mb-1">
                                        <h5 class="text-primary mb-1 me-2">{{ $video->ten }}</h5>
                                    </div>

                                    <div class="d-flex">
                                        <span class="small"><strong>Ngày tạo:</strong>
                                            {{ \Carbon\Carbon::parse($video->created_at)->format('d/m/Y') }}</span>
                                    </div>

                                    <!-- Trạng thái và nút thao tác -->
                                    <div class="d-flex justify-content-between flex-wrap mt-2">
                                        <div>{!! $video->getTrangThai() !!}</div>
                                        <div class="mt-2 mt-md-0">
                                            <button class="btn btn-sm btn-outline-info"
                                                wire:click="view({{ $video->id }})">Chi tiết</button>
                                            <button class="btn btn-sm btn-outline-success"
                                                wire:click="edit({{ $video->id }})">Sửa</button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="delete({{ $video->id }})">Xoá</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <br>
                    {{ $videos->appends(request()->input())->links() }}
                </div>

            </div>
        </div>
    </div>

    <!-- Modal tạo mới -->
    <div wire:ignore.self class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">
                            {{ $videoId ? 'Chỉnh sửa' : 'Thêm mới' }} video</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <x-label for="ten" field="ten" class="col-6" :required="true">Tên</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="ten" wire:model.defer="ten"
                                    placeholder="Nhập tên video">
                                @error('ten')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Thêm Alpine nếu chưa có -->
                        <style>
                            [x-cloak] { display: none !important; }
                        </style>
                        {{-- { loai: '', init() { this.loai = @entangle('loai_video') } } --}}
                        <div x-data="{ loai: '' }" x-init="loai = @js($loai_video)">
                            <div class="form-group mb-2">
                                <x-label for="loai_video" field="loai_video" class="col-6" :required="true">Chọn hình thức video</x-label>
                                <select class="form-select" x-model="loai" wire:model="loai_video">
                                    <option value="">Chọn</option>
                                    <option value="1">Mã nhúng YouTube</option>
                                    <option value="2">Upload file</option>
                                </select>
                                @error('loai_video')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Mã nhúng YouTube -->
                            <div class="form-group mb-2" x-show="String(loai) === '1'" x-transition x-cloak>
                                <x-label for="embed_code" field="embed_code" class="col-6" :required="true">Mã nhúng YouTube</x-label>
                                <textarea class="form-control" wire:model.defer="embed_code" placeholder="Nhập mã nhúng" rows="1" id="embed_code"></textarea>
                                @error('embed_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Upload file -->
                            <div class="form-group mb-2" x-show="String(loai) === '2'" x-transition x-cloak>
                                <x-label for="video_file" field="video_file" class="col-6" :required="true">Upload video MP4</x-label>
                                <input type="file" class="form-control" wire:model="video_file"
                                    accept="video/mp4">
                                @error('video_file')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                @if ($video_file)
                                    <small class="text-muted">Đã chọn: {{ is_string($video_file) ? $video_file : $video_file->getClientOriginalName() }}</small>
                                @endif
                            </div>
                            {{-- <div x-text="loai" class="text-danger fw-bold mb-2"></div> --}}
                        </div>

                        {{-- <div x-data="{ count: 0 }" x-init="console.log('mounted')">
                            <span x-text="count"></span>
                        </div> --}}

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
                            class="btn btn-primary">{{ $videoId ? 'Cập nhật' : 'Thêm mới' }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteVideoModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá video</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá video này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-primary" wire:click="deleteVideo()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết -->
    <div wire:ignore.self class="modal fade" id="viewVideoModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết video</h5>
                    <button type="button" class="btn-close" wire:click="closeViewModal()"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <td>{{ $videoId }}</td>
                            </tr>
                            <tr>
                                <th>Tên video</th>
                                <td>{{ $ten }}</td>
                            </tr>
                            <tr>
                                <th>Loại video</th>
                                <td>{{ $original_name }}</td>
                            </tr>
                            <tr>
                                <th>Url</th>
                                <td>{{ $url }}</td>
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
        $('#videoModal').on('hidden.bs.modal', function() {
            @this.resetFields();
        });
    });
    window.addEventListener('close-modal', event => {
        $('#videoModal').modal('hide');
        $('#deleteVideoModal').modal('hide');
        $('#viewVideoModal').modal('hide');
    });

    window.addEventListener('show-edit-modal', event => {
        $('#videoModal').modal('show');

        setTimeout(() => {
            autoResizeTextarea('embed_code');
        }, 300);
    })

    window.addEventListener('show-delete-modal', event => {
        $('#deleteVideoModal').modal('show');
    });

    window.addEventListener('show-view-modal', event => {
        $('#viewVideoModal').modal('show');
    })

    function autoResizeTextarea(id) {
        var $textarea = $('#' + id);
        if ($textarea.length) {
            // Resize chiều cao ban đầu nếu đã có nội dung
            $textarea.css('height', 'auto');
            $textarea.css('height', $textarea[0].scrollHeight + 'px');

            // Resize khi người dùng gõ vào
            $textarea.on('input', function() {
                $(this).css('height', 'auto');
                $(this).css('height', this.scrollHeight + 'px');
            });
        }
    }

    $(document).ready(function() {
        autoResizeTextarea('embed_code'); // Gọi resize textarea chứa giá trị "ABC"
    });

</script>
