<div>
    <div class="container-fluid pt-4 px-4">
        <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Quản lý thẻ hướng dẫn viên</h4>
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
                                    Thẻ
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="container-fluid px-4">
                <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#addHdvdlTheModal">Thêm mới</button>
            </div>

            <div class="text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-black">Thẻ</h6>
                    <div class="d-flex flex-grow-1 ms-3" style="max-width: 500px; min-width: 300px;">
                        <input class="form-control me-1 flex-grow-1" type="text"
                            wire:model.live.debounce.300ms="searchParam"
                            placeholder="Tìm kiếm theo hướng dẫn viên, số thẻ, ngôn ngữ chính, thời hạn thẻ ..."
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
                                <th scope="col" width="10%" class="text-center">Hướng dẫn viên</th>
                                <th scope="col" width="15%" class="text-center">Ngôn ngữ chính</th>
                                <th scope="col" width="10%" class="text-center">Số thẻ</th>
                                <th scope="col" width="10%" class="text-center">Nơi cấp thẻ</th>
                                <th scope="col" width="15%" class="text-center">Thời hạn thẻ</th>
                                <th scope="col" width="10%" class="text-center">Từ ngày</th>
                                <th scope="col" width="10%" class="text-center">Đến ngày</th>
                                <th scope="col" width="10%" class="text-center">Trạng thái</th>
                                <th scope="col" width="15%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($hdvdl_thes as $hdvdl_the)
                                <tr>
                                    <td class="text-center">{{ $hdvdl_the->huongDanVien?->getHoVaTen() }}</td>
                                    <td class="text-center">{{ $hdvdl_the->tiengchinh?->ten }}</td>
                                    <td class="text-center">
                                        <a href="#" wire:click.prevent="view({{ $hdvdl_the->id }})"
                                            style="color: rgb(48, 100, 177); cursor: pointer; text-decoration: underline;">
                                            {{ $hdvdl_the->sothe }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $hdvdl_the->noicapthe?->ten }}</td>
                                    <td class="text-center">{{ $hdvdl_the->thoihanthe?->ten }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($hdvdl_the->tungay)->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($hdvdl_the->denngay)->format('d/m/Y') }}</td>
                                    <td class="text-center">{!! $hdvdl_the->getTrangThai() !!}</td>
                                    <td class="text-center">
                                        {{-- {{ route('the.huong.dan.vien.list', ['hdvId' => $huongDanVien->id]) }} --}}
                                        {{-- <a class="btn btn-sm btn-primary"
                                            href=" {{ route('portal.the.huong.dan.vien.list', ['hdvId' => $huongDanVien->id]) }}">Quản
                                            lý thẻ</a> --}}
                                        <button class="btn btn-sm btn-outline-success"
                                            wire:click="edit({{ $hdvdl_the->id }})">Sửa</button>
                                        <button class="btn btn-sm btn-outline-danger"
                                            wire:click="delete({{ $hdvdl_the->id }})">Xoá</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div style="float: right;">
                                        {{ $hdvdl_thes->appends(request()->input())->links() }}
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
    <div wire:ignore.self class="modal fade" id="addHdvdlTheModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form wire:submit.prevent="store">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Thêm mới thẻ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            <x-label for="hdvdl_huongdanvien_id" field="hdvdl_huongdanvien_id" class="col-6"
                                :required="$this->isRequired('hdvdl_huongdanvien_id')">Hướng dẫn viên</x-label>
                            <div class="col-12">
                                <select id="hdvdl_huongdanvien_id" wire:model="hdvdl_huongdanvien_id"
                                    class="form-select">
                                    <option value="">-- Chọn hướng dẫn viên --</option>
                                    @foreach ($hdvdl_huongdanviens as $hdv)
                                        <option value="{{ $hdv->id }}">{{ $hdv->getHoVaTen() }}</option>
                                    @endforeach
                                </select>
                                @error('hdvdl_huongdanvien_id')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="hdvdl_ngonnguchinh_id" field="hdvdl_ngonnguchinh_id" class="col-6"
                                :required="$this->isRequired('hdvdl_ngonnguchinh_id')">Ngôn ngữ chính</x-label>
                            <div class="col-12">
                                <select id="hdvdl_ngonnguchinh_id" wire:model="hdvdl_ngonnguchinh_id"
                                    class="form-select">
                                    <option value="">-- Chọn ngôn ngữ chính --</option>
                                    @foreach ($hdvdl_ngonngus as $ngonngu)
                                        <option value="{{ $ngonngu->id }}">{{ $ngonngu->ten }}</option>
                                    @endforeach
                                </select>
                                @error('hdvdl_ngonnguchinh_id')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="sothe" field="sothe" class="col-6" :required="$this->isRequired('sothe')">Số
                                thẻ</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="sothe" wire:model.defer="sothe"
                                    placeholder="Nhập số thẻ">
                                @error('sothe')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="hdvdl_noicapthe_id" field="hdvdl_noicapthe_id" class="col-6"
                                :required="$this->isRequired('hdvdl_noicapthe_id')">Nơi cấp thẻ</x-label>
                            <div class="col-12">
                                <select id="hdvdl_noicapthe_id" wire:model="hdvdl_noicapthe_id" class="form-select">
                                    <option value="">-- Chọn nơi cấp thẻ--</option>
                                    @foreach ($hdvdl_noicapthes as $noicapthe)
                                        <option value="{{ $noicapthe->id }}">{{ $noicapthe->ten }}</option>
                                    @endforeach
                                </select>
                                @error('hdvdl_noicapthe_id')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="hdvdl_thoihanthe_id" field="hdvdl_thoihanthe_id" class="col-6"
                                :required="$this->isRequired('hdvdl_thoihanthe_id')">Thời hạn thẻ</x-label>
                            <div class="col-12">
                                <select id="hdvdl_thoihanthe_id" wire:model.live="hdvdl_thoihanthe_id"
                                    class="form-select">
                                    <option value="">-- Chọn thời hạn thẻ--</option>
                                    @foreach ($hdvdl_thoihanthes as $thoihanthe)
                                        <option value="{{ $thoihanthe->id }}">{{ $thoihanthe->ten }}</option>
                                    @endforeach
                                </select>
                                @error('hdvdl_thoihanthe_id')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @if ($hdvdl_thoihanthe_id)
                            <div class="form-group mb-2">
                                <x-label for="tungay" field="tungay" class="col-6" :required="$this->isRequired('tungay')">Từ
                                    ngày</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="tungay" wire:model="tungay"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <x-label for="denngay" field="denngay" class="col-6" :required="$this->isRequired('denngay')">Đến
                                    ngày</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="denngay" wire:model="denngay"
                                        readonly>
                                </div>
                            </div>
                        @endif
                        <div class="form-group mb-2" wire:ignore>
                            <x-label for="trangThai" field="trangThai" class="col-6" :required="$this->isRequired('trangThai')">Trạng
                                thái</x-label>
                            <div class="col-12">
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
    <div wire:ignore.self class="modal fade" id="editHdvdlTheModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form wire:submit.prevent="update" class="mb-2">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title text-black" id="exampleModalLabel">Chỉnh sửa thẻ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="form-group mb-2">
                            <x-label for="hdvdl_huongdanvien_id" field="hdvdl_huongdanvien_id" class="col-6"
                                :required="$this->isRequired('hdvdl_huongdanvien_id')">Hướng dẫn viên</x-label>
                            <div class="col-12">
                                <select id="hdvdl_huongdanvien_id" wire:model="hdvdl_huongdanvien_id"
                                    class="form-select">
                                    <option value="">-- Chọn hướng dẫn viên --</option>
                                    @foreach ($hdvdl_huongdanviens as $hdv)
                                        <option value="{{ $hdv->id }}">{{ $hdv->getHoVaTen() }}</option>
                                    @endforeach
                                </select>
                                @error('hdvdl_huongdanvien_id')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="hdvdl_ngonnguchinh_id" field="hdvdl_ngonnguchinh_id" class="col-6"
                                :required="$this->isRequired('hdvdl_ngonnguchinh_id')">Ngôn ngữ chính</x-label>
                            <div class="col-12">
                                <select id="hdvdl_ngonnguchinh_id" wire:model="hdvdl_ngonnguchinh_id"
                                    class="form-select">
                                    <option value="">-- Chọn ngôn ngữ chính --</option>
                                    @foreach ($hdvdl_ngonngus as $ngonngu)
                                        <option value="{{ $ngonngu->id }}">{{ $ngonngu->ten }}</option>
                                    @endforeach
                                </select>
                                @error('hdvdl_ngonnguchinh_id')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="sothe" field="sothe" class="col-6" :required="$this->isRequired('sothe')">Số
                                thẻ</x-label>
                            <div class="col-12">
                                <input type="text" class="form-control" id="sothe" wire:model.defer="sothe"
                                    placeholder="Nhập số thẻ">
                                @error('sothe')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="hdvdl_noicapthe_id" field="hdvdl_noicapthe_id" class="col-6"
                                :required="$this->isRequired('hdvdl_noicapthe_id')">Nơi cấp thẻ</x-label>
                            <div class="col-12">
                                <select id="hdvdl_noicapthe_id" wire:model="hdvdl_noicapthe_id" class="form-select">
                                    <option value="">-- Chọn nơi cấp thẻ--</option>
                                    @foreach ($hdvdl_noicapthes as $noicapthe)
                                        <option value="{{ $noicapthe->id }}">{{ $noicapthe->ten }}</option>
                                    @endforeach
                                </select>
                                @error('hdvdl_noicapthe_id')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <x-label for="hdvdl_thoihanthe_id" field="hdvdl_thoihanthe_id" class="col-6"
                                :required="$this->isRequired('hdvdl_thoihanthe_id')">Thời hạn thẻ</x-label>
                            <div class="col-12">
                                <select id="hdvdl_thoihanthe_id" wire:model.live="hdvdl_thoihanthe_id"
                                    class="form-select">
                                    <option value="">-- Chọn thời hạn thẻ--</option>
                                    @foreach ($hdvdl_thoihanthes as $thoihanthe)
                                        <option value="{{ $thoihanthe->id }}">{{ $thoihanthe->ten }}</option>
                                    @endforeach
                                </select>
                                @error('hdvdl_thoihanthe_id')
                                    <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        @if ($hdvdl_thoihanthe_id)
                            <div class="form-group mb-2">
                                <x-label for="tungay" field="tungay" class="col-6" :required="$this->isRequired('tungay')">Từ
                                    ngày</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="tungay" wire:model="tungay"
                                        readonly>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <x-label for="denngay" field="denngay" class="col-6" :required="$this->isRequired('denngay')">Đến
                                    ngày</x-label>
                                <div class="col-12">
                                    <input type="text" class="form-control" id="denngay" wire:model="denngay"
                                        readonly>
                                </div>
                            </div>
                        @endif
                        <div class="form-group mb-2" wire:ignore>
                            <x-label for="trangThai" field="trangThai" class="col-6" :required="$this->isRequired('trangThai')">Trạng
                                thái</x-label>
                            <div class="col-12">
                                <select id="trangThai" wire:model="trangthai" class="form-select">
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
                        <button type="submit" class="btn btn-info">Chỉnh sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal xoá -->
    <div wire:ignore.self class="modal fade" id="deleteHdvdlTheModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Xoá thẻ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-4 pb-4">
                    <h5 class="text-black">Bạn chắc chắn muốn xoá thẻ này??</h5>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-sm btn-danger" data-bs-dismiss="modal" aria-label="Close">Huỷ bỏ</button>
                    <button class="btn btn-sm btn-primary" wire:click="deleteThe()">Xác nhận</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chi tiết -->
    <div wire:ignore.self class="modal fade" id="viewHdvdlTheModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Chi tiết thẻ</h5>
                    <button type="button" class="btn-close" wire:click="closeViewModal()"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th>Id</th>
                                <td>{{ $view_the_id }}</td>
                            </tr>
                            <tr>
                                <th>Hướng dẫn viên</th>
                                <td>{{ $view_the_huongdanvien }}</td>
                            </tr>
                            <tr>
                                <th>Ngôn ngữ chính</th>
                                <td>{{ $view_the_ngonnguchinh }}</td>
                            </tr>
                            <tr>
                                <th>Số thẻ</th>
                                <td>{{ $view_the_sothe }}</td>
                            </tr>
                            <tr>
                                <th>Nơi cấp thẻ</th>
                                <td>{{ $view_the_noicapthe }}</td>
                            </tr>
                            <tr>
                                <th>Thời hạn thẻ</th>
                                <td>{{ $view_the_thoihanthe }}</td>
                            </tr>
                            <tr>
                                <th>Từ ngày</th>
                                <td>{{ $view_the_tungay }}</td>
                            </tr>
                            <tr>
                                <th>Đến ngày</th>
                                <td>{{ $view_the_denngay }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái</th>
                                <td>{!! $view_the_trangthai !!} </td>
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
        $('#addHdvdlTheModal').modal('hide');
        $('#editHdvdlTheModal').modal('hide');
        $('#deleteHdvdlTheModal').modal('hide');
        $('#viewHdvdlTheModal').modal('hide');
    });

    window.addEventListener('show-edit-the-modal', event => {
        $('#editHdvdlTheModal').modal('show');
    })

    window.addEventListener('show-delete-the-modal', event => {
        $('#deleteHdvdlTheModal').modal('show');
    });

    window.addEventListener('show-view-the-modal', event => {
        $('#viewHdvdlTheModal').modal('show');
    })
</script>
