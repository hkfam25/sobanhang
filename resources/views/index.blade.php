@extends(backpack_view('blank'))
@section('content')
<div class="row">
    {{-- Left Column: Product Search & Results --}}
    <div class="col-md-7">
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <input type="text" id="productSearch" class="form-control form-control-lg" placeholder="Scan barcode or search product...">
                </div>
                <div id="searchResults" class="list-group mt-3">
                    {{-- Search results will be dynamically added here --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Cart & Payment --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Current Sale</h3>
            </div>
            <div class="card-body">
                <div id="cart">
                    <table class="table" id="cartTable">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cartItems">
                        </tbody>
                    </table>
                </div>
                <div class="text-right">
                    <h4>Total: <span id="grandTotal">0</span></h4>
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary btn-lg btn-block" id="checkoutBtn">Checkout</button>
                    <button class="btn btn-danger btn-block" id="clearCartBtn">Clear Cart</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Checkout Modal --}}
<div class="modal fade" id="checkoutModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Checkout</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Payment Method</label>
                    <select class="form-control" id="paymentMethod">
                        <option value="cash">Cash</option>
                        <option value="card">Card</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Amount Received</label>
                    <input type="number" class="form-control" id="amountReceived">
                </div>
                <div class="form-group">
                    <label>Change Due</label>
                    <input type="text" class="form-control" id="changeDue" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="completeCheckoutBtn">Complete Sale</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('after_scripts')
<script>
let cart = [];

// Product Search
$('#productSearch').on('keyup', function() {
    const searchTerm = $(this).val();
    if (searchTerm.length >= 2) {
        $.get('{{ backpack_url("search-products") }}', { term: searchTerm })
            .done(function(products) {
                displaySearchResults(products);
            });
    }
});

// Display search results
function displaySearchResults(products) {
    const results = $('#searchResults');
    results.empty();
    products.forEach(product => {
        results.append(`
            <div class="list-group-item" style="cursor: pointer" onclick="addToCart(${JSON.stringify(product)})">
                <div class="d-flex justify-content-between">
                    <h6>${product.name}</h6>
                    <span>$${product.selling_price}</span>
                </div>
                <small>Stock: ${product.stock_quantity}</small>
            </div>
        `);
    });
}

// Cart Management
function addToCart(product) {
    const existingItem = cart.find(item => item.product_id === product.id);
    if (existingItem) {
        existingItem.quantity++;
    } else {
        cart.push({
            product_id: product.id,
            name: product.name,
            price: product.selling_price,
            quantity: 1
        });
    }
    updateCartDisplay();
}

function updateCartDisplay() {
    const tbody = $('#cartItems');
    tbody.empty();
    let total = 0;
    
    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        tbody.append(`
            <tr>
                <td>${item.name}</td>
                <td>
                    <input type="number" value="${item.quantity}" min="1" 
                           onchange="updateQuantity(${index}, this.value)">
                </td>
                <td>$${item.price}</td>
                <td>$${itemTotal}</td>
                <td><button class="btn btn-sm btn-danger" onclick="removeItem(${index})">×</button></td>
            </tr>
        `);
    });
    
    $('#grandTotal').text('$' + total);
}

// Checkout Process
$('#checkoutBtn').click(function() {
    if (cart.length === 0) {
        alert('Cart is empty!');
        return;
    }
    $('#checkoutModal').modal('show');
});

$('#completeCheckoutBtn').click(function() {
    $.post('{{ backpack_url("submit-sale") }}', {
        _token: '{{ csrf_token() }}',
        cart_items: cart,
        payment_method: $('#paymentMethod').val()
    })
    .done(function(response) {
        if (response.success) {
            alert('Sale completed successfully!');
            cart = [];
            updateCartDisplay();
            $('#checkoutModal').modal('hide');
        }
    })
    .fail(function(response) {
        alert('Error: ' + response.responseJSON.message);
    });
});
</script>
@endpush