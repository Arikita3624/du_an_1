<!-- Shop Details Section Begin -->
<section class="shop-details">
    <div class="product__details__pic">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product__details__breadcrumb">
                        <a href="?act=/">Home</a>
                        <a href="?act=product-list">Shop</a>
                        <span><?= htmlspecialchars($product['name']) ?></span>
                    </div>
                </div>
            </div>
            <div class="row">
                <!-- Ảnh nhỏ (nếu có nhiều ảnh thì lặp, ở đây chỉ 1 ảnh đại diện) -->
                <div class="col-lg-3 col-md-3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                <div class="product__thumb__pic">
                                    <img src="<?= !empty($product['image']) ? 'admin/' . htmlspecialchars($product['image']) : 'assets/img/no-image.jpg' ?>"
                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                        style="width:100px;height:100px;object-fit:cover;">
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Ảnh lớn -->
                <div class="col-lg-6 col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabs-1" role="tabpanel">
                            <div class="product__details__pic__item">
                                <img src="<?= !empty($product['image']) ? 'admin/' . htmlspecialchars($product['image']) : 'assets/img/no-image.jpg' ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                    style="width:100%;max-height:400px;object-fit:cover;">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Thông tin sản phẩm -->
                <div class="col-lg-3">
                    <div class="product__details__text">
                        <h4><?= htmlspecialchars($product['name']) ?></h4>
                        <div class="rating">
                            <!-- Nếu có rating thì hiển thị, nếu không thì bỏ -->
                        </div>
                        <h3><?= number_format($product['price'], 0, ',', '.') ?>₫</h3>
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                        <!-- filepath: c:\xampp\htdocs\Nhom4\duan1\views\pages\ProductDetail.php -->
                        <form method="post" action="?act=add-to-cart" class="product__details__cart__option" style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="quantity">
                                <div class="pro-qty">
                                    <input type="number" name="quantity" value="1" min="1" style="width: 60px; text-align: center;">
                                </div>
                            </div>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                            <button type="submit" class="primary-btn">Thêm vào giỏ hàng</button>
                        </form>
                        <div class="product__details__btns__option">
                            <a href="#"><i class="fa fa-heart"></i> Yêu thích</a>
                            <a href="#"><i class="fa fa-exchange"></i> So sánh</a>
                        </div>
                        <div class="product__details__last__option">
                            <ul>
                                <li><span>Danh mục:</span> <?= htmlspecialchars($product['category_id']) ?></li>
                                <li><span>Mã sản phẩm:</span> <?= htmlspecialchars($product['id']) ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tab mô tả, đánh giá, thông tin thêm -->
    <div class="product__details__content">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-8">
                    <div class="product__details__tab">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Mô tả</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                <div class="product__details__tab__content">
                                    <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                                </div>
                            </div>
                            <!-- Có thể bổ sung thêm tab đánh giá, thông tin khác nếu muốn -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- Shop Details Section End -->

<!-- Related Section Begin -->
<section class="related spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="related-title">Sản phẩm tương tự</h3>
            </div>
        </div>
        <div class="row">
            <?php if (!empty($relatedProducts)): ?>
                <?php foreach ($relatedProducts as $item): ?>
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="product__item">
                            <div class="product__item__pic">
                                <a href="?act=product-detail&id=<?= $item['id'] ?>">
                                    <img src="<?= !empty($item['image']) ? 'admin/' . htmlspecialchars($item['image']) : 'assets/img/no-image.jpg' ?>"
                                        alt="<?= htmlspecialchars($item['name']) ?>"
                                        style="width:100%;height:200px;object-fit:cover;">
                                </a>
                            </div>
                            <div class="product__item__text">
                                <h6><?= htmlspecialchars($item['name']) ?></h6>
                                <h5><?= number_format($item['price'], 0, ',', '.') ?>₫</h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p>Không có sản phẩm tương tự.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<!-- Related Product Section End -->