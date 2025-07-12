<?php
// Script kiểm tra và tạo thư mục upload
// Chạy script này trên server để đảm bảo các thư mục tồn tại và có quyền ghi

echo "=== Kiểm tra và tạo thư mục upload ===\n\n";

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
    
    if (is_writable($dir)) {
        echo "✓ Thư mục có quyền ghi: $dir\n";
    } else {
        echo "✗ Thư mục không có quyền ghi: $dir\n";
        // Thử thay đổi quyền
        if (chmod($dir, 0775)) {
            echo "✓ Đã thay đổi quyền thư mục: $dir\n";
        } else {
            echo "✗ Không thể thay đổi quyền thư mục: $dir\n";
        }
    }
    echo "\n";
}

echo "=== Kiểm tra cấu hình PHP ===\n";
echo "upload_max_filesize: " . ini_get('upload_max_filesize') . "\n";
echo "post_max_size: " . ini_get('post_max_size') . "\n";
echo "max_execution_time: " . ini_get('max_execution_time') . "\n";
echo "memory_limit: " . ini_get('memory_limit') . "\n";
echo "file_uploads: " . (ini_get('file_uploads') ? 'On' : 'Off') . "\n";

echo "\n=== Hoàn thành ===\n";
?> 