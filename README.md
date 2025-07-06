Đây là dự án 1 (Một môn học liên quan đến dụ án web site)
Dưới đây là phần nội dung và cách thực hiện demo trang web Male Fashion

1. Cài đặt 
  - Xampp, chạy start apache, mySql
  - tạo folder Nhom4
  - nhập lệnh clone git clone https://github.com/Arikita3624/du_an_1/
  - chạy trang web vói đường dẫn http://localhost/Nhom4/du_an_1/duan1/

2. Nội dung đã thực hiện
*Client
  - Trang chủ: Thực hiện xem trang chủ cho khách hàng ở trang Client. Hiển thị sản phẩm được xem nhiều nhất (tính theo views, chưa có mỗi lần ấn vào sản phẩm là tính một lần xem)
  - Sản phẩm: Danh sách sản phẩm được phân trang và được lọc theo tên và danh mục, mức giá (Chưa thể lọc theo biến thể, và khi lọc sẽ chưa thể lọc cùng một lúc nhiều thứ)
  - Chi tiết sản phẩm: Khi ấn vào một sản phẩm bất kỳ sẽ ra chi tiết sản phẩm, hiển thị tên, giá, số lượng muốn thêm vào giỏ, tồn kho, bình luận(Chưa thực hiện được đánh giá theo sao), khi người dùng mua một sản phẩm mới có bình luận
  - Các sản phẩm tương tự(Theo cùng danh mục)
  - Giỏ hàng: Thực hiện thêm sản phẩm vào giỏ hàng, không thể thực hiện thêm nếu số lượng là 0, và vượt quá số lượng tồn kho. Hiển thị thông tìn về giỏ hàng, tổng giá. Khi ấn thanh toán chuyển qua trang nhập thông tin(sẽ tự field thông tin khách hàng nếu khi đăng ký nhập đầy đủ) thông tin(số điện thoại và địa chỉ không bắt buộc)
  - Thanh toán: khi ấn thanh toán sẽ chuyển trang chi tiết đơn hàng, hiển thị đầy đủ nội dung từ thời gian, thông tin khách hàng, tên sản phẩm, giá, v.v... Khi ở trạng thái chờ xác nhận, và đã xác nhận vẫn có thể huỷ được đươn hàng,
  Khi ở trangj thái đang giao hàng thì không được huỷ. Khi đơn hàng đang ở trạng thái đã giao, việc hoàn tất đơn hàng sẽ ở bên client khi ấn vào nút đã nhận hàng(chưa thực hiện được đơn hàng sẽ tự động chuyển qua đã nhận hàng và hoàn thành đơn khi qua mấy ngày mà khách hàng không ấn đã nhận hàng)
  Khi ở trạng thái đã hoàn thành thì trạng thái thanh toán sẽ thành Đã thanh toán (chưa thực hiện được đặt hàng online)
*Admin
  - Thêm sửa sản phẩm (Vô hiệu hoá xoá sản phẩm), hiển thị danh sách sản phẩm
  - Hiển thị danh sách danh mục, thêm danh mục, sửa danh mục
  - Xem và chỉnh sửa thạng thái đơn hàng, chỉ có thể huỷ khi đabg ở chờ xác nhận và đã xác nhận
  - Hiển thị danh sách comment. xoá comment
  - Quản lý người dùng, có thể xem. chỉnh sửa quyền của người dùng(Chỉ vô hiệu hoá ở bên admib, chưa thực hiện nó ở trang client), vô hiệu hoá người dùng, không thể phân quyền cho tài khoản đang đăng nhập !

!English
This is project 1 (A subject related to the web site project)
Here is the content and how to perform the Male Fashion website demo

1. Installation
- Xampp, run start apache, mySql
- create folder Nhom4
- enter the clone command git clone https://github.com/Arikita3624/du_an_1/
- run the website with the path http://localhost/Nhom4/du_an_1/duan1/

2. Completed content
*Client
- Home page: View the home page for customers on the Client page. Show most viewed products (by views, each click on the product is counted as a view)
- Product: The product list is paginated and filtered by name and category, price (Cannot filter by variant, and when filtering, cannot filter multiple things at the same time)
- Product details: When clicking on any product, the product details will appear, displaying the name, price, quantity to add to cart, inventory, comments (Cannot rate by star yet), when the user buys a new product with comments
- Similar products (According to the same category)
- Shopping cart: Add products to the shopping cart, cannot add if the quantity is 0, and exceeds the inventory quantity. Display information about the shopping cart, total price. When clicking on payment, it will go to the information entry page (customer information will be automatically fielded if you enter it completely when registering) information (phone number and address are not required)
- Payment: when clicking on payment, it will go to the order detail page, displaying full content from time, customer information, product name, price, etc. When in the status of waiting for confirmation, and confirmed, the order can still be canceled,
When in the status of delivery, it cannot be canceled. When the order is in the delivered status, the order completion will be on the client side when clicking on the received button (the order will automatically change to received and complete the order after a few days if the customer does not click received)
When in the completed status, the payment status will become Paid (cannot place an online order)
*Admin
- Add and edit products (Disable delete products), display product list
- Display category list, add category, edit category
- View and edit order status, can only cancel when waiting for confirmation and confirmed
- Display comment list. delete comment
- Manage users, can view. edit user rights (Only disable on the admin side, not yet implemented on the client page), disable users, cannot assign rights to the logged in account!
