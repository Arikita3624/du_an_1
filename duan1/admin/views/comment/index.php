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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách bình luận chờ duyệt</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sản phẩm</th>
                            <th>Người dùng</th>
                            <th>Nội dung</th>
                            <th>Đánh giá</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>
                            <tr>
                                <td><?php echo $comment['id']; ?></td>
                                <td><?php echo htmlspecialchars($comment['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($comment['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($comment['content']); ?></td>
                                <td>
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo $i <= $comment['rating'] ? 'text-warning' : 'text-muted'; ?>"></i>
                                    <?php endfor; ?>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></td>
                                <td>
                                    <a href="index.php?controller=comment&action=view&id=<?php echo $comment['id']; ?>" 
                                       class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="index.php?controller=comment&action=approve" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Bạn có chắc muốn duyệt bình luận này?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="index.php?controller=comment&action=reject" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Bạn có chắc muốn từ chối bình luận này?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                    <form action="index.php?controller=comment&action=delete" method="POST" class="d-inline">
                                        <input type="hidden" name="id" value="<?php echo $comment['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa bình luận này?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 