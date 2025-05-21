<style>
    .form-section {
        padding: 60px 0;
        background-color: #f3f4f6;
        position: relative;
    }

    .form-container {
        max-width: 420px;
        margin: auto;
        background: white;
        padding: 40px 30px;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        position: relative;
        z-index: 1;
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
        padding: 10px 20px;
        margin-bottom: 20px;
        border-radius: 4px;
        text-align: center;
        font-size: 14px;
        position: relative; /* Đặt trong form-container thay vì absolute */
        width: 100%;
        box-sizing: border-box;
        transition: opacity 0.5s ease;
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

    .message.hidden {
        opacity: 0;
        visibility: hidden;
    }
</style>

<section class="form-section">
    <div class="form-container">
        <?php
        // Hiển thị thông báo từ session nếu có
        if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
            echo '<div class="message ' . htmlspecialchars($_SESSION['message_type']) . '" id="loginMessage">';
            echo htmlspecialchars($_SESSION['message']);
            echo '</div>';
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>
        <h2 class="form-title">Login to Your Account</h2>
        <form action="?act=login" method="POST">
            <div class="form-group">
                <label>Email address</label>
                <input type="email" name="email" required />
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required />
            </div>
            <button type="submit" class="form-btn">Login</button>
            <p class="form-footer">
                Don’t have an account?
                <a href="?act=register">Sign up</a>
            </p>
        </form>
    </div>
</section>

<script>
    // Tự động ẩn thông báo sau 1,5 giây
    const message = document.getElementById('loginMessage');
    if (message) {
        console.log('Thông báo đang hiển thị:', message.textContent); // Debug
        setTimeout(() => {
            message.classList.add('hidden');
        }, 2500); // 1500 milliseconds = 2,5 giây
    } else {
        console.log('Không tìm thấy thông báo'); // Debug
    }
</script>