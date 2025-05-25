<?php
$cart = $cartItems ?? [];
$total = $cartTotal ?? 0;
?>

<style>
    /* Tùy chỉnh CSS cho giỏ hàng */
    .shopping-cart.spad {
        padding-top: 50px;
        padding-bottom: 50px;
    }

    .cart-table table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 15px; /* Khoảng cách giữa các hàng */
    }

    .cart-table th {
        text-align: left;
        padding: 10px 0;
        border-bottom: 1px solid #ebebeb;
        font-weight: bold;
    }

    .cart-table td {
        padding: 15px 0;
        vertical-align: middle;
        border-bottom: 1px solid #ebebeb;
    }

    .cart-pic img {
        width: 100px; /* Kích thước hình ảnh nhỏ hơn */
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
    }

    .cart-title h5 a {
        color: #111;
        font-weight: normal;
        transition: color 0.3s;
    }

    .cart-title h5 a:hover {
        color: #e53637; /* Màu đỏ khi hover */
    }

    .p-price, .total-price {
        font-weight: bold;
        color: #e53637; /* Màu đỏ cho giá */
    }

    .qua-col .quantity .pro-qty {
        width: 100px; /* Chiều rộng input số lượng */
        display: inline-block;
    }

    .qua-col .quantity .pro-qty input {
        width: 100%;
        text-align: center;
        border: 1px solid #ebebeb;
        padding: 5px 0;
        border-radius: 4px;
    }
    
     .qua-col .quantity .pro-qty .qtybtn {
        display: none; /* Ẩn nút tăng giảm mặc định nếu có */
    }

    .close-td i {
        cursor: pointer;
        color: #e53637; /* Đổi màu mặc định thành màu đỏ */
        transition: color 0.3s;
    }

    .close-td i:hover {
        color: #e53637; /* Giữ nguyên màu đỏ khi hover */
    }

    .cart-buttons {
        margin-top: 30px;
    }

    .cart-buttons a {
        margin-right: 10px;
        margin-bottom: 10px; /* Thêm khoảng cách dưới cho mobile */
        padding: 10px 20px;
        text-transform: uppercase;
        font-size: 14px;
        border-radius: 5px;
        display: inline-block;
         transition: all 0.3s ease; /* Thêm transition để hiệu ứng mượt mà hơn */
    }
    
     .cart-buttons .continue-shop {
        background-color: #ebebeb; /* Đổi màu nền giống nút xóa */
        color: #111; /* Đổi màu chữ giống nút xóa */
        border: 1px solid #ebebeb; /* Đổi màu viền giống nút xóa */
    }
    
     .cart-buttons .continue-shop:hover {
         background-color: transparent; /* Nền trong suốt khi hover */
         color: #e53637; /* Màu đỏ khi hover */
         border-color: #e53637; /* Viền màu đỏ khi hover */
     }
     
     .cart-buttons .up-cart {
         background-color: #ebebeb;
         color: #111;
         border: 1px solid #ebebeb;
     }
     
     .cart-buttons .up-cart:hover {
          background-color: transparent; /* Nền trong suốt khi hover */
          color: #e53637; /* Màu đỏ khi hover */
          border-color: #e53637; /* Viền màu đỏ khi hover */
     }

    .proceed-checkout {
        margin-top: 30px;
        border: 1px solid #ebebeb;
        padding: 20px;
        border-radius: 5px;
    }

    .proceed-checkout ul {
        list-style: none;
        padding: 0;
        margin: 0 0 20px 0;
    }

    .proceed-checkout ul li {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px dashed #ebebeb;
        font-size: 16px;
    }

    .proceed-checkout ul li:last-child {
        border-bottom: none;
        font-size: 18px;
        font-weight: bold;
        color: #e53637; /* Màu đỏ cho tổng thanh toán */
    }

    .proceed-checkout .proceed-btn {
        display: block;
        text-align: center;
        background-color: #e53637; /* Màu đỏ */
        color: #fff;
        padding: 12px 0;
        text-transform: uppercase;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .proceed-checkout .proceed-btn:hover {
        background-color: #111; /* Màu đen khi hover */
        color: #fff;
    }
    
     /* Responsive adjustments */
    @media (max-width: 767px) {
        .cart-table table, .cart-table tbody, .cart-table tr, .cart-table td {
            display: block;
            width: 100%;
        }

        .cart-table tr {
             margin-bottom: 15px;
             border: 1px solid #ebebeb;
             border-radius: 5px;
        }

        .cart-table td {
            text-align: right; /* Căn phải nội dung trên mobile */
            position: relative;
            padding-left: 50%; /* Tạo không gian cho label */
        }

        .cart-table td::before {
            content: attr(data-label); /* Hiển thị label từ data attribute */
            position: absolute;
            left: 10px;
            width: calc(50% - 20px); /* Chiều rộng của label */
            padding-right: 10px;
            white-space: nowrap;
            font-weight: bold;
            text-align: left; /* Căn trái label */
        }
        
         .cart-pic img {
             width: 80px; /* Kích thước hình ảnh nhỏ hơn trên mobile */
             height: 80px;
             display: block;
             margin: 0 auto 10px auto; /* Căn giữa hình ảnh */
         }
         
          .cart-title h5 {
              text-align: right; /* Căn phải tên sản phẩm */
          }
          
           .close-td {
               text-align: center !important; /* Căn giữa nút xóa */
           }

        .cart-buttons {
            text-align: center; /* Căn giữa các nút */
        }
        
         .proceed-checkout {
             margin-top: 20px;
         }
    }


</style>

<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="cart-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng tiền</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($cart)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="alert alert-info">
                                            Giỏ hàng của bạn đang trống.
                                            <a href="?act=product-list" class="alert-link">Tiếp tục mua sắm</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($cart as $item): ?>
                                    <tr>
                                        <td class="cart-pic first-row" data-label="Hình ảnh:">
                                            <img src="admin/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" style="width: 100px; height: 100px; object-fit: cover;">
                                        </td>
                                        <td class="cart-title first-row" data-label="Tên sản phẩm:">
                                            <h5>
                                                <a href="?act=product-detail&id=<?php echo $item['id']; ?>">
                                                    <?php echo htmlspecialchars($item['name']); ?>
                                                </a>
                                            </h5>
                                        </td>
                                        <td class="p-price first-row" data-label="Giá:">
                                            <?php echo number_format($item['price'], 0, ',', '.'); ?>₫
                                        </td>
                                        <td class="qua-col first-row" data-label="Số lượng:">
                                            <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="<?php echo $item['quantity']; ?>" 
                                                           onchange="updateQuantity(<?php echo $item['id']; ?>, this.value)">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="total-price first-row" data-label="Tổng:">
                                            <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>₫
                                        </td>
                                        <td class="close-td first-row" data-label="Xóa:">
                                            <i class="ti-close" onclick="removeFromCart(<?php echo $item['id']; ?>)"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="cart-buttons">
                            <a href="?act=product-list" class="primary-btn continue-shop">Tiếp tục mua sắm</a>
                            <a href="javascript:void(0)" onclick="clearCart()" class="primary-btn up-cart">Xóa giỏ hàng</a>
                        </div>
                    </div>
                    <div class="col-lg-4 offset-lg-4">
                        <div class="proceed-checkout">
                            <ul>
                                <li class="subtotal">Tổng tiền hàng <span><?php echo number_format($total, 0, ',', '.'); ?>₫</span></li>
                                <li class="cart-total">Tổng thanh toán <span><?php echo number_format($total, 0, ',', '.'); ?>₫</span></li>
                            </ul>
                            <a href="?act=checkout" class="proceed-btn">Tiến hành thanh toán</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function updateQuantity(productId, quantity) {
    if (quantity < 1) {
        quantity = 1;
    }
    $.ajax({
        url: '?act=update-cart',
        type: 'POST',
        data: {
            product_id: productId,
            quantity: quantity
        },
        success: function(response) {
            if(response.success) {
                location.reload();
            } else {
                alert(response.message || 'Có lỗi xảy ra!');
            }
        },
        error: function() {
            alert('Có lỗi xảy ra khi cập nhật số lượng!');
        }
    });
}

function removeFromCart(productId) {
    if (confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        $.ajax({
            url: '?act=remove-from-cart',
            type: 'POST',
            data: {
                product_id: productId
            },
            dataType: 'json',
            success: function(response) {
                console.log('Remove From Cart Response:', response);
                if(response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Có lỗi xảy ra!');
                }
            },
            error: function(xhr, status, error) {
                 console.error('Remove From Cart Error:', xhr.responseText, status, error);
                alert('Có lỗi xảy ra khi xóa sản phẩm!');
            }
        });
    }
}

function clearCart() {
    if (confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
        $.ajax({
            url: '?act=clear-cart',
            type: 'POST',
            dataType: 'json',
            success: function(response) {
                console.log('Clear Cart Response:', response);
                if(response.success) {
                    location.reload();
                } else {
                    alert(response.message || 'Có lỗi xảy ra!');
                }
            },
            error: function(xhr, status, error) {
                console.error('Clear Cart Error:', xhr.responseText, status, error);
                alert('Có lỗi xảy ra khi xóa giỏ hàng!');
            }
        });
    }
}
</script> 