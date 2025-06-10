<div class="container-fluid">
    <h1 class="mt-4">Thêm người dùng mới</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?controller=user">Quản lý người dùng</a></li>
        <li class="breadcrumb-item active">Thêm mới</li>
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
            <h6 class="m-0 font-weight-bold text-primary">Thông tin người dùng mới</h6>
        </div>
        <div class="card-body">
            <form action="index.php?controller=user&action=create" method="POST">
                <div class="form-group">
                    <label for="username">Tên đăng nhập <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="full_name">Họ tên <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                 <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone">
                </div>
                 <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                </div>
                 <div class="form-group">
                    <label for="role">Vai trò <span class="text-danger">*</span></label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="user">Người dùng</option>
                        <option value="admin">Quản trị viên</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Thêm người dùng</button>
                <a href="index.php?controller=user" class="btn btn-secondary">Hủy</a>
            </form>
        </div>
    </div>
</div> 