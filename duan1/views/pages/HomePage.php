<!-- Offcanvas Menu Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="offcanvas__option">
        <div class="offcanvas__links">
            <a href="#">Sign in</a>
            <a href="#">FAQs</a>
        </div>
        <div class="offcanvas__top__hover">
            <span>Usd <i class="arrow_carrot-down"></i></span>
            <ul>
                <li>USD</li>
                <li>EUR</li>
                <li>USD</li>
            </ul>
        </div>
    </div>
    <div class="offcanvas__nav__option">
        <a href="#" class="search-switch"><img src="assets/img/icon/search.png" alt=""></a>
        <a href="#"><img src="assets/img/icon/heart.png" alt=""></a>
        <a href="#"><img src="assets/img/icon/cart.png" alt=""> <span>0</span></a>
        <div class="price">$0.00</div>
    </div>
    <div id="mobile-menu-wrap"></div>
    <div class="offcanvas__text">
        <p>Free shipping, 30-day return or refund guarantee.</p>
    </div>
</div>
<!-- Offcanvas Menu End -->

<!-- Hero Section Begin -->
<section class="hero">
    <div class="hero__slider owl-carousel">
        <div class="hero__items set-bg" data-setbg="assets/img/hero/hero-1.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>Bộ sưu tập mua Hè</h6>
                            <h2>Bộ sưu tập Thu - Đông 2030</h2>
                            <p>Một nhãn hiệu chuyên nghiệp tạo ra những sản phẩm thiết yếu sang trọng.
                                Được chế tác có đạo đức với cam kết không ngừng
                                về chất lượng vượt trội.</p>
                            <a href="#" class="primary-btn">Mua ngay<span class="arrow_right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__items set-bg" data-setbg="assets/img/hero/hero-2.jpg">
            <div class="container">
                <div class="row">
                    <div class="col-xl-5 col-lg-7 col-md-8">
                        <div class="hero__text">
                            <h6>Bộ sưu tập mua Hè</h6>
                            <h2>Bộ sưu tập Thu - Đông 2030</h2>
                            <p>Một nhãn hiệu chuyên nghiệp tạo ra những sản phẩm thiết yếu sang trọng.
                                Được chế tác có đạo đức với cam kết không ngừng
                                về chất lượng vượt trội.</p>
                            <a href="#" class="primary-btn">Mua ngay <span class="arrow_right"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- Top Viewed Products Section Begin -->
<?php
$productModel = new ProductModels();
$topProducts = $productModel->getTopViews(4); // Lấy top 4 sản phẩm có lượt views cao nhất
?>
<section class="product spad" style="margin-top: 60px;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Top Sản Phẩm Xem Nhiều</h2>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($topProducts)): ?>
                <?php foreach ($topProducts as $product): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="product__item">
                            <div class="product__item__pic">
                                <img src="admin/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%;height:250px;object-fit:cover;border-radius:8px;">
                            </div>
                            <div class="product__item__text">
                                <h6><?= htmlspecialchars($product['name']) ?></h6>
                                <a href="?act=product-detail&id=<?= $product['id'] ?>" class="add-cart">Xem chi tiết</a>
                                <h5><?= number_format($product['price'], 0, ',', '.') ?>₫</h5>
                                <p>Lượt xem: <?= htmlspecialchars($product['views']) ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">Không có sản phẩm nào.</div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Top Viewed Products Section End -->

<!-- Product List Section Begin -->
<?php
$search = $_GET['search'] ?? '';
$price = $_GET['price'] ?? '';
$category_id = $_GET['category_id'] ?? '';
$page = max(1, intval($_GET['page'] ?? 1));
$limit = 12;
$offset = ($page - 1) * $limit;

$products = $productModel->getFiltered($search, $price, $category_id, $limit, $offset);
$totalProducts = $productModel->countFiltered($search, $price, $category_id);
$totalPages = ceil($totalProducts / $limit);

