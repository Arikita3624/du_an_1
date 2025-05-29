<style>
    .header {
        position: relative;
        z-index: 900;
        background: #ffffff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .header__top {
        background:rgb(172, 178, 164);
        padding: 10px 0;
    }

    .header__top__left p {
        color: #ffffff;
        margin: 0;
    }

    .header__top__right {
        text-align: right;
    }

    .user-greeting {
        color: #ffffff;
        margin-right: 10px;
        font-weight: 500;
        font-size: 14px;
    }

    .header__top__links a {
        margin-left: 10px;
        color: #ffffff;
        text-decoration: none;
        font-size: 14px;
    }

    .header__top__links a:hover {
        text-decoration: underline;
    }

    .header__logo {
        padding: 15px 0;
    }

    .header__logo img {
        max-height: 50px;
    }

    .header__menu {
        padding: 15px 0;
    }

    .header__menu ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        justify-content: center;
    }

    .header__menu ul li {
        position: relative;
        margin: 0 15px;
    }

    .header__menu ul li a {
        color: #111111;
        font-weight: 500;
        text-decoration: none;
        font-size: 16px;
    }

    .header__menu ul li:hover > a {
        color: #7fad39;
    }

    .header__menu ul li .dropdown {
        position: absolute;
        left: 0;
        top: 100%;
        width: 200px;
        background: #ffffff;
        padding: 10px 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: none;
    }

    .header__menu ul li:hover .dropdown {
        display: block;
    }

    .header__menu ul li .dropdown li {
        margin: 0;
        padding: 0 15px;
    }

    .header__menu ul li .dropdown li a {
        font-size: 14px;
        padding: 5px 0;
        display: block;
    }

    .header__search {
        padding: 15px 0;
    }

    .header__search form {
        display: flex;
        align-items: center;
        max-width: 100%;
    }

    .header__search input[type="text"] {
        border: 1px solid #e1e1e1;
        padding: 8px 15px;
        border-radius: 4px 0 0 4px;
        outline: none;
        flex-grow: 1;
        font-size: 14px;
    }

    .header__search button {
        background-color:rgb(174, 237, 80);
        color: white;
        border: 1px solidrgb(141, 157, 116);
        padding: 8px 15px;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        transition: all 0.3s;
    }

    .header__search button:hover {
        background-color:rgb(122, 134, 105);
        border-color:rgb(170, 185, 147);
    }

    .canvas__open {
        display: none;
    }

    @media only screen and (max-width: 991px) {
        .header__menu {
            display: none;
        }
        .canvas__open {
            display: block;
            position: absolute;
            right: 15px;
            top: 15px;
            font-size: 24px;
            color: #111111;
            cursor: pointer;
        }
    }
</style>

<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-7">
                    <div class="header__top__left">
                        <p>Lê Đức Quân</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-5">
                    <div class="header__top__right">
                        <div class="header__top__links">
                            <?php if (isset($_SESSION['user']) && is_array($_SESSION['user']) && !empty($_SESSION['user']['username'])): ?>
                                <span class="user-greeting">Xin chào, <?= htmlspecialchars($_SESSION['user']['username'], ENT_QUOTES, 'UTF-8') ?>!</span>
                                <a href="?act=logout">Đăng xuất</a>
                            <?php else: ?>
                                <?php unset($_SESSION['user']); ?>
                                <a href="?act=login">Đăng nhập</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-3">
                <div class="header__logo">
                    <a href="?act=/"><img src="assets/img/logo.png" alt="Logo"></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <nav class="header__menu mobile-menu">
                    <ul>
                        <li class="active"><a href="?act=/">Trang chủ</a></li>
                        <li><a href="?act=product-list">Cửa hàng</a></li>
                        <li><a href="#">Trang</a>
                            <ul class="dropdown">
                                <li><a href="?act=about">Về chúng tôi</a></li>
                                <li><a href="?act=product-detail">Chi tiết sản phẩm</a></li>
                                <li><a href="?act=carts">Giỏ hàng</a></li>
                                <li><a href="?act=checkout">Thanh toán</a></li>
                                <li><a href="blog-details.html">Chi tiết Blog</a></li>
                            </ul>
                        </li>
                        <li><a href="?act=about">Về chúng tôi</a></li>
                        <li><a href="contact.html">Liên hệ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-md-3">
                <div class="header__search">
                    <div class="d-flex align-items-center justify-content-end">
                        <form action="?act=product-list" method="GET" class="d-flex align-items-center me-2">
                            <input type="hidden" name="act" value="product-list">
                            <input type="text" name="keyword" placeholder="Tìm kiếm sản phẩm...">
                            <button type="submit"><i class="fa fa-search"></i></button>
                        </form>
                        <a href="?act=carts" class="cart-icon"><img src="assets/img/icon/cart.png" alt=""></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="canvas__open"><i class="fa fa-bars"></i></div>
    </div>
</header>