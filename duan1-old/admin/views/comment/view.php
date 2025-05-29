<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chi tiết bình luận</h1>
        <a href="index.php?controller=comment" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Quay lại
        </a>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php 
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Thông tin bình luận</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>ID:</strong> <?php echo $comment['id']; ?></p>
                    <p><strong>Sản phẩm:</strong> <?php echo htmlspecialchars($comment['product_name']); ?></p>
                    <p><strong>Người dùng:</strong> <?php echo htmlspecialchars($comment['full_name']); ?></p>
                    <p><strong>Username:</strong> <?php echo htmlspecialchars($comment['username']); ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Đánh giá:</strong>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star <?php echo $i <= $comment['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                        <?php endfor; ?>
                    </p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="badge badge-<?php 
                            echo $comment['status'] === 'approved' ? 'success' : 
                                ($comment['status'] === 'rejected' ? 'danger' : 'warning'); 
                        ?>">
                            <?php 
                            echo $comment['status'] === 'approved' ? 'Đã duyệt' : 
                                ($comment['status'] === 'rejected' ? 'Đã từ chối' : 'Chờ duyệt'); 
                            ?>
                        </span>
                    </p>
                    <p><strong>Ngày tạo:</strong> <?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></p>
                    <p><strong>Ngày cập nhật:</strong> <?php echo date('d/m/Y H:i', strtotime($comment['updated_at'])); ?></p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <p><strong>Nội dung:</strong></p>
                    <div class="p-3 bg-light rounded">
                        <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <?php if ($comment['status'] === 'pending'): ?>
                        <form action="index.php?controller=comment&action=approve" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Bạn có chắc muốn duyệt bình luận này?')">
                                <i class="fas fa-check"></i> Duyệt
                            </button>
                        </form>
                        <form action="index.php?controller=comment&action=reject" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Bạn có chắc muốn từ chối bình luận này?')">
                                <i class="fas fa-times"></i> Từ chối
                            </button>
                        </form>
                    <?php endif; ?>
                    <form action="index.php?controller=comment&action=delete" method="POST" class="d-inline">
                        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                            <i class="fas fa-trash"></i> Xóa
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function () {
        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
    });
</script>
</body>
</html> 