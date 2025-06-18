<div class="container-fluid">
    <h2 class="mb-4">Quản lý giỏ hàng</h2>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Người dùng</th>
                            <th>Số sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($carts)): ?>
                            <?php foreach ($carts as $cart): ?>
                                <tr>
                                    <td><?php echo $cart['id']; ?></td>
                                    <td><?php echo htmlspecialchars($cart['full_name']); ?></td>
                                    <td><?php echo $cart['total_items']; ?></td>
                                    <td><?php echo number_format($cart['total_amount'], 0, ',', '.'); ?> VNĐ</td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($cart['created_at'])); ?></td>
                                    <td>
                                        <a href="index.php?controller=cart&action=view&id=<?php echo $cart['id']; ?>"
                                           class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST" action="index.php?controller=cart&action=delete"
                                              class="d-inline" onsubmit="return confirm('Bạn có chắc muốn xóa giỏ hàng này?');">
                                            <input type="hidden" name="id" value="<?php echo $cart['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">Không có giỏ hàng nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>