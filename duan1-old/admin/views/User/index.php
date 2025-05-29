<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý người dùng</h1>
        <a href="index.php?controller=user&action=create" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Thêm người dùng
        </a>
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
            <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
        </div>
        <div class="card-body">
            <!-- Form tìm kiếm -->
            <form action="index.php" method="GET" class="mb-4">
                <input type="hidden" name="controller" value="user">
                <div class="input-group">
                    <input type="text" class="form-control" name="keyword" 
                           placeholder="Tìm kiếm theo tên đăng nhập, họ tên, email, số điện thoại..." 
                           value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                        <?php if (!empty($_GET['keyword'])): ?>
                            <a href="index.php?controller=user" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Xóa tìm kiếm
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" id="datatablesSimple" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên đăng nhập</th>
                            <th>Họ tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Vai trò</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['full_name']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td><?php echo $user['phone']; ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'info'; ?>">
                                        <?php echo $user['role'] === 'admin' ? 'Quản trị viên' : 'Người dùng'; ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?php echo $user['status'] === 'active' ? 'success' : 'danger'; ?>">
                                        <?php echo $user['status'] === 'active' ? 'Hoạt động' : 'Khóa'; ?>
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <a href="index.php?controller=user&action=view&id=<?php echo $user['id']; ?>" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <a href="index.php?controller=user&action=toggleStatus&id=<?php echo $user['id']; ?>" 
                                       class="btn btn-<?php echo $user['status'] === 'active' ? 'warning' : 'success'; ?> btn-sm"
                                       onclick="return confirm('Bạn có chắc chắn muốn <?php echo $user['status'] === 'active' ? 'khóa' : 'mở khóa'; ?> người dùng này?')">
                                        <i class="fas fa-<?php echo $user['status'] === 'active' ? 'lock' : 'unlock'; ?>"></i> <?php echo $user['status'] === 'active' ? 'Khóa' : 'Mở khóa'; ?>
                                    </a>
                                     <a href="index.php?controller=user&action=manageRole&id=<?php echo $user['id']; ?>" 
                                       class="btn btn-secondary btn-sm">
                                        <i class="fas fa-user-tag"></i> Phân quyền
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