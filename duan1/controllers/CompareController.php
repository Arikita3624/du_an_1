<?php
class CompareController {
    private $productModel;
    private $categoryModel;

    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        // Lấy danh sách sản phẩm cần so sánh
        $compareProducts = $this->getCompareList();
        
        // Lấy danh sách danh mục để hiển thị tên
        $categories = [];
        $allCategories = $this->categoryModel->getAll();
        foreach ($allCategories as $category) {
            $categories[$category['id']] = $category;
        }
        
        // Load view
        require_once 'views/pages/Compare.php';
    }

    public function addToCompare() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;

            if (!$productId) {
                echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
                return;
            }

            // Lấy danh sách sản phẩm so sánh từ session
            $compareList = $_SESSION['compare_list'] ?? [];

            // Kiểm tra số lượng sản phẩm trong danh sách so sánh
            if (count($compareList) >= 3) {
                echo json_encode(['success' => false, 'message' => 'Chỉ có thể so sánh tối đa 3 sản phẩm']);
                return;
            }

            // Kiểm tra sản phẩm đã tồn tại trong danh sách
            if (in_array($productId, $compareList)) {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm đã có trong danh sách so sánh']);
                return;
            }

            // Thêm sản phẩm vào danh sách
            $compareList[] = $productId;
            $_SESSION['compare_list'] = $compareList;

            echo json_encode(['success' => true, 'message' => 'Đã thêm sản phẩm vào danh sách so sánh']);
        }
    }

    public function removeFromCompare() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? 0;

            if (!$productId) {
                echo json_encode(['success' => false, 'message' => 'ID sản phẩm không hợp lệ']);
                return;
            }

            $compareList = $_SESSION['compare_list'] ?? [];
            $key = array_search($productId, $compareList);

            if ($key !== false) {
                unset($compareList[$key]);
                $_SESSION['compare_list'] = array_values($compareList);
                echo json_encode(['success' => true, 'message' => 'Đã xóa sản phẩm khỏi danh sách so sánh']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Sản phẩm không có trong danh sách so sánh']);
            }
        }
    }

    public function getCompareList() {
        $compareList = $_SESSION['compare_list'] ?? [];
        $products = [];

        foreach ($compareList as $productId) {
            $product = $this->productModel->getById($productId);
            if ($product) {
                $products[] = $product;
            }
        }

        return $products;
    }
} 