<?php
require_once __DIR__ . '/../../../commons/helpers.php';
$title = "Chi tiết đơn hàng #" . $order['id'];
?>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết đơn hàng #<?php echo $order['id']; ?></h1>
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
        <!-- Thông tin đơn hàng -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin đơn hàng</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th>Mã đơn hàng:</th>
                            <td>#<?php echo $order['id']; ?></td>
                        </tr>
                        <tr>
                            <th>Ngày đặt:</th>
                            <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                        </tr>
                        <tr>
                            <th>Trạng thái:</th>
                            <td>
                                    <span class="badge badge-<?php echo getStatusBadgeClass($order['status']); ?>">
                                        <?php echo getStatusText($order['status']); ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Phương thức thanh toán:</th>
                                <td><?php echo getPaymentMethodText($order['payment_method']); ?></td>
                            </tr>
                            <tr>
                                <th>Trạng thái thanh toán:</th>
                                <td>
                                    <span class="badge badge-<?php
                                        if ($order['payment_status'] === 'pending') {
                                            echo 'info';
                                        } else {
                                            echo getPaymentStatusBadgeClass($order['payment_status']);
                                        }
                                     ?>">
                                        <?php echo getPaymentStatusText($order['payment_status']); ?>
                                    </span>
                            </td>
                        </tr>
                            <tr>
                                <th>Tổng tiền:</th>
                                <td class="font-weight-bold"><?php echo number_format($order['total_amount']); ?> VNĐ</td>
                            </tr>
                            <?php if ($order['status'] === 'cancelled' && !empty($order['cancel_reason'])): ?>
                            <tr>
                                <th>Lý do hủy:</th>
                                <td class="text-danger"><?php echo htmlspecialchars($order['cancel_reason']); ?></td>
                            </tr>
                            <?php endif; ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Thông tin khách hàng -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Thông tin khách hàng</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table class="table">
                        <tr>
                                <th>Họ tên:</th>
                                <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                        </tr>
                        <tr>
                                <th>Email:</th>
                                <td><?php echo htmlspecialchars($order['email']); ?></td>
                        </tr>
                        <tr>
                                <th>Số điện thoại:</th>
                                <td><?php echo htmlspecialchars($order['phone']); ?></td>
                        </tr>
                            <tr>
                                <th>Địa chỉ:</th>
                                <td><?php echo htmlspecialchars($order['address']); ?></td>
                            </tr>
                            <?php if (!empty($order['note'])): ?>
                        <tr>
                            <th>Ghi chú:</th>
                                <td><?php echo htmlspecialchars($order['note']); ?></td>
                        </tr>
                            <?php endif; ?>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết sản phẩm -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Chi tiết sản phẩm</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orderItems)): ?>
                            <?php $stt = 1; ?>
                        <?php foreach ($orderItems as $item): ?>
                            <tr>
                                    <td><?php echo $stt++; ?></td>
                                <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                <td>
                                        <?php if (!empty($item['image'])): ?>
                                            <img src="<?php echo $item['image']; ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>"
                                                 style="max-width: 50px; max-height: 50px;">
                                    <?php endif; ?>
                                </td>
                                    <td><?php echo number_format($item['price']); ?> VNĐ</td>
                                <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo number_format($item['price'] * $item['quantity']); ?> VNĐ</td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có sản phẩm nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><strong>Tổng tiền đơn hàng:</strong></td>
                            <td><strong><?php echo number_format($order['total_amount']); ?> VNĐ</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Cập nhật trạng thái -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cập nhật trạng thái</h6>
        </div>
        <div class="card-body">
            <form action="index.php?controller=order&action=updateStatus" method="POST">
                <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                        <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                        <option value="delivering" <?php echo $order['status'] == 'delivering' ? 'selected' : ''; ?>>Đang giao hàng</option>
                        <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Đã giao hàng</option>
                        <option value="finished" <?php echo $order['status'] == 'finished' ? 'selected' : ''; ?>>Hoàn thành</option>
                        <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>
                                 <?php echo in_array($order['status'], ['delivering', 'completed', 'finished']) ? 'disabled' : ''; ?>
                                 >Đã hủy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>