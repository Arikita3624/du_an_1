<h3>Đơn hàng của bạn</h3>
<table class="table">
    <thead>
        <tr>
            <th>Mã đơn</th>
            <th>Ngày đặt</th>
            <th>Tổng tiền</th>
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
                <td><?= htmlspecialchars($order['status']) ?></td>
                <td><a href="?act=order-confirmation&order_id=<?= $order['id'] ?>">Xem</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<style>
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