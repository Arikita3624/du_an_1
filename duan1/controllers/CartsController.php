<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../models/Carts.php';

class CartsController
{
    private $cartModel;
    private $productModel;

    public function __construct()
    {
        $this->cartModel = new CartModels();
        $this->productModel = new ProductModels();
    }

    private function writeLog($message)
    {
        $timestamp = date('Y-m-d H:i:s');
        $logMessage = "[$timestamp] $message";
        error_log($logMessage, 3, "C:/laragon/www/DUAN1/du_an_1/duan1/logs/cart.log");
    }

    public function index()
    {
        if (!isset($_SESSION['user'])) {
            $_SESSION['message'] = 'Bạn cần đăng nhập để xem giỏ hàng!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=login');
            exit;
        }

        $cartItems = $this->cartModel->getCartItemsByUserId($_SESSION['user']['id']);
        require_once __DIR__ . '/../views/pages/Carts.php';
    }

    public function addToCart()
    {
        // Debug: Kiểm tra dữ liệu POST
        echo "<pre>";
        echo "POST data:\n";
        print_r($_POST);
        echo "</pre>";

        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            $_SESSION['message'] = 'Dữ liệu không hợp lệ!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=product-list');
            exit;
        }

        $product_id = intval($_POST['product_id']);
        $quantity = max(1, intval($_POST['quantity']));

        try {
            $conn = connectDB();
            $conn->beginTransaction();

            // Kiểm tra số lượng tồn kho
            $stmt = $conn->prepare("SELECT stock, price, name, image FROM products WHERE id = ? FOR UPDATE");
            $stmt->execute([$product_id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$product) {
                echo "<pre>";
                echo "Lỗi: Không tìm thấy sản phẩm với ID: $product_id\n";
                echo "</pre>";
                die();
                throw new Exception("Sản phẩm không tồn tại!");
            }

            $cartQuantity = 0;
            if (isset($_SESSION['user'])) {
                $cart_id = $this->cartModel->getOrCreateCart($_SESSION['user']['id']);
                $cartItem = $this->cartModel->getCartItem($cart_id, $product_id);
                if ($cartItem) {
                    $cartQuantity = intval($cartItem['quantity']);
                }
            } else {
                if (isset($_SESSION['cart'][$product_id])) {
                    $cartQuantity = intval($_SESSION['cart'][$product_id]['quantity']);
                }
            }
            $totalQuantity = $cartQuantity + $quantity;

            if ($product['stock'] < $totalQuantity) {
                echo "<pre>";
                echo "Lỗi: Số lượng trong kho không đủ\n";
                echo "Stock hiện tại: {$product['stock']}\n";
                echo "Số lượng đã có trong giỏ: {$cartQuantity}\n";
                echo "Số lượng muốn thêm: {$quantity}\n";
                echo "</pre>";
                die();
                throw new Exception("Số lượng sản phẩm trong kho không đủ!");
            }
            // Debug: In thông tin trước khi cập nhật
            echo "<pre>";
            echo "Thông tin trước khi cập nhật:\n";
            echo "Product ID: $product_id\n";
            echo "Current stock: {$product['stock']}\n";
            echo "Quantity to reduce: $quantity\n";

            // Cập nhật số lượng tồn kho
            $newStock = $product['stock'] - $quantity;
            $updateStmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
            $updateResult = $updateStmt->execute([$newStock, $product_id]);

            if (!$updateResult) {
                echo "<pre>";
                echo "Lỗi: Không thể cập nhật số lượng tồn kho\n";
                echo "SQL Error: " . print_r($updateStmt->errorInfo(), true);
                echo "</pre>";
                die();
                throw new Exception("Không thể cập nhật số lượng tồn kho!");
            }

            // Kiểm tra lại số lượng tồn kho sau khi cập nhật
            $checkStmt = $conn->prepare("SELECT stock FROM products WHERE id = ?");
            $checkStmt->execute([$product_id]);
            $updatedProduct = $checkStmt->fetch(PDO::FETCH_ASSOC);

            // Debug: In thông tin sau khi cập nhật
            echo "\nThông tin sau khi cập nhật:\n";
            echo "Expected new stock: $newStock\n";
            echo "Actual new stock: {$updatedProduct['stock']}\n";
            echo "</pre>";
            die();

            if ($updatedProduct['stock'] != $newStock) {
                throw new Exception("Cập nhật số lượng tồn kho không thành công!");
            }

            // Thêm vào giỏ hàng
            if (isset($_SESSION['user'])) {
                $cart_id = $this->cartModel->getOrCreateCart($_SESSION['user']['id']);
                $this->cartModel->addToCart($cart_id, $product_id, $quantity, $product['price']);
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

            $conn->commit();

            $_SESSION['message'] = 'Đã thêm sản phẩm vào giỏ hàng!';
            $_SESSION['message_type'] = 'success';
            header('Location: ?act=carts');
            exit;
        } catch (Exception $e) {
            if (isset($conn)) {
                $conn->rollBack();
            }
            echo "<pre>";
            echo "Lỗi: " . $e->getMessage() . "\n";
            echo "</pre>";
            die();
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=product-detail&id=' . $product_id);
            exit;
        }
    }

    public function updateCart()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: ?act=login');
            exit;
        }

        if (!isset($_POST['product_id']) || !isset($_POST['quantity'])) {
            $_SESSION['message'] = 'Dữ liệu không hợp lệ!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        $product_id = intval($_POST['product_id']);
        $quantity = max(1, intval($_POST['quantity']));

        $product = $this->productModel->getById($product_id);
        if ($product['stock'] < $quantity) {
            $_SESSION['message'] = 'Số lượng sản phẩm trong kho không đủ!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        $cart_id = $this->cartModel->getOrCreateCart($_SESSION['user']['id']);
        $this->cartModel->updateCartItem($cart_id, $product_id, $quantity);

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

        if (!isset($_POST['product_id'])) {
            $_SESSION['message'] = 'Dữ liệu không hợp lệ!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }

        $product_id = intval($_POST['product_id']);

        try {
            $conn = connectDB();
            $conn->beginTransaction();

            $cart_id = $this->cartModel->getOrCreateCart($_SESSION['user']['id']);

            // Lấy thông tin sản phẩm trong giỏ hàng
            $stmt = $conn->prepare("SELECT quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
            $stmt->execute([$cart_id, $product_id]);
            $cartItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($cartItem) {
                // Lấy thông tin sản phẩm
                $stmt = $conn->prepare("SELECT stock FROM products WHERE id = ? FOR UPDATE");
                $stmt->execute([$product_id]);
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($product) {
                    // Cập nhật số lượng tồn kho
                    $newStock = $product['stock'] + $cartItem['quantity'];
                    $stmt = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
                    $stmt->execute([$newStock, $product_id]);

                    // Xóa sản phẩm khỏi giỏ hàng
                    $this->cartModel->removeCartItem($cart_id, $product_id);
                }
            }

            $conn->commit();

            $_SESSION['message'] = 'Đã xóa sản phẩm khỏi giỏ hàng!';
            $_SESSION['message_type'] = 'success';
            header('Location: ?act=carts');
            exit;
        } catch (Exception $e) {
            $conn->rollBack();
            $_SESSION['message'] = 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng!';
            $_SESSION['message_type'] = 'error';
            header('Location: ?act=carts');
            exit;
        }
    }
}
