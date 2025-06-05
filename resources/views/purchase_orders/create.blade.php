@extends(backpack_view('blank'))


@section('title', 'Tạo Phiếu Nhập Hàng Mới')

@section('content')
<div class="container mt-4">
    <h1>Tạo Phiếu Nhập Hàng Mới</h1>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('purchase-orders.store') }}" method="POST" id="createPoForm">
        @csrf
        <div class="card">
            <div class="card-header">Thông Tin Chung</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="supplier_id" class="form-label">Nhà Cung Cấp <span class="text-danger">*</span></label>
                        <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
                            <option value="">-- Chọn Nhà Cung Cấp --</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="order_date" class="form-label">Ngày Đặt Hàng <span class="text-danger">*</span></label>
                        <input type="date" name="order_date" id="order_date" class="form-control @error('order_date') is-invalid @enderror" value="{{ old('order_date', date('Y-m-d')) }}" required>
                        @error('order_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="expected_delivery_date" class="form-label">Ngày Dự Kiến Nhận</label>
                        <input type="date" name="expected_delivery_date" id="expected_delivery_date" class="form-control @error('expected_delivery_date') is-invalid @enderror" value="{{ old('expected_delivery_date') }}" required>
                         @error('expected_delivery_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Ghi Chú</label>
                    <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">Chi Tiết Sản Phẩm</div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="productSearchPo" class="form-label">Tìm Sản Phẩm</label>
                        <input type="text" id="productSearchPo" class="form-control" placeholder="Nhập tên hoặc mã sản phẩm...">
                        <div id="searchResultsPo" class="list-group mt-1" style="max-height: 200px; overflow-y: auto; position: absolute; z-index: 1000; width: calc(100% - 30px);"></div>
                    </div>
                </div>

                <table class="table table-bordered" id="poItemsTable">
                    <thead>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th style="width: 120px;">Số Lượng Đặt <span class="text-danger">*</span></th>
                            <th style="width: 180px;">Giá Nhập/ĐV <span class="text-danger">*</span></th>
                            <th style="width: 180px;">Thành Tiền</th>
                            <th style="width: 50px;">Xóa</th>
                        </tr>
                    </thead>
                    <tbody id="poItemsTableBody">
                        {{-- Các dòng sản phẩm sẽ được thêm vào đây bằng JavaScript --}}
                        {{-- Ví dụ một dòng nếu có old input --}}
                        @if(old('items'))
                            @foreach(old('items') as $key => $oldItem)
                                <tr class="po-item-row">
                                    <td>
                                        <input type="hidden" name="items[{{ $key }}][product_id]" value="{{ $oldItem['product_id'] }}">
                                        {{ \App\Models\Product::find($oldItem['product_id'])->name ?? 'Sản phẩm không tồn tại' }}
                                    </td>
                                    <td><input type="number" name="items[{{ $key }}][quantity_ordered]" class="form-control form-control-sm quantity-ordered" value="{{ $oldItem['quantity_ordered'] }}" min="1" required></td>
                                    <td><input type="number" name="items[{{ $key }}][cost_price_at_order]" class="form-control form-control-sm cost-price" value="{{ $oldItem['cost_price_at_order'] }}" min="0" step="100" required></td>
                                    <td class="item-subtotal text-end">0</td>
                                    <td><button type="button" class="btn btn-danger btn-sm removeItemPoButton"><i class="fas fa-times"></i></button></td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold">Tổng Cộng Dự Kiến:</td>
                            <td id="grandTotalPo" class="text-end fw-bold">0 VND</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                @error('items')
                    <div class="text-danger mt-2">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success btn-lg">Lưu Phiếu Nhập</button>
            <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary btn-lg">Hủy</a>
        </div>
    </form>
</div>
@endsection

@push('after_scripts')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap Bundle JS (bao gồm Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 (nếu bạn dùng cho thông báo) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    let poItemIndex = {{ old('items') ? count(old('items')) : 0 }}; // Để tạo index duy nhất cho các item

    // Thiết lập CSRF token (nếu layout chưa có)
    if (!$('meta[name="csrf-token"]').length) {
        $('head').append('<meta name="csrf-token" content="{{ csrf_token() }}">');
    }
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function updateRowSubtotal(row) {
        const quantity = parseFloat(row.find('.quantity-ordered').val()) || 0;
        const costPrice = parseFloat(row.find('.cost-price').val()) || 0;
        const subtotal = quantity * costPrice;
        row.find('.item-subtotal').text(subtotal.toLocaleString('vi-VN') + ' VND');
        updateGrandTotalPo();
    }

    function updateGrandTotalPo() {
        let grandTotal = 0;
        $('#poItemsTableBody .po-item-row').each(function() {
            const quantity = parseFloat($(this).find('.quantity-ordered').val()) || 0;
            const costPrice = parseFloat($(this).find('.cost-price').val()) || 0;
            grandTotal += quantity * costPrice;
        });
        $('#grandTotalPo').text(grandTotal.toLocaleString('vi-VN') + ' VND');
    }

    function addProductToPoTable(product) {
        // Kiểm tra xem sản phẩm đã có trong bảng chưa
        let existingRow = null;
        $('#poItemsTableBody .po-item-row').each(function() {
            if ($(this).find('input[name$="[product_id]"]').val() == product.id) {
                existingRow = $(this);
                return false; // break loop
            }
        });

        if (existingRow) {
            // Nếu đã có, tăng số lượng
            let quantityInput = existingRow.find('.quantity-ordered');
            quantityInput.val(parseInt(quantityInput.val()) + 1).trigger('change');
            Swal.fire('Thông báo', `Đã cập nhật số lượng cho ${product.name}.`, 'info');
        } else {
            // Nếu chưa có, thêm dòng mới
            const newRow = `
                <tr class="po-item-row">
                    <td>
                        <input type="hidden" name="items[${poItemIndex}][product_id]" value="${product.id}">
                        ${product.name}
                        ${product.barcode ? '<br><small class="text-muted">Mã: ' + product.barcode + '</small>' : ''}
                    </td>
                    <td><input type="number" name="items[${poItemIndex}][quantity_ordered]" class="form-control form-control-sm quantity-ordered" value="1" min="1" required></td>
                    <td><input type="number" name="items[${poItemIndex}][cost_price_at_order]" class="form-control form-control-sm cost-price" value="${product.purchase_price || 0}" min="0" step="any" required></td>
                    <td class="item-subtotal text-end">0 VND</td>
                    <td><button type="button" class="btn btn-danger btn-sm removeItemPoButton"><i class="fas fa-times"></i></button></td>
                </tr>
            `;
            $('#poItemsTableBody').append(newRow);
            updateRowSubtotal($('#poItemsTableBody .po-item-row').last()); // Cập nhật subtotal cho dòng mới
            poItemIndex++;
        }
        updateGrandTotalPo();
    }

    // Tìm kiếm sản phẩm cho PO
    let searchPoTimeout;
    $('#productSearchPo').on('input', function() {
        clearTimeout(searchPoTimeout);
        const searchTerm = $(this).val().trim();
        const searchResultsContainerPo = $('#searchResultsPo');

        if (searchTerm.length >= 1) {
            searchResultsContainerPo.html('<div class="list-group-item text-muted">Đang tìm...</div>');
            searchPoTimeout = setTimeout(function() {
                $.ajax({
                    url: "{{ route('products.searchForPo') }}", // Route để tìm sản phẩm
                    type: 'GET',
                    data: { term: searchTerm },
                    dataType: 'json',
                    success: function(products) {
                        searchResultsContainerPo.empty();
                        if (products.length > 0) {
                            products.forEach(function(p) {
                                // Lấy giá nhập từ ProductSupplier nếu có, hoặc từ Product
                                // Đây là ví dụ, bạn cần điều chỉnh logic lấy giá nhập ưu tiên
                                let purchasePrice = p.purchase_price || 0;

                                searchResultsContainerPo.append(
                                    `<a href="#" class="list-group-item list-group-item-action add-product-to-po-button"
                                       data-product-id="${p.id}"
                                       data-product-name="${p.name}"
                                       data-product-barcode="${p.barcode || ''}"
                                       data-product-purchase-price="${purchasePrice}">
                                        <strong>${p.name}</strong>
                                        <small class="d-block text-muted">
                                            Giá nhập dự kiến: ${parseFloat(purchasePrice).toLocaleString('vi-VN')} VND
                                            ${p.barcode ? ' - Mã: ' + p.barcode : ''}
                                        </small>
                                    </a>`
                                );
                            });
                        } else {
                            searchResultsContainerPo.html('<div class="list-group-item">Không tìm thấy.</div>');
                        }
                    },
                    error: function(xhr) {
                        console.error("Lỗi tìm sản phẩm PO: ", xhr.responseText);
                        searchResultsContainerPo.html('<div class="list-group-item text-danger">Lỗi kết nối.</div>');
                    }
                });
            }, 300);
        } else {
            searchResultsContainerPo.empty();
        }
    });

    // Thêm sản phẩm vào bảng từ kết quả tìm kiếm
    $('#searchResultsPo').on('click', '.add-product-to-po-button', function(e) {
        e.preventDefault();
        const product = {
            id: $(this).data('product-id'),
            name: $(this).data('product-name'),
            barcode: $(this).data('product-barcode'),
            purchase_price: $(this).data('product-purchase-price')
        };
        addProductToPoTable(product);
        $('#productSearchPo').val('');
        $('#searchResultsPo').empty();
    });

    // Xóa dòng sản phẩm khỏi bảng
    $('#poItemsTable').on('click', '.removeItemPoButton', function() {
        $(this).closest('.po-item-row').remove();
        updateGrandTotalPo();
    });

    // Cập nhật thành tiền và tổng cộng khi số lượng hoặc giá thay đổi
    $('#poItemsTable').on('change keyup', '.quantity-ordered, .cost-price', function() {
        updateRowSubtotal($(this).closest('.po-item-row'));
    });

    // Tính toán lại tổng tiền khi tải trang nếu có old input
    $('#poItemsTableBody .po-item-row').each(function() {
        updateRowSubtotal($(this));
    });
    updateGrandTotalPo(); // Cập nhật tổng tiền ban đầu

    // Ngăn submit form bằng Enter trên các ô input để tránh lỗi
    $('#createPoForm input').on('keypress', function(e) {
        if (e.which === 13) { // 13 is the Enter key
            e.preventDefault();
        }
    });
});
</script>
@endpush