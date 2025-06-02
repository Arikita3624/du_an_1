<!-- Shop Details Section Begin -->
<style>
    /* Ảnh lớn */
    .product__details__pic__item img {
        max-height: 500px !important;
        height: 500px;
        object-fit: cover;
        border-radius: 10px;
    }
    /* Ảnh nhỏ */
    .product__thumb__pic img {
        width: 120px !important;
        height: 120px !important;
        object-fit: cover;
        border-radius: 8px;
    }
    /* Ảnh sản phẩm tương tự */
    .related .product__item__pic img {
        height: 260px !important;
        max-height: 260px;
        object-fit: cover;
        border-radius: 8px;
    }
    /* Số lượng */
    .product__details__cart__option .quantity-row {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 10px;
    }
    .product__details__cart__option label {
        font-weight: 500;
        margin-bottom: 0;
        display: inline-block;
        min-width: 80px;
        text-align: left;
        font-size: 18px;
    }
    .product__details__cart__option input[type="number"] {
        width: 70px;
        text-align: center;
        font-size: 16px;
        padding: 6px 0;
        border-radius: 6px;
        border: 1px solid #ccc;
    }
</style>
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
                <!-- Ảnh nhỏ -->
                <div class="col-lg-3 col-md-3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                <div class="product__thumb__pic">
                                    <img src="<?= !empty($product['image']) ? 'admin/' . htmlspecialchars($product['image']) : 'assets/img/no-image.jpg' ?>"
                                        alt="<?= htmlspecialchars($product['name']) ?>">
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
                                    alt="<?= htmlspecialchars($product['name']) ?>">
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
                        <form method="post" action="?act=add-to-cart" class="product__details__cart__option">
                            <div class="quantity-row">
                                <label for="quantity">Số lượng tồn kho: <?= htmlspecialchars($product['stock']) ?></label>
                                <input type="number" id="quantity" name="quantity" value="1" min="1">
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
                                <li><span>Danh mục:</span> <?= htmlspecialchars($product['category_name']) ?></li>
                                <!-- Đã xóa mã sản phẩm -->
                            </ul>
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
                                        style="width:100%;height:260px;object-fit:cover;border-radius:8px;">
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