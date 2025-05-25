<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý đơn hàng</h1>
        <!-- Nút thêm mới đơn hàng (nếu có) -->
        <!-- <a href="index.php?controller=order&action=create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Thêm đơn hàng
        </a> -->
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
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Thanh toán</th>
                            <th>Ngày đặt</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?php echo $order['id']; ?></td>
                                <td><?php echo $order['customer_name']; ?></td>
                                <td><?php echo number_format($order['total_amount']); ?> VNĐ</td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo match($order['status']) {
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'secondary'
                                        };
                                    ?>">
                                        <?php 
                                        echo match($order['status']) {
                                            'pending' => 'Chờ xử lý',
                                            'processing' => 'Đang xử lý',
                                            'completed' => 'Hoàn thành',
                                            'cancelled' => 'Đã hủy',
                                            default => 'Không xác định'
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php 
                                        echo match($order['payment_status']) {
                                            'pending' => 'warning',
                                            'paid' => 'success',
                                            'failed' => 'danger',
                                            default => 'secondary'
                                        };
                                    ?>">
                                        <?php 
                                        echo match($order['payment_status']) {
                                            'pending' => 'Chờ thanh toán',
                                            'paid' => 'Đã thanh toán',
                                            'failed' => 'Thanh toán thất bại',
                                            default => 'Không xác định'
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($order['created_at'])); ?></td>
                                <td>
                                    <a href="index.php?controller=order&action=view&id=<?php echo $order['id']; ?>" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <a href="index.php?controller=order&action=edit&id=<?php echo $order['id']; ?>" 
                                       class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="index.php?controller=order&action=delete&id=<?php echo $order['id']; ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?')">
                                        <i class="fas fa-trash"></i> Xóa
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