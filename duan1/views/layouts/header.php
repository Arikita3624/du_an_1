<style>
    .user-greeting {
        color: #111;
        margin-right: 10px;
        font-weight: 500;
        font-size: 14px;
    }

    .header__top__links a {
        margin-left: 10px;
        color: #111;
        text-decoration: none;
    }

    .header__top__links a:hover {
        text-decoration: underline;
    }

    .header__top__links .logout-link {
        color: #ffffff;
        /* Thay đổi màu chữ của nút "Đăng xuất" thành trắng */
    }

    .header {
        position: relative;
        z-index: 900;
    }

    body {
        padding-top: 0;
    }

    .user-greeting {
        color: #ffffff;
    }

    .logout-link {
        color: #ffffff;
        text-decoration: none;
        margin-left: 10px;
    }

    .user-dropdown {
        position: relative;
        display: inline-block;
    }

    .user-dropdown .user-greeting {
        color: #fff;
        cursor: pointer;
        font-weight: 500;
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 4px;
        transition: background 0.2s;
    }

    .user-dropdown .user-greeting:hover {
        background: #e53637;
    }

    .user-dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        top: 120%;
        background: #fff;
        min-width: 180px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        border-radius: 6px;
        z-index: 1001;
        padding: 8px 0;
        margin: 0;
        list-style: none;
    }

    .user-dropdown-menu li {
        border-bottom: 1px solid #f0f0f0;
    }

    .user-dropdown-menu li:last-child {
        border-bottom: none;
    }

    .user-dropdown-menu a {
        display: block;
        color: #222;
        padding: 10px 18px;
        text-decoration: none;
        font-size: 15px;
        transition: background 0.2s;
    }

    .user-dropdown-menu a:hover {
        background: #f6f6f6;
        color: #e53637;
    }
</style>

<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        <p>Miễn phí giao hàng, trả hàng trong 30 ngày!</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            <?php if (isset($_SESSION['user']) && is_array($_SESSION['user']) && !empty($_SESSION['user']['username'])): ?>
                                <div class="user-dropdown">
                                    <span class="user-greeting" id="userDropdownToggle">
                                        <i class="fa fa-user"></i>
                                        <?= htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') ?>
                                        <i class="fa fa-caret-down"></i>
                                    </span>
                                    <ul class="user-dropdown-menu" id="userDropdownMenu">
                                        <li><a href="?act=order-list">Danh sách đơn hàng</a></li>
                                        <li><a href="#">Thông tin tài khoản</a></li>
                                        <li><a href="#">Đổi mật khẩu</a></li>
                                        <li><a href="?act=logout" class="logout-link">Đăng xuất</a></li>
                                    </ul>
                                </div>
                            <?php else: ?>
                                <?php unset($_SESSION['user']); ?>
                                <a href="?act=login" class="logout-link">Đăng nhập</a>
                            <?php endif; ?>
                        </div>
                        <div class="header__top__hover">
                            <span>VND<i class="arrow_carrot-down"></i></span>
                            <ul>
                                <li>VND</li>
                                <li>USD</li>
                                <li>URO</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="?act=/"><img src="assets/img/logo.png" alt="Logo"></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="active"><a href="?act=/">Trang chủ</a></li>
                        <li><a href="?act=product-list">Sản phẩm</a></li>
                        <li><a href="?act=about">Về chúng tôi</a></li>
                        <li><a href="contact.html">Liên Hệ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <a href="#" class="search-switch"><img src="assets/img/icon/search.png" alt="Search"></a>
                    <a href="#"><img src="assets/img/icon/heart.png" alt="Wishlist"></a>
                    <a href="?act=carts"><img src="assets/img/icon/cart.png" alt="Cart"></a>
                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>