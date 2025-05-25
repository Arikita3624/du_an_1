    <!-- Offcanvas Menu Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="offcanvas-menu-wrapper">
        <div class="offcanvas__option">
            <div class="offcanvas__links">
                <a href="?act=login">Đăng nhập</a>
                <a href="#">Câu hỏi thường gặp</a>
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
            <p>Miễn phí vận chuyển, đảm bảo hoàn trả hoặc hoàn tiền trong 30 ngày.</p>
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
                                <h6>Bộ sưu tập mùa hè</h6>
                                <h2>Bộ sưu tập Thu - Đông 2024</h2>
                                <p>Thương hiệu chuyên tạo ra các sản phẩm thời trang cao cấp. Được sản xuất với cam kết về chất lượng xuất sắc.</p>
                                <a href="?act=product-list" class="primary-btn">Mua ngay <span class="arrow_right"></span></a>
                                <div class="hero__social">
                                    <a href="#"><i class="fa fa-facebook"></i></a>
                                    <a href="#"><i class="fa fa-twitter"></i></a>
                                    <a href="#"><i class="fa fa-pinterest"></i></a>
                                    <a href="#"><i class="fa fa-instagram"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Sản phẩm nổi bật</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $maxProducts = 8;
                $count = 0;
                if (!empty($products)):
                    foreach ($products as $product):
                        if ($count >= $maxProducts) break;
                ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="product__item">
                                <div class="product__item__pic">
                                    <img src="admin/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="product__item__text">
                                    <h6><?= htmlspecialchars($product['name']) ?></h6>
                                    <div><?= htmlspecialchars($product['category_name']) ?></div>
                                    <a href="?act=product-detail&id=<?= $product['id'] ?>" class="add-cart">Xem chi tiết</a>
                                    <h5><?= number_format($product['price'], 0, ',', '.') ?>₫</h5>
                                </div>
                            </div>
                        </div>
                    <?php
                        $count++;
                    endforeach;
                else: ?>
                    <div class="col-12">Không có sản phẩm nào.</div>
                <?php endif; ?>
            </div>

        </div>
    </section>

    <section class="product spad">
        <div class="container">
            <div class="row">
            <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Sản phẩm bán chạy</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $maxProducts = 8;
                $count = 0;
                if (!empty($products)):
                    foreach ($products as $product):
                        if ($count >= $maxProducts) break;
                ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="product__item">
                                <div class="product__item__pic">
                                    <img src="admin/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="product__item__text">
                                    <h6><?= htmlspecialchars($product['name']) ?></h6>
                                    <div><?= htmlspecialchars($product['category_name']) ?></div>
                                    <a href="?act=product-detail&id=<?= $product['id'] ?>" class="add-cart">Xem chi tiết</a>
                                    <h5><?= number_format($product['price'], 0, ',', '.') ?>₫</h5>
                                </div>
                            </div>
                        </div>
                    <?php
                        $count++;
                    endforeach;
                else: ?>
                    <div class="col-12">Không có sản phẩm nào.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="latest spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <span>Tin tức mới nhất</span>
                        <h2>Xu hướng thời trang mới</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php
                $maxProducts = 14;
                $count = 10;
                if (!empty($products)):
                    foreach ($products as $product):
                        if ($count >= $maxProducts) break;
                ?>
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="product__item">
                                <div class="product__item__pic">
                                    <img src="admin/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div class="product__item__text">
                                    <h6><?= htmlspecialchars($product['name']) ?></h6>
                                    <div><?= htmlspecialchars($product['category_name']) ?></div>
                                    <a href="?act=product-detail&id=<?= $product['id'] ?>" class="add-cart">Xem chi tiết</a>
                                    <h5><?= number_format($product['price'], 0, ',', '.') ?>₫</h5>
                                </div>
                            </div>
                        </div>
                    <?php
                        $count++;
                    endforeach;
                else: ?>
                    <div class="col-12">Không có sản phẩm nào.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch">+</div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Tìm kiếm tại đây.....">
            </form>
        </div>
    </div>
    <!-- Search End -->
    </body>