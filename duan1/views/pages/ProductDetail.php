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
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="custom-alert <?= $_SESSION['message_type'] == 'error' ? 'alert-error' : 'alert-success' ?>">
                            <?= htmlspecialchars($_SESSION['message']) ?>
                        </div>
                        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
                    <?php endif; ?>
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
                                <input type="number" id="quantity" name="quantity" value="1">
                            </div>
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                            <button type="submit" class="primary-btn">Thêm vào giỏ hàng</button>
                        </form>
                        <!-- <div class="product__details__btns__option">
                            <a href="#"><i class="fa fa-heart"></i> Yêu thích</a>
                            <a href="#"><i class="fa fa-exchange"></i> So sánh</a>
                        </div> -->
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

<!-- Comment Section Begin -->
<section class="comment-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="comment-title">Bình luận</h3>

                <!-- Danh sách bình luận -->
                <div class="comment-list">
                    <?php if (!empty($comments)): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="comment-item">
                                <div class="comment-avatar">
                                    <!-- Avatar người dùng (có thể thêm sau nếu có cột avatar trong bảng users) -->
                                    <i class="fa fa-user-circle"></i>
                                </div>
                                <div class="comment-content">
                                    <div class="comment-author"><strong><?= htmlspecialchars($comment['username']) ?></strong></div>
                                    <div class="comment-date"><?= date('d/m/Y H:i', strtotime($comment['created_at'])) ?></div>
                                    <div class="comment-text"><?= nl2br(htmlspecialchars($comment['comment_text'])) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Chưa có bình luận nào cho sản phẩm này.</p>
                    <?php endif; ?>
                </div>
                <!-- PHÂN TRANG BÌNH LUẬN -->
                <?php if (($totalCommentPages ?? 1) > 1): ?>
                    <nav class="mt-3">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $totalCommentPages; $i++): ?>
                                <li class="page-item <?= ($i == ($commentPage ?? 1)) ? 'active' : '' ?>">
                                    <a class="page-link"
                                        href="?act=product-detail&id=<?= $product['id'] ?>&comment_page=<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>

                <!-- Form gửi bình luận -->
                <?php if (isset($_SESSION['user'])): // Chỉ hiển thị form nếu người dùng đã đăng nhập
                ?>
                    <div class="comment-form mt-4">
                        <h4>Viết bình luận của bạn</h4>
                        <form action="?act=add-comment" method="POST">
                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                            <div class="form-group">
                                <textarea name="comment_text" class="form-control" rows="4" placeholder="Nhập bình luận của bạn..." required></textarea>
                            </div>
                            <button type="submit" class="site-btn">Gửi bình luận</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p class="mt-4">Vui lòng <a href="?act=login">đăng nhập</a> để bình luận.</p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<!-- Comment Section End -->

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
                            <div class="product__item__pic" style="position:relative;overflow:hidden;">
                                <a href="?act=product-detail&id=<?= $item['id'] ?>">
                                    <img src="<?= !empty($item['image']) ? 'admin/' . htmlspecialchars($item['image']) : 'assets/img/no-image.jpg' ?>"
                                        alt="<?= htmlspecialchars($item['name']) ?>"
                                        style="width:100%;height:260px;object-fit:cover;border-radius:8px;">
                                    <span class="product__item__view-detail">Xem chi tiết</span>
                                </a>
                            </div>
                            <div class="product__item__text">
                                <h6 class="product-name"><?= htmlspecialchars($item['name']) ?></h6>
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

<style>
    .related .product__item__pic {
        position: relative;
        overflow: hidden;
    }

    .related .product__item__view-detail {
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        padding: 10px 0;
        background: rgba(229, 54, 55, 0.95);
        color: #fff;
        text-align: center;
        font-weight: 600;
        opacity: 0;
        transition: opacity 0.3s;
        z-index: 2;
        cursor: pointer;
        font-size: 16px;
    }

    .related .product__item__pic:hover .product__item__view-detail {
        opacity: 1;
    }

    .related .product__item__text {
        min-height: 60px;
        padding-top: 8px;
    }

    .related .product__item__text h6 {
        margin: 0 0 4px 0;
        font-size: 16px;
        font-weight: 600;
    }

    .related .product__item__text h5 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .related .product__item {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 14px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
        padding: 18px 12px 16px 12px;
        margin-bottom: 28px;
        transition: box-shadow 0.2s, border-color 0.2s;
    }

    .related .product__item:hover {
        box-shadow: 0 6px 24px rgba(229, 54, 55, 0.13);
        border-color: #e53637;
    }

    .comment-list {
        margin-top: 24px;
    }

    .comment-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        background: #fafbfc;
        border-radius: 10px;
        padding: 18px 20px 14px 20px;
        margin-bottom: 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .comment-avatar {
        font-size: 38px;
        color: #e53637;
        margin-top: 2px;
    }

    .comment-content {
        flex: 1;
    }

    .comment-author {
        font-weight: 600;
        font-size: 17px;
        margin-bottom: 2px;
    }

    .comment-date {
        font-size: 13px;
        color: #888;
        margin-bottom: 6px;
    }

    .comment-text {
        font-size: 15px;
        color: #222;
        line-height: 1.6;
    }

    /* Form bình luận */
    .comment-form {
        background: #f7f7f7;
        border-radius: 10px;
        padding: 22px 24px 18px 24px;
        margin-top: 32px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .comment-form h4 {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 14px;
    }

    .comment-form textarea.form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 15px;
        padding: 10px 12px;
        resize: vertical;
        margin-bottom: 12px;
    }

    .comment-form .site-btn {
        background: #e53637;
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 10px 28px;
        font-size: 16px;
        font-weight: 600;
        transition: background 0.2s;
    }

    .comment-form .site-btn:hover {
        background: #b91c1c;
    }

    .pagination .page-item .page-link {
        color: #e74c3c;
        background-color: #f5f5f5;
        border: 1px solid #e0e0e0;
        margin: 0 2px;
        border-radius: 8px;
        transition: background 0.2s, color 0.2s;
    }

    .pagination .page-item.active .page-link,
    .pagination .page-item .page-link:hover {
        background-color: #e74c3c;
        color: #fff;
        border-color: #e74c3c;
    }
</style>