<?php

require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../models/Checkout.php';

class CommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new CommentModel();
    }

    // Xử lý thêm bình luận từ client
    public function add() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra người dùng đã đăng nhập chưa
            if (!isset($_SESSION['user'])) {
                $_SESSION['error'] = 'Vui lòng đăng nhập để bình luận.';
                $product_id = $_POST['product_id'] ?? '';
                header('Location: ?act=product-detail&id=' . $product_id);
                exit;
            }

            $product_id = intval($_POST['product_id'] ?? 0);
            $user_id = $_SESSION['user']['id'];
            $comment_text = trim($_POST['comment_text'] ?? '');

            // Kiểm tra đã mua hàng chưa
            $checkoutModel = new CheckoutModel();
            if (!$checkoutModel->hasUserPurchasedProduct($user_id, $product_id)) {
                $_SESSION['error'] = 'Bạn chỉ có thể bình luận khi đã mua sản phẩm này.';
                header('Location: ?act=product-detail&id=' . $product_id);
                exit;
            }

            if ($product_id > 0 && !empty($comment_text)) {
                $result = $this->commentModel->addComment($product_id, $user_id, $comment_text);

                if ($result) {
                    $_SESSION['success'] = 'Bình luận của bạn đã được đăng thành công.';
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi gửi bình luận.';
                }
            } else {
                $_SESSION['error'] = 'Nội dung bình luận không được trống.';
            }

            // Chuyển hướng về trang chi tiết sản phẩm
            header('Location: ?act=product-detail&id=' . $product_id);
            exit;
        }

        // Nếu không phải POST request, chuyển hướng về trang chủ
        header('Location: ?act=/');
        exit;
    }
}