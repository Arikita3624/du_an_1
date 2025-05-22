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
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm trong giỏ hàng</h6>
            <?php if (!empty($cartItems)): ?>
                <form action="index.php?controller=cart&action=clear" method="POST" class="d-inline">
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                        <i class="fas fa-trash"></i> Xóa giỏ hàng
                    </button>
                </form>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if (empty($cartItems)): ?>
                <div class="alert alert-info">
                    Giỏ hàng của bạn đang trống. 
                    <a href="index.php?controller=product" class="alert-link">Tiếp tục mua sắm</a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($item['image']): ?>
                                                <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['name']); ?>"
                                                     class="img-thumbnail mr-3" style="width: 50px;">
                                            <?php endif; ?>
                                            <div>
                                                <h6 class="mb-0"><?php echo htmlspecialchars($item['name']); ?></h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($item['discount_price']): ?>
                                            <span class="text-muted text-decoration-line-through">
                                                <?php echo number_format($item['price']); ?>đ
                                            </span>
                                            <br>
                                            <span class="text-danger font-weight-bold">
                                                <?php echo number_format($item['discount_price']); ?>đ
                                            </span>
                                        <?php else: ?>
                                            <?php echo number_format($item['price']); ?>đ
                                        <?php endif; ?>
                                    </td>
                                    <td style="width: 150px;">
                                        <form action="index.php?controller=cart&action=update" method="POST" class="d-flex align-items-center">
                                            <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                                   min="1" class="form-control form-control-sm mr-2" style="width: 70px;">
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="font-weight-bold">
                                        <?php 
                                        $itemTotal = $item['discount_price'] 
                                            ? $item['discount_price'] * $item['quantity']
                                            : $item['price'] * $item['quantity'];
                                        echo number_format($itemTotal); ?>đ
                                    </td>
                                    <td>
                                        <form action="index.php?controller=cart&action=remove" method="POST" class="d-inline">
                                            <input type="hidden" name="cart_item_id" value="<?php echo $item['id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right font-weight-bold">Tổng cộng:</td>
                                <td class="font-weight-bold text-danger"><?php echo number_format($total); ?>đ</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="text-right mt-4">
                    <a href="index.php?controller=product" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Tiếp tục mua sắm
                    </a>
                    <a href="index.php?controller=order&action=checkout" class="btn btn-primary">
                        <i class="fas fa-shopping-cart"></i> Thanh toán
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div> 