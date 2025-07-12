@extends('layouts.app')

@section('space-work')
    <div class="container position-relative">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center mb-3">
                    <div class="col-12 text-center">
                        <h3 class="fs-3 text-black mb-0">Đăng ký thông tin - thẻ hướng dẫn viên</h3>
                    </div>
                </div>
                <div class="row justify-content-center mt-3">
                    <form action="{{ route('post.dang.ky.thong.tin') }}" method="POST" class="position-relative ">
                        @csrf
                        <div class="row ps-xxl-5 ps-xl-5 ps-lg-3 ps-md-0 ps-sm-0 ps-0">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Họ và tên đệm <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="ho_tenlot" class="form-control"
                                        placeholder="Nhập họ và tên đệm" value="{{ old('ho_tenlot') }}">
                                    @error('ho_tenlot')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Tên <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="ten" class="form-control" placeholder="Nhập tên"
                                        value="{{ old('ten') }}">
                                    @error('ten')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Ngày sinh <span
                                            class="text-danger">*</span></label>
                                    <input id="ngaysinh" type="text" name="ngaysinh" class="form-control"
                                        placeholder="Nhập ngày sinh" value="{{ old('ngaysinh') }}">
                                    @error('ngaysinh')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label for="gioiTinh" class="form-label text-black fs-7 mb-3">Giới tính <span
                                            class="text-danger">*</span></label>
                                    <select id="gioiTinh" name="gioitinh" class="form-select">
                                        <option value="">Chọn giới tính</option>
                                        <option value="1" {{ old('gioitinh') == '1' ? 'selected' : '' }}>Nam</option>
                                        <option value="2" {{ old('gioitinh') == '2' ? 'selected' : '' }}>Nữ</option>
                                    </select>
                                    @error('gioitinh')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="sdt1" class="form-control"
                                        placeholder="Nhập số điện thoại" value="{{ old('sdt1') }}">
                                    @error('sdt1')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="email" name="email1" class="form-control" placeholder="Nhập email"
                                        value="{{ old('email1') }}">
                                    @error('email1')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Số CCCD <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="cmnd_so" class="form-control" placeholder="Nhập số CCCD"
                                        value="{{ old('cmnd_so') }}">
                                    @error('cmnd_so')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Địa chỉ <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="diachi" class="form-control" placeholder="Nhập địa chỉ"
                                        value="{{ old('diachi') }}">
                                    @error('diachi')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Ngày cấp CCCD <span
                                            class="text-danger">*</span></label>
                                    <input id="cmnd_ngaycap" type="text" name="cmnd_ngaycap" class="form-control"
                                        placeholder="Nhập ngày cấp CCCD" value="{{ old('cmnd_ngaycap') }}">
                                    @error('cmnd_ngaycap')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Nơi cấp CCCD <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="cmnd_noicap" class="form-control"
                                        placeholder="Nhập nơi cấp CCCD" value="{{ old('cmnd_noicap') }}">
                                    @error('cmnd_noicap')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Số thẻ <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="sothe" class="form-control" placeholder="Nhập số thẻ"
                                        value="{{ old('sothe') }}">
                                    @error('sothe')
                                        <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Thời hạn thẻ <span
                                            class="text-danger">*</span></label>
                                    @if ($dm_thoihanthes)
                                        <select name="thoihanthe_id" class="form-select">
                                            <option value="">-- Chọn thời hạn thẻ --</option>
                                            @foreach ($dm_thoihanthes as $thoihanthe)
                                                <option value="{{ $thoihanthe->id }}"
                                                    {{ old('thoihanthe_id') == $thoihanthe->id ? 'selected' : '' }}>
                                                    {{ $thoihanthe->ten }}</option>
                                            @endforeach
                                        </select>
                                        @error('thoihanthe_id')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <p>Không có dữ liệu thời hạn thẻ.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Nơi cấp thẻ <span
                                            class="text-danger">*</span></label>
                                    @if ($dm_noicapthes)
                                        <select name="noicapthe_id" class="form-select">
                                            <option value="">-- Chọn nơi cấp thẻ --</option>
                                            @foreach ($dm_noicapthes as $noicapthe)
                                                <option value="{{ $noicapthe->id }}"
                                                    {{ old('noicapthe_id') == $noicapthe->id ? 'selected' : '' }}>
                                                    {{ $noicapthe->ten }}</option>
                                            @endforeach
                                        </select>
                                        @error('noicapthe_id')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <p>Không có dữ liệu nơi cấp thẻ.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 mt-3">
                                <div class="form-group">
                                    <label class="form-label text-black fs-7 mb-3">Ngôn ngữ chính <span
                                            class="text-danger">*</span></label>
                                    @if ($dm_ngonngus)
                                        <select name="huongdan_tiengchinh" class="form-select">
                                            <option value="">-- Chọn ngôn ngữ chính --</option>
                                            @foreach ($dm_ngonngus as $ngonngu)
                                                <option value="{{ $ngonngu->id }}"
                                                    {{ old('huongdan_tiengchinh') == $ngonngu->id ? 'selected' : '' }}>
                                                    {{ $ngonngu->ten }}</option>
                                            @endforeach
                                        </select>
                                        @error('huongdan_tiengchinh')
                                            <span class="text-danger" style="font-size: 15px">{{ $message }}</span>
                                        @enderror
                                    @else
                                        <p>Không có dữ liệu ngôn ngữ.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <button type="submit"
                                    class="btn btn-warning btn-hover-secondery text-capitalize mt-2 w-auto contact-btn">Đăng
                                    ký</button>
                                <a href="{{ route('home') }}"
                                    class="btn btn-secondary btn-hover-secondery text-capitalize mt-2 w-auto contact-btn">Quay
                                    lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('#ngaysinh', {
            dateFormat: 'd/m/Y', // Định dạng ngày Việt nam
            allowInput: true, // Cho phép nhập liệu trực tiếp
            onChange: function(selectedDates, dateStr, instance) {
                // Cập nhật giá trị của input khi ngày thay đổi
                instance.input.value = dateStr;
            }
        });

        flatpickr('#cmnd_ngaycap', {
            dateFormat: 'd/m/Y', // Định dạng ngày Việt nam
            allowInput: true, // Cho phép nhập liệu trực tiếp
            onChange: function(selectedDates, dateStr, instance) {
                // Cập nhật giá trị của input khi ngày thay đổi
                instance.input.value = dateStr;
            }
        });
    });
</script>
