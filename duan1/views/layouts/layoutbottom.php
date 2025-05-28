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


</body>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const categorySelect = document.getElementById('categorySelect');
        const productList = document.querySelector('.col-lg-9 .row');

        function fetchProducts() {
            const search = searchInput.value;
            const category_id = categorySelect.value;
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `?act=product-list-ajax&search=${encodeURIComponent(search)}&category_id=${encodeURIComponent(category_id)}`, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    productList.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }

        searchInput.addEventListener('input', fetchProducts);
        categorySelect.addEventListener('change', fetchProducts);
    });

    document.querySelectorAll('.set-bg').forEach(function(element) {
        element.style.backgroundImage = 'url(' + element.getAttribute('data-setbg') + ')';
    });

    document.addEventListener('DOMContentLoaded', function() {
        var toggle = document.getElementById('userDropdownToggle');
        var menu = document.getElementById('userDropdownMenu');
        if (toggle && menu) {
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
            });
            document.addEventListener('click', function() {
                menu.style.display = 'none';
            });
        }
    });
</script>

</html>