<?php

 require_once __DIR__ . '/../commons/env.php';
 require_once __DIR__ . '/../commons/function.php';
 require_once __DIR__ . '/../models/Client.php'; // Assuming Product model is here


 class CartsController {
    public function index() {
        // Ensure cart session key exists
        $_SESSION['cart'] = $_SESSION['cart'] ?? [];
        
        // Lấy dữ liệu giỏ hàng từ session và làm sạch/cập nhật dữ liệu
        $cartItems = [];
        $total = 0;
        
        $productModel = new Product(); // Khởi tạo Product Model để lấy thông tin sản phẩm

        foreach ($_SESSION['cart'] as $productId => $item) {
            // Kiểm tra nếu thông tin sản phẩm (name, price, image) chưa đầy đủ
            if (!isset($item['name']) || !isset($item['price']) || !isset($item['image'])) {
                // Lấy lại thông tin sản phẩm đầy đủ từ database
                $product = $productModel->getById($productId);
                
                if ($product) {
                    // Cập nhật mục trong session với thông tin đầy đủ
                    $_SESSION['cart'][$productId] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $product['image'],
                        'quantity' => $item['quantity'] // Giữ nguyên số lượng đã có
                    ];
                    $cartItems[$productId] = $_SESSION['cart'][$productId]; // Thêm vào mảng để truyền sang view
                } else {
                    // Nếu không tìm thấy sản phẩm trong DB (có thể đã bị xóa), xóa khỏi session
                    unset($_SESSION['cart'][$productId]);
                    continue; // Bỏ qua mục này và chuyển sang mục tiếp theo
                }
            } else {
                // Nếu thông tin đã đầy đủ, sử dụng dữ liệu hiện có
                $cartItems[$productId] = $item;
            }
            
            // Tính tổng tiền cho các mục hợp lệ
            $price = isset($cartItems[$productId]['price']) && is_numeric($cartItems[$productId]['price']) ? $cartItems[$productId]['price'] : 0;
            $quantity = isset($cartItems[$productId]['quantity']) && is_numeric($cartItems[$productId]['quantity']) ? $cartItems[$productId]['quantity'] : 0;
            $total += $price * $quantity;
        }

        // Truyền dữ liệu giỏ hàng đã được làm sạch/cập nhật và tổng tiền sang view
        require_once __DIR__ . '/../views/pages/Cart.php';
    }

    public function addToCart() {
        // Kiểm tra xem yêu cầu có phải là AJAX không
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $productId = $_POST['product_id'] ?? 0;
                $quantity = $_POST['quantity'] ?? 1;

                if (!$productId) {
                    $message = 'ID sản phẩm không hợp lệ';
                    if ($isAjax) {
                        echo json_encode(['success' => false, 'message' => $message]);
                        return;
                    } else {
                        $_SESSION['message'] = $message;
                        $_SESSION['message_type'] = 'error';
                        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '?act=/');
                        exit();
                    }
                }

                // Lấy thông tin sản phẩm từ database
                $productModel = new Product();
                $product = $productModel->getById($productId);

                if (!$product) {
                    $message = 'Không tìm thấy sản phẩm';
                     if ($isAjax) {
                        echo json_encode(['success' => false, 'message' => $message]);
                        return;
                    } else {
                        $_SESSION['message'] = $message;
                        $_SESSION['message_type'] = 'error';
                        header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '?act=/');
                        exit();
                    }
                }

                // Thêm vào giỏ hàng
                $_SESSION['cart'] = $_SESSION['cart'] ?? [];
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'id' => $product['id'],
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'image' => $product['image'],
                        'quantity' => $quantity
                    ];
                }

                // Xử lý phản hồi dựa trên loại yêu cầu
                $message = 'Đã thêm vào giỏ hàng thành công!';
                if ($isAjax) {
                    header('Content-Type: application/json');
                     echo json_encode(['success' => true, 'message' => $message]);
                     exit(); // Stop script execution after sending JSON
                } else {
                    $_SESSION['message'] = $message;
                    $_SESSION['message_type'] = 'success';
                    header('Location: ?act=carts'); // Chuyển hướng đến trang giỏ hàng cho yêu cầu không phải AJAX
                    exit();
                }
            } catch (Exception $e) {
                $message = 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng: ' . $e->getMessage();
                if ($isAjax) {
                     echo json_encode(['success' => false, 'message' => $message]);
                     return;
                } else {
                    $_SESSION['message'] = $message;
                    $_SESSION['message_type'] = 'error';
                    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? '?act=/');
                    exit();
                }
            }
        }
    }

    public function updateCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $productId = $_POST['product_id'] ?? 0;
                $quantity = $_POST['quantity'] ?? 1;

                if (!$productId) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
                    exit(); // Stop script execution after sending JSON
                }

                if ($quantity < 1) {
                    $quantity = 1;
                }

                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] = $quantity;
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Đã cập nhật số lượng']);
                    exit(); // Stop script execution after sending JSON
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm trong giỏ hàng']);
                    exit(); // Stop script execution after sending JSON
                }
            } catch (Exception $e) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật giỏ hàng: ' . $e->getMessage()]);
                exit(); // Stop script execution after sending JSON
            }
        }
    }

    public function removeFromCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $productId = $_POST['product_id'] ?? 0;

                if (!$productId) {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
                    exit(); // Stop script execution after sending JSON
                }

                if (isset($_SESSION['cart'][$productId])) {
                    unset($_SESSION['cart'][$productId]);
                    header('Content-Type: application/json');
                    echo json_encode(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi giỏ hàng']);
                    exit(); // Stop script execution after sending JSON
                } else {
                    header('Content-Type: application/json');
                    echo json_encode(['success' => false, 'message' => 'Không tìm thấy sản phẩm trong giỏ hàng']);
                    exit(); // Stop script execution after sending JSON
                }
            } catch (Exception $e) {
                 header('Content-Type: application/json');
                 echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng: ' . $e->getMessage()]);
                 exit(); // Stop script execution after sending JSON
            }
        }
    }

    public function clearCart() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Bắt đầu bộ đệm đầu ra
                ob_start();

                $_SESSION['cart'] = [];

                // Thiết lập message thành công vào session
                $_SESSION['message'] = 'Bạn đã xóa giỏ hàng thành công';
                $_SESSION['message_type'] = 'success';

                // Trả về phản hồi JSON
                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Đã xóa giỏ hàng']);

                // Kết thúc và xóa bộ đệm, chỉ giữ lại nội dung đã echo (JSON)
                ob_end_clean();
                exit(); // Đảm bảo không có code nào chạy tiếp và gây ra output khác
            } catch (Exception $e) {
                 ob_end_clean(); // Xóa bộ đệm trước khi trả về lỗi
                 header('Content-Type: application/json');
                 echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi xóa giỏ hàng: ' . $e->getMessage()]);
                 exit(); // Dừng thực thi
            }
        }
    }
 }


?>