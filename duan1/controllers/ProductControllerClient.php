<?php
require_once __DIR__ . '/../commons/env.php';
require_once __DIR__ . '/../commons/function.php';
require_once __DIR__ . '/../models/Client.php';
require_once __DIR__ . '/../models/CommentModel.php';

class ProductControllerClient
{
    public function list()
    {
        $productModel = new ProductModels();
        $categoryModel = new CategoryModels();

        $search = $_GET['search'] ?? '';
        $price = $_GET['price'] ?? '';
        $category_id = $_GET['category_id'] ?? '';
        $page = max(1, intval($_GET['page'] ?? 1));
        $limit = 6;
        $offset = ($page - 1) * $limit;

        // Nếu có category_id thì huỷ search (chỉ lọc theo danh mục)
        if ($category_id !== '') {
            $search = '';
        }

        $products = $productModel->getFiltered($search, $price, $category_id, $limit, $offset);
        $totalProducts = $productModel->countFiltered($search, $price, $category_id);

        $conn = connectDB();
        foreach ($products as $key => $product) {
            $categoryId = $product['category_id'];
            $stmt = $conn->prepare('SELECT name FROM categories WHERE id = :id');
            $stmt->execute([':id' => $categoryId]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            $products[$key]['category_name'] = $category['name'] ?? 'Chưa phân loại';
        }

        $categories = $categoryModel->getAll();
        $totalPages = ceil($totalProducts / $limit);

        require_once __DIR__ . '/../views/pages/ProductsList.php';
    }
    public function detail()
    {
        $productModel = new ProductModels();
        $categoryModel = new CategoryModels();

        $id = $_GET['id'] ?? 0;
        $product = $productModel->getById($id);

        if (!$product) {
            die('Không tìm thấy sản phẩm!');
        }

        // Lấy tên danh mục từ bảng categories
        $categoryId = $product['category_id'];
        $stmt = connectDB()->prepare('SELECT name FROM categories WHERE id = :id');
        $stmt->execute([':id' => $categoryId]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);
        $product['category_name'] = $category['name'] ?? 'Chưa phân loại';

        // Lấy sản phẩm tương tự cùng danh mục (trừ sản phẩm hiện tại)
        $relatedProducts = $productModel->getRelated($product['category_id'], $product['id']);

        // Lấy bình luận cho sản phẩm (phân trang)
        $commentModel = new CommentModel();
        $commentPage = isset($_GET['comment_page']) ? max(1, intval($_GET['comment_page'])) : 1;
        $commentLimit = 3;
        $commentOffset = ($commentPage - 1) * $commentLimit;

        $totalComments = $commentModel->countCommentsByProductId($id);
        $totalCommentPages = ceil($totalComments / $commentLimit);

        $comments = $commentModel->getCommentsByProductIdPaging($id, $commentLimit, $commentOffset);
        require_once __DIR__ . '/../views/pages/ProductDetail.php';
    }
}
