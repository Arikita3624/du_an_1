<div class="container-fluid">
    <h2 class="mb-4">Chi tiết giỏ hàng</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Thông tin giỏ hàng</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> <?php echo $cart['id']; ?></p>
                    <p><strong>Người dùng:</strong> <?php echo htmlspecialchars($cart['full_name']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($cart['created_at'])); ?></p>
                    <p><strong>Cập nhật lần cuối:</strong> <?php echo date('d/m/Y H:i', strtotime($cart['updated_at'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Danh sách sản phẩm</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cartItems)): ?>
                            <?php 
                            $total = 0;
                            foreach ($cartItems as $item): 
                                $itemTotal = $item['price'] * $item['quantity'];
                                $total += $itemTotal;
                            ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($item['image']): ?>
                                                <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                     class="img-thumbnail mr-3" style="width: 50px;">
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($itemTotal, 0, ',', '.'); ?> VNĐ</td>
                                </tr>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Tổng cộng:</strong></td>
                                <td><strong><?php echo number_format($total, 0, ',', '.'); ?> VNĐ</strong></td>
                            </tr>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center">Không có sản phẩm nào trong giỏ hàng</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="index.php?controller=cart" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>
</div> 