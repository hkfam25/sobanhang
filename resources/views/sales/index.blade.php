@extends(backpack_view('blank'))

@section('content')
    <div class="container mt-4">
        <h2>Lịch sử bán hàng</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Mã hóa đơn</th>
                            <th>Tổng tiền</th>
                            <th>Thời gian bán hàng</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                            <tr>
                                <td>{{ $sale->id }}</td>
                                <td>{{ number_format($sale->total_amount, 0, ',', '.') }} VNĐ</td>
                                <td>{{ $sale->created_at }}</td>
                                <td>
                                    <a href="{{ backpack_url('sales/' . $sale->id) }}" class="btn btn-sm btn-info">Chi tiết hóa đơn</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $sales->links() }}
    </div>
@endsection