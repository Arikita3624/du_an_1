<?php

require_once __DIR__ . '/../models/Checkout.php';
require_once __DIR__ . '/../models/Carts.php';

class CheckoutController
{
    private $checkoutModel;

    public function __construct()
    {
        $this->checkoutModel = new CheckoutModel();
    }
    public function index()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }
        $userId = $_SESSION['user']['id'];
        $cartModel = new CartModels();
        $cart_id = $cartModel->getOrCreateCart($userId);
        $cartItems = $cartModel->getCartItems($cart_id);

        require_once __DIR__ . '/../views/pages/Checkout.php';
    }

    public function processCheckout()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }

        $errors = [];
        $user_id = $_SESSION['user']['id'];
        $full_name = trim($_POST['first_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $address = trim($_POST['address'] ?? '');
        $payment_method = $_POST['payment_method'] ?? 'cod';
        $order_reason = $_POST['reason'] ?? '';

        // Validate từng trường
        if ($full_name === '') {
            $errors['first_name'] = 'Vui lòng nhập họ tên!';
        }
        if ($phone === '' || !preg_match('/^[0-9]{9,15}$/', $phone)) {
            $errors['phone'] = 'Vui lòng nhập số điện thoại hợp lệ!';
        }
        if ($address === '') {
            $errors['address'] = 'Vui lòng nhập địa chỉ!';
        }
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Vui lòng nhập email hợp lệ!';
        }

        $cartModel = new CartModels();
        $cart_id = $cartModel->getOrCreateCart($user_id);
        $cartItems = $cartModel->getCartItems($cart_id);

        if (empty($cartItems)) {
            $_SESSION['message'] = 'Giỏ hàng của bạn đang trống.';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        if (!empty($errors)) {
            $_SESSION['checkout_errors'] = $errors;
            $_SESSION['checkout_old'] = $_POST;
            header('Location: ?act=checkout');
            exit;
        }

        $total_price = 0;
        foreach ($cartItems as $item) {
            $total_price += $item['total_price'];
        }

        try {
            $order_id = $this->checkoutModel->saveOrder(
                $user_id,
                $full_name,
                $email,
                $phone,
                $address,
                $total_price,
                $payment_method,
                $order_reason,
            );

            $this->checkoutModel->saveOrderDetails($order_id, $cartItems);

            // Thay đổi số lượng sản phẩm trong kho

            require_once __DIR__ . '/../models/Client.php';
            $productModel = new ProductModels();
            foreach ($cartItems as $item) {
                $product = $productModel->getById($item['product_id']);
                if ($product) {
                    $newStock = max(0, $product['stock'] - $item['quantity']);
                    $productModel->updateStock($item['product_id'], $newStock);
                }
            }



            // Xóa giỏ hàng trong database
            $cartModel->clearCart($cart_id);

            $_SESSION['message'] = 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm.';
            $_SESSION['message_type'] = 'success';
            header('Location: ?act=order-confirmation&order_id=' . $order_id);
            exit;
        } catch (Exception $e) {
            error_log($e->getMessage());
            $_SESSION['message'] = 'Có lỗi xảy ra khi xử lý đơn hàng. Vui lòng thử lại!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=checkout');
            exit;
        }
    }

    public function orderConfirmation()
    {
        if (!isset($_GET['order_id'])) {
            header('Location: ?act=product-list');
            exit;
        }
        $order_id = intval($_GET['order_id']);
        $order = $this->checkoutModel->getOrderById($order_id);
        $order_details = $this->checkoutModel->getOrderDetails($order_id);

        require_once __DIR__ . '/../views/pages/OrderConfirmation.php';
    }
}
