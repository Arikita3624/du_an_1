<?php
require_once __DIR__ . '/../../../commons/helpers.php';
$title = "Quản lý đơn hàng";
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý đơn hàng</h1>
    </div>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
             <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="index.php" method="GET" class="form-inline mb-4">
                <input type="hidden" name="controller" value="order">
                <div class="form-group mr-2">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo tên khách hàng..." value="<?php echo htmlspecialchars($keyword ?? ''); ?>">
                </div>
                <div class="form-group mr-2">
                    <select name="status" class="form-control">
                        <option value="">-- Chọn trạng thái --</option>
                        <option value="pending" <?php echo ($status == 'pending') ? 'selected' : ''; ?>>Chờ xử lý</option>
                        <option value="processing" <?php echo ($status == 'processing') ? 'selected' : ''; ?>>Đang xử lý</option>
                        <option value="delivering" <?php echo ($status == 'delivering') ? 'selected' : ''; ?>>Đang giao hàng</option>
                        <option value="completed" <?php echo ($status == 'completed') ? 'selected' : ''; ?>>Đã giao hàng</option>
                        <option value="finished" <?php echo ($status == 'finished') ? 'selected' : ''; ?>>Hoàn thành</option>
                        <option value="cancelled" <?php echo ($status == 'cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Tìm kiếm</button>
                <a href="index.php?controller=order" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Tổng tiền</th>
                            <th>Phương thức thanh toán</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo htmlspecialchars($order['customer_name'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($order['phone']); ?></td>
                                <td><?php echo number_format($order['total_amount']); ?> VNĐ</td>
                                <td><?php
                                    switch ($order['payment_method']) {
                                        case 'cod':
                                            echo 'Thanh toán khi nhận hàng (COD)';
                                            break;
                                        case 'bank_transfer':
                                            echo 'Chuyển khoản ngân hàng';
                                            break;
                                        default:
                                            echo 'Không xác định';
                                            break;
                                    }
                                ?></td>
                                <td>
                                    <span class="badge badge-<?php echo getPaymentStatusBadgeClass($order['payment_status']); ?>">
                                        <?php echo getPaymentStatusText($order['payment_status']); ?>
                                    </span>
                                </td>
                                <td>
                                        <span class="badge badge-<?php echo getStatusBadgeClass($order['status']); ?>">
                                            <?php echo getStatusText($order['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <a href="index.php?controller=order&action=view&id=<?php echo $order['id']; ?>"
                                       class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                    </a>
                                        <button type="button"
                                                class="btn btn-primary btn-sm"
                                                data-toggle="modal"
                                                data-target="#updateStatusModal<?php echo $order['id']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    <a href="index.php?controller=order&action=delete&id=<?php echo $order['id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                            <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                                </tr>

                                <!-- Modal cập nhật trạng thái -->
                                <div class="modal fade" id="updateStatusModal<?php echo $order['id']; ?>" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Cập nhật trạng thái đơn hàng #<?php echo $order['id']; ?></h5>
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span>&times;</span>
                                                </button>
                                            </div>
                                            <form action="index.php?controller=order&action=updateStatus" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                                                    <div class="form-group">
                                                        <label>Trạng thái</label>
                                                        <select name="status" class="form-control">
                                                            <option value="pending" <?php echo $order['status'] == 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                                                            <option value="processing" <?php echo $order['status'] == 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                                                            <option value="delivering" <?php echo $order['status'] == 'delivering' ? 'selected' : ''; ?>>Đang giao hàng</option>
                                                            <option value="completed" <?php echo $order['status'] == 'completed' ? 'selected' : ''; ?>>Đã giao hàng</option>
                                                            <option value="finished" <?php echo $order['status'] == 'finished' ? 'selected' : ''; ?>>Hoàn thành</option>
                                                            <option value="cancelled" <?php echo $order['status'] == 'cancelled' ? 'selected' : ''; ?>>Đã hủy</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                                    <button type="submit" class="btn btn-primary">Cập nhật</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">Không có đơn hàng nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo ($page > 1) ? 'index.php?controller=order&page=' . ($page - 1) . (($keyword) ? '&keyword=' . urlencode($keyword) : '') . (($status) ? '&status=' . urlencode($status) : '') : '#'; ?>">Trước</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo 'index.php?controller=order&page=' . $i . (($keyword) ? '&keyword=' . urlencode($keyword) : '') . (($status) ? '&status=' . urlencode($status) : ''); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo ($page < $totalPages) ? 'index.php?controller=order&page=' . ($page + 1) . (($keyword) ? '&keyword=' . urlencode($keyword) : '') . (($status) ? '&status=' . urlencode($status) : '') : '#'; ?>">Sau</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>