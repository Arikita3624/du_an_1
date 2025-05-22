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
</style>

<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        <p>Free shipping, 30-day return or refund guarantee.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            <?php if (isset($_SESSION['user']) && is_array($_SESSION['user']) && !empty($_SESSION['user']['username'])): ?>
                                <span class="user-greeting">Xin chào, <?= htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') ?>!</span>
                                <a href="?act=logout" class="logout-link">Đăng xuất</a>
                            <?php else: ?>
                                <?php unset($_SESSION['user']); // Xóa session không hợp lệ
                                ?>
                                <a href="?act=login" class="logout-link">Sign in</a>
                            <?php endif; ?>
                        </div>
                        <div class="header__top__hover">
                            <span>Usd <i class="arrow_carrot-down"></i></span>
                            <ul>
                                <li>USD</li>
                                <li>EUR</li>
                                <li>USD</li>
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
                        <li class="active"><a href="?act=/">Home</a></li>
                        <li><a href="?act=product-list">Shop</a></li>
                        <li><a href="#">Pages</a>
                            <ul class="dropdown">
                                <li><a href="?act=about">About Us</a></li>
                                <li><a href="?act=product-detail">Shop Details</a></li>
                                <li><a href="?act=carts">Shopping Cart</a></li>
                                <li><a href="?act=checkout">Check Out</a></li>
                                <li><a href="blog-details.html">Blog Details</a></li>
                            </ul>
                        </li>
                        <li><a href="?act=about">About</a></li>
                        <li><a href="contact.html">Contacts</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__nav__option">
                    <a href="#" class="search-switch"><img src="assets/img/icon/search.png" alt="Search"></a>
                    <a href="#"><img src="assets/img/icon/heart.png" alt="Wishlist"></a>
                    <a href="#"><img src="assets/img/icon/cart.png" alt="Cart"> <span>0</span></a>
                    <div class="price">$0.00</div>
                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>