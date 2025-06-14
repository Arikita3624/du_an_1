        <div class="container-fluid">
            <form class="filter-form" method="GET" action="index.php?controller=dashboard">
                <label for="start_date">Từ ngày:</label>
                <input type="date" name="start_date" id="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
                <label for="end_date">Đến ngày:</label>
                <input type="date" name="end_date" id="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
                <button type="submit">Lọc</button>
            </form>

            <div class="dashboard-revenue" style="text-align:center; margin: 24px 0 12px 0;">
                <span style="font-size: 1.2rem; font-weight: 600;">Doanh thu:</span>
                <span style="font-size: 1.2rem; color: #28a745; font-weight: 700;">
                    <?= number_format($totalRevenue) ?> VNĐ
                </span>
            </div>

            <!-- Nhúng Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <div class="dashboard-charts-center">
                <div class="dashboard-charts-row">
                    <div class="dashboard-chart-col">
                        <h5>Sản phẩm bán chạy</h5>
                        <canvas id="bestSellingProductsChart" width="180" height="180"></canvas>
                    </div>
                    <div class="dashboard-chart-col">
                        <h5>Sản phẩm tồn kho nhiều</h5>
                        <canvas id="topStockProductsChart" width="180" height="180"></canvas>
                    </div>
                    <div class="dashboard-chart-col">
                        <h5>Người mua nhiều nhất</h5>
                        <canvas id="topBuyersChart" width="180" height="180"></canvas>
                    </div>
                </div>
            </div>

            <!-- Chart.js -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const bestSellingProducts = <?= json_encode($bestSellingProducts) ?>;
                const topStockProducts = <?= json_encode($topStockProducts) ?>;
                const topBuyers = <?= json_encode($topBuyers) ?>;

                new Chart(document.getElementById('bestSellingProductsChart'), {
                    type: 'doughnut',
                    data: {
                        labels: bestSellingProducts.map(p => p.name),
                        datasets: [{
                            data: bestSellingProducts.map(p => p.total_sold),
                            backgroundColor: ['#36a2eb', '#ff6384', '#ffcd56', '#4bc0c0', '#9966ff']
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false
                    }
                });

                new Chart(document.getElementById('topStockProductsChart'), {
                    type: 'pie',
                    data: {
                        labels: topStockProducts.map(p => p.name),
                        datasets: [{
                            data: topStockProducts.map(p => p.stock),
                            backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56', '#4bc0c0', '#9966ff']
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false
                    }
                });

                new Chart(document.getElementById('topBuyersChart'), {
                    type: 'doughnut',
                    data: {
                        labels: topBuyers.map(u => u.full_name),
                        datasets: [{
                            data: topBuyers.map(u => u.total_orders),
                            backgroundColor: ['#4bc0c0', '#ff6384', '#36a2eb', '#ffcd56', '#9966ff']
                        }]
                    },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false
                    }
                });
            </script>
            <!-- Đơn hàng mới nhất -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Đơn hàng mới nhất</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày đặt</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($latestOrders as $order): ?>
                                    <tr>
                                        <td><?php echo $order['id']; ?></td>
                                        <td><?php echo htmlspecialchars($order['full_name']); ?></td>
                                        <td><?php echo number_format($order['total_price']); ?> VNĐ</td>
                                        <td>
                                            <span class="badge badge-<?php echo $this->getStatusBadgeClass($order['status']); ?>">
                                                <?php echo $this->getStatusText($order['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                        <td>
                                            <a href="index.php?controller=order&action=view&id=<?php echo $order['id']; ?>"
                                                class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .filter-form {
                display: flex;
                flex-wrap: wrap;
                gap: 16px;
                align-items: center;
                margin-bottom: 24px;
                background: #f8f9fa;
                padding: 16px 24px;
                border-radius: 8px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            }

            .filter-form label {
                font-weight: 500;
                margin-right: 8px;
            }

            .filter-form input[type="date"] {
                padding: 6px 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }

            .filter-form button {
                padding: 6px 18px;
                border: none;
                border-radius: 4px;
                background: #007bff;
                color: #fff;
                font-weight: 500;
                cursor: pointer;
                transition: background 0.2s;
            }

            .filter-form button:hover {
                background: #0056b3;
            }

            .dashboard-charts-row {
                display: flex;
                flex-wrap: wrap;
                gap: 32px;
                justify-content: center;
                /* Căn giữa các box */
                align-items: flex-start;
                margin-bottom: 32px;
            }

            .dashboard-chart-col {
                flex: 1 1 180px;
                max-width: 220px;
                min-width: 180px;
                background: #fff;
                border-radius: 10px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
                padding: 16px 8px 24px 8px;
                margin: 0 8px;
                display: flex;
                flex-direction: column;
                align-items: center;
                /* Căn giữa nội dung trong box */
            }

            .dashboard-chart-col h5 {
                text-align: center;
                margin-bottom: 12px;
                font-size: 1.1rem;
                font-weight: 600;
            }

            .dashboard-chart-col canvas {
                width: 180px !important;
                height: 180px !important;
                max-width: 180px !important;
                max-height: 180px !important;
                margin: 0 auto;
                display: block;
                background: #fff;
            }

            .dashboard-charts-center {
                width: 100%;
                display: flex;
                justify-content: center;
            }

            .dashboard-charts-row {
                display: flex;
                flex-wrap: wrap;
                gap: 32px;
                justify-content: center;
                align-items: flex-start;
                max-width: 900px;
            }

            @media (max-width: 900px) {
                .dashboard-charts-row {
                    flex-direction: column;
                    align-items: center;
                }

                .dashboard-chart-col {
                    margin-bottom: 24px;
                }
            }
        </style>