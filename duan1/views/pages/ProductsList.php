<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Shop</h4>
                    <div class="breadcrumb__links">
                        <a href="index.php">Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<?php
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 6;

// Debug thông tin phân trang
echo "<!-- Debug: Total Products = $totalProducts, Total Pages = $totalPages, Current Page = $page -->";
?>

<!-- Shop Section Begin -->
<section class="shop spad">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="shop__sidebar" style="padding-top: 30px;">
                    <!-- Search -->
                    <div class="shop__sidebar__search" style="margin-bottom: 30px;">
                        <form method="GET" action="">
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <button type="submit"><span class="icon_search"></span></button>
                        </form>
                    </div>
                    <!-- Category Filter -->
                    <div class="shop__sidebar__accordion" style="margin-bottom: 30px;">
                        <div class="accordion" id="accordionCategory">
                            <div class="card">
                                <div class="card-heading">
                                    <a data-toggle="collapse" data-target="#collapseCategory">Danh mục</a>
                                </div>
                                <div id="collapseCategory" class="collapse show" data-parent="#accordionCategory">
                                    <div class="card-body">
                                        <div class="shop__sidebar__categories">
                                            <ul class="nice-scroll">
                                                <li><a href="?<?= http_build_query(array_merge($_GET, ['category_id' => ''])) ?>">Tất cả</a></li>
                                                <?php foreach ($categories as $cat): ?>
                                                    <li>
                                                        <a href="?<?= http_build_query(array_merge($_GET, ['category_id' => $cat['id']])) ?>"
                                                            <?= (($_GET['category_id'] ?? '') == $cat['id']) ? 'style="font-weight:bold;"' : '' ?>>
                                                            <?= htmlspecialchars($cat['name']) ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Category Filter -->
                    <!-- <div class="shop__sidebar__color" style="margin-bottom: 30px;">
                        <h5 style="margin-bottom: 10px;">Lọc theo màu</h5>
                        <label class="color color-1" style="background: #000;" title="Đen">
                            <input type="radio" name="color" value="black" <?= (($_GET['color'] ?? '') == 'black') ? 'checked' : '' ?> onchange="this.form.submit()">
                        </label>
                        <label class="color color-2" style="background: #fff; border:1px solid #ccc;" title="Trắng">
                            <input type="radio" name="color" value="white" <?= (($_GET['color'] ?? '') == 'white') ? 'checked' : '' ?> onchange="this.form.submit()">
                        </label>
                        <label class="color color-3" style="background: #e53637;" title="Đỏ">
                            <input type="radio" name="color" value="red" <?= (($_GET['color'] ?? '') == 'red') ? 'checked' : '' ?> onchange="this.form.submit()">
                        </label>
                        <label class="color color-4" style="background: #4287f5;" title="Xanh">
                            <input type="radio" name="color" value="blue" <?= (($_GET['color'] ?? '') == 'blue') ? 'checked' : '' ?> onchange="this.form.submit()">
                        </label>
                    </div>
                    <div class="shop__sidebar__tags" style="margin-bottom: 30px;">
                        <h5 style="margin-bottom: 10px;">Tags</h5>
                        <a href="?<?= http_build_query(array_merge($_GET, ['tag' => 'ao-thun'])) ?>">Áo thun</a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['tag' => 'quan-jean'])) ?>">Quần jean</a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['tag' => 'so-mi'])) ?>">Sơ mi</a>
                        <a href="?<?= http_build_query(array_merge($_GET, ['tag' => 'phu-kien'])) ?>">Phụ kiện</a>
                    </div> -->
                </div>
            </div>
            <!-- End Sidebar -->

            <!-- Product List & Price Filter -->
            <div class="col-lg-9">
                <!-- Price Filter Top Right -->
                <div class="row" style="margin-bottom: 20px;">
                    <div class="col-lg-6 col-md-6 col-sm-6"></div>
                    <div class="col-lg-6 col-md-6 col-sm-6 d-flex justify-content-end">
                        <form method="GET" action="" class="form-inline" style="gap:10px;">
                            <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <input type="hidden" name="category_id" value="<?= htmlspecialchars($_GET['category_id'] ?? '') ?>">
                            <label for="price" style="margin-right:8px;">Lọc theo giá:</label>
                            <select name="price" id="price" class="form-control" style="min-width:180px;">
                                <option value="">Các mức giá</option>
                                <option value="0-100000" <?= (($_GET['price'] ?? '') == '0-100000') ? 'selected' : '' ?>>Dưới 100.000₫</option>
                                <option value="100000-300000" <?= (($_GET['price'] ?? '') == '100000-300000') ? 'selected' : '' ?>>100.000₫ - 300.000₫</option>
                                <option value="300000-500000" <?= (($_GET['price'] ?? '') == '300000-500000') ? 'selected' : '' ?>>300.000₫ - 500.000₫</option>
                                <option value="500000-1000000" <?= (($_GET['price'] ?? '') == '500000-1000000') ? 'selected' : '' ?>>500.000₫ - 1.000.000₫</option>
                                <option value="1000000-99999999" <?= (($_GET['price'] ?? '') == '1000000-99999999') ? 'selected' : '' ?>>Trên 1.000.000₫</option>
                            </select>
                            <button type="submit" class="btn btn-outline-dark btn-sm">Lọc</button>
                        </form>
                    </div>
                </div>
                <!-- End Price Filter -->

                <!-- Product List -->
                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic" style="position:relative;overflow:hidden;">
                                        <a href="?act=product-detail&id=<?= $product['id'] ?>">
                                            <img src="<?= !empty($product['image']) ? 'admin/' . htmlspecialchars($product['image']) : 'assets/img/no-image.jpg' ?>"
                                                alt="<?= htmlspecialchars($product['name']) ?>"
                                                style="width:100%;height:250px;object-fit:cover;border-radius:8px;">
                                            <span class="product__item__view-detail"
                                                style="position:absolute;left:0;right:0;bottom:0;padding:10px 0;background:rgba(229,54,55,0.95);color:#fff;text-align:center;font-weight:600;opacity:0;transition:opacity 0.3s;">
                                                Xem chi tiết
                                            </span>
                                        </a>
                                    </div>
                                    <div class="product__item__text" style="position:relative;">
                                        <h6 class="product-name"><?= htmlspecialchars($product['name']) ?></h6>
                                        <a href="?act=product-detail&id=<?= $product['id'] ?>" class="product-view-detail">Xem chi tiết</a>
                                        <h5><?= number_format($product['price'], 0, ',', '.') ?>₫</h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <p>Không tìm thấy sản phẩm phù hợp.</p>
                        </div>
                    <?php endif; ?>
                </div>
                <!-- Pagination -->
                <!-- Pagination -->
                <style>
                    .product__pagination {
                        padding-top: 25px;
                        text-align: center;
                    }

                    .product__pagination .pagination-btn {
                        display: inline-flex;
                        /* Sử dụng flex để căn giữa text */
                        justify-content: center;
                        /* Căn giữa theo chiều ngang */
                        align-items: center;
                        /* Căn giữa theo chiều dọc */
                        margin: 0 5px;
                        padding: 8px 12px;
                        /* Giảm padding để text vừa vặn */
                        border: 1px solid #ddd;
                        border-radius: 5px;
                        text-decoration: none;
                        font-size: 16px;
                        font-weight: 700;
                        color: #111111;
                        transition: background 0.3s, color 0.3s;
                        min-width: 60px;
                        /* Đặt kích thước tối thiểu để đồng đều */
                    }

                    .product__pagination .pagination-btn:hover:not([aria-disabled="true"]) {
                        background: #f0f0f0;
                    }

                    .product__pagination .pagination-btn.active {
                        background: #e53637;
                        color: #fff;
                        border-color: #e53637;
                    }

                    .product__pagination .pagination-btn[aria-disabled="true"] {
                        color: #999;
                        border-color: #eee;
                        cursor: not-allowed;
                        pointer-events: none;
                    }

                    .product__item {
                        background: #fff;
                        border: 1px solid #eee;
                        border-radius: 14px;
                        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
                        padding: 18px 12px 16px 12px;
                        margin-bottom: 28px;
                        transition: box-shadow 0.2s, border-color 0.2s;
                    }

                    .product__item:hover {
                        box-shadow: 0 6px 24px rgba(229, 54, 55, 0.13);
                        border-color: #e53637;
                    }

                    .product__item__pic img {
                        border-radius: 8px;
                    }

                    .product__item__pic:hover .product__item__view-detail {
                        opacity: 1;
                    }

                    .product__item__pic .product__item__view-detail {
                        opacity: 0;
                        transition: opacity 0.3s;
                    }

                    .product__item__text .product-view-detail {
                        display: none;
                        color: #e53637;
                        font-weight: 600;
                        margin-top: 4px;
                        transition: all 0.3s;
                    }

                    .product__item:hover .product-view-detail {
                        display: block;
                    }

                    select.form-control,
                    select {
                        min-width: 180px;
                        width: auto;
                        max-width: 100%;
                    }
                </style>
                <div class="product__pagination">
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => max(1, $page - 1)])) ?>"
                        class="pagination-btn"
                        aria-disabled="<?= $page <= 1 ? 'true' : 'false' ?>">
                        Trước
                    </a>
                    <?php
                    $range = 2;
                    $start = max(1, $page - $range);
                    $end = min($totalPages, $page + $range);

                    if ($start > 1) {
                        echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => 1])) . '" class="pagination-btn' . ($page == 1 ? ' active' : '') . '">1</a>';
                        if ($start > 2) echo '<span style="margin: 0 5px;">...</span>';
                    }

                    for ($i = $start; $i <= $end; $i++): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                            class="pagination-btn <?= ($i == $page) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php endfor;

                    if ($end < $totalPages) {
                        if ($end < $totalPages - 1) echo '<span style="margin: 0 5px;">...</span>';
                        echo '<a href="?' . http_build_query(array_merge($_GET, ['page' => $totalPages])) . '" class="pagination-btn' . ($page == $totalPages ? ' active' : '') . '">' . $totalPages . '</a>';
                    }
                    ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => min($totalPages, $page + 1)])) ?>"
                        class="pagination-btn"
                        aria-disabled="<?= $page >= $totalPages ? 'true' : 'false' ?>">
                        Sau
                    </a>
                </div>
            </div>
            <!-- End Product List -->
        </div>
    </div>
</section>
<!-- Shop Section End -->