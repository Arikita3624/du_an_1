<?php

require_once __DIR__ . '/../../models/CommentModel.php';
require_once __DIR__ . '/../models/ProductModel.php';

class CommentController
{
    private $commentModel;
    private $productModel;

    public function __construct()
    {
        $this->commentModel = new CommentModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $comments = $this->commentModel->getAllComments();
        require_once __DIR__ . '/../views/comment/index.php';
    }

    public function approve()
    {
        $this->handleStatusChange('approved', 'Đã duyệt bình luận.', 'Có lỗi xảy ra khi duyệt bình luận.');
    }

    public function reject()
    {
        $this->handleStatusChange('rejected', 'Đã từ chối bình luận.', 'Có lỗi xảy ra khi từ chối bình luận.');
    }

    public function delete()
    {
        $commentId = $_GET['id'] ?? 0;

        if ($commentId > 0) {
            $result = $this->commentModel->deleteComment($commentId);
            $_SESSION[$result ? 'success' : 'error'] = $result
                ? 'Đã xóa bình luận.'
                : 'Có lỗi xảy ra khi xóa bình luận.';
        }

        $this->redirectToIndex();
    }

    public function view()
    {
        if (isset($_GET['id'])) {
            // Gợi ý: Cần bổ sung phương thức getCommentById trong CommentModel
            $_SESSION['error'] = 'Chức năng xem chi tiết bình luận chưa được triển khai đầy đủ.';
        }

        $this->redirectToIndex();
    }

    private function handleStatusChange($status, $successMsg, $errorMsg)
    {
        $commentId = $_GET['id'] ?? 0;

        if ($commentId > 0) {
            $result = $this->commentModel->updateCommentStatus($commentId, $status);
            $_SESSION[$result ? 'success' : 'error'] = $result ? $successMsg : $errorMsg;
        }

        $this->redirectToIndex();
    }

    private function redirectToIndex()
    {
        header('Location: index.php?controller=comment');
        exit;
    }
}
