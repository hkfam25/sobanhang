@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid mt-3" id="pos-container">
    <div class="row">
        {{-- Cột bên trái: Tìm kiếm sản phẩm và kết quả tìm kiếm --}}
        <div class="col-lg-7 mb-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-search me-2"></i>Tìm Kiếm Sản Phẩm</h5>
                </div>
                <div class="card-body">
                    <div class="input-group input-group-lg mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-barcode"></i></span>
                        <input type="text" id="productSearchInput" class="form-control" placeholder="Quét mã vạch hoặc nhập tên sản phẩm..." aria-label="Tìm sản phẩm" aria-describedby="basic-addon1" autocomplete="off">
                    </div>
                    <div id="searchResults" class="list-group" style="max-height: 450px; overflow-y: auto;">
                        {{-- Kết quả tìm kiếm sản phẩm sẽ được hiển thị ở đây bằng JavaScript --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- Cột bên phải: Giỏ hàng hiện tại và thông tin thanh toán --}}
        <div class="col-lg-5">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart me-2"></i>Hóa Đơn Hiện Tại</h5>
                </div>
                <div class="card-body">
                    <div id="currentSaleCart" style="min-height: 300px; max-height: 400px; overflow-y: auto; border-bottom: 1px solid #eee; margin-bottom: 15px;">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th style="width: 80px;">SL</th>
                                    <th style="width: 120px;">Đơn giá</th>
                                    <th>Thành tiền</th>
                                    <th style="width: 50px;">Xóa</th>
                                </tr>
                            </thead>
                            <tbody id="cartTableBody">
                                {{-- Các sản phẩm trong giỏ hàng sẽ được hiển thị ở đây --}}
                                <tr id="cartEmptyRow">
                                    <td colspan="5" class="text-center text-muted py-3">Giỏ hàng trống</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="row mb-2">
                        <label for="paymentMethod" class="col-sm-4 col-form-label fw-bold">P.Thức T.Toán:</label>
                        <div class="col-sm-8">
                            <select id="paymentMethod" class="form-select">
                                <option value="Tiền mặt" selected>Tiền mặt</option>
                                <option value="Chuyển khoản">Chuyển khoản</option>
                                <option value="Thẻ ngân hàng">Thẻ ngân hàng</option>
                                <option value="Ví điện tử">Ví điện tử</option>
                            </select>
                        </div>
                    </div>
                    {{-- Bạn có thể thêm các trường khác như Khách hàng, Ghi chú ở đây --}}

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="mb-0">Tổng cộng:</h4>
                        <h4 class="mb-0 fw-bold text-danger"><span id="grandTotal">0</span> VND</h4>
                    </div>

                    <div class="d-grid gap-2">
                        <button id="submitSaleButton" class="btn btn-success btn-lg" disabled>
                            <i class="fas fa-check-circle me-2"></i>THANH TOÁN
                        </button>
                        <button id="clearCartButton" class="btn btn-outline-danger">
                            <i class="fas fa-trash-alt me-2"></i>HỦY HÓA ĐƠN
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('after_scripts') {{-- Đẩy JavaScript vào stack 'scripts' trong layout của bạn --}}
<script>
$(document).ready(function() {
    let cart = []; // Mảng lưu trữ các sản phẩm trong giỏ hàng (client-side)

    // Thiết lập CSRF token cho tất cả các AJAX request (quan trọng cho Laravel)
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Hàm cập nhật và hiển thị lại giỏ hàng trên giao diện
    function renderCart() {
        const cartTableBody = $('#cartTableBody');
        cartTableBody.empty(); // Xóa các dòng cũ
        let grandTotal = 0;

        if (cart.length === 0) {
            cartTableBody.html('<tr id="cartEmptyRow"><td colspan="5" class="text-center text-muted py-3">Giỏ hàng trống</td></tr>');
            $('#submitSaleButton').prop('disabled', true); // Vô hiệu hóa nút thanh toán nếu giỏ hàng trống
        } else {
            cart.forEach(function(item, index) {
                let subtotal = item.quantity * item.price;
                grandTotal += subtotal;
                cartTableBody.append(`
                    <tr data-cart-index="${index}" data-product-id="${item.product_id}">
                        <td>
                            ${item.name}
                            ${item.barcode ? '<br><small class="text-muted">Mã: ' + item.barcode + '</small>' : ''}
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm item-quantity-input" value="${item.quantity}" min="1" max="${item.stock_quantity_on_add || 999}" style="width: 70px;">
                        </td>
                        <td>
                            <input type="number" class="form-control form-control-sm item-price-input" value="${item.price}" min="0" step="1000" style="width: 120px;">
                        </td>
                        <td class="item-subtotal">${subtotal.toLocaleString('vi-VN')}</td>
                        <td><button class="btn btn-danger btn-sm removeItemButton" title="Xóa sản phẩm"><i class="fas fa-times"></i></button></td>
                    </tr>
                `);
            });
            $('#submitSaleButton').prop('disabled', false); // Kích hoạt nút thanh toán
        }
        $('#grandTotal').text(grandTotal.toLocaleString('vi-VN'));
    }

    // Xử lý sự kiện thay đổi số lượng sản phẩm trong giỏ hàng
    $('#cartTableBody').on('change', '.item-quantity-input', function() {
        const index = $(this).closest('tr').data('cart-index');
        let newQuantity = parseInt($(this).val());
        const maxQuantity = parseInt($(this).attr('max'));

        if (isNaN(newQuantity) || newQuantity < 1) {
            newQuantity = 1;
            $(this).val(1);
        } else if (newQuantity > maxQuantity) {
            newQuantity = maxQuantity;
            $(this).val(maxQuantity);
            // alert(`Số lượng tồn kho của sản phẩm này chỉ còn ${maxQuantity}.`);
            // Hoặc dùng thư viện toast/notification
        }
        cart[index].quantity = newQuantity;
        renderCart();
    });

    // Xử lý sự kiện thay đổi giá sản phẩm trong giỏ hàng (giảm giá)
    $('#cartTableBody').on('change', '.item-price-input', function() {
        const index = $(this).closest('tr').data('cart-index');
        let newPrice = parseFloat($(this).val());
        if (isNaN(newPrice) || newPrice < 0) {
            newPrice = 0; // Hoặc giá gốc cart[index].original_price
            $(this).val(newPrice);
        }
        cart[index].price = newPrice;
        renderCart();
    });

    // Xử lý sự kiện xóa sản phẩm khỏi giỏ hàng
    $('#cartTableBody').on('click', '.removeItemButton', function() {
        const index = $(this).closest('tr').data('cart-index');
        cart.splice(index, 1); // Xóa phần tử khỏi mảng cart
        renderCart();
    });

    // Hàm thêm sản phẩm vào giỏ hàng
    function addToCart(product) {
        if (!product || product.stock_quantity <= 0) {
            // alert('Sản phẩm đã hết hàng hoặc không hợp lệ.');
            // Hoặc dùng toast/notification
            $('#productSearchInput').val('').focus();
            return;
        }

        const existingItemIndex = cart.findIndex(item => item.product_id === product.id);

        if (existingItemIndex > -1) {
            // Nếu sản phẩm đã có trong giỏ, tăng số lượng
            // Kiểm tra số lượng tồn kho trước khi tăng
            if (cart[existingItemIndex].quantity < product.stock_quantity) {
                 cart[existingItemIndex].quantity++;
            } else {
                // alert(`Đã đạt số lượng tồn kho tối đa cho sản phẩm ${product.name}.`);
                // Hoặc dùng toast/notification
            }
        } else {
            // Nếu sản phẩm chưa có, thêm mới vào giỏ
            cart.push({
                product_id: product.id,
                name: product.name,
                barcode: product.barcode,
                quantity: 1,
                price: parseFloat(product.selling_price), // Giá bán gốc
                original_price: parseFloat(product.selling_price), // Lưu giá gốc để tham khảo
                stock_quantity_on_add: product.stock_quantity, // Lưu tồn kho lúc thêm vào để giới hạn input số lượng
            });
        }
        renderCart();
    }

    // Xử lý sự kiện tìm kiếm sản phẩm khi người dùng nhập liệu hoặc quét mã vạch
    let searchTimeout;
    $('#productSearchInput').on('input', function() { // Dùng 'input' thay vì 'keyup' để bắt cả paste
        clearTimeout(searchTimeout);
        const searchTerm = $(this).val().trim();
        const searchResultsContainer = $('#searchResults');

        if (searchTerm.length >= 1) { // Bắt đầu tìm khi có ít nhất 1 ký tự (hoặc sau khi quét barcode)
            searchResultsContainer.html('<div class="list-group-item text-muted">Đang tìm kiếm...</div>');
            searchTimeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('searchProducts') }}", // Route đã định nghĩa ở web.php
                    type: 'GET',
                    data: { term: searchTerm },
                    dataType: 'json',
                    success: function(products) {
                        console.log('Sản phẩm tìm thấy từ server:', products);
                        searchResultsContainer.empty();
                        if (products.length > 0) {
                            products.forEach(function(product) {
                                searchResultsContainer.append(`
                                    <a href="#" class="list-group-item list-group-item-action add-to-cart-button"
                                       data-product-id="${product.id}"
                                       data-product-name="${product.name}"
                                       data-product-barcode="${product.barcode || ''}"
                                       data-product-price="${product.selling_price}"
                                       data-product-stock="${product.stock_quantity}">
                                        <strong>${product.name}</strong>
                                        <small class="d-block text-muted">
                                            Giá: ${parseFloat(product.selling_price).toLocaleString('vi-VN')} VND
                                            - Tồn: ${product.stock_quantity}
                                            ${product.barcode ? ' - Mã: ' + product.barcode : ''}
                                        </small>
                                    </a>
                                `);
                            });
                            // Nếu chỉ có 1 kết quả (thường là khi quét barcode chính xác) và sản phẩm còn hàng -> tự động thêm vào giỏ
                            if (products.length === 1 && products[0].stock_quantity > 0) {
                                console.log('Tự động thêm sản phẩm:', products[0]); // Bỏ comment để debug

                                addToCart(products[0]);
                                $('#productSearchInput').val('').focus(); // Xóa input và focus lại
                                searchResultsContainer.empty(); // Xóa kết quả tìm kiếm
                            }
                        } else {
                            searchResultsContainer.html('<div class="list-group-item">Không tìm thấy sản phẩm nào.</div>');
                        }
                    },
                    error: function(xhr) {
                        console.error("Lỗi khi tìm kiếm sản phẩm: ", xhr.responseText);
                        searchResultsContainer.html('<div class="list-group-item text-danger">Lỗi kết nối hoặc không tìm thấy sản phẩm.</div>');
                    }
                });
            }, 300); // Chờ 300ms sau khi người dùng ngừng gõ mới gửi request
        } else {
            searchResultsContainer.empty(); // Xóa kết quả nếu ô tìm kiếm trống
        }
    });

    // Xử lý sự kiện click vào một sản phẩm trong danh sách kết quả tìm kiếm
    $('#searchResults').on('click', '.add-to-cart-button', function(e) {
        e.preventDefault();
        const productData = {
            id: $(this).data('product-id'),
            name: $(this).data('product-name'),
            barcode: $(this).data('product-barcode'),
            selling_price: $(this).data('product-price'),
            stock_quantity: $(this).data('product-stock')
        };
        addToCart(productData);
        $('#productSearchInput').val('').focus(); // Xóa input và focus lại
        $('#searchResults').empty(); // Xóa kết quả tìm kiếm
    });


    // Xử lý sự kiện hủy toàn bộ hóa đơn
    $('#clearCartButton').on('click', function() {
        if (confirm('Bạn có chắc chắn muốn hủy hóa đơn này?')) {
            cart = [];
            renderCart();
            $('#productSearchInput').val('').focus();
            $('#searchResults').empty();
            // Thêm thông báo nếu cần
        }
    });

    // Xử lý sự kiện nhấn nút Thanh Toán
    $('#submitSaleButton').on('click', function() {
        if (cart.length === 0) {
            // alert('Giỏ hàng trống. Vui lòng thêm sản phẩm để thanh toán.');
            // Hoặc dùng toast/notification
            return;
        }

        // Vô hiệu hóa nút để tránh click nhiều lần
        const $thisButton = $(this);
        $thisButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Đang xử lý...');

        const saleDataPayload = {
            cart_items: cart.map(item => ({ // Chỉ gửi các thông tin cần thiết
                product_id: item.product_id,
                quantity: item.quantity,
                price: item.price // Giá đã có thể được sửa
            })),
            payment_method: $('#paymentMethod').val(),
            // Thêm các thông tin khác nếu cần: customer_id, notes,...
        };

        $.ajax({
            url: "{{ route('submitSale') }}", // Route đã định nghĩa
            type: 'POST',
            data: JSON.stringify(saleDataPayload), // Gửi dữ liệu dưới dạng JSON
            contentType: 'application/json; charset=utf-8', // Quan trọng: khai báo kiểu nội dung
            dataType: 'json', // Mong muốn nhận phản hồi dưới dạng JSON
            success: function(response) {
                if (response.success) {
                    // alert(response.message); // Hoặc dùng thư viện thông báo đẹp hơn (ví dụ: SweetAlert2, Toastr)
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: response.message + (response.sale_id ? ` (Mã HĐ: ${response.sale_id})` : ''),
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#clearCartButton').click(); // Xóa giỏ hàng sau khi thanh toán thành công
                    // (Tùy chọn) In hóa đơn: window.open('/pos/receipt/' + response.sale_id, '_blank');
                } else {
                    // alert('Lỗi: ' + response.message);
                     Swal.fire({
                        icon: 'error',
                        title: 'Thất bại...',
                        text: response.message || 'Có lỗi xảy ra khi lưu đơn hàng.'
                    });
                }
            },
            error: function(xhr) {
                console.error("Lỗi khi gửi đơn hàng: ", xhr.responseText);
                let errorMessage = "Có lỗi không xác định xảy ra trong quá trình thanh toán.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 422) { // Lỗi validation từ Laravel
                    errorMessage = "Dữ liệu không hợp lệ. Vui lòng kiểm tra lại.";
                    // Bạn có thể xử lý chi tiết lỗi validation ở đây nếu muốn
                    // Ví dụ: xhr.responseJSON.errors
                }
                 Swal.fire({
                    icon: 'error',
                    title: 'Lỗi nghiêm trọng!',
                    text: errorMessage
                });
            },
            complete: function() {
                // Kích hoạt lại nút sau khi request hoàn tất
                $thisButton.prop('disabled', false).html('<i class="fas fa-check-circle me-2"></i>THANH TOÁN');
            }
        });
    });

    // Khởi tạo giỏ hàng và focus vào ô tìm kiếm khi trang tải xong
    renderCart(); // Để hiển thị "Giỏ hàng trống" ban đầu
    $('#productSearchInput').focus();

    // (Tùy chọn) Thêm thư viện thông báo như SweetAlert2 hoặc Toastr để có thông báo đẹp hơn
    // Ví dụ với SweetAlert2:
    // Swal.fire('Any fool can use a computer')
});
</script>
@endpush