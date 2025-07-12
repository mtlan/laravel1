<div x-data="{ keyword: '' }" class="container py-4">
    <input type="text" class="form-control mb-4" placeholder="Tìm thư mục..." x-model="keyword">

    <div class="row g-3">
        <template x-for="folder in @js($folders).filter(f => f.toLowerCase().includes(keyword.toLowerCase()))" :key="folder">
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="folder-card text-center border rounded p-3">
                    <img src="https://img.icons8.com/fluency/96/folder-invoices.png" class="folder-icon" style="max-width: 80px;">
                    <div class="folder-name mt-2" x-text="folder" style="font-size: 14px;"></div>
                </div>
            </div>
        </template>
    </div>
</div>
