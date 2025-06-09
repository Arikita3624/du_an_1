<?php

require_once __DIR__ . '/../commons/Database.php';

class CommentModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Thêm bình luận mới
    public function addComment($product_id, $user_id, $comment_text) {
        $sql = "INSERT INTO comments (product_id, user_id, comment_text, status) 
                VALUES (:product_id, :user_id, :comment_text, 'approved')";
        return $this->db->execute($sql, [
            'product_id' => $product_id,
            'user_id' => $user_id,
            'comment_text' => $comment_text
        ]);
    }

    // Lấy bình luận theo product_id (chỉ lấy bình luận đã được duyệt)
    public function getCommentsByProductId($product_id) {
        $sql = "SELECT c.*, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE c.product_id = :product_id AND c.status = 'approved' ORDER BY c.created_at DESC";
        return $this->db->query($sql, ['product_id' => $product_id]);
    }

    // Lấy tất cả bình luận (dành cho admin)
    public function getAllComments() {
        $sql = "SELECT c.*, u.username, p.name as product_name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                JOIN products p ON c.product_id = p.id
                ORDER BY c.created_at DESC";
        return $this->db->query($sql);
    }

    // Cập nhật trạng thái bình luận (dành cho admin)
    public function updateCommentStatus($comment_id, $status) {
        $sql = "UPDATE comments SET status = :status, updated_at = NOW() WHERE id = :comment_id";
         return $this->db->execute($sql, [
            'comment_id' => $comment_id,
            'status' => $status
        ]);
    }

    // Xóa bình luận (dành cho admin)
     public function deleteComment($comment_id) {
        $sql = "DELETE FROM comments WHERE id = :comment_id";
        return $this->db->execute($sql, ['comment_id' => $comment_id]);
    }

} 