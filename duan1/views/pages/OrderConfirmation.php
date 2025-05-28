<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Order Confirmation</h4>
                    <div class="breadcrumb__links">
                        <a href="?act=/">Home</a>
                        <a href="?act=product-list">Shop</a>
                        <span>Order Confirmation</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Order Confirmation Section Begin -->
<section class="order-confirmation spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Thank you for your order!</h4>
                <p>Your order has been placed successfully. You will receive a confirmation email shortly.</p>
                <div class="order__details">
                    <h5>Order #<?= htmlspecialchars($order['id']) ?></h5>
                    <p><strong>Tên đầy đủ:</strong> <?= htmlspecialchars($order['full_name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
                    <p><strong>Số điện thoại:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                    <p><strong>Địa chỉ:</strong> <?= htmlspecialchars($order['address']) ?></p>
                    <p><strong>Tổng giá:</strong> <?= number_format($order['total_price'], 0, ',', '.') ?>₫</p>
                    <p><strong>Phương thức:</strong> <?= htmlspecialchars($order['payment_method']) ?></p>
                    <p><strong>Trạng thái:</strong> <?= htmlspecialchars($order['status']) ?></p>
                    <p><strong>Trang thái thanh toán:</strong> <?= htmlspecialchars($order['payment_status']) ?></p>
                    <h6>Order Items:</h6>
                    <ul>
                        <?php foreach ($order_details as $item): ?>
                            <li>
                                <?= htmlspecialchars($item['name']) ?> -
                                Số lượng: <?= $item['quantity'] ?> -
                                Giá: <?= number_format($item['total_price'], 0, ',', '.') ?>₫
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <a href="?act=product-list" class="primary-btn">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</section>
<!-- Order Confirmation Section End -->

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

    .order-confirmation.spad {
        padding: 40px 0 60px 0;
    }

    .order-confirmation h4 {
        color: #27ae60;
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .order-confirmation p {
        color: #333;
        font-size: 16px;
        margin-bottom: 18px;
    }

    .order__details {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.07);
        padding: 28px 26px 18px 26px;
        margin-bottom: 22px;
    }

    .order__details h5 {
        font-size: 20px;
        font-weight: 700;
        color: #e53637;
        margin-bottom: 14px;
    }

    .order__details p {
        margin-bottom: 7px;
        font-size: 15px;
        color: #222;
    }

    .order__details h6 {
        margin-top: 18px;
        margin-bottom: 8px;
        font-size: 16px;
        font-weight: 700;
        color: #111;
    }

    .order__details ul {
        padding-left: 18px;
        margin-bottom: 0;
    }

    .order__details li {
        font-size: 15px;
        color: #333;
        margin-bottom: 5px;
    }

    .primary-btn {
        display: inline-block;
        background: #e53637;
        color: #fff;
        font-weight: 700;
        border: none;
        border-radius: 5px;
        padding: 12px 32px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        margin-top: 18px;
        transition: background 0.2s;
    }

    .primary-btn:hover {
        background: #b91c1c;
    }

    @media (max-width: 768px) {
        .order__details {
            padding: 14px 6px 10px 6px;
        }

        .order-confirmation h4 {
            font-size: 20px;
        }
    }
</style>