<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0" /> --}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Thẻ Hội Viên - {{ $guideData['name'] ?? 'Họ tên' }}</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/guide-profile.css') }}" /> --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        /* Reset và Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(120deg, #f3c381 0%, #f5dd96 20%, #7ee8fa 40%, #eec0c6 60%, #70e1f5 80%, #ffd194 100%);
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: linear-gradient(120deg, #f3c381 0%, #f5dd96 20%, #7ee8fa 40%, #eec0c6 60%, #70e1f5 80%, #ffd194 100%);
        }

        /* Header Styles */
        .header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 25px 30px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>'); */
            opacity: 0.3;
        } 

        .header-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 8px;
            border-radius: 8px;
        }

        .company-info h1 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .company-info p {
            font-size: 13px;
            opacity: 0.9;
            font-weight: 300;
        }

        .document-info {
            text-align: right;
        }

        .document-info h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .document-number,
        .issue-date {
            font-size: 13px;
            opacity: 0.9;
            margin-bottom: 4px;
        }

        /* Main Content */
        .main-content {
            padding: 30px;
        }

        /* Profile Section */
        .profile-section {
            margin-bottom: 30px;
        }

        .profile-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 20px;
            padding: 25px;
            display: flex;
            gap: 25px;
            align-items: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .profile-photo {
            position: relative;
            flex-shrink: 0;
        }

        .profile-photo img {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid white;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .status-badge {
            position: absolute;
            bottom: 8px;
            right: 8px;
            background: #10b981;
            color: white;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .profile-info {
            flex: 1;
        }

        .guide-name {
            font-size: 24px;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 8px;
        }

        .guide-title {
            font-size: 16px;
            color: #667eea;
            font-weight: 500;
            margin-bottom: 18px;
        }

        .guide-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 12px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.7);
            border-radius: 8px;
            backdrop-filter: blur(10px);
        }

        .detail-item i {
            color: #667eea;
            width: 18px;
            text-align: center;
            font-size: 14px;
        }

        /* Card Section - Nền trắng hài hòa */
        .card-section {
            margin-bottom: 30px;
        }

        .guide-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            position: relative;
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #e5e7eb;
        }

        .guide-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .card-left {
            width: 180px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 1;
            border-right: 1px solid #e5e7eb;
        }

        .card-photo {
            position: relative;
            margin-bottom: 15px;
        }

        .card-photo img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            background: white;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-photo img:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }

        .qr-section {
            text-align: center;
            color: white;
            margin-top: auto;
        }

        .qr-code {
            width: 50px;
            height: 50px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-size: 24px;
            color: #667eea;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .qr-section p {
            font-size: 11px;
            opacity: 0.9;
            font-weight: 500;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        .card-right {
            flex: 1;
            padding: 20px;
            color: #333;
            position: relative;
            z-index: 1;
            background: white;
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-logo {
            width: 35px;
            height: 35px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }

        .card-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 4px;
            border-radius: 50%;
        }

        .card-title h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #1e3c72;
        }

        .card-title p {
            font-size: 11px;
            opacity: 0.7;
            font-weight: 400;
            color: #666;
        }

        .card-info {
            display: grid;
            gap: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s ease;
        }

        .info-row:hover {
            background: #f9fafb;
            border-radius: 6px;
            padding: 8px 6px;
            margin: 0 -6px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .label {
            font-size: 13px;
            opacity: 0.7;
            font-weight: 500;
            color: #666;
        }

        .value {
            font-weight: 600;
            font-size: 13px;
            text-align: right;
            max-width: 60%;
            word-wrap: break-word;
            color: #333;
        }

        .card-number {
            color: #667eea;
            font-weight: 700;
        }

        /* Section Titles */
        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding-bottom: 8px;
            border-bottom: 3px solid #667eea;
        }

        .section-title i {
            color: #667eea;
            font-size: 24px;
        }

        /* Specializations Section */
        .specializations-section {
            margin-bottom: 30px;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .skill-category {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-top: 4px solid #667eea;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .skill-category:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .skill-category h4 {
            font-size: 16px;
            font-weight: 600;
            color: #1e3c72;
            margin-bottom: 12px;
            text-align: center;
        }

        .skill-items {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            justify-content: center;
        }

        .skill-tag {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 500;
            transition: transform 0.2s ease;
        }

        .skill-tag:hover {
            transform: scale(1.05);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 25px;
            margin-top: 30px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 15px;
        }

        .footer-left,
        .footer-right {
            flex: 1;
            min-width: 200px;
        }

        .footer p {
            margin-bottom: 6px;
            font-size: 13px;
        }

        .footer-bottom {
            text-align: center;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            font-size: 11px;
            opacity: 0.8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                margin: 10px;
                border-radius: 15px;
            }

            .header-content {
                flex-direction: column;
                text-align: center;
            }

            .document-info {
                text-align: center;
            }

            .main-content {
                padding: 20px;
            }

            .profile-card {
                flex-direction: column;
                text-align: center;
            }

            .guide-details {
                grid-template-columns: 1fr;
            }

            .guide-card {
                flex-direction: column;
                max-width: 100%;
            }

            .card-left {
                width: 100%;
                flex-direction: row;
                justify-content: space-around;
                padding: 15px;
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
            }

            .card-photo {
                margin-bottom: 0;
            }

            .skills-grid {
                grid-template-columns: 1fr;
            }

            .footer-content {
                flex-direction: column;
                text-align: center;
            }

            .logo {
                width: 50px;
                height: 50px;
            }

            .logo img {
                padding: 6px;
            }
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .container {
                box-shadow: none;
                margin: 0;
                border-radius: 0;
            }

            .header {
                background: #1e3c72 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .guide-card {
                background: white !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .skill-category {
                box-shadow: none;
                border: 1px solid #ddd;
            }

            .footer {
                background: #1e3c72 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }

        .body-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 32px;
            background: none;
            box-shadow: none;
            padding: 36px 0 24px 0;
        }

        .guide-info-block {
            width: 95%;
            background: transparent;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(30, 60, 114, 0.10);
            padding: 32px 36px 24px 36px;
            margin-bottom: 0;
        }

        .guide-info-header {
            display: flex;
            align-items: stretch;
            gap: 32px;
            height: 220px;
        }

        .guide-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .guide-avatar img {
            width: 66%;
            height: 66%;
            max-width: 320px;
            max-height: 320px;
            min-width: 100px;
            min-height: 100px;
            object-fit: cover;
            border-radius: 12px;
            border: none;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
            background: #fff;
        }

        .guide-status {
            margin-top: 10px;
            background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%);
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: 2px 16px;
            font-size: 0.98em;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .guide-info-main {
            flex: 1;
            margin-top: 8px;
        }

        .guide-name {
            font-size: 1.35em;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 2px;
        }

        .guide-role {
            font-size: 1em;
            color: #5a189a;
            margin-bottom: 16px;
        }

        .guide-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 16px 20px;
            width: 100%;
        }

        .guide-info-item {
            display: flex;
            align-items: flex-start;
            border-radius: 10px;
            padding: 12px 18px;
            font-size: 1em;
            min-height: 48px;
            box-sizing: border-box;
            background: transparent;
        }

        .guide-info-item i {
            color: #2a5298;
            margin-right: 10px;
            font-size: 1.1em;
            min-width: 20px;
            text-align: center;
            margin-top: 2px;
        }

        .guide-info-label {
            color: #222;
            margin-right: 6px;
            margin-bottom: 0;
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

        .card-info-block {
            width: 55%;
            display: flex;
            justify-content: center;
        }

        .card-bg {
            width: 420px;
            background: transparent;
            border-radius: 18px;
            box-shadow: 0 4px 24px rgba(30, 60, 114, 0.13);
            color: #fff;
            padding: 28px 32px 22px 32px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .card-photo-label {
            position: absolute;
            top: 16px;
            left: 18px;
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            font-size: 0.95em;
            border-radius: 8px;
            padding: 2px 12px;
            font-weight: 500;
            box-shadow: 0 1px 4px rgba(30, 60, 114, 0.08);
        }

        .card-title {
            font-size: 1.15em;
            font-weight: 700;
            margin-bottom: 18px;
            margin-top: 8px;
            letter-spacing: 1px;
            color: #1e3c72;;
        }

        .card-title span {
            font-size: 0.95em;
            font-weight: 400;
            opacity: 0.85;
            color: #5a189a;
        }

        .card-row {
            font-size: 1em;
            margin-bottom: 8px;
            display: flex;
            gap: 12px;
        }

        .card-row span {
            min-width: 90px;
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

        .card-qr {
            margin-top: 18px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .card-qr img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background: #fff;
            border-radius: 8px;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
        }

        .qr-label {
            font-size: 0.9em;
            color: #ffd600;
            margin-top: 6px;
            font-weight: 500;
            text-align: center;
        }

        .footer {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 22px 36px 0 36px;
            display: flex;
            flex-direction: column;
            align-items: stretch;
            font-size: 1em;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
        }

        .footer-left,
        .footer-right {
            min-width: 200px;
        }

        .footer p {
            margin-bottom: 6px;
            font-size: 1em;
        }

        .footer-bottom {
            text-align: center;
            padding: 10px 0 8px 0;
            font-size: 0.95em;
            opacity: 0.8;
            width: 100%;
            background: none;
            color: #fff;
        }

        @media (max-width: 900px) {
            .container {
                max-width: 100%;
            }

            .guide-info-block {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
                padding: 18px 12px;
            }

            .card-info-block {
                min-width: unset;
                max-width: 100%;
                align-items: center;
            }
        }

        .card-bg-flex {
            display: flex;
            flex-direction: row;
            align-items: stretch;
            width: 100%;
            min-height: 180px;
            padding: 0;
        }

        .card-col {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-qr-col {
            width: 120px;
            min-width: 120px;
            align-items: center;
            background: rgba(255, 255, 255, 0.06);
            border-top-left-radius: 18px;
            border-bottom-left-radius: 18px;
            padding: 24px 10px 24px 10px;
            position: relative;
        }

        .card-info-col {
            flex: 1;
            padding: 28px 32px 22px 24px;
            border-top-right-radius: 18px;
            border-bottom-right-radius: 18px;
            background: transparent;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-qr-img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            background: #fff;
            border-radius: 8px;
            border: 2px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
            margin: 8px 0 8px 0;
        }

        .qr-label-card {
            font-size: 0.95em;
            color: #ffd600;
            font-weight: 500;
            text-align: center;
            margin-bottom: 4px;
        }

        .card-photo-label {
            background: rgba(255, 255, 255, 0.18);
            color: #fff;
            font-size: 0.95em;
            border-radius: 8px;
            padding: 2px 12px;
            font-weight: 500;
            box-shadow: 0 1px 4px rgba(30, 60, 114, 0.08);
            margin-top: 8px;
            text-align: center;
        }

        @media (max-width: 600px) {
            .card-bg-flex {
                flex-direction: column;
                align-items: center;
            }

            .card-qr-col,
            .card-info-col {
                border-radius: 0 !important;
                padding: 16px 8px;
                width: 100%;
                min-width: unset;
            }

            .card-info-col {
                padding: 16px 8px;
            }

            .guide-avatar img {
                width: 90%;
                min-width: 80px;
                min-height: 80px;
            }
        }

        @media (max-width: 800px) {
            .guide-info-header {
                flex-direction: column;
                height: auto;
                gap: 18px;
            }

            .guide-avatar {
                margin-bottom: 18px;
            }

            .guide-info-grid {
                grid-template-columns: 1fr;
            }
        }

        .card-info-block,
        .card-bg,
        .card-info-col,
        .card-row,
        .card-row span,
        .card-row strong {
            min-width: 0;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        @media (max-width: 400px) {
            .card-bg {
                padding: 10px 4px;
                font-size: 0.95em;
            }

            .card-row {
                flex-direction: column;
                gap: 2px;
                align-items: flex-start;
            }

            .card-title {
                font-size: 1em;
            }
        }

        /* Placeholder styles */
        .header-logo-placeholder {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .avatar-placeholder {
            width: 90px;
            height: 110px;
            background: #f0f0f0;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
            color: #666;
            border: 2px solid #ddd;
        }

        .qr-placeholder {
            width: 80px;
            height: 80px;
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
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                @if(isset($guideData['logo']) && $guideData['logo'])
                    <img class="header-logo" src="{{ $guideData['logo'] }}" alt="logo" />
                @else
                    <div class="header-logo-placeholder">LOGO</div>
                @endif
                <div>
                    <div class="header-company">CÔNG TY DU LỊCH VIỆT NAM</div>
                    <div class="header-slogan">Vietnam Tourism Company</div>
                </div>
            </div>
            <div class="header-right">
                <!-- Có thể thêm thông tin khác nếu muốn -->
            </div>
        </div>
        <!-- Body -->
        <div class="body-card">
            <div class="guide-info-block">
                <div class="guide-info-header">
                    <div class="guide-avatar">
                        {{-- @if(isset($guideData['avatar']) && $guideData['avatar'])
                            <img src="{{ $guideData['avatar'] }}" alt="Ảnh hội viên" />
                        @else
                            <div class="avatar-placeholder">ẢNH</div>
                        @endif --}}
                        {{-- <div class="guide-status">
                            <i class="fa fa-check-circle"></i> Đang hoạt động
                        </div> --}}
                    </div>
                    <div class="guide-info-main">
                        <div class="guide-name">{{ $guideData['name'] ?? 'Họ tên' }}</div>
                        <div class="guide-role">Hướng dẫn viên Du lịch Quốc tế</div>
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
            <div class="card-info-block">
                <div class="card-bg card-bg-flex">
                    <div class="card-col card-qr-col">
                        {{-- @if(isset($guideData['qr']) && $guideData['qr'])
                            <img class="card-qr-img" src="{{ $guideData['qr'] }}" alt="QR xác minh" />
                        @else
                            <div class="qr-placeholder">QR</div>
                        @endif --}}
                        <div class="qr-label-card">Quét để xác minh</div>
                        {{-- <div class="card-photo-label">Ảnh thẻ</div> --}}
                    </div>
                    <div class="card-col card-info-col">
                        <div class="card-title">THẺ HƯỚNG DẪN VIÊN<br><span>Tour Guide Card</span></div>
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
        <!-- Footer -->
        <div class="footer">
            <div class="footer-content">
                <div class="footer-left">
                    <p><strong>Địa chỉ:</strong> 123 Nguyễn Huệ, Quận 1, TP.HCM</p>
                    <p><strong>Điện thoại:</strong> (028) 3822 1234</p>
                </div>
                <div class="footer-right">
                    <p><strong>Website:</strong> www.vietnamtourism.com</p>
                    <p><strong>Email:</strong> info@vietnamtourism.com</p>
                </div>
            </div>
            <div class="footer-bottom">
                © 2024 Công ty Du lịch Việt Nam. Tất cả quyền được bảo lưu.
            </div>
        </div>
    </div>
</body>

</html>
