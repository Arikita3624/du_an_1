-- Tạo cơ sở dữ liệu
CREATE DATABASE IF NOT EXISTS base_du_an_1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE base_du_an_1;

-- Bảng admins
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2) DEFAULT NULL,
    image VARCHAR(255),
    category_id INT,
    stock INT NOT NULL DEFAULT 0,
    views INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('admin', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive', 'locked') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng comments
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng orders
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'completed', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('pending', 'paid', 'failed') DEFAULT 'pending',
    payment_method ENUM('cod', 'banking', 'momo', 'zalopay') DEFAULT 'cod',
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bảng order_items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Thêm dữ liệu mẫu cho bảng admins
INSERT INTO admins (username, password, full_name, email) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@example.com');
-- Mật khẩu mặc định là 'password'

-- Thêm dữ liệu mẫu cho bảng categories
INSERT INTO categories (name, description) VALUES
('Áo Nam', 'Các loại áo dành cho nam giới'),
('Quần Nam', 'Các loại quần dành cho nam giới'),
('Phụ kiện', 'Các loại phụ kiện thời trang nam'),
('Giày Dép', 'Giày dép nam thời trang'),
('Túi Xách', 'Túi xách nam công sở và du lịch');

-- Thêm dữ liệu mẫu cho bảng products
INSERT INTO products (name, description, price, discount_price, category_id, stock) VALUES
-- Áo Nam
('Áo sơ mi trắng nam', 'Áo sơ mi trắng cổ trụ, chất liệu cotton', 350000, 299000, 1, 50),
('Áo thun nam basic', 'Áo thun nam basic, chất liệu cotton 100%', 250000, 199000, 1, 100),
('Áo polo nam', 'Áo polo nam, chất liệu cotton pique', 450000, 399000, 1, 75),

-- Quần Nam
('Quần jean nam slim', 'Quần jean nam slim fit, chất liệu denim', 650000, 550000, 2, 40),
('Quần khaki nam', 'Quần khaki nam, chất liệu cotton', 450000, 399000, 2, 55),
('Quần short nam', 'Quần short nam, chất liệu cotton thoáng mát', 350000, 299000, 2, 70),

-- Phụ kiện
('Thắt lưng da nam', 'Thắt lưng da nam, chất liệu da thật', 350000, 299000, 3, 30),
('Ví da nam', 'Ví da nam, nhiều ngăn tiện dụng', 450000, 399000, 3, 35),
('Đồng hồ nam dây da', 'Đồng hồ nam dây da, thiết kế thanh lịch', 1200000, 999000, 3, 25),

-- Giày Dép
('Giày lười nam da', 'Giày lười nam da thật, thiết kế tối giản', 850000, 750000, 4, 45),
('Giày thể thao nam', 'Giày thể thao nam, đế cao su bền bỉ', 1200000, 999000, 4, 60),
('Dép quai ngang nam', 'Dép quai ngang nam, chất liệu cao su', 250000, 199000, 4, 80),

-- Túi Xách
('Túi đeo chéo nam', 'Túi đeo chéo nam, thiết kế đơn giản', 550000, 499000, 5, 40),
('Ba lô nam công sở', 'Ba lô nam công sở, nhiều ngăn tiện dụng', 750000, 650000, 5, 35),
('Túi xách tay nam', 'Túi xách tay nam, chất liệu da tổng hợp', 950000, 850000, 5, 30); 