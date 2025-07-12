<?php
// Script sửa lỗi upload file
echo "=== Sửa lỗi upload file ===\n\n";

// Tạo thư mục cần thiết
$directories = [
    'public/filedinhkem',
    'public/livewire-tmp',
    'public/images',
    'storage/app/public',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
];

foreach ($directories as $dir) {
    echo "Kiểm tra thư mục: $dir\n";
    
    if (!file_exists($dir)) {
        if (mkdir($dir, 0775, true)) {
            echo "✓ Đã tạo thư mục: $dir\n";
        } else {
            echo "✗ Không thể tạo thư mục: $dir\n";
        }
    } else {
        echo "✓ Thư mục đã tồn tại: $dir\n";
    }
    
    // Đảm bảo quyền ghi
    if (file_exists($dir)) {
        if (!is_writable($dir)) {
            if (chmod($dir, 0775)) {
                echo "✓ Đã thay đổi quyền thư mục: $dir\n";
            } else {
                echo "✗ Không thể thay đổi quyền thư mục: $dir\n";
            }
        } else {
            echo "✓ Thư mục có quyền ghi: $dir\n";
        }
    }
    echo "\n";
}

// Kiểm tra file test
echo "=== Test tạo file ===\n";
$testFile = 'public/filedinhkem/test.txt';
if (file_put_contents($testFile, 'test')) {
    echo "✓ Có thể tạo file trong thư mục filedinhkem\n";
    unlink($testFile); // Xóa file test
} else {
    echo "✗ Không thể tạo file trong thư mục filedinhkem\n";
}

// Kiểm tra cấu hình PHP
echo "\n=== Cấu hình PHP ===\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_execution_time: " . ini_get('max_execution_time') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";

// Kiểm tra đường dẫn tuyệt đối
echo "\n=== Đường dẫn ===\n";
echo "public_path(): " . public_path() . "\n";
echo "storage_path(): " . storage_path() . "\n";
echo "base_path(): " . base_path() . "\n";

echo "\n=== Hoàn thành ===\n";
?> 