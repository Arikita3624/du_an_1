<style>
    .product-add-container {
        max-width: 600px;
        margin: 40px auto;
        padding: 30px;
        background-color: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .product-add-container h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #1a202c;
        font-size: 24px;
        font-weight: 600;
    }

    .product-add-form label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #2d3748;
        font-size: 14px;

    }

    .product-add-form input[type="text"],
    .product-add-form input[type="number"],
    .product-add-form textarea,
    .product-add-form select {
        width: 100%;
        padding: 12px;
        margin-bottom: 20px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 14px;
        background-color: #f7fafc;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .product-add-form input[type="text"]:focus,
    .product-add-form input[type="number"]:focus,
    .product-add-form textarea:focus,
    .product-add-form select:focus {
        outline: none;
        border-color: #3182ce;
        box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.2);
    }

    .product-add-form textarea {
        resize: vertical;
        min-height: 100px;
    }

    .product-add-form button[type="submit"] {
        width: 100%;
        background-color: #3182ce;
        color: #ffffff;
        border: none;
        padding: 12px;
        border-radius: 6px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .product-add-form button[type="submit"]:hover {
        background-color: #2b6cb0;
    }

    .product-add-form button[type="submit"]:disabled {
        background-color: #a0aec0;
        cursor: not-allowed;
    }

    .alert-error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .form-group {
        margin-bottom: 20px;
    }
</style>

<div class="product-add-container">
    <?php if (isset($_GET['status']) && $_GET['status'] === 'error'): ?>
        <div class="alert-error">
            <?= htmlspecialchars(urldecode($_GET['message'] ?? 'Có lỗi xảy ra khi thêm sản phẩm!')); ?>
        </div>
    <?php endif; ?>

    <h2>Thêm sản phẩm mới</h2>

    <form class="product-add-form" method="post" action="index.php?act=product-store">
        <div class="form-group">
            <label for="name">Tên:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="slug">Slug:</label>
            <input type="text" name="slug" id="slug" required>
        </div>

        <div class="form-group">
            <label for="description">Mô tả:</label>
            <textarea name="description" id="description" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Giá:</label>
            <input type="number" step="0.01" name="price" id="price" required>
        </div>

        <div class="form-group">
            <label for="sale_price">Giá sale:</label>
            <input type="number" step="0.01" name="sale_price" id="sale_price">
        </div>

        <div class="form-group">
            <label for="stock">Tồn kho:</label>
            <input type="number" name="stock" id="stock" value="0" required>
        </div>

        <div class="form-group">
            <label for="image">Ảnh:</label>
            <input type="text" name="image" id="image">
        </div>

        <div class="form-group">
            <label for="category_id">Danh mục:</label>
            <select name="category_id" id="category_id" required>
                <option value="">Chọn danh mục</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Trạng thái:</label>
            <select name="product_status" id="status" required>
                <option value="active" <?= (isset($_POST['product_status']) && $_POST['product_status'] === 'active') ? 'selected' : ''; ?>>Active</option>
                <option value="inactive" <?= (isset($_POST['product_status']) && $_POST['product_status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
            </select>

        </div>

        <button type="submit">Thêm</button>
    </form>
</div>