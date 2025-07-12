<?php
// File này chỉ để kiểm tra cấu hình PHP trên server
// Xóa file này sau khi kiểm tra xong

echo "<h2>PHP Upload Configuration</h2>";
echo "<table border='1'>";
echo "<tr><th>Setting</th><th>Value</th></tr>";
echo "<tr><td>upload_max_filesize</td><td>" . ini_get('upload_max_filesize') . "</td></tr>";
echo "<tr><td>post_max_size</td><td>" . ini_get('post_max_size') . "</td></tr>";
echo "<tr><td>max_execution_time</td><td>" . ini_get('max_execution_time') . "</td></tr>";
echo "<tr><td>max_input_time</td><td>" . ini_get('max_input_time') . "</td></tr>";
echo "<tr><td>memory_limit</td><td>" . ini_get('memory_limit') . "</td></tr>";
echo "<tr><td>file_uploads</td><td>" . (ini_get('file_uploads') ? 'On' : 'Off') . "</td></tr>";
echo "<tr><td>max_file_uploads</td><td>" . ini_get('max_file_uploads') . "</td></tr>";
echo "</table>";

echo "<h2>Directory Permissions</h2>";
$directories = [
    'public/filedinhkem' => 'filedinhkem',
    'public/livewire-tmp' => 'livewire-tmp',
    'storage/app/public' => 'storage/app/public',
    'storage/framework/cache' => 'storage/framework/cache',
    'storage/framework/sessions' => 'storage/framework/sessions',
    'storage/framework/views' => 'storage/framework/views',
];

echo "<table border='1'>";
echo "<tr><th>Directory</th><th>Exists</th><th>Writable</th><th>Permissions</th></tr>";

foreach ($directories as $path => $name) {
    $exists = file_exists($path) ? 'Yes' : 'No';
    $writable = is_writable($path) ? 'Yes' : 'No';
    $perms = file_exists($path) ? substr(sprintf('%o', fileperms($path)), -4) : 'N/A';
    
    echo "<tr><td>$name</td><td>$exists</td><td>$writable</td><td>$perms</td></tr>";
}
echo "</table>";

echo "<h2>PHP Version</h2>";
echo "PHP Version: " . phpversion();

echo "<h2>Extensions</h2>";
$required_extensions = ['fileinfo', 'gd', 'mbstring', 'openssl', 'pdo', 'tokenizer', 'xml'];
echo "<table border='1'>";
echo "<tr><th>Extension</th><th>Loaded</th></tr>";

foreach ($required_extensions as $ext) {
    $loaded = extension_loaded($ext) ? 'Yes' : 'No';
    echo "<tr><td>$ext</td><td>$loaded</td></tr>";
}
echo "</table>";
?> 