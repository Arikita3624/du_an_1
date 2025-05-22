<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
<!-- Search End -->

<!-- Js Plugins -->
<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.nice-select.min.js"></script>
<script src="assets/js/jquery.nicescroll.min.js"></script>
<script src="assets/js/jquery.magnific-popup.min.js"></script>
<script src="assets/js/jquery.countdown.min.js"></script>
<script src="assets/js/jquery.slicknav.js"></script>
<script src="assets/js/mixitup.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/main.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    try {
        const message = document.getElementById('globalMessage');
        if (message) {
            console.log('Thông báo được tìm thấy:', message.textContent);
            setTimeout(() => {
                message.classList.add('hidden');
                console.log('Thông báo đã được ẩn sau 2,5 giây');
            }, 2500);
        } else {
            console.log('Không tìm thấy thông báo với ID globalMessage');
        }

        const loader = document.querySelector('.loader');
        if (loader) {
            setTimeout(() => {
                loader.style.display = 'none';
                console.log('Loader đã được ẩn');
            }, 500);
        } else {
            console.log('Không tìm thấy loader');
        }
    } catch (error) {
        console.error('Lỗi trong script:', error);
    }
});
</script>

</body>
</html>