<?php
require_once __DIR__ . '/../../commons/helpers.php';
?>
<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Danh sách đơn hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="?act=/">Trang chủ</a>
                        <span>Danh sách đơn hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<?php
// Hiển thị message (nếu có)
if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
    echo '<div class="message ' . htmlspecialchars($_SESSION['message_type'], ENT_QUOTES, 'UTF-8') . '" id="globalMessage">';
    echo htmlspecialchars($_SESSION['message'], ENT_QUOTES, 'UTF-8');
    echo '</div>';
    echo '<script>
        setTimeout(() => {
            const message = document.getElementById("globalMessage");
            if (message) {
                message.classList.add("hidden");
            }
        }, 3000);
    </script>';
    unset($_SESSION['message'], $_SESSION['message_type']);
} else if (isset($_SESSION['success'])) {
     echo '<div class="message success" id="globalMessage">';
     echo htmlspecialchars($_SESSION['success'], ENT_QUOTES, 'UTF-8');
     echo '</div>';
     echo '<script>
         setTimeout(() => {
             const message = document.getElementById("globalMessage");
             if (message) {
                 message.classList.add("hidden");
             }
         }, 3000);
     </script>';
     unset($_SESSION['success']);
}
?>

<h3>Đơn hàng của bạn</h3>
<table class="table">
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
            <th>Phương thức thanh toán</th>
            <th>Trạng thái</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']) ?></td>
                <td><?= htmlspecialchars($order['created_at']) ?></td>
                <td><?= number_format($order['total_price'], 0, ',', '.') ?>₫</td>
                <td><?= $order['payment_method'] === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' ?></td>
                <td><?= getStatusText($order['status']) ?></td>
                <td><a href="?act=order-confirmation&order_id=<?= $order['id'] ?>">Xem</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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

    h3 {
        font-size: 26px;
        font-weight: 700;
        color: #e53637;
        margin-bottom: 28px;
        text-align: center;
        letter-spacing: 1px;
    }

    /* Bảng đơn hàng */
    .table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        margin-bottom: 40px;
    }

    .table thead {
        background: #f9f9f9;
    }

    .table th,
    .table td {
        padding: 14px 12px;
        text-align: center;
        font-size: 16px;
    }

    .table th {
        color: #111;
        font-weight: 700;
        border-bottom: 2px solid #e53637;
        background: #f6f6f6;
        letter-spacing: 0.5px;
    }

    .table tbody tr {
        transition: background 0.2s;
    }

    .table tbody tr:nth-child(even) {
        background: #fafafa;
    }

    .table tbody tr:hover {
        background: #ffeaea;
    }

    .table td {
        color: #333;
        border-bottom: 1px solid #f0f0f0;
    }

    .table a {
        color: #fff;
        background: #e53637;
        padding: 6px 18px;
        border-radius: 5px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
        display: inline-block;
    }

    .table a:hover {
        background: #b91c1c;
    }

    @media (max-width: 768px) {
        .table th,
        .table td {
            font-size: 14px;
            padding: 10px 4px;
        }

        h3 {
            font-size: 20px;
        }
    }
</style>