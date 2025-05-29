    <!-- Shop Details Section Begin -->
    <section class="shop-details">
        <div class="product__details__pic">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__breadcrumb">
                            <a href="?act=/">Trang chủ</a>
                            <a href="?act=product-list">Cửa hàng</a>
                            <span><?php echo htmlspecialchars($product['name']); ?></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-md-3">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">
                                    <div class="product__thumb__pic set-bg" data-setbg="admin/<?php echo htmlspecialchars($product['image']); ?>">
                                    </div>
                                </a>
                            </li>
                            <!-- Add more tabs for additional images if available -->
                             <?php /*
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">
                                    <div class="product__thumb__pic set-bg" data-setbg="assets/img/shop-details/thumb-2.png">
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-3" role="tab">
                                    <div class="product__thumb__pic set-bg" data-setbg="assets/img/shop-details/thumb-3.png">
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#tabs-4" role="tab">
                                    <div class="product__thumb__pic set-bg" data-setbg="assets/img/shop-details/thumb-4.png">
                                        <i class="fa fa-play"></i>
                                    </div>
                                </a>
                            </li>
                             */ ?>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tabs-1" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="admin/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                                </div>
                            </div>
                            <!-- Add more panes for additional images if available -->
                            <?php /*
                            <div class="tab-pane" id="tabs-2" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="assets/img/shop-details/product-big-3.png" alt="">
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-3" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="assets/img/shop-details/product-big.png" alt="">
                                </div>
                            </div>
                            <div class="tab-pane" id="tabs-4" role="tabpanel">
                                <div class="product__details__pic__item">
                                    <img src="assets/img/shop-details/product-big-4.png" alt="">
                                    <a href="https://www.youtube.com/watch?v=8PJ3_p7VqHw&amp;list=RD8PJ3_p7VqHw&amp;start_radio=1" class="video-popup"><i class="fa fa-play"></i></a>
                                </div>
                            </div>
                            */ ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product__details__content">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="product__details__text">
                            <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                            <div class="rating">
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star-o"></i>
                                <span> - 0 đánh giá</span> <?php /* TODO: Implement reviews */ ?>
                            </div>
                            <h3><?php echo number_format($product['price'], 0, ',', '.'); ?>₫ <?php if ($product['discount_price'] < $product['price']) { ?><span><?php echo number_format($product['discount_price'], 0, ',', '.'); ?>₫</span><?php } ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                            <div class="product__details__option">
                            </div>
                            <div class="product__details__cart__option">
                                <form action="?act=add-to-cart" method="POST" class="d-flex align-items-center justify-content-center">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                    <div class="quantity">
                                        <div class="pro-qty">
                                            <input type="text" name="quantity" value="1" min="1" id="quantityInput">
                                        </div>
                                    </div>
                                    <button type="submit" class="primary-btn">Thêm vào giỏ hàng</button>
                                </form> <?php /* TODO: Implement add to cart */ ?>
                            </div>
                            <div class="product__details__btns__option">
                                <a href="#"><i class="fa fa-heart"></i> Thêm vào danh sách yêu thích</a> <?php /* TODO: Implement wishlist */ ?>
                                <a href="#"><i class="fa fa-exchange"></i> Thêm vào so sánh</a> <?php /* TODO: Implement compare */ ?>
                            </div>
                            <div class="product__details__last__option">
                                <h5><span>Thanh toán an toàn được đảm bảo</span></h5>
                                <?php /* TODO: Add payment icons */ ?>
                                <ul>
                                    <li><span>Mã sản phẩm:</span> <?php echo htmlspecialchars($product['id']); ?></li>
                                    <li><span>Danh mục:</span> <?php echo htmlspecialchars($product['category_name']); ?></li>
                                    <?php /* TODO: Implement tags */ ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product__details__tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#tabs-5" role="tab">Mô tả</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-6" role="tab">Customer
                                    Đánh giá(0)</a> <?php /* TODO: Implement reviews */ ?>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#tabs-7" role="tab">Thông tin bổ sung</a> <?php /* TODO: Implement additional info */ ?>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tabs-5" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                                        <div class="product__details__tab__content__item">
                                            <?php /* TODO: Add more detailed product info if available */ ?>
                                        </div>
                                        <div class="product__details__tab__content__item">
                                            <?php /* TODO: Add material info if available */ ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-6" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <?php /* TODO: Implement customer reviews */ ?>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabs-7" role="tabpanel">
                                    <div class="product__details__tab__content">
                                        <?php /* TODO: Implement additional information */ ?>
                                    </div>
                                </div>
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
                    <h3 class="related-title">Sản phẩm liên quan</h3> <?php /* TODO: Implement logic to fetch related products */ ?>
                </div>
            </div>
            <div class="row">
                <?php if (!empty($relatedProducts)): ?>
                    <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="admin/<?php echo htmlspecialchars($relatedProduct['image']); ?>">
                                    <?php /* TODO: Add logic for 'New' or 'Sale' label if applicable */ ?>
                                    <ul class="product__hover">
                                        <li><a href="#"><i class="fa fa-heart"></i></a></li> <?php /* TODO: Implement wishlist */ ?>
                                        <li><a href="#"><i class="fa fa-retweet"></i> <span>So sánh</span></a></li> <?php /* TODO: Implement compare */ ?>
                                        <li><a href="?act=product-detail&id=<?php echo $relatedProduct['id']; ?>" title="Xem chi tiết"><i class="fa fa-search"></i></a></li> <?php /* View Detail Link */ ?>
                                        <li><a href="#" title="Thêm vào giỏ hàng"><i class="fa fa-shopping-cart"></i></a></li> <?php /* TODO: Implement add to cart */ ?>
                                    </ul>
                                </div>
                                <div class="product__item__text">
                                    <h6><a href="?act=product-detail&id=<?php echo $relatedProduct['id']; ?>"><?php echo htmlspecialchars($relatedProduct['name']); ?></a></h6> <?php /* Link on product name */ ?>
                                    <h5><?php echo number_format($relatedProduct['price'], 0, ',', '.'); ?>₫</h5> <?php /* TODO: Display discount price if applicable */ ?>
                                    <?php /* TODO: Implement rating display if available */ ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">Không có sản phẩm liên quan nào.</div>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Related Product Section End -->

    <style>
        /* Custom CSS for Product Detail Page */

        .shop-details {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .product__details__pic__item img {
            width: 100%; /* Make image responsive */
            height: auto;
        }

        .product__details__text h4 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #333;
        }

        .product__details__text .rating i {
            color: #ffc107; /* Star color */
        }

        .product__details__text h3 {
            font-size: 28px;
            color: #e44; /* Price color */
            margin-bottom: 20px;
        }

        .product__details__text h3 span {
            font-size: 18px;
            color: #888; /* Original price color */
            text-decoration: line-through;
            margin-left: 10px;
        }

        .product__details__text p {
            margin-bottom: 25px;
            line-height: 1.6;
            color: #555;
        }

        .product__details__cart__option {
            margin-bottom: 30px;
        }

        .product__details__cart__option .quantity {
            margin-right: 20px;
        }

        .product__details__cart__option .pro-qty input {
            width: 60px;
            text-align: center;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
        }

        .product__details__cart__option .primary-btn {
            background-color: #e44;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product__details__cart__option .primary-btn:hover {
            background-color: #d43a3a;
        }

        .product__details__btns__option a {
            display: inline-block;
            margin-right: 20px;
            color: #555;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .product__details__btns__option a i {
            margin-right: 5px;
            color: #e44; /* Icon color */
        }

        .product__details__btns__option a:hover {
            color: #e44;
        }

        .product__details__last__option h5 {
            margin-bottom: 15px;
            color: #333;
        }

        .product__details__last__option ul {
            list-style: none;
            padding: 0;
        }

        .product__details__last__option ul li {
            margin-bottom: 10px;
            color: #555;
        }

        .product__details__last__option ul li span {
            font-weight: bold;
            margin-right: 10px;
            color: #333;
        }

        .product__details__tab .nav-tabs {
            margin-bottom: 30px;
            border-bottom: 1px solid #e1e1e1;
        }

        .product__details__tab .nav-tabs .nav-item {
            margin-bottom: -1px; /* To make the active tab border connect */
        }

        .product__details__tab .nav-tabs .nav-link {
            border: 1px solid transparent;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            color: #555;
            padding: 10px 20px;
            transition: all 0.3s ease;
        }

        .product__details__tab .nav-tabs .nav-link.active {
            color: #e44;
            border-color: #e1e1e1 #e1e1e1 #fff;
            background-color: #fff;
        }

         .product__details__tab .nav-tabs .nav-link:hover {
            border-color: #e1e1e1;
         }

        .product__details__tab__content {
            padding-top: 20px;
            color: #555;
            line-height: 1.6;
        }

        .related.spad {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .related-title {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
            text-align: center;
        }

        /* Reuse product item styles from product list page */
         .related .product__item {
             margin-bottom: 30px;
             border: 1px solid #e1e1e1;
             border-radius: 4px;
             overflow: hidden;
             transition: all 0.3s ease;
         }

         .related .product__item:hover {
             box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
             transform: translateY(-5px);
         }

         .related .product__item__pic {
              height: 250px;
             background-size: cover;
             background-position: center;
             position: relative;
         }

         .related .product__item__text {
             padding: 15px;
             text-align: center;
         }

         .related .product__item__text h6 a {
             font-size: 16px;
             color: #333;
             text-decoration: none;
             margin-bottom: 10px;
             display: block;
         }

         .related .product__item__text h5 {
             color: #e44;
             font-size: 18px;
             margin-bottom: 0;
         }

         .related .product__hover li a {
             border: 1px solid #e1e1e1;
             border-radius: 50%;
             width: 40px;
             height: 40px;
             line-height: 38px;
             text-align: center;
             background-color: #fff;
             color: #333;
             margin: 5px;
             transition: all 0.3s ease;
         }

         .related .product__hover li a:hover {
             background-color: #e44;
             color: #fff;
             border-color: #e44;
         }

    </style>

    <!-- Related Section End -->