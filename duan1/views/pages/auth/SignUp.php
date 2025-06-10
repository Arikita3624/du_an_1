<style>
  .form-section {
    padding: 60px 0;
    background-color: #f3f4f6;
  }

  .form-container {
    max-width: 420px;
    margin: auto;
    background: white;
    padding: 40px 30px;
    border-radius: 8px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
  }

  .form-title {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 25px;
    text-align: center;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-group label {
    display: block;
    font-weight: 500;
    margin-bottom: 6px;
  }

  .form-group input {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 15px;
  }

  .form-btn {
    width: 100%;
    background-color: #111;
    color: white;
    padding: 12px;
    border: none;
    border-radius: 4px;
    font-weight: bold;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
  }

  .form-btn:hover {
    background-color: #333;
  }

  .form-footer {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
  }

  .form-footer a {
    color: #e53637;
    text-decoration: none;
  }

  .form-footer a:hover {
    text-decoration: underline;
  }

  .message {
    padding: 10px;
    margin-bottom: 20px;
    border-radius: 4px;
    text-align: center;
    font-size: 14px;
  }

  .message.success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
  }

  .message.error {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
  }
</style>

<section class="form-section">
  <div class="form-container">
    <h2 class="form-title">Đăng ký tài khoản</h2>

    <?php
    $type = $_SESSION['message_type'] ?? '';
    $message = $_SESSION['message'] ?? '';
    unset($_SESSION['message'], $_SESSION['message_type']);

    if (!empty($message)) {
      echo '<div class="message ' . htmlspecialchars($type) . '">';
      echo htmlspecialchars($message);
      echo '</div>';
    }
    ?>

    <form action="?act=register" method="POST">
      <div class="form-group">
        <label>Username<span>*</span></label>
        <input type="text" name="username" id="username" required />
      </div>
      <div class="form-group">
        <label for="full_name">Họ và tên<span>*</span></label>
        <input type="text" name="full_name" id="full_name" required />
      </div>
      <div class="form-group">
        <label>Email<span>*</span></label>
        <input type="email" name="email" id="email" required />
      </div>
      <div class="form-group">
        <label>Mật khẩu</label>
        <input type="password" name="password" id="password" required />
      </div>
      <div class="form-group">
        <label>Địa chỉ<span>*</span></label>
        <input type="text" name="address" id="address" required>
      </div>
      <div class="form-group">
        <label>Số điện thoại<span>*</span></label>
        <input type="text" name="phone" id="phone" required pattern="[0-9]+" title="Vui lòng nhập số điện thoại hợp lệ">
      </div>
      <button type="submit" class="form-btn">Đăng Ký</button>
      <p class="form-footer">
        Đã có tải khoản ? <a href="?act=login">Đăng nhập</a>
      </p>
    </form>
  </div>
</section>
