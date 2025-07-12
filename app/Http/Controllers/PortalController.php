<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index()
    {
        return view('portal/dashboard');
    }

    public function userList()
    {
        return view('portal.users');
    }

    public function roleList()
    {
        return view('portal.roles');
    }

    public function permissionList()
    {
        // dd(11110);
        return view('portal.permissions');
    }

    public function dmNgonNguList()
    {
        return view('portal.dm.ngon-ngu');
    }

    public function dmNoiCapTheList()
    {
        return view('portal.dm.noi-cap-the');
    }

    public function dmThoiHanTheList()
    {
        return view('portal.dm.thoi-han-the');
    }

    public function huongDanVienList()
    {
        return view('portal.huong-dan-vien');
    }

    public function theList()
    {
        return view('portal.the');
    }

    public function NgonNguList() {
        return view('portal.ngon-ngu');
    }

    public function ChuyenMucList() {
        return view('portal.chuyen-muc');
    }

    public function TuKhoaList() {
        return view('portal.tu-khoa');
    }

    public function TinTucList() {
        return view('portal.tin-tuc');
    }

    public function VideoList() {
        return view('portal.video');
    }

    public function BannerList() {
        return view('portal.banner');
    }

    public function ThuMucChaList() {
        return view('portal.thu-muc-cha');
    }

    public function ThuMucConList($slugCha) {
        return view('portal.thu-muc-con', compact('slugCha'));
    }

    public function ThuVienAnhList($slugCha, $slugCon) {
        return view('portal.thu-vien-anh', compact('slugCha', 'slugCon'));
    }

    public function yeuCauDangKyThongTinList() {
        return view('portal.yeu-cau-dang-ky-thong-tin');
    }

}
