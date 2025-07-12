<!DOCTYPE html>
<html lang="vi">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Thẻ Hội Viên - {{ $guideData['name'] ?? 'Họ tên' }}</title>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /> --}}
    <style>
        .print-container:after {
            clear: both;
            display: block;
            content: "";
        }

        .bgthe:after {
            clear: both;
            display: block;
            content: "";
        }

        .qrcode canvas {
            width: 180px;
        }

        .bgtruoc {
            width: 1064px;
            height: 627px;
        }

        .headertruoc {
            height: 142px
        }

        .tencq {
            font-size: 30px !important;
            text-align: center !important;
            margin: 0px 0 !important;
            line-height: 50px !important;
            width: 760px !important;
            font-weight: bold !important;
            color: #000 !important;
            font-family: Times New Roman !important;
        }

        .maintruoc {
            overflow: hidden !important;
            color: #000 !important;
        }

        .anhthe {
            width: 230px !important;
            float: left !important;
        }

        .anhthe img {
            height: 298px !important;
            width: 230px !important;
        }

        .infotruoc {
            font-family: Times New Roman !important;
            width: 530px !important;
            color: #000 !important;
            position: relative;
            overflow: hidden;
        }

        .infotruoc h3 {
            font-size: 34px;
            margin: 25px 0;
            text-align: center;
            color: #000 !important;
            font-weight: bold;
        }

        h3.thehv {
            margin-top: 50px !important;
            color: #000 !important;
            line-height: 60px;
            font-weight: bold;
        }

        .infothe {
            width: 545px !important;
            margin-top: 62px;
            float: left !important;
            color: #000 !important;
            margin-left: 20px !important
        }

        .infothe p {
            font-size: 30px;
            margin: 0 !important;
            color: #000 !important;
            font-family: Times New Roman !important;
            line-height: 40px;
        }

        .infothe p .hoten {
            text-transform: uppercase !important;
            color: #000 !important;
        }

        .the {
            position: relative;
            overflow: hidden;
            margin-top: 25px;
            width: 745px
        }

        .qrcode {
            float: left;
        }

        .qrcode img {
            width: 180px;
            height: 183px;
        }

        h3.noiquy {
            font-size: 38px;
            color: #000;
            font-weight: bold;
            font-family: Times New Roman !important;
            line-height: 60px;
            margin: 20px 0
        }

        .bgsau {
            width: 1064px;
            height: 627px;
            position: relative;
            margin-top: 20px
        }

        .bgsau p {
            margin: 5px 0;
            font-size: 34px;
            color: #000;
            font-family: Times New Roman !important;
            line-height: 60px
        }

        .link {
            text-align: center
        }

        .noiquy {
            margin: 15px 0;
            text-align: center;
        }

        .container-hdv {
            position: absolute;
            top: -9px;
            width: inherit;
            left: 0px;
            padding: 45px
        }

        .bgthe .bgtruoc {
            position: relative;
        }

        .matsau-container {
            position: absolute;
            top: 0px;
            width: inherit;
            left: 0px;
            padding: 45px
        }

        @media print {
            #non-printable>.btn {
                float: left;
                margin: 10px 0 0 10px;
            }

            .print-control {
                display: none;
            }
        }
    </style>
</head>

