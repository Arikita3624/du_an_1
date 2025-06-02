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
                                <span class="badge <?= getStatusBadgeClass($order['status']) ?>">
                                    <?= getStatusText($order['status']) ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin khách hàng -->
                    <div class="order-details__section">
                        <h5>Thông tin khách hàng</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['full_name'] ?? $order['full_name']) ?></p>
                                <p><strong>Email:</strong> <?= htmlspecialchars($order['email'] ?? $order['email']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone'] ?? $order['phone']) ?></p>
                                <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address'] ?? $order['address']) ?></p>
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

                    <!-- Thông tin thanh toán -->
                    <div class="order-details__section">
                        <h5>Thông tin thanh toán</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Phương thức thanh toán:</strong> <?= getPaymentMethodText($order['payment_method']) ?></p>
                                <p><strong>Trạng thái thanh toán:</strong> 
                                    <span class="badge <?= getPaymentStatusBadgeClass($order['payment_status']) ?>">
                                        <?= getPaymentStatusText($order['payment_status']) ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="order-details__actions">
                        <a href="?act=order-list" class="btn btn-secondary">Quay lại</a>
                        <?php if (in_array($order['status'], ['pending', 'processing'])): ?>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelOrderModal">
                                Hủy đơn hàng
                            </button>
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
        padding: 22px 0 18px 0;
        border-radius: 8px;
        margin-bottom: 32px;
    }

    .breadcrumb__text h4 {
        font-size: 22px;
        font-weight: 700;
        color: #e53637;
        margin-bottom: 6px;
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
        border-radius: 5px;
    }

    .table {
        margin-bottom: 0;
    }

    .table th {
        font-weight: 600;
        color: #111;
        border-bottom: 2px solid #eee;
    }

    .table td {
        vertical-align: middle;
        color: #333;
    }

    .badge {
        padding: 8px 12px;
        font-weight: 500;
        font-size: 13px;
    }

    .order-details__actions {
        margin-top: 30px;
        text-align: right;
    }

    .btn {
        padding: 10px 24px;
        font-weight: 600;
        border-radius: 5px;
        margin-left: 10px;
    }

    .btn-primary {
        background: #e53637;
        border-color: #e53637;
    }

    .btn-primary:hover {
        background: #b91c1c;
        border-color: #b91c1c;
    }

    .btn-secondary {
        background: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background: #5a6268;
        border-color: #545b62;
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