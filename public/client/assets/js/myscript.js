document.addEventListener('DOMContentLoaded', function () {
    const cookiePopup = document.getElementById('cookiePopup');
    const closeCookiePopup = document.getElementById('closeCookiePopup');

    // Kiểm tra nếu người dùng đã đóng thông báo cookie
    if (localStorage.getItem('cookiePopupClosed') === 'true') {
        cookiePopup.style.display = 'none';
    }

    // Xử lý sự kiện khi người dùng nhấn nút đóng
    closeCookiePopup.addEventListener('click', function () {
        cookiePopup.style.display = 'none';
        localStorage.setItem('cookiePopupClosed', 'true');
    });
});
