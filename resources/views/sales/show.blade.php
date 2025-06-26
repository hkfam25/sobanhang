@extends(backpack_view('blank'))

@section('content')
    <div class="container mt-4">
        <h2>Chi tiết hóa đơn #{{ $sale->id }}</h2>
        <p><strong>Thời gian bán hàng:</strong> {{ $sale->created_at }}</p>
        <p><strong>Tổng tiền:</strong> {{ number_format($sale->total_amount, 0, ',', '.') }} VNĐ</p>
        <p><strong>Nhân viên:</strong> {{ $sale->user->name ?? 'Chưa xác định' }}</p>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->getTotalAttribute(), 0, ',', '.') }} VNĐ</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <a href="{{ backpack_url('sales') }}" class="btn btn-primary">Quay lại</a>
    </div>
@endsection
