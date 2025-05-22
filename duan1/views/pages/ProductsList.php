<section class="shop spad">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="shop__sidebar">
                    <form method="GET" action="">
                        <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" style="margin-bottom:10px;">
                        <select name="category_id" style="width:100%;margin-bottom:10px;">
                            <option value="">Tất cả danh mục</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= (($_GET['category_id'] ?? '') == $cat['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <button type="submit" style="width:100%;">Lọc</button>
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

                    $filteredProducts = array_filter($products, function($product) use ($search, $category_id) {
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
                                    <div class="product__item__pic" style="height:220px; display:flex; align-items:center; justify-content:center;">
                                        <img src="<?= htmlspecialchars($product['image'] ?? 'default.jpg') ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-height:100%; max-width:100%; object-fit:contain;">
                                    </div>
                                    <div class="product__item__text">
                                        <h6><?= htmlspecialchars($product['name']) ?></h6>
                                        <h5><?= number_format($product['price'], 0, ',', '.') ?> đ</h5>
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