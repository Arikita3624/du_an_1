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
// Xử lý lọc sản phẩm
$search = $_GET['search'] ?? '';
$category_id = $_GET['category_id'] ?? '';
$price = $_GET['price'] ?? '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$limit = 12;
$offset = ($page - 1) * $limit;

// Lọc sản phẩm
$filteredProducts = array_filter($products, function ($product) use ($search, $price, $category_id) {
    $match = true;
    if ($search) {
        $match = stripos($product['name'], $search) !== false;
    }
    if ($match && $category_id) {
        $match = $product['category_id'] == $category_id;
    }
    if ($match && $price) {
        [$min, $max] = explode('-', $price);
        $match = $product['price'] >= $min && $product['price'] <= $max;
    }
    return $match;
});
$totalProducts = count($filteredProducts);
$totalPages = $totalProducts > 0 ? ceil($totalProducts / $limit) : 1;
$productsToShow = array_slice($filteredProducts, $offset, $limit);
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
                            <!-- Giữ lại các tham số khác nếu có -->
                            <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            <input type="hidden" name="category_id" value="<?= htmlspecialchars($_GET['category_id'] ?? '') ?>">
                            <label for="price" style="margin-right:8px;">Lọc theo giá:</label>
                            <select name="price" id="price" class="form-control" style="width:auto;">
                                <option value="">Tất cả mức giá</option>
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
                    <?php if (!empty($productsToShow)): ?>
                        <?php foreach ($productsToShow as $product): ?>
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="product__item">
                                    <div class="product__item__pic">
                                        <img src="<?= !empty($product['image']) ? 'admin/' . htmlspecialchars($product['image']) : 'assets/img/no-image.jpg' ?>"
                                            alt="<?= htmlspecialchars($product['name']) ?>"
                                            style="width:100%;height:250px;object-fit:cover;border-radius:8px;">
                                    </div>
                                    <div class="product__item__text">
                                        <h6><?= htmlspecialchars($product['name']) ?></h6>
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
                <?php if ($totalPages > 1): ?>
                    <div class="product__pagination">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" <?= ($i == $page) ? 'class="active"' : '' ?>><?= $i ?></a>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- End Product List -->
        </div>
    </div>
</section>
<!-- Shop Section End -->