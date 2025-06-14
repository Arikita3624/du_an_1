<?php require_once __DIR__ . '/../../commons/helpers.php'; ?>
<div class="container mt-4">

    <!-- Bộ lọc thời gian -->
    <form method="GET" class="row g-2 align-items-end mb-4">
        <div class="col-auto">
            <label for="start_date" class="form-label mb-0">Từ ngày:</label>
            <input type="date" id="start_date" name="start_date" class="form-control"
                value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
        </div>
        <div class="col-auto">
            <label for="end_date" class="form-label mb-0">Đến ngày:</label>
            <input type="date" id="end_date" name="end_date" class="form-control"
                value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Lọc</button>
            <a href="index.php?controller=dashboard" class="btn btn-secondary">Reset</a>
        </div>
    </form>

    <div class="row">
        <!-- Khối lớn bên trái -->
        <div class="col-md-8 d-flex flex-column">
            <div class="card h-100">
                <div class="card-header bg-info text-white">Sản phẩm bán chạy</div>
                <div class="card-body p-0">
                    <!-- Table sản phẩm bán chạy -->
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng bán</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($bestSellingProducts as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= $product['total_sold'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- 2 khối nhỏ bên phải -->
        <div class="col-md-4 d-flex flex-column justify-content-between" style="gap: 24px;">
            <div class="card flex-fill mb-3">
                <div class="card-header bg-success text-white">Người mua nhiều nhất</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Họ tên</th>
                                <th>Số đơn</th>
                                <th>Tổng chi tiêu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topBuyers as $user): ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                                    <td><?= $user['total_orders'] ?></td>
                                    <td><?= number_format($user['total_spent']) ?> VNĐ</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card flex-fill">
                <div class="card-header bg-warning">Tồn kho nhiều nhất</div>
                <div class="card-body p-0">
                    <table class="table mb-0">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Tồn kho</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach (array_slice($topStockProducts, 0, 3) as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= $product['stock'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Biểu đồ nhỏ gọn ở giữa -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Biểu đồ sản phẩm bán chạy nhất tháng</div>
        <div class="card-body">
            <div style="width:100%; height:400px;">
                <canvas id="bestSellingChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Đơn hàng mới nhất -->
    <div class="card mb-4">
        <div class="card-header bg-warning">Đơn hàng mới nhất</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($latestOrders as $order): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($order['full_name']) ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></td>
                            <td><?= number_format($order['total_price']) ?> VNĐ</td>
                            <td>
                                <span class="badge badge-<?= getStatusBadgeClass($order['status']) ?>">
                                    <?= getStatusText($order['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const bestSellingLabels = <?= json_encode(array_column($bestSellingProducts, 'name')) ?>;
    const bestSellingData = <?= json_encode(array_column($bestSellingProducts, 'total_sold')) ?>;

    new Chart(document.getElementById('bestSellingChart'), {
        type: 'bar',
        data: {
            labels: bestSellingLabels,
            datasets: [{
                label: 'Số lượng bán',
                data: bestSellingData,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>