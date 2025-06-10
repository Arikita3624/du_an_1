<?php

require_once __DIR__ . '/../commons/function.php';

class SignUpModel
{
    public function register($data)
    {
        $conn = connectDB(); // lấy kết nối PDO

        $username = trim($data['username']);
        $full_name = trim($data['full_name']);
        $email = trim($data['email']);
        $password = password_hash(trim($data['password']), PASSWORD_DEFAULT);
        $address = trim($data['address'] ?? '');
        $phone = trim($data['phone'] ?? '');

        // Kiểm tra username hoặc email đã tồn tại
        try {
            $sqlCheck = "SELECT COUNT(*) FROM users WHERE email = :email OR username = :username";
            $stmtCheck = $conn->prepare($sqlCheck);
            $stmtCheck->execute([':email' => $email, ':username' => $username]);
            if ($stmtCheck->fetchColumn() > 0) {
                return ['success' => false, 'message' => 'Email hoặc username đã tồn tại.'];
            }

            $sql = "INSERT INTO users (username, full_name, email, password, address, phone) VALUES (:username, :full_name, :email, :password, :address, :phone)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':full_name' => $full_name,
                ':email' => $email,
                ':password' => $password,
                ':address' => $address ?: null,
                ':phone' => $phone ?: null
            ]);

            return ['success' => true, 'message' => 'Đăng ký thành công! Vui lòng đăng nhập.'];
        } catch (PDOException $e) {
            // Xử lý lỗi cụ thể (ví dụ: vi phạm ràng buộc duy nhất)
            if ($e->getCode() == 23000) {
                return ['success' => false, 'message' => 'Email hoặc username đã được sử dụng.'];
            }
            return ['success' => false, 'message' => 'Lỗi khi đăng ký: ' . $e->getMessage()];
        }
    }
}

class SignInModel
{
    public function login($email, $password = null, $byEmailOnly = false)
    {
        $conn = connectDB();
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($byEmailOnly && $user) {
            return $user;
        }

        if ($user && $password !== null && password_verify($password, $user['password'])) {
            return $user;
        }

        return ['success' => false, 'message' => 'Email hoặc mật khẩu không đúng'];
    }
}
