<?php
require_once __DIR__ . '/../../models/CommentModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class CommentController {
    private $commentModel;
    private $productModel;

    public function __construct() {
        $this->commentModel = new CommentModel();
        $this->productModel = new ProductModel();
    }

    public function index() {
        $comments = $this->commentModel->getAllComments();
        require_once __DIR__ . '/../views/comment/index.php';
    }

    public function approve() {
        $comment_id = $_GET['id'] ?? 0;
        if ($comment_id > 0) {
            $result = $this->commentModel->updateCommentStatus($comment_id, 'approved');
            if ($result) {
                $_SESSION['success'] = 'Đã duyệt bình luận.';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi duyệt bình luận.';
            }
        }
        header('Location: index.php?controller=comment');
        exit;
    }

    public function reject() {
        $comment_id = $_GET['id'] ?? 0;
        if ($comment_id > 0) {
            $result = $this->commentModel->updateCommentStatus($comment_id, 'rejected');
            if ($result) {
                $_SESSION['success'] = 'Đã từ chối bình luận.';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi từ chối bình luận.';
            }
        }
        header('Location: index.php?controller=comment');
        exit;
    }

    public function delete() {
        $comment_id = $_GET['id'] ?? 0;
        if ($comment_id > 0) {
            $result = $this->commentModel->deleteComment($comment_id);
            if ($result) {
                $_SESSION['success'] = 'Đã xóa bình luận.';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi xóa bình luận.';
            }
        }
        header('Location: index.php?controller=comment');
        exit;
    }

    public function view() {
        if (isset($_GET['id'])) {
            $commentId = $_GET['id'];
            // Cần thêm phương thức getCommentById trong CommentModel nếu muốn xem chi tiết
             $_SESSION['error'] = 'Chức năng xem chi tiết bình luận chưa được triển khai đầy đủ.';
             header('Location: index.php?controller=comment');
             exit();
        } else {
            header('Location: index.php?controller=comment');
            exit();
        }
    }
} 