# Hướng dẫn khắc phục lỗi upload file PDF

## Vấn đề
Lỗi 422 "The files.0 failed to upload" khi upload file PDF trên server.

## Nguyên nhân có thể
1. Cấu hình PHP upload limits quá thấp
2. Quyền truy cập thư mục không đúng
3. Cấu hình Livewire temporary upload không đúng
4. Thiếu thư mục upload

## Các bước khắc phục

### 1. Chạy script sửa lỗi
```bash
php fix_upload_dirs.php
```

### 2. Test upload
```bash
php test_upload.php
```

### 3. Kiểm tra cấu hình server
Truy cập: `https://yourdomain.com/phpinfo.php`
Kiểm tra các giá trị:
- `upload_max_filesize`: Phải >= 10M
- `post_max_size`: Phải >= 10M  
- `max_execution_time`: Phải >= 300
- `memory_limit`: Phải >= 256M

### 3. Tạo thư mục cần thiết
```bash
mkdir -p public/filedinhkem
mkdir -p public/livewire-tmp
chmod 775 public/filedinhkem
chmod 775 public/livewire-tmp
```

### 4. Cấu hình .htaccess (đã cập nhật)
File `.htaccess` đã được cập nhật với cấu hình upload limits.

### 5. Cấu hình Livewire (đã cập nhật)
File `config/livewire.php` đã được cập nhật với rules đúng.

### 6. Clear cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### 7. Kiểm tra quyền storage
```bash
chmod -R 775 storage/
chmod -R 775 public/
```

### 8. Nếu vẫn lỗi, thử các giải pháp sau:

#### A. Tăng limits trong php.ini (nếu có quyền)
```ini
upload_max_filesize = 10M
post_max_size = 10M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

#### B. Thêm cấu hình trong .env
```env
LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK=real_public
LIVEWIRE_TEMPORARY_FILE_UPLOAD_RULES=["file","max:10240"]
```

#### C. Kiểm tra logs
```bash
tail -f storage/logs/laravel.log
```

### 9. Test upload
Sau khi thực hiện các bước trên, thử upload file PDF nhỏ (< 1MB) trước.

## Lưu ý quan trọng
1. Xóa file `phpinfo.php` sau khi kiểm tra xong
2. Đảm bảo server có đủ dung lượng ổ cứng
3. Kiểm tra firewall/security settings có chặn upload không
4. Nếu dùng shared hosting, liên hệ nhà cung cấp để tăng limits

## Debug thêm
Nếu vẫn lỗi, thêm logging vào component:
```php
Log::info('Upload attempt', [
    'file_size' => $this->filedinhkem ? $this->filedinhkem->getSize() : 0,
    'file_name' => $this->filedinhkem ? $this->filedinhkem->getClientOriginalName() : 'none'
]);
``` 