<body>
    {{-- @foreach ($guideData as $guide)
        <div class="main-container" style="page-break-after: always;">
            <div class="print-container" id="contentThe">
                <div class="bgthe">
                    <div class="bgtruoc" style="float:left; margin-right:30px">
                        @if ($guide['background-mattruoc'])
                            <img src="{{ $guide['background-mattruoc'] }}" />
                        @else
                            <div class="avatar-placeholder">ẢNH</div>
                        @endif
                        <div class="container-hdv">
                            <div class="headertruoc">
                                <h3 class="tencq">HIỆP HỘI DU LỊCH ĐÀ NẴNG <BR />CHI HỘI HƯỚNG DẪN VIÊN DU LỊCH ĐÀ NẴNG
                                </h3>
                            </div>
                            <div class="maintruoc">

                                <div class="anhthe">
                                    @if ($guide['avatar'])
                                        <img src="{{ $guide['avatar'] }}" alt="Ảnh hội viên" />
                                    @else
                                        <div class="avatar-placeholder">ẢNH</div>
                                    @endif
                                </div>
                                <div class="infotruoc">
                                    <h3 class="thehv">THẺ HỘI VIÊN</h3>
                                    <h3 class="sothe">{{ $guide['card_number'] }}</h3>
                                </div>
                                <div class="the">
                                    <div class="infothe">
                                        <p>Họ và tên: <span class="hoten">{{ $guide['name'] }}</span>
                                        </p>
                                        <p>Số CMT/CCCD: <span class="socmt">{{ $guide['cccd'] }}</span></p>
                                        <p>Giá trị từ: <span class="tungay">{{ $guide['issue_date'] }}</span> đến
                                            <span class="denngay">{{ $guide['expiry_date'] }}</span>
                                        </p>
                                    </div>
                                    <div class="qrcode">
                                        @if ($guide['qr_code'])
                                            <img src="{{ $guide['qr_code'] }}" alt="QR code" />
                                        @else
                                            <div class="avatar-placeholder">QR CODE</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bgsau" style="float:left">
                        @if ($guide['background-matsau'])
                            <img src="{{ $guide['background-matsau'] }}" alt="Ảnh hội viên" />
                        @else
                            <div class="avatar-placeholder">ẢNH</div>
                        @endif
                        <div class="matsau-container">
                            <div class="link">
                                <p>http://tourguidedanang.vn</p>
                            </div>
                            <h3 class="noiquy">NỘI QUY THẺ THÀNH VIÊN</h3>
                            <div class="noidung">
                                <p>- Sử dụng thẻ khi làm nhiệm vụ</p>
                                <p>- Thẻ không có giá trị khi cho người khác mượn</p>
                                <p>- Thẻ được phát hành và quản lý bởi Chi hội HDV DL Đà Nẵng</p>
                                <p>- Trường hợp nhặt được vui lòng liên hệ với chủ thẻ</p>
                                <p>- Thẻ không còn giá trị khi không còn là hội viên Chi hội.
                                <p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach  --}}

    <div class="main-container" style="page-break-after: always;">
        <div class="print-container" id="contentThe">
            <div class="bgthe">
                <div class="bgtruoc" style="float:left; margin-right:30px">
                    @if ($guideData['background-mattruoc'])
                        <img src="{{ $guideData['background-mattruoc'] }}" />
                    @else
                        <div class="avatar-placeholder">ẢNH</div>
                    @endif
                    <div class="container-hdv">
                        <div class="headertruoc">
                            <h3 class="tencq">HIỆP HỘI DU LỊCH ĐÀ NẴNG <BR />CHI HỘI HƯỚNG DẪN VIÊN DU LỊCH ĐÀ NẴNG
                            </h3>
                        </div>
                        <div class="maintruoc">

                            <div class="anhthe">
                                @if ($guideData['avatar'])
                                    <img src="{{ $guideData['avatar'] }}" alt="Ảnh hội viên" />
                                @else
                                    <div class="avatar-placeholder">ẢNH</div>
                                @endif
                            </div>
                            <div class="infotruoc">
                                <h3 class="thehv">THẺ HỘI VIÊN</h3>
                                <h3 class="sothe">{{ $guideData['card_number'] }}</h3>
                            </div>
                            <div class="the">
                                <div class="infothe">
                                    <p>Họ và tên: <span class="hoten">{{ $guideData['name'] }}</span>
                                    </p>
                                    <p>Số CMT/CCCD: <span class="socmt">{{ $guideData['cccd'] }}</span></p>
                                    <p>Giá trị từ: <span class="tungay">{{ $guideData['issue_date'] }}</span> đến
                                        <span class="denngay">{{ $guideData['expiry_date'] }}</span>
                                    </p>
                                </div>
                                <div class="qrcode">
                                    @if ($guideData['avatar'])
                                        <img src="{{ $guideData['avatar'] }}" alt="Ảnh hội viên" />
                                    @else
                                        <div class="avatar-placeholder">ẢNH</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bgsau" style="float:left">
                    @if ($guideData['background-matsau'])
                        <img src="{{ $guideData['background-matsau'] }}" alt="Ảnh hội viên" />
                    @else
                        <div class="avatar-placeholder">ẢNH</div>
                    @endif
                    <div class="matsau-container">
                        <div class="link">
                            <p>http://tourguidedanang.vn</p>
                        </div>
                        <h3 class="noiquy">NỘI QUY THẺ THÀNH VIÊN</h3>
                        <div class="noidung">
                            <p>- Sử dụng thẻ khi làm nhiệm vụ</p>
                            <p>- Thẻ không có giá trị khi cho người khác mượn</p>
                            <p>- Thẻ được phát hành và quản lý bởi Chi hội HDV DL Đà Nẵng</p>
                            <p>- Trường hợp nhặt được vui lòng liên hệ với chủ thẻ</p>
                            <p>- Thẻ không còn giá trị khi không còn là hội viên Chi hội.
                            <p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
