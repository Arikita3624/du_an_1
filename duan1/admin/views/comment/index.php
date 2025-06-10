<?php
$title = "Quản lý bình luận";
?>

<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Quản lý bình luận</h1>

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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người bình luận</th>
                            <th>Sản phẩm</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Ngày bình luận</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($comments)): ?>
                            <?php foreach ($comments as $comment): ?>
                                <tr>
                                    <td><?php echo $comment['id']; ?></td>
                                    <td><?php echo htmlspecialchars($comment['username']); ?></td>
                                    <td><?php echo htmlspecialchars($comment['product_name']); ?></td>
                                    <td><?php echo nl2br(htmlspecialchars($comment['comment_text'])); ?></td>
                                    <td>
                                        <?php 
                                            $statusClass = 'secondary';
                                            $statusText = 'Không xác định';
                                            switch ($comment['status']) {
                                                case 'pending':
                                                    $statusClass = 'warning';
                                                    $statusText = 'Chờ duyệt';
                                                    break;
                                                case 'approved':
                                                    $statusClass = 'success';
                                                    $statusText = 'Đã duyệt';
                                                    break;
                                                case 'rejected':
                                                    $statusClass = 'danger';
                                                    $statusText = 'Đã từ chối';
                                                    break;
                                            }
                                        ?>
                                        <span class="badge badge-<?php echo $statusClass; ?>">
                                            <?php echo $statusText; ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></td>
                                    <td>
                                        <?php if ($comment['status'] === 'pending'): ?>
                                            <a href="index.php?controller=comment&action=approve&id=<?php echo $comment['id']; ?>" 
                                               class="btn btn-success btn-sm mb-1">
                                                <i class="fas fa-check"></i> Duyệt
                                            </a>
                                            <a href="index.php?controller=comment&action=reject&id=<?php echo $comment['id']; ?>" 
                                               class="btn btn-warning btn-sm mb-1">
                                                <i class="fas fa-times"></i> Từ chối
                                            </a>
                                        <?php endif; ?>
                                        <a href="index.php?controller=comment&action=delete&id=<?php echo $comment['id']; ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Bạn có chắc chắn muốn xóa bình luận này?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" class="text-center">Không có bình luận nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div> 