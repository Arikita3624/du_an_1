<?php
require_once __DIR__ . '/../models/CommentModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class CommentController {
    private $commentModel;
    private $productModel;

    public function __construct($db) {
        $this->commentModel = new CommentModel($db);
        $this->productModel = new ProductModel($db);
    }

    public function index() {
        $comments = $this->commentModel->getPendingComments();
        require_once __DIR__ . '/../views/comment/index.php';
    }

    public function approve() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $commentId = $_POST['id'];
            if ($this->commentModel->updateCommentStatus($commentId, 'approved')) {
                $_SESSION['success'] = 'Đã duyệt comment thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi duyệt comment!';
            }
        }
        header('Location: index.php?controller=comment');
        exit();
    }

    public function reject() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $commentId = $_POST['id'];
            if ($this->commentModel->updateCommentStatus($commentId, 'rejected')) {
                $_SESSION['success'] = 'Đã từ chối comment!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi từ chối comment!';
            }
        }
        header('Location: index.php?controller=comment');
        exit();
    }

    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
            $commentId = $_POST['id'];
            if ($this->commentModel->deleteComment($commentId)) {
                $_SESSION['success'] = 'Đã xóa comment thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi xóa comment!';
            }
        }
        header('Location: index.php?controller=comment');
        exit();
    }

    public function view() {
        if (isset($_GET['id'])) {
            $commentId = $_GET['id'];
            $comment = $this->commentModel->getCommentById($commentId);
            if ($comment) {
                require_once __DIR__ . '/../views/comment/view.php';
            } else {
                $_SESSION['error'] = 'Không tìm thấy comment!';
                header('Location: index.php?controller=comment');
                exit();
            }
        } else {
            header('Location: index.php?controller=comment');
            exit();
        }
    }
} 