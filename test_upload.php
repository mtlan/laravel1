<?php
// File test upload
require_once 'vendor/autoload.php';

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Test Upload File ===\n\n";

// Test tạo thư mục
$testDir = public_path('filedinhkem');
echo "Test thư mục: $testDir\n";

if (!file_exists($testDir)) {
    if (mkdir($testDir, 0775, true)) {
        echo "✓ Đã tạo thư mục\n";
    } else {
        echo "✗ Không thể tạo thư mục\n";
        exit(1);
    }
} else {
    echo "✓ Thư mục đã tồn tại\n";
}

// Test quyền ghi
if (is_writable($testDir)) {
    echo "✓ Thư mục có quyền ghi\n";
} else {
    echo "✗ Thư mục không có quyền ghi\n";
    if (chmod($testDir, 0775)) {
        echo "✓ Đã thay đổi quyền\n";
    } else {
        echo "✗ Không thể thay đổi quyền\n";
        exit(1);
    }
}

// Test tạo file
$testFile = $testDir . '/test.txt';
if (file_put_contents($testFile, 'test content')) {
    echo "✓ Có thể tạo file\n";
    unlink($testFile);
} else {
    echo "✗ Không thể tạo file\n";
    exit(1);
}

// Test copy file
$sourceFile = __FILE__;
$destFile = $testDir . '/test_copy.php';
if (copy($sourceFile, $destFile)) {
    echo "✓ Có thể copy file\n";
    unlink($destFile);
} else {
    echo "✗ Không thể copy file\n";
    exit(1);
}

echo "\n=== Test thành công ===\n";
echo "Thư mục upload sẵn sàng sử dụng!\n";
?> 