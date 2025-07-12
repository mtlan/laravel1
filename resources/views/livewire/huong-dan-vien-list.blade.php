<main id="content">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-2">
                <div class="breadcrumb u-breadcrumb  pt-3 px-0 mb-0 bg-transparent small">
                    <a class="breadcrumb-item" href="{{route('home')}}">Trang chủ</a>&nbsp;&nbsp;&#187;&nbsp;&nbsp;
                    <span class="d-none d-md-inline">Hướng dẫn viên</span>
                </div>
            </div>
            <!-- Form Tìm kiếm -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="block-title-4">
                        <h4 class="h5 title-arrow"><span>TÌM KIẾM</span></h4>
                    </div>
                    <div class="card-body">
                        
                            <div class="form-group mb-3">
                                <label for="province">Tỉnh cấp thẻ</label>
                                <select class="form-control form-control-sm" id="province" wire:model.live.debounce.300ms="selectNoiCapThe">
                                    <option value="">Chọn</option>
                                    @foreach($noiCapThes as $noiCapThe)
                                    <option value="{{$noiCapThe->id}}">{{$noiCapThe->ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group mb-3">
                                <label for="cardType">Loại thẻ</label>
                                <select class="form-control form-control-sm" id="cardType">
                                    <option>Chọn</option>
                                    <option>Quốc tế</option>
                                    <option>Trong nước</option>
                                    <option>Hướng dẫn viên địa phương</option>
                                </select>
                            </div> --}}
                            <div class="form-group mb-3">
                                <label for="language">Ngoại ngữ sử dụng</label>
                                <select class="form-control form-control-sm" id="language" wire:model.live.debounce.300ms="selectNgonNgu">
                                    <option value="">Chọn</option>
                                    @foreach($ngonNgus as $ngonNgu)
                                    <option value="{{$ngonNgu->id}}">{{$ngonNgu->ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Họ và tên</label>
                                <input type="text" class="form-control form-control-sm" id="name"
                                    placeholder="Họ và tên" wire:model.live.debounce.300ms="hoTens">
                            </div>
                            <div class="form-group mb-3">
                                <label for="cardNumber">Số thẻ hướng dẫn viên</label>
                                <input type="text" class="form-control form-control-sm" id="cardNumber"
                                    placeholder="Số thẻ hướng dẫn viên" wire:model.live.debounce.300ms="soThes">
                            </div>
                            <!-- <div class="text-end">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-search"></i> Tìm kiếm
                                </button>
                            </div> -->
                        
                    </div>
                </div>

            </div>

            <!-- Danh sách Hướng dẫn viên -->
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="block-title-4">
                        <h4 class="h5 title-arrow"><span>HƯỚNG DẪN VIÊN</span></h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-3">Tổng số hướng dẫn viên: <strong>{{$theHuongDanViens->count()}}</strong></p>

                        <!-- Phân trang -->
                        {{ $theHuongDanViens->links('user.customPaginate') }}
                        {{-- <div class="clearfix my-4">
                            <nav class="float-start" aria-label="Posts navigation">
                                <ul class="pagination">
                                    <li class="page-item active">
                                        <span aria-current="page" class="page-link current">1</span>
                                    </li>
                                    <li class="page-item ">
                                        <a class="page-link" href="detail.html">2</a>
                                    </li>
                                    <li class="page-item ">
                                        <a class="next page-link" href="detail.html">&raquo;</a>
                                    </li>
                                </ul>
                            </nav>
                            <span class="py-2 float-end"></span>
                        </div> --}}
                        @foreach($theHuongDanViens as $theHuongDanVien)
                        <div class="row contact-item mx-0 pt-0 pb-2 card-box">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-4 px-0">
                                        {{-- <div class="row mx-0 text-white font-weight-bold"
                                            style="min-height:40px; background-color:#f15a2a">
                                            <div class="col-md-12 mx-0 px-0 pt-2 text-center text-uppercase align-middle"
                                                style="height:40px; ">
                                                Thẻ Tại điểm </div>
                                        </div> --}}
                                        <div class="col-lg-12 mx-0 px-0 pt-2">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="50" valign="top" align="center"><span
                                                                class="font-weight-bold"> {{$loop->iteration}}</span></td>
                                                        <td align="center">
                                                            <div class="bg-light border"
                                                                style="height:192px; width:142px;padding:10px;margin:0px auto;">
                                                                @php
                                                                    $image = App\Models\CmsAttachment::where(
                                                                        'huongdanvien_id',
                                                                        $theHuongDanVien->huongdanvien_id,
                                                                    )
                                                                        ->where('daxoa', 0)
                                                                        ->first();
                                                                @endphp
                                                                @if ($image)
                                                                <img src="{{ asset($image->url) }}"
                                                                    style="height:170px; width:120px;"
                                                                    class="border">
                                                                @else
                                                                <img src="{{ asset('frontend/images/noimage.png') }}"
                                                                    style="height:170px; width:120px;"
                                                                    class="border">
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-8 px-0">
                                        <div class="row mx-0 pt-2 px-2 text-white font-weight-bold text-left"
                                            style="min-height:40px;background-color:#2596be">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody class="text-uppercase">
                                                    <tr>
                                                        <td width="40%">Họ và tên:</td>
                                                        <td>{{$theHuongDanVien->huongdanvien?->ho_tenlot}} {{$theHuongDanVien->huongdanvien?->ten}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mx-0 px-2 py-1 text-secondary text-left border-bottom form-inline"
                                            style="border-bottom:1px dashed">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="45%"><strong>Số thẻ:</strong></td>
                                                        <td>{{$theHuongDanVien->sothe}}</td>
                                                        <td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mx-0 px-2 py-1 text-secondary text-left border-bottom form-inline"
                                            style="border-bottom:1px dashed">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="45%"><strong>Ngày cấp:</strong></td>
                                                        <td>{{$theHuongDanVien->tungay->format('d/m/Y')}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mx-0 px-2 py-1 text-secondary text-left border-bottom form-inline"
                                            style="border-bottom:1px dashed">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="45%"><strong>Ngày hết hạn:</strong></td>
                                                        <td>{{$theHuongDanVien->denngay->format('d/m/Y')}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mx-0 px-2 py-1 text-secondary text-left border-bottom form-inline"
                                            style="border-bottom:1px dashed">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="45%"><strong>Thời hạn:</strong></td>
                                                        <td>{{$theHuongDanVien->thoihanthe?->ten}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mx-0 px-2 py-1 text-secondary text-left border-bottom form-inline"
                                            style="border-bottom:1px dashed">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="45%"><strong>Nơi cấp thẻ:</strong></td>
                                                        <td>{{$theHuongDanVien->noicapthe?->ten}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row mx-0 px-2 py-1 text-secondary text-left border-bottom form-inline"
                                            style="border-bottom:1px dashed">
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tbody>
                                                    <tr>
                                                        <td width="45%"><strong>Ngôn ngữ:</strong></td>
                                                        <td>{{$theHuongDanVien->tiengchinh?->ten}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach


                        <!-- Thêm nhiều thẻ như trên, thay số STT và dữ liệu tương ứng -->

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>