<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Chỉnh sửa sản phẩm</h1>
        <a href="index.php?controller=product" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <?php if (!empty($errors['general'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($errors['general']); ?>
                </div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form action="index.php?controller=product&action=edit&id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" class="form-control" id="name" name="name"
                           value="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php if (!empty($errors['name'])): ?>
                        <div class="text-danger"><?php echo $errors['name']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?php
                        echo htmlspecialchars($product['description'] ?? '');
                    ?></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="number" class="form-control" id="price" name="price"
                           value="<?php echo htmlspecialchars($product['price']); ?>">
                    <?php if (!empty($errors['price'])): ?>
                        <div class="text-danger"><?php echo $errors['price']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="category_id">Danh mục</label>
                    <select class="form-control" id="category_id" name="category_id">
                        <option value="">Chọn danh mục</option>
                        <?php foreach ($categories as $category): ?>
                        <option value="<?php echo $category['id']; ?>"
                                <?php echo $category['id'] == $product['category_id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['category_id'])): ?>
                        <div class="text-danger"><?php echo $errors['category_id']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="image">Hình ảnh</label>
                    <?php if (!empty($product['image'])): ?>
                    <div class="mb-2">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>"
                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                             style="max-width: 200px;">
                    </div>
                    <?php endif; ?>
                    <input type="file" class="form-control-file" id="image" name="image" accept="image/*">
                    <small class="form-text text-muted">Để trống nếu không muốn thay đổi hình ảnh</small>
                    <?php if (!empty($errors['image'])): ?>
                        <div class="text-danger"><?php echo $errors['image']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="stock">Tồn kho</label>
                    <input type="number" class="form-control" id="stock" name="stock"
                           value="<?php echo htmlspecialchars($product['stock']); ?>">
                    <?php if (!empty($errors['stock'])): ?>
                        <div class="text-danger"><?php echo $errors['stock']; ?></div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            </form>
        </div>
    </div>