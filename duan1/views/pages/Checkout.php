<!-- Checkout Section Begin -->
<section class="checkout spad">
    <div class="container">
        <div class="checkout__form">
            <form action="?act=process-checkout" method="POST" id="checkoutForm">
                <div class="row">
                    <div class="col-lg-8 col-md-6">
                        <h6 class="coupon__code"><span class="icon_tag_alt"></span> Have a coupon? <a href="#">Click here</a> to enter your code</h6>
                        <h6 class="checkout__title">Billing Details</h6>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Họ tênn<span>*</span></p>
                                    <input type="text" name="first_name" required>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Tên người nhận<span>*</span></p>
                                    <input type="text" name="last_name" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input">
                            <p>Khu vực<span>*</span></p>
                            <input type="text" name="country" required>
                        </div>
                        <div class="checkout__input">
                            <p>Địa chỉ<span>*</span></p>
                            <input type="text" placeholder="Street Address" class="checkout__input__add" name="street_address" required>
                            <input type="text" placeholder="Apartment, suite, unite ect (optional)" name="apartment">
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Số điện thoại<span>*</span></p>
                                    <input type="text" name="phone" required pattern="[0-9]+" title="Please enter a valid phone number">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="checkout__input">
                                    <p>Email<span>*</span></p>
                                    <input type="email" name="email" required>
                                </div>
                            </div>
                        </div>
                        <div class="checkout__input__checkbox">
                            <label for="diff-acc">
                                Ghi chú
                                <input type="checkbox" id="diff-acc">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <div class="checkout__input">
                            <p>Nội dung</p>
                            <input type="text" placeholder="Notes about your order, e.g. special notes for delivery." name="order_notes">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="checkout__order">
                            <h4 class="order__title">Đơn hàng của bạn</h4>
                            <div class="checkout__order__products">Sản phẩm <span>Tổng giá</span></div>
                            <ul class="checkout__total__products">
                                <?php
                                $total = 0;
                                if (!empty($cartItems)) {
                                    foreach ($cartItems as $index => $item) {
                                        $itemTotal = $item['total_price'];
                                        $total += $itemTotal;
                                ?>
                                        <li>
                                            <img src="<?= !empty($item['image']) ? 'admin/' . htmlspecialchars($item['image']) : 'assets/img/no-image.jpg' ?>" alt="" style="width: 50px;">
                                            <?= sprintf("%02d", $index + 1) ?>. <?= htmlspecialchars($item['name']) ?> <span><?= number_format($itemTotal, 0, ',', '.') ?>₫</span>
                                        </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                            <ul class="checkout__total__all">
                                <li>Subtotal <span><?= number_format($total, 0, ',', '.') ?>₫</span></li>
                                <li>Total <span><?= number_format($total, 0, ',', '.') ?>₫</span></li>
                            </ul>
                            <div class="checkout__input__checkbox">
                                <label for="cod">
                                    Thanh toán khi nhận hàng (COD)
                                    <input type="radio" id="cod" name="payment_method" value="cod" checked>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="payment">
                                    Chuyển khoản ngân hàng
                                    <input type="radio" id="payment" name="payment_method" value="banking">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="checkout__input__checkbox">
                                <label for="paypal">
                                    Paypal
                                    <input type="radio" id="paypal" name="payment_method" value="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">Thanh toán</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- Checkout Section End -->
<style>
    .checkout__form {
        background: #fff;
        padding: 40px 30px 30px 30px;
        border-radius: 8px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        margin-bottom: 40px;
    }

    .checkout__title {
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 25px;
        color: #111;
    }

    .checkout__input {
        margin-bottom: 18px;
    }

    .checkout__input p {
        margin-bottom: 8px;
        font-weight: 600;
        color: #111;
    }

    .checkout__input input[type="text"],
    .checkout__input input[type="email"] {
        width: 100%;
        border: 1px solid #ebebeb;
        border-radius: 5px;
        padding: 10px 15px;
        font-size: 15px;
        color: #111;
        background: #f9f9f9;
        transition: border 0.2s;
    }

    .checkout__input input[type="text"]:focus,
    .checkout__input input[type="email"]:focus {
        border: 1.5px solid #e53637;
        background: #fff;
        outline: none;
    }

    .checkout__input__checkbox {
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }

    .checkout__input__checkbox label {
        font-weight: 500;
        color: #111;
        cursor: pointer;
        margin-bottom: 0;
        display: flex;
        align-items: center;
    }

    .checkout__input__checkbox input[type="checkbox"],
    .checkout__input__checkbox input[type="radio"] {
        margin-right: 8px;
        accent-color: #e53637;
    }

    .checkout__order {
        background: #f9f9f9;
        border-radius: 8px;
        padding: 25px 20px 20px 20px;
        margin-top: 10px;
    }

    .order__title {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 18px;
        color: #111;
    }

    .checkout__order__products {
        font-weight: 600;
        margin-bottom: 10px;
        color: #111;
        display: flex;
        justify-content: space-between;
    }

    .checkout__total__products {
        list-style: none;
        padding: 0;
        margin: 0 0 10px 0;
    }

    .checkout__total__products li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 15px;
        color: #333;
    }

    .checkout__total__products img {
        width: 38px;
        height: 38px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 8px;
        border: 1px solid #eee;
    }

    .checkout__total__all {
        list-style: none;
        padding: 0;
        margin: 0 0 18px 0;
    }

    .checkout__total__all li {
        display: flex;
        justify-content: space-between;
        font-weight: 700;
        font-size: 16px;
        color: #111;
        margin-bottom: 6px;
    }

    .site-btn {
        display: inline-block;
        background: #e53637;
        color: #fff;
        font-weight: 700;
        border: none;
        border-radius: 5px;
        padding: 12px 32px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .site-btn:hover {
        background: #b91c1c;
    }

    @media (max-width: 991px) {
        .checkout__form {
            padding: 25px 10px 20px 10px;
        }

        .checkout__order {
            padding: 18px 8px 12px 8px;
        }
    }
</style>