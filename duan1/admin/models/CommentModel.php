<?php
class CommentModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getCommentsByProduct($productId) {
        $sql = "SELECT c.*, u.username, u.full_name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                WHERE c.product_id = ? AND c.status = 'approved'
                ORDER BY c.created_at DESC";
        return $this->db->query($sql, [$productId]);
    }

    public function addComment($productId, $userId, $content, $rating) {
        $sql = "INSERT INTO comments (product_id, user_id, content, rating) 
                VALUES (?, ?, ?, ?)";
        return $this->db->execute($sql, [$productId, $userId, $content, $rating]);
    }

    public function updateCommentStatus($commentId, $status) {
        $sql = "UPDATE comments SET status = ? WHERE id = ?";
        return $this->db->execute($sql, [$status, $commentId]);
    }

    public function deleteComment($commentId) {
        $sql = "DELETE FROM comments WHERE id = ?";
        return $this->db->execute($sql, [$commentId]);
    }

    public function getPendingComments() {
        $sql = "SELECT c.*, u.username, u.full_name, p.name as product_name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                JOIN products p ON c.product_id = p.id 
                WHERE c.status = 'pending'
                ORDER BY c.created_at DESC";
        return $this->db->query($sql);
    }

    public function getCommentById($commentId) {
        $sql = "SELECT c.*, u.username, u.full_name, p.name as product_name 
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                JOIN products p ON c.product_id = p.id 
                WHERE c.id = ?";
        return $this->db->queryOne($sql, [$commentId]);
    }
} 