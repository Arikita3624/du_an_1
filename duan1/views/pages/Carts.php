    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__text">
                        <h4>Shopping Cart</h4>
                        <div class="breadcrumb__links">
                            <a href="?act=/">Home</a>
                            <a href="?act=product-list">Shop</a>
                            <span>Shopping Cart</span>
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
                        <table>
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $cart = $_SESSION['cart'] ?? [];
                                $total = 0;
                                foreach ($cart as $item):
                                    $item_total = $item['price'] * $item['quantity'];
                                    $total += $item_total;
                                ?>
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="<?= !empty($item['image']) ? 'admin/' . htmlspecialchars($item['image']) : 'assets/img/no-image.jpg' ?>" alt="" style="width:70px;">
                                            </div>
                                            <div class="product__cart__item__text">
                                                <h6><?= htmlspecialchars($item['name']) ?></h6>
                                                <h5><?= number_format($item['price'], 0, ',', '.') ?>₫</h5>
                                            </div>
                                        </td>
                                        <td class="quantity__item">
                                            <form method="post" action="?act=update-cart" style="display:inline-flex;">
                                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                                <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" style="width:50px;text-align:center;">
                                                <button type="submit" style="margin-left:5px;">Cập nhật</button>
                                            </form>
                                        </td>
                                        <td class="cart__price"><?= number_format($item_total, 0, ',', '.') ?>₫</td>
                                        <td class="cart__close">
                                            <form method="post" action="?act=remove-cart" style="display:inline;">
                                                <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                                                <button type="submit" style="background:none;border:none;color:red;font-size:18px;"><i class="fa fa-close"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn">
                                <a href="#">Continue Shopping</a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="continue__btn update__btn">
                                <a href="#"><i class="fa fa-spinner"></i> Update cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="cart__discount">
                        <h6>Discount codes</h6>
                        <form action="#">
                            <input type="text" placeholder="Coupon code">
                            <button type="submit">Apply</button>
                        </form>
                    </div>
                    <div class="cart__total">
                        <ul>
                            <li>Subtotal <span><?= number_format($total, 0, ',', '.') ?>₫</span></li>
                            <li>Total <span><?= number_format($total, 0, ',', '.') ?>₫</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shopping Cart Section End -->