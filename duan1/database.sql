-- Tạo cơ sở dữ liệu nếu chưa tồn tại
CREATE DATABASE IF NOT EXISTS base_du_an_1;
USE base_du_an_1;

-- Tạo bảng users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    role ENUM('admin', 'user') DEFAULT 'user',
    status ENUM('active', 'inactive') DEFAULT 'active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tạo bảng categories
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tạo bảng products
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2) DEFAULT NULL,
    category_id INT,
    image VARCHAR(255),
    stock INT NOT NULL DEFAULT 0,
    views INT DEFAULT 0,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Tạo bảng orders
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
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Tạo bảng order_items
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    discount_price DECIMAL(10,2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Thêm tài khoản admin mặc định
INSERT INTO users (username, password, full_name, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@example.com', 'admin');

-- Thêm dữ liệu mẫu cho bảng categories
INSERT INTO categories (name, description) VALUES 
('Áo Nam', 'Các loại áo dành cho nam giới'),
('Áo Nữ', 'Các loại áo dành cho phụ nữ'),
('Quần Nam', 'Các loại quần dành cho nam giới'),
('Quần Nữ', 'Các loại quần dành cho phụ nữ'),
('Phụ kiện', 'Các loại phụ kiện thời trang');

-- Thêm dữ liệu mẫu cho bảng products
INSERT INTO products (name, description, price, category_id, stock) VALUES 
-- Áo Nam
('Áo sơ mi trắng nam', 'Áo sơ mi trắng cổ trụ, chất liệu cotton', 350000, 1, 50),
('Áo thun nam basic', 'Áo thun nam basic, chất liệu cotton 100%', 250000, 1, 100),
('Áo polo nam', 'Áo polo nam, chất liệu cotton pique', 450000, 1, 75),

-- Áo Nữ
('Áo sơ mi nữ trắng', 'Áo sơ mi nữ trắng, thiết kế thanh lịch', 400000, 2, 60),
('Áo thun nữ basic', 'Áo thun nữ basic, chất liệu cotton mềm mại', 280000, 2, 80),
('Áo kiểu nữ', 'Áo kiểu nữ, thiết kế hiện đại', 550000, 2, 45),

-- Quần Nam
('Quần jean nam slim', 'Quần jean nam slim fit, chất liệu denim', 650000, 3, 40),
('Quần khaki nam', 'Quần khaki nam, chất liệu cotton', 450000, 3, 55),
('Quần short nam', 'Quần short nam, chất liệu cotton thoáng mát', 350000, 3, 70),

-- Quần Nữ
('Quần jean nữ skinny', 'Quần jean nữ skinny, chất liệu denim co giãn', 600000, 4, 65),
('Quần tây nữ', 'Quần tây nữ công sở, chất liệu cao cấp', 500000, 4, 50),
('Quần short nữ', 'Quần short nữ, thiết kế trẻ trung', 300000, 4, 85),

-- Phụ kiện
('Thắt lưng da nam', 'Thắt lưng da nam, chất liệu da thật', 350000, 5, 30),
('Túi xách nữ', 'Túi xách nữ, thiết kế thời trang', 850000, 5, 25),
('Ví da nam', 'Ví da nam, nhiều ngăn tiện dụng', 450000, 5, 35);

-- Cập nhật cấu trúc bảng nếu đã tồn tại
SET @dbname = 'base_du_an_1';

-- Kiểm tra và thêm cột cho bảng users
SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'users' 
        AND COLUMN_NAME = 'status'
    ),
    'ALTER TABLE users ADD COLUMN status ENUM("active", "inactive") DEFAULT "active" AFTER role',
    'SELECT "Column status already exists in users table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'users' 
        AND COLUMN_NAME = 'last_login'
    ),
    'ALTER TABLE users ADD COLUMN last_login TIMESTAMP NULL AFTER status',
    'SELECT "Column last_login already exists in users table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm cột cho bảng categories
SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'categories' 
        AND COLUMN_NAME = 'status'
    ),
    'ALTER TABLE categories ADD COLUMN status ENUM("active", "inactive") DEFAULT "active" AFTER description',
    'SELECT "Column status already exists in categories table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm cột cho bảng products
SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'products' 
        AND COLUMN_NAME = 'discount_price'
    ),
    'ALTER TABLE products ADD COLUMN discount_price DECIMAL(10,2) DEFAULT NULL AFTER price',
    'SELECT "Column discount_price already exists in products table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'products' 
        AND COLUMN_NAME = 'views'
    ),
    'ALTER TABLE products ADD COLUMN views INT DEFAULT 0 AFTER stock',
    'SELECT "Column views already exists in products table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'products' 
        AND COLUMN_NAME = 'status'
    ),
    'ALTER TABLE products ADD COLUMN status ENUM("active", "inactive") DEFAULT "active" AFTER views',
    'SELECT "Column status already exists in products table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm cột cho bảng orders
SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'orders' 
        AND COLUMN_NAME = 'payment_method'
    ),
    'ALTER TABLE orders ADD COLUMN payment_method ENUM("cod", "banking", "momo", "zalopay") DEFAULT "cod" AFTER payment_status',
    'SELECT "Column payment_method already exists in orders table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'orders' 
        AND COLUMN_NAME = 'note'
    ),
    'ALTER TABLE orders ADD COLUMN note TEXT AFTER payment_method',
    'SELECT "Column note already exists in orders table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Kiểm tra và thêm cột cho bảng order_items
SELECT IF(
    NOT EXISTS(
        SELECT * FROM INFORMATION_SCHEMA.COLUMNS 
        WHERE TABLE_SCHEMA = @dbname 
        AND TABLE_NAME = 'order_items' 
        AND COLUMN_NAME = 'discount_price'
    ),
    'ALTER TABLE order_items ADD COLUMN discount_price DECIMAL(10,2) DEFAULT NULL AFTER price',
    'SELECT "Column discount_price already exists in order_items table"'
) INTO @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt; 