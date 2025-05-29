<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quản lý sản phẩm</h1>
        <a href="index.php?controller=product&action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm sản phẩm mới
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
        <div class="card-body">

            <form action="index.php" method="GET" class="form-inline mb-4">
                <input type="hidden" name="controller" value="product">
                <div class="form-group mr-2">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm theo tên..." value="<?php echo htmlspecialchars($keyword ?? ''); ?>">
                </div>
                <div class="form-group mr-2">
                    <select name="category_id" class="form-control">
                        <option value="">-- Chọn danh mục --</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo $cat['id']; ?>" <?php echo ($categoryId == $cat['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Tìm kiếm</button>
                <a href="index.php?controller=product" class="btn btn-secondary"><i class="fas fa-sync-alt"></i> Reset</a>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Hình ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $product['id']; ?></td>
                                <td>
                                    <?php if (!empty($product['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                                            alt="<?php echo htmlspecialchars($product['name']); ?>"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php else: ?>
                                        <img src="assets/img/no-image.jpg" alt="No image"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    <?php endif; ?>
                                </td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td><?php echo htmlspecialchars($product['category_name'] ?? 'Chưa phân loại'); ?></td>
                                <td><?php echo number_format($product['price']); ?> VNĐ</td>
                                <td><?php echo number_format($product['stock']); ?></td>
                                <td>
                                    <a href="index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>"
                                        class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="index.php?controller=product&action=delete&id=<?php echo $product['id']; ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Không tìm thấy sản phẩm nào.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo ($page > 1) ? 'index.php?controller=product&page=' . ($page - 1) . (($keyword) ? '&keyword=' . urlencode($keyword) : '') . (($categoryId) ? '&category_id=' . urlencode($categoryId) : '') : '#'; ?>">Trước</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="<?php echo 'index.php?controller=product&page=' . $i . (($keyword) ? '&keyword=' . urlencode($keyword) : '') . (($categoryId) ? '&category_id=' . urlencode($categoryId) : ''); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                        <a class="page-link" href="<?php echo ($page < $totalPages) ? 'index.php?controller=product&page=' . ($page + 1) . (($keyword) ? '&keyword=' . urlencode($keyword) : '') . (($categoryId) ? '&category_id=' . urlencode($categoryId) : '') : '#'; ?>">Sau</a>
                    </li>
                </ul>
            </nav>

        </div>
    </div>
</div>