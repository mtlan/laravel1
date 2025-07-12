<!DOCTYPE html>
<html lang="vi">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Thẻ Hội Viên - {{ $guideData['name'] ?? 'Họ tên' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #333;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #1e3c72;
            margin: 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-row {
            display: flex;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .label {
            font-weight: bold;
            width: 150px;
            color: #333;
        }
        .value {
            flex: 1;
            color: #666;
        }
        .card-section {
            border: 2px solid #1e3c72;
            padding: 20px;
            margin-top: 20px;
            background: #f9f9f9;
        }
        .card-title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #1e3c72;
            margin-bottom: 15px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #333;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>CÔNG TY DU LỊCH VIỆT NAM</h1>
            <p>Vietnam Tourism Company</p>
        </div>

        <div class="info-section">
            <h2>Thông tin Hướng dẫn viên</h2>
            <div class="info-row">
                <span class="label">Họ tên:</span>
                <span class="value">{{ $guideData['name'] ?? '---' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Ngày sinh:</span>
                <span class="value">{{ $guideData['dob'] ?? '---' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Điện thoại:</span>
                <span class="value">{{ $guideData['phone'] ?? '---' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Email:</span>
                <span class="value">{{ $guideData['email'] ?? '---' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Địa chỉ:</span>
                <span class="value">{{ $guideData['address'] ?? '---' }}</span>
            </div>
        </div>

        <div class="card-section">
            <div class="card-title">THẺ HƯỚNG DẪN VIÊN</div>
            <div class="info-row">
                <span class="label">Số thẻ:</span>
                <span class="value">{{ $guideData['card_number'] ?? '---' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Cấp ngày:</span>
                <span class="value">{{ $guideData['issue_date'] ?? '---' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Hạn đến:</span>
                <span class="value">{{ $guideData['expiry_date'] ?? '---' }}</span>
            </div>
            <div class="info-row">
                <span class="label">Trạng thái:</span>
                <span class="value">{{ $guideData['status'] ?? '---' }}</span>
            </div>
        </div>

        <div class="footer">
            <p>© 2024 Công ty Du lịch Việt Nam. Tất cả quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html> 