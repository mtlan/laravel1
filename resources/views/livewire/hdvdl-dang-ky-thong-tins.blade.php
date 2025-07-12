<div>
    <div class="container-fluid pt-4 px-4">
        <div class="custom-title">
            <div class="container-fluid pt-3 px-3">
                <div class="row g-4 mb-4">
                    <div class="col-12 col-lg-8 ">
                        <nav class="navbar navbar-expand-lg">
                            <div class="container-fluid">
                                <h4>Quản lý yêu cầu đăng ký/chỉnh sửa/gia hạn thông tin - thẻ hướng dẫn viên</h4>
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
                                    Yêu cầu đăng ký/chỉnh sửa/gia hạn thông tin
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-contain">
            <div class="text-center rounded p-4">
                {{-- <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0 text-black">Yêu cầu</h6>

                    <div class="col-xxl-2">
                        <div class="search-box ms-3" style="max-width: 500px; min-width: 300px;">
                            <input class="form-control serch me-1 flex-grow-1" type="text"
                                wire:model.live.debounce.300ms="searchParam"
                                placeholder="Tìm kiếm theo tên, số điện thoại, CCCD/CMND, email ..."
                                aria-label="Search">
                            <i class="ri-search-line search-icon"></i>
                        </div>
                    </div>

                    <div class="col-xxl-2">
                        <select class="form-control" id="select-category" data-choices="" data-choices-search-false="">
                            <option value="">Select Categories</option>
                            <option value="All">All</option>
                            <option value="Retailer">Retailer</option>
                            <option value="Health & Medicine">Health & Medicine</option>
                            <option value="Manufacturer">Manufacturer</option>
                            <option value="Food Service">Food Service</option>
                            <option value="Computers & Electronics">Computers & Electronics</option>
                        </select>
                    </div><!--end col-->
                </div> --}}
                <div class="row g-3 mb-4">
                    <div class="col-12 col-md-2 col-lg-2 col-xl-auto me-auto">
                        <h6 class="mb-0 text-black">Yêu cầu</h6>
                    </div><!--end col-->

                    <div class="col-12 col-md-4 col-lg-4 col-xl-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input class="form-control" type="text" wire:model.live.debounce.300ms="searchParam"
                                placeholder="Tìm kiếm theo tên, số điện thoại, CCCD/CMND, email ..."
                                aria-label="Search">
                        </div>
                    </div>

                    <div class="col-12 col-md-3 col-lg-3 col-xl-2">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-funnel"></i>
                            </span>
                            <select class="form-control" id="select-category" wire:model.live="searchType">
                                <option value="">Lọc loại yêu cầu</option>
                                <option value="tao_moi">Tạo mới</option>
                                <option value="chinh_sua">Chỉnh sửa</option>
                                <option value="gia_han">Gia hạn</option>
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

                <div class="table-responsive">
                    <table class="table text-start align-middle table-bordered table-hover mb-0">
                        <thead>
                            <tr class="text-white">
                                <th scope="col" width="10%" class="text-center">Loại yêu cầu</th>
                                <th scope="col" width="10%" class="text-center">Tên</th>
                                <th scope="col" width="10%" class="text-center">CMND/CCCD</th>
                                <th scope="col" width="10%" class="text-center">Số thẻ</th>
                                <th scope="col" width="10%" class="text-center">Tiếng chính</th>
                                <th scope="col" width="10%" class="text-center">Nơi cấp thẻ</th>
                                <th scope="col" width="10%" class="text-center">Hướng dẫn viên</th>
                                <th scope="col" width="10%" class="text-center">Thời hạn thẻ</th>
                                <th scope="col" width="10%" class="text-center">Trạng thái</th>
                                <th scope="col" width="10%" class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($yeuCaus as $yeuCau)
                                <tr>
                                    <td class="text-center">{!! $yeuCau->getType() !!}</td>
                                    <td class="text-center">
                                        <a href="#" wire:click.prevent="view({{ $yeuCau->id }})"
                                            style="color: rgb(48, 100, 177); cursor: pointer; text-decoration: underline;">
                                            {{ $yeuCau->ho_tenlot }}
                                            {{ $yeuCau->ten }}
                                        </a>
                                    </td>
                                    <td class="text-center">{{ $yeuCau->cmnd_so }}</td>
                                    <td class="text-center">{{ $yeuCau->sothe }}</td>
                                    <td class="text-center">{{ $yeuCau->tiengchinh?->ten }}</td>
                                    <td class="text-center">{{ $yeuCau->noicapthe?->ten }}</td>
                                    <td class="text-center">{{ $yeuCau->huongdanvien?->getHoVaTen() }}</td>
                                    <td class="text-center">{{ $yeuCau->thoihanthe?->ten }}</td>
                                    <td class="text-center">{!! $yeuCau->getTrangThai() !!}</td>
                                    <td class="text-center">
                                        @if ($yeuCau->trangthai !== 'da_phe_duyet')
                                            {{-- <button class="btn btn-sm btn-outline-primary"
                                            wire:click="manageThe({{ $yeuCau->id }})">Thẻ</button> --}}
                                            <button class="btn btn-sm btn-outline-success"
                                                wire:click="edit({{ $yeuCau->id }}, '{{ $yeuCau->type }}')">Phê
                                                duyệt</button>
                                            <button class="btn btn-sm btn-outline-danger"
                                                wire:click="delete({{ $yeuCau->id }})">Xoá</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div style="float: right;">
                                        {{ $yeuCaus->appends(request()->input())->links('vendor.pagination.bootstrap-5-vi') }}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chỉnh sửa -->
    <div wire:ignore.self class="modal fade" id="editYeuCauModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-black" id="exampleModalLabel">Phê duyệt
                        {{ $yeucauthongtin_edit_type == 'tao_moi' ? 'yêu cầu đăng ký' : ($yeucauthongtin_edit_type == 'chinh_sua' ? 'chỉnh sửa' : 'gia hạn') }}
                        thông tin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form wire:submit.prevent="update" class="mb-2">
                    @csrf
                    <div class="modal-body">
                        @if ($thongtin_hdv)
                            <h5 class="text-black">Thông tin hướng dẫn viên</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <tbody>
                                        <tr class="text-center">
                                            <td>Họ và tên</td>
                                            <td>{{ $thongtin_hdv->ho_tenlot }} {{ $thongtin_hdv->ten }}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>Số CCCD</td>
                                            <td>{{ $thongtin_hdv->cmnd_so }}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>Số thẻ</td>
                                            <td>{{ $thongtin_hdv->thedanghoatdong?->sothe }}</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>Thời hạn thẻ</td>
                                            <td>{{ $thongtin_hdv->thedanghoatdong?->thoihanthe?->ten }}</td>
                                        </tr>
                                        @if ($yeucauthongtin_edit_type == 'gia_han')
                                            <tr class="text-center">
                                                <td>Từ ngày</td>
                                                <td>{{ $thongtin_hdv->thedanghoatdong?->tungay }}</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Đến ngày</td>
                                                <td>{{ $thongtin_hdv->thedanghoatdong?->denngay }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            @if ($yeucauthongtin_edit_type == 'gia_han')
                                <h5 class="text-black">Thông tin gia hạn</h5>
                                <div class="row">
                                    <div class="col-md-12 mb-2">
                                        <label for="thoiHanThe" class="col-6">Thời hạn thẻ</label>
                                        <div class="col-12">
                                            <input id="thoiHanThe" wire:model="thoiHanThe" type="text"
                                                class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="tuNgay" class="col-6">Từ ngày</label>
                                        <div class="col-12">
                                            <input id="tuNgay" wire:model="tuNgay" type="text"
                                                class="form-control" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="denNgay" class="col-6">Đến ngày</label>
                                        <div class="col-12">
                                            <input id="denNgay" wire:model="denNgay" type="text"
                                                class="form-control" readonly />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if ($yeucauthongtin_edit_type != 'gia_han')
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="hoTenLot" class="col-6">Họ và tên đệm</label>
                                    <div class="col-12">
                                        <input id="hoTenLot" wire:model="hoTenLot" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="ten" class="col-6">Tên</label>
                                    <div class="col-12">
                                        <input id="ten" wire:model="ten" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="sdt1" class="col-6">Số điện thoại</label>
                                    <div class="col-12">
                                        <input id="sdt1" wire:model="sdt1" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="email1" class="col-6">Email</label>
                                    <div class="col-12">
                                        <input id="email1" wire:model="email1" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="cmndSo" class="col-6">Số CCCD/CMND</label>
                                    <div class="col-12">
                                        <input id="cmndSo" wire:model="cmndSo" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="cmndNgayCap" class="col-6">Ngày cấp CCCD/CMND</label>
                                    <div class="col-12">
                                        <input id="cmndNgayCap" wire:model="cmndNgayCap" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="cmndNoiCap" class="col-6">Nơi cấp CCCD/CMND</label>
                                    <div class="col-12">
                                        <input id="cmndNoiCap" wire:model="cmndNoiCap" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="diaChi" class="col-6">Địa chỉ</label>
                                    <div class="col-12">
                                        <input id="diaChi" wire:model="diaChi" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="tiengChinh" class="col-6">Ngôn ngữ chính</label>
                                    <div class="col-12">
                                        <input id="tiengChinh" wire:model="tiengChinh" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="soThe" class="col-6">Số thẻ</label>
                                    <div class="col-12">
                                        <input id="soThe" wire:model="soThe" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="noiCapThe" class="col-6">Nơi cấp thẻ</label>
                                    <div class="col-12">
                                        <input id="noiCapThe" wire:model="noiCapThe" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="thoiHanThe" class="col-6">Thời hạn thẻ</label>
                                    <div class="col-12">
                                        <input id="thoiHanThe" wire:model="thoiHanThe" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="tuNgay" class="col-6">Từ ngày</label>
                                    <div class="col-12">
                                        <input id="tuNgay" wire:model="tuNgay" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="denNgay" class="col-6">Đến ngày</label>
                                    <div class="col-12">
                                        <input id="denNgay" wire:model="denNgay" type="text"
                                            class="form-control" />
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Phê duyệt</button>
                    </div>
                </form>
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
</div>

<script>
    document.addEventListener('livewire:init', function() {
        $('#editYeuCauModal').on('hidden.bs.modal', function() {
            @this.resetFields(); // Reset giá trị Livewire
        });
    });
    window.addEventListener('close-modal', event => {
        $('#editYeuCauModal').modal('hide');
    });

    window.addEventListener('show-edit-yeucauthongtin-modal', event => {
        $('#editYeuCauModal').modal('show');
    })

    window.addEventListener('show-delete-yeucauthongtin-modal', event => {
        $('#deleteHdvdlHdvModal').modal('show');
    });
</script>
