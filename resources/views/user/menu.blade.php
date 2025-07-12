<div id="navbarNavDropdown" class="collapse navbar-collapse hover-mode">
    <ul id="menu-primary-menu" class="main-nav navbar-uppercase navbar-nav navbar-end ms-auto">
        <li
            class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home active nav-item">
            <a title="Home" href="{{ route('home') }}" class="nav-link">Trang chủ</a>
        </li>
        <li
            class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children dropdown mega-dropdown nav-item">
            <a title="Champions" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                class="nav-link" id="menu-item-dropdown-13">Giới thiệu</a>
            <ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-13" role="menu">
                @foreach($chuyenMucGioiThieus as $gt)
                
                @endforeach
            </ul>
        </li>
        <li>
            <a href="{{ route('huong.dan.vien.list') }}" class="nav-link">Thành viên</a>
        </li>
        <li>
            <a href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link"
                id="menu-item-dropdown-15">Dịch vụ</a>
            <ul class="dropdown-menu" aria-labelledby="menu-item-dropdown-15" role="menu">
                <li>
                    <a href="#" class="dropdown-item">Khách sạn</a>
                </li>
                <li>
                    <a href="#" class="dropdown-item">Nhà hàng</a>
                </li>
                <li>
                    <a href="#" class="dropdown-item">Điểm tham quan</a>
                </li>
                <li>
                    <a href="#" class="dropdown-item">Vận chuyển</a>
                </li>
                <li>
                    <a href="#" class="dropdown-item">Dịch vụ khác</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('tinTucSuKien') }}" class="nav-link">Tin tức - Sự kiện</a>
        </li>

        <li>
            <a href="{{ route('thu-vien') }}" class="nav-link">Thư viện ảnh</a>
        </li>

        <li>
            <a href="#" class="nav-link">Tuyển dụng</a>
        </li>
        <li>
            <a href="{{ route('lienHe') }}" class="nav-link">Liên hệ</a>
        </li>
    </ul>
</div>
