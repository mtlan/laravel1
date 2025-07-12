<main id="content">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb u-breadcrumb pt-3 px-0 mb-0 bg-transparent small">
                    <a class="breadcrumb-item" href="{{route('home')}}">Trang chủ</a>&nbsp;&nbsp;&#187;&nbsp;&nbsp;
                    <span class="d-none d-md-inline">Thư viện ảnh</span>
                </div>
            
                <div class="row">
                    <div class="col-md-8 py-4">
                        {{-- Ô tìm kiếm --}}
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control mb-4" placeholder="Tìm kiếm...">
            
                        {{-- TH1: Không có slugCha => hiển thị thư mục cha --}}
                        @if (!$slugCha && !$slugCon)
                            <div class="row g-3">
                                @foreach($thuMucChas as $thuMucCha)
                                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                        <div class="folder-card text-center border rounded p-3">
                                            <a href="{{ route('thu-vien-con', $thuMucCha->slug) }}">
                                                <img src="https://img.icons8.com/fluency/96/folder-invoices.png" class="folder-icon" style="max-width: 80px;">
                                                <div class="folder-name mt-2">{{ $thuMucCha->ten }}</div>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4">{{ $thuMucChas->links() }}</div>
                        @endif
            
                        {{-- TH2: Có slugCha, không có slugCon => hiển thị thư mục con hoặc ảnh trong thư mục cha --}}
                        @if ($slugCha && !$slugCon)
                            @if (isset($hinhanhs))
                                {{-- Hiển thị ảnh trong thư mục cha --}}
                                <h5 class="mb-3">Ảnh trong thư mục: {{ $thuMucCha->ten }}</h5>
                                <div class="row g-3">
                                    @forelse ($hinhanhs as $anh)
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <div class="card">
                                                <a data-fancybox="gallery" href="{{ asset($anh->url) }}">
                                                    <img src="{{ asset($anh->url) }}" class="card-img-top" alt="{{ $anh->ten }}">
                                                    <div class="card-body">
                                                        <p class="card-text small">{{ $anh->ten }}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    @empty
                                        <p>Không có ảnh nào trong thư mục này.</p>
                                    @endforelse
                                </div>
                                <div class="mt-4">{{ $hinhanhs->links() }}</div>
                            @elseif (isset($thuMucCons))
                                {{-- Hiển thị thư mục con --}}
                                <h5 class="mb-3">Thư mục con của: {{ $thuMucCha->ten }}</h5>
                                <div class="row g-3">
                                    @foreach($thuMucCons as $thuMucCon)
                                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                            <div class="folder-card text-center border rounded p-3">
                                                <a href="{{ route('thu-vien-anh', [$thuMucCha->slug, $thuMucCon->slug]) }}">
                                                    <img src="https://img.icons8.com/fluency/96/opened-folder.png" class="folder-icon" style="max-width: 80px;">
                                                    <div class="folder-name mt-2">{{ $thuMucCon->ten }}</div>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4">{{ $thuMucCons->links() }}</div>
                            @endif
                        @endif
            
                        {{-- TH3: Có cả slugCha và slugCon => hiển thị ảnh --}}
                        @if ($slugCha && $slugCon && isset($hinhanhs))
                            <h5 class="mb-3">Ảnh trong thư mục: {{ $thuMucCon->ten }}</h5>
                            <div class="row g-3">
                                @forelse ($hinhanhs as $anh)
                                    <div class="col-6 col-sm-4 col-md-3">
                                        <div class="card">
                                            <a data-fancybox="gallery" href="{{ asset($anh->url) }}">
                                                <img src="{{ asset($anh->url) }}" class="card-img-top" alt="{{ $anh->ten }}">
                                                <div class="card-body">
                                                    <p class="card-text small">{{ $anh->ten }}</p>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <p>Không có ảnh nào trong thư mục này.</p>
                                @endforelse
                            </div>
                            <div class="mt-4">{{ $hinhanhs->links() }}</div>
                        @endif
                    </div>
            
                    {{-- Sidebar --}}
                    @include('user.right-sidebar')
                </div>
            </div>
            
        </div>
</main>