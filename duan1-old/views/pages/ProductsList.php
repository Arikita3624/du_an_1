<section class="shop spad">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    <h4 class="mb-3">Bộ lọc sản phẩm</h4>
                    <form method="GET" action="">
                        <?php /* Preserve existing GET parameters except search and category_id */ ?>
                        <?php foreach($_GET as $key => $value): if($key != 'search' && $key != 'category_id'): ?>
                            <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                        <?php endif; endforeach; ?>
                        <div class="mb-3">
                            <input type="text" name="search" class="form-control" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <select name="category_id" class="form-select">
                                <option value="">Tất cả danh mục</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= (($_GET['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($cat['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="primary-btn w-100">Lọc sản phẩm</button>
                    </form>
                </div>
            </div>
            <!-- End Sidebar -->

            <!-- Product List -->
            <div class="col-lg-9">
                <div class="row">
                    <?php
                    // Lọc sản phẩm theo tên và danh mục (nếu có)
                    $search = $_GET['search'] ?? '';
                    $category_id = $_GET['category_id'] ?? '';
                    $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
                    $limit = 12;
                    $offset = ($page - 1) * $limit;

                    $filteredProducts = array_filter($products, function ($product) use ($search, $category_id) {
                        $match = true;
                        if ($search) {
                            $match = stripos($product['name'], $search) !== false;
                        }
                        if ($match && $category_id) {
                            $match = $product['category_id'] == $category_id;
                        }
                        return $match;
                    });
                    $totalProducts = count($filteredProducts);
                    $totalPages = ceil($totalProducts / $limit);
                    $productsToShow = array_slice($filteredProducts, $offset, $limit);
                    ?>
                    <?php if (!empty($productsToShow)): ?>
                        <?php foreach ($productsToShow as $product): ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="admin/<?php echo htmlspecialchars($product['image']); ?>">
                                        <?php /* TODO: Add logic for 'New' or 'Sale' label if applicable */ ?>
                                        <ul class="product__hover">
                                            <li><a href="#"><i class="fa fa-heart"></i></a></li> <?php /* TODO: Implement wishlist */ ?>
                                            <li><a href="javascript:void(0)" onclick="addToCompare(<?php echo $product['id']; ?>)" title="So sánh sản phẩm" class="compare-btn" data-product-id="<?php echo $product['id']; ?>"><i class="fa fa-retweet"></i> <span>So sánh</span></a></li>
                                            <li><a href="?act=product-detail&id=<?php echo $product['id']; ?>" title="Xem chi tiết"><i class="fa fa-search"></i></a></li>
                                            <li><a href="?act=add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>)" title="Thêm vào giỏ hàng" class="cart-btn" data-product-id="<?php echo $product['id']; ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <h6><a href="?act=product-detail&id=<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></a></h6> <?php /* Link on product name */ ?>
                                    <div class="product__item__text">
                                        <h5><?php echo number_format($product['price'], 0, ',', '.'); ?>₫</h5> <?php /* TODO: Display discount price if applicable */ ?>
                                        <?php /* TODO: Implement rating display if available */ ?>
                                        <div class="view-detail-btn">
                                            <a href="?act=product-detail&id=<?php echo $product['id']; ?>">Xem chi tiết</a>
                                        </div>
                                    </div>
                                    <style>
                                        .product__item:hover .view-detail-btn {
                                            display: block !important;
                                        }
                                        .view-detail-btn a:hover {
                                            text-decoration: underline !important;
                                        }
                                        .compare-btn.active i,
                                        .cart-btn.active i {
                                            color: #e44;
                                        }
                                    </style>
                                    <style>
                                        /* Custom CSS for Product List Page */
                                        .shop__sidebar {
                                            padding: 20px;
                                            border: 1px solid #e1e1e1;
                                            border-radius: 4px;
                                            margin-bottom: 30px; /* Add space below sidebar */
                                        }

                                        .shop__sidebar h4 {
                                            font-size: 18px;
                                            margin-bottom: 20px;
                                            color: #333;
                                        }

                                        .shop__sidebar .form-control,
                                        .shop__sidebar .form-select {
                                            margin-bottom: 15px;
                                        }

                                        .product__item {
                                            margin-bottom: 30px; /* Add space between product items */
                                            border: 1px solid #e1e1e1; /* Add border to product item */
                                            border-radius: 4px;
                                            overflow: hidden; /* Ensure border-radius is applied */
                                            transition: all 0.3s ease;
                                        }

                                        .product__item:hover {
                                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                                            transform: translateY(-5px); /* Add a slight lift effect */
                                        }

                                        .product__item__pic {
                                             height: 250px; /* Fixed height for product images */
                                            background-size: cover;
                                            background-position: center;
                                            position: relative;
                                        }

                                        .product__item__text {
                                            padding: 15px;
                                            text-align: center; /* Center product text */
                                        }

                                        .product__item__text h6 a {
                                            font-size: 16px;
                                            color: #333;
                                            text-decoration: none;
                                            margin-bottom: 10px;
                                            display: block; /* Ensure the link takes full width */
                                        }

                                        .product__item__text h5 {
                                            color: #e44; /* Price color */
                                            font-size: 18px;
                                            margin-bottom: 0;
                                        }

                                        .product__hover li a {
                                            border: 1px solid #e1e1e1; /* Add border to hover icons */
                                            border-radius: 50%;
                                            width: 40px;
                                            height: 40px;
                                            line-height: 38px; /* Center icon vertically */
                                            text-align: center;
                                            background-color: #fff;
                                            color: #333;
                                            margin: 5px;
                                            transition: all 0.3s ease;
                                        }

                                        .product__hover li a:hover {
                                            background-color: #e44;
                                            color: #fff;
                                            border-color: #e44;
                                        }

                                        .product__pagination {
                                            margin-top: 30px;
                                            text-align: center; /* Center pagination */
                                        }

                                        .product__pagination a {
                                            display: inline-block;
                                            padding: 8px 16px;
                                            margin: 0 5px;
                                            border: 1px solid #e1e1e1;
                                            border-radius: 4px;
                                            text-decoration: none;
                                            color: #333;
                                            transition: all 0.3s ease;
                                        }

                                        .product__pagination a.active,
                                        .product__pagination a:hover {
                                            background-color: #e44;
                                            color: #fff;
                                            border-color: #e44;
                                        }

                                        /* Style for the moved 'Xem chi tiết' link */
                                        .product__item__text .view-detail-btn {
                                            display: inline-block !important; /* Make sure it's always visible */
                                            margin-left: 10px; /* Add space between price and link */
                                        }

                                        .product__item__text .view-detail-btn a {
                                            color: #e44; /* Match price color */
                                            text-decoration: none;
                                            font-size: 14px;
                                        }

                                        .product__item__text h5,
                                        .product__item__text .view-detail-btn {
                                            display: inline-block; /* Display price and link side by side */
                                            vertical-align: middle; /* Align vertically */
                                        }
                                    </style>
                                    <script>
                                    $(document).ready(function() {
                                        // Kiểm tra sản phẩm đã có trong danh sách so sánh
                                        var compareList = <?php echo json_encode($_SESSION['compare_list'] ?? []); ?>;
                                        $('.compare-btn').each(function() {
                                            var productId = $(this).data('product-id');
                                            if (compareList.includes(parseInt(productId))) {
                                                $(this).addClass('active');
                                            }
                                        });

                                        // Kiểm tra sản phẩm đã có trong giỏ hàng
                                        var cart = <?php echo json_encode($_SESSION['cart'] ?? []); ?>;
                                        $('.cart-btn').each(function() {
                                            var productId = $(this).data('product-id');
                                            if (cart[productId]) {
                                                $(this).addClass('active');
                                            }
                                        });
                                    });

                                    function addToCompare(productId) {
                                        $.ajax({
                                            url: '?act=add-to-compare',
                                            type: 'POST',
                                            data: {
                                                product_id: productId
                                            },
                                            success: function(response) {
                                                if(response.success) {
                                                    alert('Đã thêm sản phẩm vào danh sách so sánh!');
                                                    $('.compare-btn[data-product-id="' + productId + '"]').addClass('active');
                                                } else {
                                                    alert(response.message || 'Có lỗi xảy ra!');
                                                }
                                            },
                                            error: function() {
                                                alert('Có lỗi xảy ra khi thêm vào danh sách so sánh!');
                                            }
                                        });
                                    }

                                    function addToCart(productId) {
                                        $.ajax({
                                            url: '?act=add-to-cart',
                                            type: 'POST',
                                            data: {
                                                product_id: productId,
                                                quantity: 1
                                            },
                                            success: function(response) {
                                                if(response.success) {
                                                    // Chuyển hướng đến trang giỏ hàng sau khi thêm thành công
                                                    window.location.href = '?act=carts';
                                                } else {
                                                    alert(response.message || 'Có lỗi xảy ra!');
                                                }
                                            },
                                            error: function() {
                                                alert('Có lỗi xảy ra khi thêm vào giỏ hàng!');
                                            }
                                        });
                                    }
                                    </script>
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
                <?php if ($totalPages > 1): ?>
                    <div class="product__pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" <?= ($i == $page) ? 'class="active"' : '' ?>><?php echo $i; ?></a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- End Product List -->
        </div>
    </div>
</section>