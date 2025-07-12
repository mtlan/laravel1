<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Thẻ Hội Viên - {{ $guideData['name'] ?? 'Họ tên' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(120deg, #f3c381 0%, #f5dd96 20%, #7ee8fa 40%, #eec0c6 60%, #70e1f5 80%, #ffd194 100%);
            min-height: 100vh;
            display: block;
            padding-top: 0;
        }

        .pdf-card {
            background: linear-gradient(120deg, #f3c381 0%, #f5dd96 20%, #7ee8fa 40%, #eec0c6 60%, #70e1f5 80%, #ffd194 100%);
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(30, 60, 114, 0.13);
            border: 1.5px solid #e0e0e0;
            max-width: 700px;
            width: 100%;
            margin: 0 auto;
            padding: 32px 32px 24px 32px;
            display: flex;
            flex-direction: column;
            gap: 28px;
        }

        .guide-info-block {
            background: transparent;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07);
            padding: 24px 24px 18px 24px;
            margin: 0 auto;
            width: 95%;
            border: 1px solid #e0e0e0;
        }

        .card-info-block {
            background: transparent;
            border-radius: 14px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07);
            padding: 24px 24px 18px 24px;
            margin: 0 auto;
            width: 55%;
            border: 1px solid #e0e0e0;
        }

        .guide-info-header {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .guide-avatar {
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .guide-avatar img {
            width: 110px;
            height: 130px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
            background: #fff;
        }

        .avatar-placeholder {
            width: 110px;
            height: 130px;
            background: #f0f0f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            color: #666;
            border: 2px solid #ddd;
        }

        .guide-info-main {
            flex: 1;
        }

        .guide-name {
            font-size: 1.25em;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 2px;
        }

        .guide-role {
            font-size: 1em;
            color: #5a189a;
            margin-bottom: 12px;
        }

        .guide-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 10px 18px;
            width: 100%;
        }

        .guide-info-item {
            display: flex;
            align-items: center;
            border-radius: 8px;
            padding: 7px 0;
            font-size: 1em;
        }

        .guide-info-item i {
            color: #2a5298;
            margin-right: 8px;
            font-size: 1.1em;
            min-width: 20px;
            text-align: center;
        }

        .guide-info-label {
            color: #222;
            margin-right: 4px;
            font-size: 1em;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .guide-info-content {
            color: #5a189a;
            font-weight: 700;
            font-size: 1em;
            word-break: break-word;
            flex: 1 1 0;
            min-width: 0;
        }

        .card-bg-flex {
            display: flex;
            flex-direction: row;
            align-items: stretch;
            width: 100%;
            min-height: 140px;
            padding: 0;
        }

        .card-col {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-qr-col {
            width: 110px;
            min-width: 110px;
            align-items: center;
            display: flex;
            justify-content: center;
            background: rgba(255, 255, 255, 0.12);
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
            padding: 12px 6px 12px 6px;
            position: relative;
        }

        .card-info-col {
            flex: 1;
            padding: 18px 18px 12px 18px;
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
            background: transparent;
            color: #222;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-qr-img {
            width: 70px;
            height: 70px;
            object-fit: contain;
            background: #fff;
            border-radius: 8px;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
            margin: 8px 0 8px 0;
        }

        .qr-placeholder {
            width: 70px;
            height: 70px;
            background: #f0f0f0;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            color: #666;
            border: 2px solid #ddd;
            margin: 8px 0;
        }

        .qr-label-card {
            font-size: 0.95em;
            color: #ffd600;
            font-weight: 500;
            text-align: center;
            margin-bottom: 4px;
        }

        .card-title {
            font-size: 1.1em;
            font-weight: 700;
            margin-bottom: 10px;
            margin-top: 4px;
            letter-spacing: 1px;
            color: #1e3c72;
        }

        .card-title span {
            font-size: 0.95em;
            font-weight: 400;
            opacity: 0.85;
            color: #5a189a;
        }

        .card-row {
            font-size: 1em;
            margin-bottom: 6px;
            display: flex;
            gap: 10px;
        }

        .card-row span {
            min-width: 80px;
            color: #222;
            opacity: 0.92;
        }

        .card-row strong {
            color: #5a189a;
            font-weight: 600;
        }

        .card-row .card-number {
            color: #ffd600;
            font-weight: 700;
        }

        @media (max-width: 800px) {
            .pdf-card {
                max-width: 98vw;
                padding: 8px;
            }

            .guide-info-header {
                flex-direction: column;
                gap: 10px;
            }

            .guide-info-block,
            .card-info-block {
                padding: 10px;
            }
        }

        @media print {
            body {
                background: #fff !important;
            }

            .pdf-card {
                background: linear-gradient(120deg, #f3c381 0%, #f5dd96 20%, #7ee8fa 40%, #eec0c6 60%, #70e1f5 80%, #ffd194 100%) !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                border: none !important;
                margin: 0 !important;
                padding: 0 !important;
                max-width: 794px !important;
                width: 100% !important;
            }

            .guide-info-block,
            .card-info-block {
                page-break-inside: avoid !important;
                box-shadow: none !important;
                border-radius: 0 !important;
                border: 1px solid #ddd !important;
                background: transparent !important;
            }
        }
    </style>
</head>

<body>
    <div class="pdf-card">
        <!-- Form thông tin hướng dẫn viên -->
        <div class="guide-info-block">
            <div class="guide-info-header">
                <div class="guide-avatar">
                    @if (isset($guideData['avatar']) && $guideData['avatar'])
                        <img src="{{ $guideData['avatar'] }}" alt="Ảnh hội viên" />
                    @else
                        <div class="avatar-placeholder">ẢNH</div>
                    @endif
                </div>
                <div class="guide-info-main">
                    <div class="guide-name">{{ $guideData['name'] ?? 'Họ tên' }}</div>
                    {{-- <div class="guide-role">{{ $guideData['title'] ?? 'Hướng dẫn viên Du lịch Quốc tế' }}</div> --}}
                    <div class="guide-info-grid">
                        <div class="guide-info-item">
                            <i class="fa fa-calendar"></i>
                            <span class="guide-info-label">Ngày sinh:</span>
                            <span class="guide-info-content">{{ $guideData['dob'] ?? '---' }}</span>
                        </div>
                        <div class="guide-info-item">
                            <i class="fa fa-phone"></i>
                            <span class="guide-info-label">Điện thoại:</span>
                            <span class="guide-info-content">{{ $guideData['phone'] ?? '---' }}</span>
                        </div>
                        <div class="guide-info-item">
                            <i class="fa fa-envelope"></i>
                            <span class="guide-info-label">Email:</span>
                            <span class="guide-info-content">{{ $guideData['email'] ?? '---' }}</span>
                        </div>
                        <div class="guide-info-item">
                            <i class="fa fa-map-marker-alt"></i>
                            <span class="guide-info-label">Địa chỉ:</span>
                            <span class="guide-info-content">{{ $guideData['address'] ?? '---' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Form thông tin thẻ -->
        <div class="card-info-block">
            <div class="card-bg-flex">
                <div class="card-col card-qr-col">
                    @if (isset($guideData['qr']) && $guideData['qr'])
                        <img class="card-qr-img" src="{{ $guideData['qr'] }}" alt="QR xác minh" />
                    @else
                        <div class="qr-placeholder">QR</div>
                    @endif
                    <div class="qr-label-card">Quét để xác minh</div>
                </div>
                <div class="card-col card-info-col">
                    <div class="card-title">THẺ HƯỚNG DẪN VIÊN</div>
                    {{-- <br><span>Tour Guide Card</span> --}}
                    <div class="card-row"><span>Họ tên:</span>
                        <strong>{{ $guideData['name'] ?? 'Họ tên' }}</strong>
                    </div>
                    <div class="card-row"><span>Số thẻ:</span> <strong
                            class="card-number">{{ $guideData['card_number'] ?? 'Số thẻ' }}</strong></div>
                    <div class="card-row"><span>Cấp ngày:</span>
                        <strong>{{ $guideData['issue_date'] ?? '---' }}</strong>
                    </div>
                    <div class="card-row"><span>Hạn đến:</span>
                        <strong>{{ $guideData['expiry_date'] ?? '---' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
