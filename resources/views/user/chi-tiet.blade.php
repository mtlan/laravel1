@extends('layouts/app')
@section('space-work')
    <style>
        /* Font size control styles */
        .font-size-controls {
            border: 1px solid #dee2e6;
            transition: all 0.3s ease;
        }

        .font-size-controls:hover {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-group .btn {
            border-radius: 0;
        }

        .btn-group .btn:first-child {
            border-top-left-radius: 0.375rem;
            border-bottom-left-radius: 0.375rem;
        }

        .btn-group .btn:last-child {
            border-top-right-radius: 0.375rem;
            border-bottom-right-radius: 0.375rem;
        }
    </style>
    <main id="content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb u-breadcrumb  pt-3 px-0 mb-0 bg-transparent small">
                        <a class="breadcrumb-item" href="index.html">Trang chủ</a>&nbsp;&nbsp;&#187;&nbsp;&nbsp;
                        <span class="d-none d-md-inline">Chi tiết</span>&nbsp;&nbsp;&#187;&nbsp;&nbsp;
                        <span class="d-none d-md-inline">{{ $tinTuc->ten }}</span>
                    </div>
                </div>

                <div class="col-md-8">

                    <article
                        class="post-181 post type-post status-publish format-standard has-post-thumbnail hentry category-champions tag-soccer tag-winner"
                        id="post-181">

                        <!-- Font Size Controls -->
                        {{-- <div class="font-size-controls mb-3 p-3 bg-light rounded">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="fw-bold">Điều chỉnh cỡ chữ:</span>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="decrease-font-btn">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="reset-font-btn">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="increase-font-btn">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div> --}}

                        <header class="entry-header post-title">
                            <h1 class="entry-title display-4 display-2-lg mt-2" id="article-title">{{ $tinTuc->ten }}</h1>
                            <div class="entry-meta post-atribute mb-3 small fw-normal text-muted" id="article-meta">
                                <span class="byline me-2 me-md-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                        fill="currentColor" class="bi bi-person me-1" viewBox="0 0 16 16">
                                        <path
                                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z" />
                                    </svg> Đăng bởi
                                    <span class="author vcard"><a class="url fn n fw-bold" href="">Admin</a></span>
                                </span>
                                <span class="posted-on me-2 me-md-3">
                                    <span title="Posted on"><svg xmlns="http://www.w3.org/2000/svg" width="14"
                                            height="14" fill="currentColor" class="bi bi-pencil-square me-1"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd"
                                                d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg></span> <time class="entry-date published updated"
                                        datetime="2019-09-16T10:16:17+00:00">{{ $tinTuc->created_at->format('d/m/Y') }}</time></span>
                                <span class="me-2 me-md-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-eye me-1" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                                        </path>
                                        <path
                                            d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                                        </path>
                                    </svg> Lượt xem {{ $tinTuc->luotxem }}
                                </span>
                                <span class="me-2 me-md-3">
                                    <i class="bi bi-printer me-1"></i>
                                    <a href="javascript:void(0)" onclick="printArticle()"
                                        style="text-decoration: none; color: inherit;">In ấn</a>
                                </span>
                                <span class="me-2 me-md-3">
                                    <i class="bi bi-share me-1"></i>
                                    <span id="total-shares">{{ $tinTuc->luot_chia_se ?? 0 }}</span> lượt chia sẻ
                                </span>
                                {{-- <span class="me-2 me-md-3">
                                    Điều chỉnh cỡ chử
                                    <i class="bi bi-dash me-1"></i>
                                    <i class="bi bi-arrow-clockwise"></i>
                                    <i class="bi bi-plus"></i>
                                </span> --}}
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="decrease-font-btn">
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="reset-font-btn">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" id="increase-font-btn">
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </header>
                        <div class="entry-content post-content" id="article-content">
                            <figure class="image-single-wrapper">
                                <img width="750" height="500" src="{{ asset($tinTuc->hinhanh) }}" class="img-fluid"
                                    alt="" />
                            </figure>

                            {!! $tinTuc->noidung !!}

                        </div>
                        @if ($attachment = $tinTuc->attachments()->first())
                            <div class="mt-3">
                                <iframe
                                    src="{{ asset('frontend/vendor/pdfjs/web/viewer.html') }}?file={{ asset($attachment->url) }}"
                                    width="100%" height="600px"></iframe>
                            </div>
                        @endif
                        <footer class="entry-footer">
                            <div class="tags-links mb-3"><span class="fw-bold me-2">Danh mục</span>
                                @foreach ($tinTuc->chuyenMucs as $cm)
                                    <a href="{{ route('chuyen-muc', ['slug' => $cm->slug]) }}"
                                        rel="category tag">{{ $cm->ten }}</a>
                                @endforeach
                            </div>
                            <div class="tags-links tagcloud"><span class="fw-bold me-2">Từ khóa</span>
                                @if ($tinTuc->tukhoa)
                                    @foreach (explode(',', $tinTuc->tukhoa) as $tk)
                                        <a href="{{ route('tu-khoa', ['tukhoa' => $tk]) }}"
                                            rel="tag">{{ $tk }}</a>
                                    @endforeach
                                @endif
                            </div>
                        </footer>
                    </article>
                    <hr>
                    <!--social share-->

                    <div class="social-share mb-3">
                        <!-- share facebook -->
                        <a class="btn btn-light btn-sm blank-windows share-btn" data-platform="facebook"
                            data-article-id="{{ $tinTuc->id }}"
                            href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}&quote={{ urlencode($tinTuc->ten) }}"
                            target="_blank" rel="noopener" title="Chia sẻ lên Facebook"
                            onclick="handleShare(this, 'facebook'); return false;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" fill="currentColor"
                                class="bi bi-facebook" viewBox="0 0 16 16">
                                <path
                                    d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z" />
                            </svg>
                            <span class="d-none d-sm-inline">Facebook</span>
                        </a>
                        <!-- share twitter -->
                        <a class="btn btn-light btn-sm blank-windows"
                            href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($tinTuc->ten) }}"
                            target="_blank" rel="noopener" title="Share to twitter">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-twitter-x" viewBox="0 0 16 16">
                                <path
                                    d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
                            </svg>
                            <span class="d-none d-sm-inline">Twitter X</span>
                        </a>
                        <!-- share linkedin -->
                        <a class="btn btn-light btn-sm blank-windows"
                            href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}"
                            target="_blank" rel="noopener" title="Chia sẻ lên LinkedIn"
                            onclick="window.open(this.href, 'linkedin-share', 'width=580,height=296'); return false;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1rem" height="1rem" fill="currentColor"
                                viewBox="0 0 512 512">
                                <path
                                    d="M444.17,32H70.28C49.85,32,32,46.7,32,66.89V441.61C32,461.91,49.85,480,70.28,480H444.06C464.6,480,480,461.79,480,441.61V66.89C480.12,46.7,464.6,32,444.17,32ZM170.87,405.43H106.69V205.88h64.18ZM141,175.54h-.46c-20.54,0-33.84-15.29-33.84-34.43,0-19.49,13.65-34.42,34.65-34.42s33.85,14.82,34.31,34.42C175.65,160.25,162.35,175.54,141,175.54ZM405.43,405.43H341.25V296.32c0-26.14-9.34-44-32.56-44-17.74,0-28.24,12-32.91,23.69-1.75,4.2-2.22,9.92-2.22,15.76V405.43H209.38V205.88h64.18v27.77c9.34-13.3,23.93-32.44,57.88-32.44,42.13,0,74,27.77,74,87.64Z" />
                            </svg>
                            <span class="d-none d-sm-inline">LinkedIn</span>
                        </a>
                        <!-- share zalo -->
                        <a class="btn btn-light btn-sm blank-windows"
                            href="https://zalo.me/share?u={{ urlencode(request()->url()) }}&t={{ urlencode($tinTuc->ten) }}"
                            target="_blank" rel="noopener" title="Chia sẻ qua Zalo"
                            onclick="window.open(this.href, 'zalo-share', 'width=580,height=296'); return false;">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="1rem" height="1rem"
                                viewBox="0 0 50 50">
                                <path
                                    d="M 9 4 C 6.2504839 4 4 6.2504839 4 9 L 4 41 C 4 43.749516 6.2504839 46 9 46 L 41 46 C 43.749516 46 46 43.749516 46 41 L 46 9 C 46 6.2504839 43.749516 4 41 4 L 9 4 z M 9 6 L 15.576172 6 C 12.118043 9.5981082 10 14.323627 10 19.5 C 10 24.861353 12.268148 29.748596 15.949219 33.388672 C 15.815412 33.261195 15.988635 33.48288 16.005859 33.875 C 16.023639 34.279773 15.962689 34.835916 15.798828 35.386719 C 15.471108 36.488324 14.785653 37.503741 13.683594 37.871094 A 1.0001 1.0001 0 0 0 13.804688 39.800781 C 16.564391 40.352722 18.51646 39.521812 19.955078 38.861328 C 21.393696 38.200845 22.171033 37.756375 23.625 38.34375 A 1.0001 1.0001 0 0 0 23.636719 38.347656 C 26.359037 39.41176 29.356235 40 32.5 40 C 36.69732 40 40.631169 38.95117 44 37.123047 L 44 41 C 44 42.668484 42.668484 44 41 44 L 9 44 C 7.3315161 44 6 42.668484 6 41 L 6 9 C 6 7.3315161 7.3315161 6 9 6 z M 18.496094 6 L 41 6 C 42.668484 6 44 7.3315161 44 9 L 44 34.804688 C 40.72689 36.812719 36.774644 38 32.5 38 C 29.610147 38 26.863646 37.459407 24.375 36.488281 C 22.261967 35.634656 20.540725 36.391201 19.121094 37.042969 C 18.352251 37.395952 17.593707 37.689389 16.736328 37.851562 C 17.160501 37.246758 17.523335 36.600775 17.714844 35.957031 C 17.941109 35.196459 18.033096 34.45168 18.003906 33.787109 C 17.974816 33.12484 17.916946 32.518297 17.357422 31.96875 L 17.355469 31.966797 C 14.016928 28.665356 12 24.298743 12 19.5 C 12 14.177406 14.48618 9.3876296 18.496094 6 z M 32.984375 14.986328 A 1.0001 1.0001 0 0 0 32 16 L 32 25 A 1.0001 1.0001 0 1 0 34 25 L 34 16 A 1.0001 1.0001 0 0 0 32.984375 14.986328 z M 18 16 A 1.0001 1.0001 0 1 0 18 18 L 21.197266 18 L 17.152344 24.470703 A 1.0001 1.0001 0 0 0 18 26 L 23 26 A 1.0001 1.0001 0 1 0 23 24 L 19.802734 24 L 23.847656 17.529297 A 1.0001 1.0001 0 0 0 23 16 L 18 16 z M 29.984375 18.986328 A 1.0001 1.0001 0 0 0 29.162109 19.443359 C 28.664523 19.170123 28.103459 19 27.5 19 C 25.578848 19 24 20.578848 24 22.5 C 24 24.421152 25.578848 26 27.5 26 C 28.10285 26 28.662926 25.829365 29.160156 25.556641 A 1.0001 1.0001 0 0 0 31 25 L 31 22.5 L 31 20 A 1.0001 1.0001 0 0 0 29.984375 18.986328 z M 38.5 19 C 36.578848 19 35 20.578848 35 22.5 C 35 24.421152 36.578848 26 38.5 26 C 40.421152 26 42 24.421152 42 22.5 C 42 20.578848 40.421152 19 38.5 19 z M 27.5 21 C 28.340272 21 29 21.659728 29 22.5 C 29 23.340272 28.340272 24 27.5 24 C 26.659728 24 26 23.340272 26 22.5 C 26 21.659728 26.659728 21 27.5 21 z M 38.5 21 C 39.340272 21 40 21.659728 40 22.5 C 40 23.340272 39.340272 24 38.5 24 C 37.659728 24 37 23.340272 37 22.5 C 37 21.659728 37.659728 21 38.5 21 z">
                                </path>
                            </svg>
                            <span class="d-none d-sm-inline">Zalo</span>
                        </a>
                    </div><!-- social share -->
                    <hr>
                    <div class="related-post mb-4">

                        <div class="block-title-13">
                            <h4 class="h5 title-box-dot"><span>Bài viết liên quan</span></h4>
                            <div class="dot-line"></div>
                        </div>
                        <div class="row">
                            @foreach ($tinTucLienQuan as $lq)
                                <article class="col-6 col-md-4">
                                    <div class="card card-full hover-a mb-4">
                                        <!--thumbnail-->
                                        <div class="image-wrapper">
                                            <a href="detail.html">
                                                <img width="100%" height="129" src="{{ asset($lq->hinhanh) }}"
                                                    class="img-fluid" alt="" /> </a>
                                        </div>
                                        <div class="card-body">
                                            <div class="card-text mb-2 text-muted small">
                                                <time class="news-date"
                                                    datetime="2019-09-11">{{ $lq->created_at->format('d/m/Y') }}</time>
                                            </div>
                                            <h2 class="card-title h5"><a
                                                    href="{{ route('chiTietTin', ['slug' => $lq->slug]) }}">
                                                    {{ $lq->ten }}</a></h2>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>

                </div>


                @include('user.right-sidebar')
            </div>
        </div>
    </main>

    <script>
        // Font size control
        // Font size control variables
        let currentFontSize = 1;
        const minFontSize = 0.8;
        const maxFontSize = 2.0;
        const fontSizeStep = 0.1;

        // Elements to control font size
        const elements = {
            title: document.getElementById('article-title'),
            meta: document.getElementById('article-meta'),
            content: document.getElementById('article-content')
        };

        // Initialize font sizes from localStorage or default
        function initializeFontSizes() {
            const savedFontSize = localStorage.getItem('articleFontSize');
            if (savedFontSize) {
                currentFontSize = parseFloat(savedFontSize);
                applyFontSize();
            }
        }

        // Apply current font size to all elements
        function applyFontSize() {
            if (elements.title) {
                elements.title.style.fontSize = `${currentFontSize * 2.5}rem`;
            }
            if (elements.meta) {
                elements.meta.style.fontSize = `${currentFontSize * 0.875}rem`;
            }
            if (elements.content) {
                elements.content.style.fontSize = `${currentFontSize * 1}rem`;
            }

            // Save to localStorage
            localStorage.setItem('articleFontSize', currentFontSize.toString());
        }

        // Increase font size
        function increaseFontSize() {
            if (currentFontSize < maxFontSize) {
                currentFontSize += fontSizeStep;
                applyFontSize();
            }
        }

        // Decrease font size
        function decreaseFontSize() {
            if (currentFontSize > minFontSize) {
                currentFontSize -= fontSizeStep;
                applyFontSize();
            }
        }

        // Reset font size to default
        function resetFontSize() {
            currentFontSize = 1;
            applyFontSize();
        }

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', function() {
            initializeFontSizes();

            // Add event listeners to buttons
            const decreaseBtn = document.getElementById('decrease-font-btn');
            const resetBtn = document.getElementById('reset-font-btn');
            const increaseBtn = document.getElementById('increase-font-btn');
            const printBtn = document.getElementById('print-btn');

            if (decreaseBtn) {
                decreaseBtn.addEventListener('click', decreaseFontSize);
            }
            if (resetBtn) {
                resetBtn.addEventListener('click', resetFontSize);
            }
            if (increaseBtn) {
                increaseBtn.addEventListener('click', increaseFontSize);
            }
            if (printBtn) {
                printBtn.addEventListener('click', printArticle);
            }
        });

        // Print article function
        function printArticle() {
            // Get the article content
            const title = document.getElementById('article-title').innerText;
            const content = document.getElementById('article-content').innerHTML;

            // Create print window content
            const printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>${title}</title>
                    <meta charset="UTF-8">
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            line-height: 1.6;
                            margin: 20px;
                            color: #333;
                        }
                        .print-header {
                            text-align: center;
                            border-bottom: 2px solid #333;
                            padding-bottom: 10px;
                            margin-bottom: 20px;
                        }
                        .print-title {
                            font-size: 24px;
                            font-weight: bold;
                            margin-bottom: 10px;
                        }
                        .print-date {
                            font-size: 14px;
                            color: #666;
                            margin-bottom: 20px;
                        }
                        .print-content {
                            font-size: 16px;
                        }
                        .print-content img {
                            max-width: 100%;
                            height: auto;
                            margin: 10px 0;
                        }
                        @media print {
                            body { margin: 0; }
                            .no-print { display: none; }
                        }
                    </style>
                </head>
                <body>
                    <div class="print-header">
                        <div class="print-title">${title}</div>
                        <div class="print-date">Ngày đăng: ${new Date().toLocaleDateString('vi-VN')}</div>
                    </div>
                    <div class="print-content">
                        ${content}
                    </div>
                </body>
                </html>
            `;

            // Open print window
            const printWindow = window.open('', '_blank');
            printWindow.document.write(printContent);
            printWindow.document.close();

            // Wait for content to load then print
            setTimeout(() => {
                printWindow.focus(); // đảm bảo popup được kích hoạt
                printWindow.print();
                printWindow.close();
            }, 500);
        }

        // Share handling functions
        function handleShare(element, platform) {
            const articleId = element.getAttribute('data-article-id');
            const shareUrl = element.href;

            // Open share window
            const shareWindow = window.open(shareUrl, `${platform}-share`, 'width=580,height=296');

            // Track share in database
            trackShare(articleId, platform);

            // Update share count on page
            updateShareCount();
        }

        function trackShare(articleId, platform) {
            // Send AJAX request to track share
            fetch('/api/track-share', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        article_id: articleId,
                        platform: platform
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Share tracked successfully');
                    }
                })
                .catch(error => {
                    console.error('Error tracking share:', error);
                });
        }

        function updateShareCount() {
            const shareCountElement = document.getElementById('total-shares');
            if (shareCountElement) {
                const currentCount = parseInt(shareCountElement.textContent) || 0;
                shareCountElement.textContent = currentCount + 1;
            }
        }

        // Get Facebook share count (if needed)
        function getFacebookShareCount(url) {
            fetch(`https://graph.facebook.com/?id=${encodeURIComponent(url)}&fields=share`)
                .then(response => response.json())
                .then(data => {
                    if (data.share && data.share.share_count) {
                        console.log('Facebook shares:', data.share.share_count);
                        // You can update UI here if needed
                    }
                })
                .catch(error => {
                    console.error('Error getting Facebook share count:', error);
                });
        }
    </script>
@section('scripts')
    <script>
        var postId = {{ $tinTuc->id }};
        $.ajax({
            url: '{{ route('updateViews') }}',
            type: 'POST',
            data: {
                post_id: postId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // console.log('Lượt xem: ' + response.views);
            },
            error: function(xhr) {
                console.error('Cập nhật lượt xem thất bại');
            }
        });
    </script>
@endsection
@endsection
