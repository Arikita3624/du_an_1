<?php
require_once __DIR__ . '/../../commons/helpers.php';
?>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Chi tiết đơn hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="?act=/">Trang chủ</a>
                        <a href="?act=order-list">Danh sách đơn hàng</a>
                        <span>Chi tiết đơn hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Order Details Section Begin -->
<section class="order-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <?php if (isset($_SESSION['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="order-details__wrapper">
                    <!-- Thông tin đơn hàng -->
                    <div class="order-details__header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Đơn hàng #<?= htmlspecialchars($order['id']) ?></h4>
                                <p class="text-muted">Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                            </div>
                            <div class="col-md-6 text-end">
                                <div class="order-summary-status">
                                    <div class="status-item">
                                        <span class="status-label">Trạng thái đơn hàng:</span>
                                        <span style="background:#ffc107; color:#fff; padding:6px 14px; border-radius:6px; display:inline-block; font-weight:600;">
                                            <?= getStatusText($order['status']) ?>
                                        </span>
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">Trạng thái thanh toán:</span>
                                        <span style="background:#17a2b8; color:#fff; padding:6px 14px; border-radius:6px; display:inline-block; font-weight:600;">
                                            <?= getPaymentStatusText($order['payment_status']) ?>
                                        </span>
                                    </div>
                                    <div class="payment-method-item">
                                        <span class="status-label">Phương thức thanh toán:</span>
                                        <span><?= getPaymentMethodText($order['payment_method']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin khách hàng -->
                    <div class="order-details__section">
                        <h5>Thông tin khách hàng</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                                <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Chi tiết sản phẩm -->
                    <div class="order-details__section">
                        <h5>Chi tiết sản phẩm</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th class="text-center">Số lượng</th>
                                        <th class="text-end">Đơn giá</th>
                                        <th class="text-end">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($order_details as $item): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if (!empty($item['image'])): ?>
                                                        <img src="<?= $item['image'] ?>"
                                                            alt="<?= htmlspecialchars($item['name']) ?>"
                                                            class="product-image">
                                                    <?php endif; ?>
                                                    <span class="ms-3"><?= htmlspecialchars($item['name']) ?></span>
                                                </div>
                                            </td>
                                            <td class="text-center"><?= $item['quantity'] ?></td>
                                            <td class="text-end"><?= number_format($item['price'], 0, ',', '.') ?>₫</td>
                                            <td class="text-end"><?= number_format($item['total_price'], 0, ',', '.') ?>₫</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-end"><strong>Tổng tiền:</strong></td>
                                        <td class="text-end"><strong><?= number_format($order['total_price'], 0, ',', '.') ?>₫</strong></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="order-details__actions">
                        <a href="?act=order-list" class="btn btn-secondary">Quay lại</a>
                        <?php if (in_array($order['status'], ['pending', 'processing'])): ?>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                Hủy đơn hàng
                            </button>
                        <?php endif; ?>

                        <?php if ($order['status'] === 'completed'): ?>
                            <form action="?act=mark-order-received" method="POST" onsubmit="return confirm('Xác nhận đã nhận được đơn hàng?');">
                                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                <button type="submit" class="btn btn-success">Đã nhận hàng</button>
                            </form>
                        <?php endif; ?>

                        <a href="?act=product-list" class="btn btn-primary">Tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Order Details Section End -->

<!-- Modal Hủy đơn hàng -->
<div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Xác nhận hủy đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn hủy đơn hàng #<?= htmlspecialchars($order['id']) ?>?</p>
                <p class="text-danger">Lưu ý: Hành động này không thể hoàn tác.</p>

                <div class="form-group mt-3">
                    <label for="cancel_reason">Lý do hủy (Không bắt buộc):</label>
                    <textarea class="form-control" id="cancel_reason" name="cancel_reason" rows="3"></textarea>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <form action="<?= $_SERVER['REQUEST_URI'] ?>" method="POST">
                    <input type="hidden" name="action" value="cancel">
                    <button type="submit" class="btn btn-danger">Xác nhận hủy</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .breadcrumb-option {
        background: #f6f6f6;
        padding: 32px 0 28px 0;
        /* tăng padding trên/dưới */
        border-radius: 8px;
        margin-bottom: 32px;
    }

    .breadcrumb__text {
        padding-left: 18px;
        /* căn lề trái cho nội dung */
    }

    .breadcrumb__text h4 {
        font-size: 28px;
        font-weight: 700;
        color: #e53637;
        margin-bottom: 10px;
    }

    .breadcrumb__links {
        padding-left: 2px;
        font-size: 18px;
    }

    .breadcrumb__links a {
        color: #111;
        font-weight: 500;
        margin-right: 8px;
        text-decoration: none;
    }

    .breadcrumb__links span {
        color: #e53637;
        font-weight: 600;
    }

    .order-details.spad {
        padding: 40px 0 60px 0;
    }

    .order-details__wrapper {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
        padding: 30px;
    }

    .order-details__header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .order-details__header h4 {
        font-size: 24px;
        font-weight: 700;
        color: #111;
        margin-bottom: 5px;
    }

    .order-summary-status {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }

    .status-item,
    .payment-method-item {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .status-label {
        color: #666;
        font-size: 14px;
        min-width: 160px;
        text-align: left;
    }

    .payment-method-item span:last-child {
        font-size: 14px;
        color: #333;
    }

    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        display: inline-block;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
    }

    .badge-warning {
        background-color: #ffc107;
        color: #000;
    }

    .badge-info {
        background-color: #17a2b8;
        color: #fff;
    }

    .badge-primary {
        background-color: #007bff;
        color: #fff;
    }

    .badge-success {
        background-color: #28a745;
        color: #fff;
    }

    .badge-danger {
        background-color: #dc3545;
        color: #fff;
    }

    .badge-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    .order-details__section {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .order-details__section h5 {
        font-size: 18px;
        font-weight: 700;
        color: #111;
        margin-bottom: 20px;
    }

    .order-details__section p {
        margin-bottom: 10px;
        color: #333;
    }

    .order-details__section strong {
        color: #111;
        font-weight: 600;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 4px;
        margin-right: 10px;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
    }

    .table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #333;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        vertical-align: middle;
        border-bottom: 1px solid #dee2e6;
    }

    .order-details__actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .btn {
        padding: 8px 20px;
        border-radius: 4px;
        font-weight: 500;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-secondary {
        background: #6c757d;
        color: #fff;
    }

    .btn-secondary:hover {
        background: #5a6268;
        color: #fff;
    }

    .btn-danger {
        background: #dc3545;
        color: #fff;
    }

    .btn-danger:hover {
        background: #c82333;
        color: #fff;
    }

    .btn-primary {
        background: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background: #0056b3;
        color: #fff;
    }

    @media (max-width: 768px) {
        .order-details__wrapper {
            padding: 20px;
        }

        .order-details__header h4 {
            font-size: 20px;
        }

        .order-details__section h5 {
            font-size: 16px;
        }

        .product-image {
            width: 50px;
            height: 50px;
        }

        .btn {
            padding: 8px 16px;
            font-size: 14px;
        }
    }
</style>

<!-- Bootstrap JS và Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>