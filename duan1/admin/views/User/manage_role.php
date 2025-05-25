<div class="container-fluid">
    <h1 class="mt-4">Phân quyền người dùng: <?php echo htmlspecialchars($user['username']); ?></h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?controller=user">Quản lý người dùng</a></li>
        <li class="breadcrumb-item active">Phân quyền</li>
    </ol>

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
            <h6 class="m-0 font-weight-bold text-primary">Chọn vai trò</h6>
        </div>
        <div class="card-body">
            <form action="index.php?controller=user&action=updateRole" method="POST">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <div class="form-group">
                    <label for="role">Vai trò</label>
                    <select class="form-control" id="role" name="role">
                        <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Người dùng</option>
                        <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Quản trị viên</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="index.php?controller=user" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div> 