// Thêm category_name cho từng sản phẩm
$conn = connectDB();
foreach ($products as $key => $product) {
    $categoryId = $product['category_id'];
    $stmt = $conn->prepare('SELECT name FROM categories WHERE id = :id');
    $stmt->execute([':id' => $categoryId]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    $products[$key]['category_name'] = $category['name'] ?? 'Chưa phân loại';
}
?>
<section class="product spad">
    <div class="container">
        <!-- Pagination -->
        <style>
            .product__pagination {
                padding-top: 25px;
                text-align: center;
            }

            .product__pagination .pagination-btn {
                display: inline-flex;
                justify-content: center;
                align-items: center;
                margin: 0 5px;
                padding: 8px 12px;
                border: 1px solid #ddd;
                border-radius: 5px;
                text-decoration: none;
                font-size: 16px;
                font-weight: 700;
                color: #111111;
                transition: background 0.3s, color 0.3s;
                min-width: 60px;
                text-align: center;
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
        </style>
    </div>
</section>
<!-- Product List Section End -->

<!-- Latest Products Section Begin -->
<?php
$productModel = new ProductModels();
$latestProducts = $productModel->getLatest(8); // Lấy 8 sản phẩm mới nhất
$conn = connectDB();
foreach ($latestProducts as $key => $product) {
    $categoryId = $product['category_id'];
    $stmt = $conn->prepare('SELECT name FROM categories WHERE id = :id');
    $stmt->execute([':id' => $categoryId]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    $latestProducts[$key]['category_name'] = $category['name'] ?? 'Chưa phân loại';
}
?>
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="section-title">Sản Phẩm Mới Nhất</h2>
            </div>
        </div>
        <?php if (!empty($latestProducts)): ?>
            <?php foreach (array_chunk($latestProducts, 4) as $rowProducts): ?>
                <div class="row">
                    <?php foreach ($rowProducts as $product): ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="product__item">
                                <div class="product__item__pic">
                                    <img src="admin/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%;height:250px;object-fit:cover;border-radius:8px;">
                                </div>
                                <div class="product__item__text">
                                    <h6><?= htmlspecialchars($product['name']) ?></h6>
                                    <div><?= htmlspecialchars($product['category_name']) ?></div>
                                    <a href="?act=product-detail&id=<?= $product['id'] ?>" class="add-cart">Xem chi tiết</a>
                                    <h5><?= number_format($product['price'], 0, ',', '.') ?>₫</h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">Không có sản phẩm nào.</div>
        <?php endif; ?>
    </div>
</section>
<!-- Latest Products Section End -->

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search End -->

<section class="instagram spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="instagram__pic">
                    <div class="instagram__pic__item set-bg" data-setbg="assets/img/instagram/instagram-1.jpg"></div>
                    <div class="instagram__pic__item set-bg" data-setbg="assets/img/instagram/instagram-2.jpg"></div>
                    <div class="instagram__pic__item set-bg" data-setbg="assets/img/instagram/instagram-3.jpg"></div>
                    <div class="instagram__pic__item set-bg" data-setbg="assets/img/instagram/instagram-4.jpg"></div>
                    <div class="instagram__pic__item set-bg" data-setbg="assets/img/instagram/instagram-5.jpg"></div>
                    <div class="instagram__pic__item set-bg" data-setbg="assets/img/instagram/instagram-6.jpg"></div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="instagram__text">
                    <h2>Instagram</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                        labore et dolore magna aliqua.</p>
                    <h3>#Male_Fashion</h3>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Instagram Section End -->

<!-- Latest Blog Section Begin -->
<section class="latest spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Latest News</span>
                    <h2>Fashion New Trends</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic set-bg" data-setbg="assets/img/blog/blog-1.jpg"></div>
                    <div class="blog__item__text">
                        <span><img src="assets/img/icon/calendar.png" alt=""> 16 February 2020</span>
                        <h5>What Curling Irons Are The Best Ones</h5>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic set-bg" data-setbg="assets/img/blog/blog-2.jpg"></div>
                    <div class="blog__item__text">
                        <span><img src="assets/img/icon/calendar.png" alt=""> 21 February 2020</span>
                        <h5>Eternity Bands Do Last Forever</h5>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6">
                <div class="blog__item">
                    <div class="blog__item__pic set-bg" data-setbg="assets/img/blog/blog-3.jpg"></div>
                    <div class="blog__item__text">
                        <span><img src="assets/img/icon/calendar.png" alt=""> 28 February 2020</span>
                        <h5>The Health Benefits Of Sunglasses</h5>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Latest Blog Section End -->
</body>

<style>
    .section-title {
        margin-top: 20px !important;
        margin-bottom: 20px !important;
    }

    section.spad {
        padding-top: 20px !important;
        padding-bottom: 20px !important;
    }
</style>