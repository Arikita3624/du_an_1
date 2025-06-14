<?php
require_once __DIR__ . '/../../commons/helpers.php';

function getOrderStatusClass($status)
{
    switch ($status) {
        case 'pending':
            return 'badge-warning';
        case 'delivering':
            return 'badge-info';
        case 'confirmed':
        case 'completed':
        case 'finished':
            return 'badge-success';
        case 'cancelled':
            return 'badge-danger';
        default:
            return 'badge-secondary';
    }
}
function getPaymentStatusClass($status)
{
    switch ($status) {
        case 'pending':
            return 'badge-secondary';      // xanh dương
        case 'paid':
            return 'badge-success';   // xanh lá
        case 'failed':
            return 'badge-danger';    // đỏ
        default:
            return 'badge-secondary';
    }
}

$ordersPerPage = 5;
$totalOrders = count($orders);
$totalPages = ceil($totalOrders / $ordersPerPage);
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$start = ($page - 1) * $ordersPerPage;
$ordersToShow = array_slice($orders, $start, $ordersPerPage);

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
            <th>Trạng thái thanh toán</th>
            <th>Chi tiết</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ordersToShow as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']) ?></td>
                <td><?= htmlspecialchars($order['created_at']) ?></td>
                <td><?= number_format($order['total_price'], 0, ',', '.') ?>₫</td>
                <td><?= $order['payment_method'] === 'cod' ? 'Thanh toán khi nhận hàng (COD)' : 'Chuyển khoản ngân hàng' ?></td>
                <td>
                    <span class="badge <?= getOrderStatusClass($order['status']) ?>">
                        <?= getStatusText($order['status']) ?>
                    </span>
                </td>
                <td>
                    <?php
                    $paymentStatus = $order['payment_status'];
                    if (in_array($order['status'], ['completed', 'finished'])) {
                        $paymentStatus = 'paid';
                    } elseif ($order['status'] === 'cancelled') {
                        $paymentStatus = 'failed';
                    }
                    ?>
                    <span class="badge <?= getPaymentStatusClass($paymentStatus) ?>">
                        <?= $paymentStatus === 'paid' ? 'Đã thanh toán' : getPaymentStatusText($paymentStatus) ?>
                    </span>
                </td>
                <td><a href="?act=order-confirmation&order_id=<?= $order['id'] ?>">Xem</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php if ($totalPages > 1): ?>
    <nav class="order-pagination">
        <ul>
            <li>
                <a href="?act=order-list&page=<?= max(1, $page - 1) ?>" class="<?= $page == 1 ? 'disabled' : '' ?>">Trước</a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li>
                    <a href="?act=order-list&page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>
            <li>
                <a href="?act=order-list&page=<?= min($totalPages, $page + 1) ?>" class="<?= $page == $totalPages ? 'disabled' : '' ?>">Sau</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

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

    .table th {
        background: #f8f9fa;
        padding: 15px;
        font-weight: 600;
        color: #333;
        text-align: left;
        border-bottom: 2px solid #dee2e6;
    }

    .table td {
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Badge styles */
    .badge {
        padding: 6px 12px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
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

    .badge-secondary {
        background-color: #6c757d;
        color: #fff;
    }

    /* Link styles */
    .table a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .table a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    .order-pagination {
        margin-bottom: 60px;
        /* Tạo khoảng cách với footer */
    }

    .order-pagination ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 30px 0 0 0;
        justify-content: center;
    }

    .order-pagination li {
        margin: 0 4px;
    }

    .order-pagination a {
        display: block;
        padding: 6px 14px;
        background: #f6f6f6;
        color: #e53637;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        border: 1px solid #e53637;
        transition: background 0.2s, color 0.2s;
    }

    .order-pagination a.active,
    .order-pagination a:hover {
        background: #e53637;
        color: #fff;
    }

    .order-pagination a.disabled {
        pointer-events: none;
        opacity: 0.5;
        background: #eee;
        color: #aaa;
        border-color: #eee;
    }
</style>