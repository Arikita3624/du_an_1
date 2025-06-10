<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__text">
                    <h4>Giỏ Hàng</h4>
                    <div class="breadcrumb__links">
                        <a href="?act=/">Trang Chủ</a>
                        <a href="?act=product-list">Cửa Hàng</a>
                        <span>Giỏ Hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="shopping__cart__table">
                    <?php if (!empty($cartItems)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Sản Phẩm</th>
                                    <th>Số Lượng</th>
                                    <th>Thành Tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0;
                                foreach ($cartItems as $item):
                                    $itemTotal = $item['total_price'];
                                    $total += $itemTotal;
                                ?>
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="<?= !empty($item['image']) ? 'admin/' . htmlspecialchars($item['image']) : 'assets/img/no-image.jpg' ?>" alt="" style="width:70px;">
                                            </div>
                                            <div class="product__cart__item__text">
                                                <h6><?= htmlspecialchars($item['name']) ?></h6>
                                                <h5 class="item-price"><?= number_format($item['price'], 0, ',', '.') ?>₫</h5>
                                            </div>
                                        </td>
                                        <td class="quantity__item">
                                            <form method="post" action="?act=update-cart" style="display:inline;" class="update-form">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?? $item['id'] ?>">
                                                
                                                <button type="submit" class="btn btn-sm btn-primary">Cập Nhật</button>
                                            </form>
                                        </td>
                                        <td class="cart__price item-total"><?= number_format($itemTotal, 0, ',', '.') ?>₫</td>
                                        <td class="cart__close">
                                            <form method="post" action="?act=remove-cart-item" style="display:inline;">
                                                <input type="hidden" name="product_id" value="<?= $item['product_id'] ?? $item['id'] ?>">
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                                    <i class="fa fa-close"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Giỏ hàng của bạn đang trống.</p>
                    <?php endif; ?>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="?act=product-list">Tiếp Tục Mua Hàng</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart__total">
                    <h6>Tổng Giỏ Hàng</h6>
                    <ul>
                        <li>Tổng Cộng <span id="cart-total"><?= isset($total) ? number_format($total, 0, ',', '.') : 0 ?>₫</span></li>
                    </ul>
                    <?php if (!empty($cartItems)): ?>
                        <a href="?act=checkout" class="primary-btn btn btn-success btn-block">Thanh Toán</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->

<style>
    .cart__close button,
.cart__close .btn-danger {
    background: #e53637 !important;
    border: none !important;
    border-radius: 12px !important;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
    transition: background 0.2s;
    box-shadow: none !important;
}

.cart__close button:hover,
.cart__close .btn-danger:hover {
    background: #b91c1c !important;
}

.cart__close .fa-close {
    color: #222;
    font-size: 24px;
    margin: 0;
}

/* Nút cập nhật style đơn giản, bo góc, nền đen */
.btn-update-cart,
.btn.btn-primary {
    background: #111 !important;
    color: #fff !important;
    border: none !important;
    border-radius: 6px !important;
    padding: 6px 18px !important;
    font-weight: 600;
    transition: background 0.2s;
}

.btn-update-cart:hover,
.btn.btn-primary:hover {
    background: #e53637 !important;
    color: #fff !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hàm định dạng số tiền
    function formatMoney(amount) {
        return new Intl.NumberFormat('vi-VN').format(amount) + '₫';
    }

    // Hàm cập nhật tổng tiền
    function updateTotal() {
        let total = 0;
        document.querySelectorAll('.item-total').forEach(function(element) {
            total += parseInt(element.getAttribute('data-total') || 0);
        });
        document.getElementById('cart-total').textContent = formatMoney(total);
    }

    // Xử lý sự kiện thay đổi số lượng
    document.querySelectorAll('.quantity-input').forEach(function(input) {
        input.addEventListener('change', function() {
            const price = parseInt(this.getAttribute('data-price'));
            const quantity = parseInt(this.value);
            const total = price * quantity;
            
            // Cập nhật thành tiền của sản phẩm
            const itemTotal = this.closest('tr').querySelector('.item-total');
            itemTotal.textContent = formatMoney(total);
            itemTotal.setAttribute('data-total', total);
            
            // Cập nhật tổng tiền
            updateTotal();
        });
    });

    // Xử lý submit form
    document.querySelectorAll('.update-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            // Gửi request cập nhật
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(() => {
                // Reload trang sau khi cập nhật thành công
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật giỏ hàng!');
            });
        });
    });
});
</script>