<?php

namespace App\Http\Controllers;

use App\Models\ChuyenMuc;
use App\Models\HdvdlDangKyThongTin;
use App\Models\HdvdlDmNgonNgu;
use App\Models\HdvdlDmNoiCapThe;
use App\Models\HdvdlDmThoiHanThe;
use App\Models\HdvdlHuongDanVien;
use App\Models\PhotoGallery;
use App\Models\TinTuc;
use App\Models\Video;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class GuestController extends Controller
{
    public function index()
    {
        // Banner
        $banners = PhotoGallery::latest()->where('trangthai', 1)->where("children_id", 0)->where("daxoa", 0)->limit(3)->get();

        $chuyenMucs = ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        $tinTucs = TinTuc::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->paginate(5);

        // video nổi bật
        $videoNoiBat = Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first();
        $videos = Video::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->limit(3)->get();

        return view('user.home', compact('chuyenMucs', 'tinTucs', 'videoNoiBat', 'videos', 'banners'));
    }

    public function dangKyThongTin()
    {
        $dm_ngonngus = HdvdlDmNgonNgu::where('daxoa', 0)->orderBy('id', 'asc')->get();
        $dm_thoihanthes = HdvdlDmThoiHanThe::where('daxoa', 0)->orderBy('id', 'asc')->get();
        $dm_noicapthes = HdvdlDmNoiCapThe::where('daxoa', 0)->orderBy('id', 'asc')->get();

        return view('dang-ky-thong-tin', compact('dm_ngonngus', 'dm_thoihanthes', 'dm_noicapthes'));
    }

    public function submitDangKyThongTin(Request $request)
    {
        $request->validate([
            'ho_tenlot' => 'required',
            'ten' => 'required',
            'gioitinh' => 'required',
            'ngaysinh' => 'required',
            'sdt1' => 'required',
            'email1' => 'required|email',
            'cmnd_so' => 'required',
            'diachi' => 'required',
            'cmnd_ngaycap' => 'required',
            'cmnd_noicap' => 'required',
            'huongdan_tiengchinh' => 'required',
            'sothe' => 'required',
            'noicapthe_id' => 'required',
            'thoihanthe_id' => 'required',
        ], [
            'ho_tenlot.required' => 'Hãy nhập họ tên lót',
            'ten.required' => 'Hãy nhập tên',
            'gioitinh.required' => 'Hãy chọn giới tính',
            'ngaysinh.required' => 'Hãy nhập ngày sinh',
            'sdt1.required' => 'Hãy nhập số điện thoại',
            'email1.required' => 'Hãy nhập email',
            'email1.email' => 'Email không hợp lệ',
            'cmnd_so.required' => 'Hãy nhập số CMND',
            'diachi.required' => 'Hãy nhập địa chỉ',
            'cmnd_ngaycap.required' => 'Hãy nhập ngày cấp CMND',
            'cmnd_noicap.required' => 'Hãy nhập nơi cấp CMND',
            'huongdan_tiengchinh.required' => 'Hãy chọn ngôn ngữ hướng dẫn chính',
            'sothe.required' => 'Hãy nhập số thẻ',
            'noicapthe_id' => 'Hãy chọn nơi cấp thẻ',
            'thoihanthe_id' => 'Hãy chọn thời hạn thẻ',
        ]);

        // dd($request->all());

        try {
            $newThongTin = new HdvdlDangKyThongTin();
            $newThongTin->ho_tenlot = $request->get('ho_tenlot');
            $newThongTin->ten = $request->get('ten');
            $newThongTin->ngaysinh = $request->get('ngaysinh') ? Carbon::createFromFormat('d/m/Y', $request->get('ngaysinh'))->format('Y-m-d') : null;
            $newThongTin->gioitinh = $request->get('gioitinh');
            $newThongTin->sdt1 = $request->get('sdt1');
            $newThongTin->email1 = $request->get('email1');
            $newThongTin->cmnd_so = $request->get('cmnd_so');
            $newThongTin->diachi = $request->get('diachi');
            $newThongTin->cmnd_ngaycap = $request->get('cmnd_ngaycap') ? Carbon::createFromFormat('d/m/Y', $request->get('cmnd_ngaycap'))->format('Y-m-d') : null;
            $newThongTin->cmnd_noicap = $request->get('cmnd_noicap');
            $newThongTin->huongdan_tiengchinh = $request->get('huongdan_tiengchinh');
            $newThongTin->sothe = $request->get('sothe');
            $newThongTin->noicapthe_id = $request->get('noicapthe_id');
            $newThongTin->thoihanthe_id = $request->get('thoihanthe_id');
            $newThongTin->type = 'tao_moi';
            $newThongTin->trangthai = 'cho_phe_duyet';
            $newThongTin->daxoa = false;
            $newThongTin->save();

            session()->flash('guest_success', 'Đã yêu cầu đăng ký thông tin - thẻ hướng dẫn viên thành công, vui lòng đợi quản trị viên xác nhận và kiểm duyệt thông tin đăng ký!');

            return redirect()->route('home');
        } catch (Exception $e) {
            $errorMessage = 'Có lỗi xảy ra trong quá trình đăng ký thông tin - thẻ hướng dẫn viên, vui lòng thử lại sau!!';
            Log::error($errorMessage . ' Chi tiết: ' . $e->getMessage());
            // Thêm dòng này để gửi thông báo lỗi về view
            return redirect()->back()->withInput()->with('guest_error', $errorMessage);
        }
    }

    public function huongDanVienList()
    {
        return view('user.huong-dan-vien');
    }

    public function tinTucSuKien()
    {
        $chuyenMucs = ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();

        // video nổi bật
        $videoNoiBat = Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first();
        $videos = Video::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->limit(3)->get();

        return view('user.tin-tuc-su-kien', compact('chuyenMucs', 'videoNoiBat', 'videos'));
    }

    public function chuyenMucList($slug)
    {
        // Lấy danh sách chuyên mục
        $chuyenMucs = ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        // Lấy chuyên mục theo slug
        $chuyenMuc = ChuyenMuc::where('slug', $slug)->first();
        $tinTucs = $chuyenMuc->tinTucs()
            ->where('trangthai', 1) // ví dụ chỉ lấy bài đã duyệt
            ->where('daxoa', 0)
            // ->whereDate('created_at', '>=', now()->subDays(30)) // ví dụ bài trong 30 ngày gần đây
            ->latest()
            ->paginate(10);

        // video nổi bật
        $videoNoiBat = Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first();
        $videos = Video::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->limit(3)->get();

        return view('user.chuyen-muc', compact('chuyenMucs', 'chuyenMuc', 'tinTucs', 'videoNoiBat', 'videos'));
    }

    public function chiTietTin($slug)
    {
        $chuyenMucs = ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        $tinTuc = TinTuc::where('slug', $slug)->first();
        $tinTucLienQuan = TinTuc::where('trangthai', 1)->where('daxoa', 0)->where('id', '!=', $tinTuc->id)->orderBy('id', 'asc')->paginate(5);
        // $attachment = $tintuc->attachments()->first();

        // video nổi bật
        $videoNoiBat = Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first();
        $videos = Video::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->limit(3)->get();

        return view('user.chi-tiet', compact('chuyenMucs', 'tinTuc', 'tinTucLienQuan', 'videoNoiBat', 'videos'));
    }

    public function updateViews(Request $request)
    {
        $postId = $request->input('post_id');

        $post = TinTuc::find($postId);
        if ($post) {
            $post->luotxem = $post->luotxem + 1;
            $post->save();
            // $post->increment('luotxem'); // tăng 1 lượt xem
            return response()->json(['success' => true, 'views' => $post->luotxem]);
        }

        return response()->json(['success' => false, 'message' => 'Bài viết không tồn tại'], 404);
    }

    public function tuKhoaPage($tukhoa) {
        $chuyenMucs = ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        $tinTucs = TinTuc::where('trangthai', 1)
        ->where('daxoa', 0)
        ->where('tukhoa', 'like', '%' . $tukhoa . '%')
        ->orWhere('ten', 'like', '%' . $tukhoa . '%')
        ->orWhere('mota', 'like', '%' . $tukhoa . '%')
        ->orWhere('noidung', 'like', '%' . $tukhoa . '%')
        ->orderBy('id', 'asc')->paginate(10);
        // video nổi bật
        $videoNoiBat = Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first();
        $videos = Video::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->limit(3)->get();
        return view('user.tu-khoa', compact('chuyenMucs', 'tinTucs', 'videoNoiBat', 'videos','tukhoa'));
    }

    public function lienHe()
    {
        $chuyenMucs = ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        // video nổi bật
        $videoNoiBat = Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first();
        $videos = Video::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->limit(3)->get();

        return view('user.lien-he', compact('chuyenMucs', 'videoNoiBat', 'videos'));
    }


    public function exportThongTinTheHdv()
    {
        return view('portal.export.thong-tin-the-hdv');
    }

    public function GioiThieuPage($slug) {
        // Lấy danh sách chuyên mục
        $chuyenMucs = ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        // Lấy chuyên mục theo slug
        $chuyenMuc = ChuyenMuc::where('slug', $slug)->first();
        $tinTucs = $chuyenMuc->tinTucs()
            ->where('trangthai', 1) // ví dụ chỉ lấy bài đã duyệt
            ->where('daxoa', 0)
            // ->whereDate('created_at', '>=', now()->subDays(30)) // ví dụ bài trong 30 ngày gần đây
            ->latest()
            ->paginate(10);

        // video nổi bật
        $videoNoiBat = Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first();
        $videos = Video::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->limit(3)->get();
        return view('user.chuyen-muc', compact('chuyenMucs', 'chuyenMuc', 'tinTucs', 'videoNoiBat', 'videos'));
    }

    public function DichVuPage($slug) {
        // Lấy danh sách chuyên mục
        $chuyenMucs = ChuyenMuc::whereIn('type',[1, 2])->where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->get();
        // Lấy chuyên mục theo slug
        $chuyenMuc = ChuyenMuc::where('slug', $slug)->first();
        $tinTucs = $chuyenMuc->tinTucs()
            ->where('trangthai', 1) // ví dụ chỉ lấy bài đã duyệt
            ->where('daxoa', 0)
            // ->whereDate('created_at', '>=', now()->subDays(30)) // ví dụ bài trong 30 ngày gần đây
            ->latest()
            ->paginate(10);

        // video nổi bật
        $videoNoiBat = Video::where('trangthai', 1)->where('daxoa', 0)->inRandomOrder()->first();
        $videos = Video::where('trangthai', 1)->where('daxoa', 0)->orderBy('id', 'asc')->limit(3)->get();
        return view('user.chuyen-muc', compact('chuyenMucs', 'chuyenMuc', 'tinTucs', 'videoNoiBat', 'videos'));
    }

    public function ThuVien() {
        return view('user.thu-vien-anh', [
            'slugCha' => null,
            'slugCon' => null
        ]);
    }

    public function ThuVienConList($slugCha) {
        return view('user.thu-vien-anh', [
            'slugCha' => $slugCha,
            'slugCon' => null
        ]);
    }

    public function ThuVienAnhList($slugCha, $slugCon) {
        return view('user.thu-vien-anh', [
            'slugCha' => $slugCha,
            'slugCon' => $slugCon
        ]);
    }
}
