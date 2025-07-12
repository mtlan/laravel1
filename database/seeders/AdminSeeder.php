<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo role 'admin' nếu như chưa tồn tại
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // Tạo người dùng admin
        $adminUser = User::firstOrCreate(
            ['email' => 'boybet139@yahoo.com'],
            [
                'name' => 'Admin User', // Bạn có thể thay đổi tên này
                'password' => Hash::make('admin139'), // Thay 'your_strong_password' bằng một mật khẩu mạnh
            ]
        );

        // Gán role 'admin' cho người dùng
        if (!$adminUser->hasRole('admin')) {
            $adminUser->assignRole($adminRole);
        }

    }
}
