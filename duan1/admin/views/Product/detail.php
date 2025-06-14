<?php require_once __DIR__ . '/../../../commons/helpers.php'; ?>
<div class="container mt-4">
    <div>
        <h2 class="text-center mb-4 p-4 bg-light text-dark rounded shadow-sm">
            Chi tiết sản phẩm: <?= htmlspecialchars($product['name']) ?>
        </h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0" style="border-radius: 18px;">
                <div class="row g-0 align-items-center">
                    <?php if (!empty($product['image'])): ?>
                        <div class="col-md-5 d-flex align-items-center justify-content-center p-4 bg-light" style="border-radius: 18px 0 0 18px;">
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                                class="img-fluid rounded shadow" style="max-height:260px;">
                        </div>
                    <?php endif; ?>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h3 class="card-title mb-3 text-primary"><?= htmlspecialchars($product['name']) ?></h3>
                            <h5 class="text-success mb-3 fw-bold"><?= number_format($product['price']) ?> VNĐ</h5>
                            <p class="mb-3"><strong>Mô tả:</strong> <br><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                            <p class="mb-3"><strong>Số lượng tồn kho:</strong> <span class="badge bg-warning text-dark"><?= $product['stock'] ?></span></p>
                            <a href="index.php?controller=product" class="btn btn-outline-primary mt-2 rounded-pill px-4 fw-bold">
                                <i class="bi bi-arrow-left"></i> Quay lại danh sách sản phẩm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php if (empty($product)): ?>
                <div class="alert alert-danger mt-3">Không tìm thấy sản phẩm.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Nếu dùng Bootstrap 5, thêm link icon nếu muốn -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">