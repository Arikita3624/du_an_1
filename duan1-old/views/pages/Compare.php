<?php
$products = $compareProducts ?? [];
?>

<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3 class="mb-4">So sánh sản phẩm</h3>
                
                <?php if (empty($products)): ?>
                    <div class="alert alert-info">
                        Chưa có sản phẩm nào trong danh sách so sánh.
                        <a href="?act=product-list" class="alert-link">Tiếp tục mua sắm</a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 200px;">Hình ảnh</th>
                                    <?php foreach ($products as $product): ?>
                                        <th>
                                            <div class="text-center">
                                                <img src="admin/<?php echo htmlspecialchars($product['image']); ?>" 
                                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                                     style="max-width: 150px; height: auto;">
                                                <div class="mt-2">
                                                    <a href="?act=product-detail&id=<?php echo $product['id']; ?>" 
                                                       class="text-decoration-none">
                                                        <?php echo htmlspecialchars($product['name']); ?>
                                                    </a>
                                                </div>
                                                <button onclick="removeFromCompare(<?php echo $product['id']; ?>)" 
                                                        class="btn btn-sm btn-danger mt-2">
                                                    Xóa khỏi danh sách
                                                </button>
                                            </div>
                                        </th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>Giá</strong></td>
                                    <?php foreach ($products as $product): ?>
                                        <td class="text-center">
                                            <?php echo number_format($product['price'], 0, ',', '.'); ?>₫
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <td><strong>Mô tả</strong></td>
                                    <?php foreach ($products as $product): ?>
                                        <td><?php echo htmlspecialchars($product['description'] ?? ''); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <td><strong>Danh mục</strong></td>
                                    <?php foreach ($products as $product): ?>
                                        <td class="text-center">
                                            <?php 
                                            $category = $categories[$product['category_id']] ?? null;
                                            echo $category ? htmlspecialchars($category['name']) : '';
                                            ?>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <td><strong>Thao tác</strong></td>
                                    <?php foreach ($products as $product): ?>
                                        <td class="text-center">
                                            <a href="?act=product-detail&id=<?php echo $product['id']; ?>" 
                                               class="btn btn-primary btn-sm">
                                                Xem chi tiết
                                            </a>
                                            <button onclick="addToCart(<?php echo $product['id']; ?>)" 
                                                    class="btn btn-success btn-sm">
                                                Thêm vào giỏ
                                            </button>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
function removeFromCompare(productId) {
    $.ajax({
        url: '?act=remove-from-compare',
        type: 'POST',
        data: {
            product_id: productId
        },
        success: function(response) {
            if(response.success) {
                location.reload();
            } else {
                alert(response.message || 'Có lỗi xảy ra!');
            }
        },
        error: function() {
            alert('Có lỗi xảy ra khi xóa sản phẩm khỏi danh sách so sánh!');
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