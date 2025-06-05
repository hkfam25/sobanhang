@extends(backpack_view('blank'))

@section('title', 'Chi Tiết Phiếu Nhập Hàng: ' . $purchaseOrder->po_number)

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Chi Tiết Phiếu Nhập: {{ $purchaseOrder->po_number }}</h1>
        <div>
            <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">Quay Lại Danh Sách</a>
            {{-- Thêm nút In Phiếu nếu cần --}}
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
     @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Thông Tin Chung</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Mã Phiếu Nhập:</strong> {{ $purchaseOrder->po_number }}</p>
                    <p><strong>Nhà Cung Cấp:</strong> {{ $purchaseOrder->supplier->name ?? 'N/A' }}</p>
                    <p><strong>Người Tạo:</strong> {{ $purchaseOrder->user->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Ngày Đặt Hàng:</strong> {{ $purchaseOrder->order_date->format('d/m/Y') }}</p>
                    <p><strong>Ngày Dự Kiến Nhận:</strong> {{ $purchaseOrder->expected_delivery_date ? $purchaseOrder->expected_delivery_date->format('d/m/Y') : 'N/A' }}</p>
                    <p><strong>Trạng Thái:</strong>
                        <span class="badge bg-{{ $purchaseOrder->status == 'received' ? 'success' : ($purchaseOrder->status == 'pending' || $purchaseOrder->status == 'ordered' ? 'warning' : ($purchaseOrder->status == 'cancelled' ? 'danger' : 'info')) }}">
                            {{ ucfirst(str_replace('_', ' ', $purchaseOrder->status)) }}
                        </span>
                    </p>
                </div>
            </div>
            @if($purchaseOrder->notes)
            <p><strong>Ghi Chú:</strong> {{ $purchaseOrder->notes }}</p>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">Chi Tiết Sản Phẩm Đặt Hàng</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sản Phẩm</th>
                        <th>Mã SP/Barcode</th>
                        <th class="text-end">Số Lượng Đặt</th>
                        <th class="text-end">Giá Nhập</th>
                        <th class="text-end">Thành Tiền (dự kiến)</th>
                        <th class="text-end">Số Lượng Đã Nhận</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseOrder->items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name ?? 'Sản phẩm không còn tồn tại' }}</td>
                            <td>{{ $item->product->sku ?? ($item->product->barcode ?? 'N/A') }}</td>
                            <td class="text-end">{{ $item->quantity_ordered }}</td>
                            <td class="text-end">{{ number_format($item->cost_price_at_order, 0, ',', '.') }} VND</td>
                            <td class="text-end">{{ number_format($item->quantity_ordered * $item->cost_price_at_order, 0, ',', '.') }} VND</td>
                            <td class="text-end">{{ $item->quantity_received }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Tổng Cộng Dự Kiến:</td>
                        <td class="text-end fw-bold">{{ number_format($purchaseOrder->total_amount, 0, ',', '.') }} VND</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Form Nhận Hàng (Ví dụ đơn giản) --}}
    @if($purchaseOrder->status == 'ordered' || $purchaseOrder->status == 'partial_received')
    <div class="card mt-4">
        <div class="card-header">Xác Nhận Nhận Hàng</div>
        <div class="card-body">
            <form action="{{ route('purchase-orders.receive', $purchaseOrder) }}" method="POST">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sản Phẩm</th>
                            <th class="text-end">SL Đặt</th>
                            <th class="text-end">Đã Nhận</th>
                            <th class="text-end" style="width: 150px;">SL Nhận Lần Này</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrder->items as $item)
                            @if ($item->quantity_ordered > $item->quantity_received)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td class="text-end">{{ $item->quantity_ordered }}</td>
                                <td class="text-end">{{ $item->quantity_received }}</td>
                                <td>
                                    <input type="number" name="items[{{ $item->id }}][quantity_received]" class="form-control form-control-sm text-end" value="0" min="0" max="{{ $item->quantity_ordered - $item->quantity_received }}">
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success">Xác Nhận Đã Nhận Hàng</button>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection

@push('after_scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap Bundle JS (bao gồm Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 (nếu bạn dùng cho thông báo) -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Có thể thêm JS nếu cần cho trang show, ví dụ xác nhận trước khi submit form nhận hàng
</script>
@endpush