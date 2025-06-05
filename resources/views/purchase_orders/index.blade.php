@extends(backpack_view('blank'))

@section('title', 'Danh Sách Phiếu Nhập Hàng')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Danh Sách Phiếu Nhập Hàng</h1>
        <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">Tạo Phiếu Nhập Mới</a>
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

    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Mã Phiếu</th>
                        <th>Nhà Cung Cấp</th>
                        <th>Ngày Đặt</th>
                        <th>Ngày Dự Kiến Nhận</th>
                        <th>Tổng Tiền (dự kiến)</th>
                        <th>Trạng Thái</th>
                        <th>Người Tạo</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($purchaseOrders as $po)
                        <tr>
                            <td>{{ $po->po_number }}</td>
                            <td>{{ $po->supplier->name ?? 'N/A' }}</td>
                            <td>{{ $po->order_date->format('d/m/Y') }}</td>
                            <td>{{ $po->expected_delivery_date ? $po->expected_delivery_date->format('d/m/Y') : 'N/A' }}</td>
                            <td class="text-end">{{ number_format($po->total_amount, 0, ',', '.') }} VND</td>
                            <td>
                                <span class="badge bg-{{ $po->status == 'received' ? 'success' : ($po->status == 'pending' || $po->status == 'ordered' ? 'warning' : ($po->status == 'cancelled' ? 'danger' : 'info')) }}">
                                    {{ ucfirst(str_replace('_', ' ', $po->status)) }}
                                </span>
                            </td>
                            <td>{{ $po->user->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-info btn-sm">Xem</a>
                                {{-- Thêm nút sửa, xóa nếu bạn đã làm chức năng đó --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Không có phiếu nhập hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $purchaseOrders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection