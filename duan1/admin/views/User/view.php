<div class="container-fluid">
    <h1 class="mt-4">Chi tiết người dùng: <?php echo htmlspecialchars($user['username']); ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?controller=user">Quản lý người dùng</a></li>
        <li class="breadcrumb-item active">Chi tiết</li>
    </ol>

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
            <h6 class="m-0 font-weight-bold text-primary">Thông tin chi tiết</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th style="width: 200px;">ID</th>
                    <td><?php echo $user['id']; ?></td>
                </tr>
                <tr>
                    <th>Tên đăng nhập</th>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                </tr>
                <tr>
                    <th>Họ tên</th>
                    <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                </tr>
                <tr>
                    <th>Số điện thoại</th>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                </tr>
                <tr>
                    <th>Địa chỉ</th>
                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                </tr>
                <tr>
                    <th>Vai trò</th>
                    <td>
                        <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'info'; ?>">
                            <?php echo $user['role'] === 'admin' ? 'Quản trị viên' : 'Người dùng'; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Trạng thái</th>
                    <td>
                        <span class="badge bg-<?php echo $user['status'] === 'active' ? 'success' : 'danger'; ?>">
                            <?php echo $user['status'] === 'active' ? 'Hoạt động' : 'Khóa'; ?>
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Ngày tạo</th>
                    <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                </tr>
                <tr>
                    <th>Ngày cập nhật</th>
                    <td><?php echo date('d/m/Y H:i', strtotime($user['updated_at'])); ?></td>
                </tr>
            </table>
            <div class="mt-3">

                 <a href="index.php?controller=user&action=toggleStatus&id=<?php echo $user['id']; ?>" 
                   class="btn btn-<?php echo $user['status'] === 'active' ? 'warning' : 'success'; ?>"
                   onclick="return confirm('Bạn có chắc chắn muốn <?php echo $user['status'] === 'active' ? 'khóa' : 'mở khóa'; ?> người dùng này?')">
                    <i class="fas fa-<?php echo $user['status'] === 'active' ? 'lock' : 'unlock'; ?>"></i> <?php echo $user['status'] === 'active' ? 'Khóa' : 'Mở khóa'; ?>
                </a>
                 <a href="index.php?controller=user&action=manageRole&id=<?php echo $user['id']; ?>" 
                   class="btn btn-secondary">
                    <i class="fas fa-user-tag"></i> Phân quyền
                </a>

                <a href="index.php?controller=user" class="btn btn-secondary">Quay lại</a>
            </div>
        </div>
    </div>
</div> 