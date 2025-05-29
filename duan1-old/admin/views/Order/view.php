<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Chi tiết đơn hàng #<?php echo $order['id']; ?></h1>
        <a href="index.php?controller=order" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

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

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin đơn hàng</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Mã đơn hàng:</th>
                            <td>#<?php echo $order['id']; ?></td>
                        </tr>
                        <tr>
                            <th>Khách hàng:</th>
                            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                        </tr>
                        <tr>
                            <th>Ngày đặt:</th>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                        </tr>
                        <tr>
                            <th>Trạng thái:</th>
                            <td>
                                <form action="index.php?controller=order&action=updateStatus" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                                    <select name="status" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                                        <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                                        <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                                        <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Hoàn thành</option>
                                        <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin thanh toán</h6>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th>Tổng tiền:</th>
                            <td><?php echo number_format($order['total_amount']); ?>đ</td>
                        </tr>
                        <tr>
                            <th>Phương thức thanh toán:</th>
                            <td><?php echo $order['payment_method']; ?></td>
                        </tr>
                        <tr>
                            <th>Địa chỉ giao hàng:</th>
                            <td><?php echo htmlspecialchars($order['shipping_address']); ?></td>
                        </tr>
                        <tr>
                            <th>Ghi chú:</th>
                            <td><?php echo nl2br(htmlspecialchars($order['note'] ?? '')); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td>
                                    <?php if ($item['image']): ?>
                                        <img src="<?php echo $item['image']; ?>" alt="" style="max-width: 50px;">
                                    <?php else: ?>
                                        <span class="text-muted">Không có ảnh</span>
                                    <?php endif; ?>
                                </td>
                                <td><?php echo number_format($item['price']); ?>đ</td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo number_format($item['price'] * $item['quantity']); ?>đ</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 