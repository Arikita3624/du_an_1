<?php

require_once __DIR__ . '/../models/Carts.php';


class CartsController
{
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['message'] = 'Bạn cần đăng nhập để xem giỏ hàng!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=login');
            exit;
        }

        // Lấy giỏ hàng từ database theo user_id
        $cartModel = new CartModels();
        $cartItems = $cartModel->getCartItemsByUserId($_SESSION['user']['id']);

        require_once __DIR__ . '/../views/pages/Carts.php';
    }

    public function addToCart()
    {
        $product_id = intval($_POST['product_id']);
        $quantity = max(1, intval($_POST['quantity']));

        require_once __DIR__ . '/../models/CartModel.php';
        require_once __DIR__ . '/../models/Client.php';

        $productModel = new ProductModels();
        $product = $productModel->getById($product_id);

        if (!$product) {
            $_SESSION['message'] = 'Sản phẩm không tồn tại!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=product-list');
            exit;
        }

        if (isset($_SESSION['user'])) {
            $cartModel = new CartModels();
            $cart_id = $cartModel->getOrCreateCart($_SESSION['user']['id']);
            $cartModel->addToCart($cart_id, $product_id, $quantity, $product['price']);
        } else {
            if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id]['quantity'] += $quantity;
            } else {
                $_SESSION['cart'][$product_id] = [
                    'id' => $product_id,
                    'name' => $product['name'],
                    'image' => $product['image'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
            }
        }

        $_SESSION['message'] = 'Đã thêm sản phẩm vào giỏ hàng!';
        $_SESSION['message_type'] = 'success';
        header('Location: ?act=carts');
        exit;
    }

    public function updateCart()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }
        $product_id = intval($_POST['product_id']);
        $quantity = max(1, intval($_POST['quantity']));

        $cartModel = new CartModels();
        $cart_id = $cartModel->getOrCreateCart($_SESSION['user']['id']);
        $cartModel->updateCartItem($cart_id, $product_id, $quantity);

        $_SESSION['message'] = 'Cập nhật giỏ hàng thành công!';
        $_SESSION['message_type'] = 'success';
        header('Location: ?act=carts');
        exit;
    }

    public function removeCartItem()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }
        $product_id = intval($_POST['product_id']);

        $cartModel = new CartModels();
        $cart_id = $cartModel->getOrCreateCart($_SESSION['user']['id']);
        $cartModel->removeCartItem($cart_id, $product_id);

        $_SESSION['message'] = 'Đã xóa sản phẩm khỏi giỏ hàng!';
        $_SESSION['message_type'] = 'success';
        header('Location: ?act=carts');
        exit;
    }
}
