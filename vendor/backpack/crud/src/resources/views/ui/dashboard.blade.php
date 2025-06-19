@extends(backpack_view('blank'))

{{-- @php
    if (backpack_theme_config('show_getting_started')) {
        $widgets['before_content'][] = [
            'type'        => 'view',
            'view'        => backpack_view('inc.getting_started'),
        ];
    } else {
        $widgets['before_content'][] = [
            'type'        => 'jumbotron',
            'heading'     => trans('Dashboard'),
            'heading_class' => 'display-3 '.(backpack_theme_config('layout') === 'horizontal_overlap' ? ' text-white' : ''),
            // 'content'     => trans('backpack::base.use_sidebar'),
            // 'content_class' => backpack_theme_config('layout') === 'horizontal_overlap' ? 'text-white' : '',
            // 'button_link' => backpack_url('logout'),
            // 'button_text' => trans('backpack::base.logout'),
        ];
    }
    
@endphp --}}
@php
    $totalCost = App\Models\Product::sum(\DB::raw('purchase_price * stock_quantity'));
    $totalRevenue = App\Models\Sale::sum(\DB::raw('total_amount'));

    $productCount = App\Models\Product::count();
    $userCount = App\Models\User::count();
    $purchaseOrderCount = App\Models\PurchaseOrder::count();

    $instockCount = App\Models\Product::count();

    $outOfStockCount = App\Models\Product::where('stock_quantity', 0)->count();
    // To keep cards in a row, add a `div` widget first:
    Widget::add()->type('div')->content([

        // Now, start creating widgets inside it
        Widget::make([
            'type' => 'progress_white',
            'ribbon' => ['top', 'la-tags'],
            'value' => $productCount,
            'description' => 'Số lượng sản phẩm',
            'progress' => ((int) $productCount / 200) * 100,
            'progressClass' => 'progress-bar bg-primary',

            'wrapperClass' => 'col-lg-3',
        ]),
        Widget::make([
            'type' => 'progress_white',
            'ribbon' => ['top', 'la-tags '],
            'value' => $userCount,
            'description' => 'Số lượng nhân viên',
            'progress' => ((int) $userCount / 200) * 100,
            'progressClass' => 'progress-bar bg-warning',
            'wrapperClass' => 'col-lg-3',
        ]),
        Widget::make([
            'type' => 'progress',
            'ribbon' => ['top', 'la-tags'],
            'value' => $purchaseOrderCount,
            'description' => 'Số lượng phiếu nhập',
            'progress' => ((int) $purchaseOrderCount / 100) * 100,
            'wrapperClass' => 'col-lg-3',
        ]),
        Widget::make([
            'type' => 'progress_white',
            'ribbon' => ['top', 'la-dollar-sign'],
            'value' => number_format($totalCost, 0, ',', '.') . ' VNĐ',
            'description' => 'Tổng chi (ước tính)',
            'progress' => min(100, $totalCost / 10000000 * 100), // Giới hạn max 100%
            'progressClass' => 'progress-bar bg-success',
            'wrapperClass' => 'col-lg-3',
        ]),
        Widget::make([
            'type' => 'progress_white',
            'ribbon' => ['top', 'la-dollar-sign'],
            'value' => number_format($totalRevenue, 0, ',', '.') . ' VNĐ',
            'description' => 'Tổng thu (ước tính)',
            'progress' => min(100, $totalRevenue / 10000000 * 100), // Giới hạn max 100%
            'progressClass' => 'progress-bar bg-success',
            'wrapperClass' => 'col-lg-3',
        ]),




        Widget::make([
            'type' => 'progress_white',
            'ribbon' => ['top', 'la-boxes'],
            'value' => $outOfStockCount,
            'description' => 'Số lượng sản phẩm hết hàng',
            'progress' => ((int) $instockCount / 200) * 100,
            'progressClass' => 'progress-bar bg-info',
            'wrapperClass' => 'col-lg-3',
        ]),
        
    ])->to('before_content'); 

@endphp

@section('content')
    <div class="container-fluid">

        @if($lowStockProducts->isNotEmpty())
            <div class="alert alert-heading alert-warning" role="alert">
                <h2>Sản phẩm sắp hết hàng!</h2>
                <h3 >Các sản phẩm dưới đây có số lượng tồn kho bằng mức tồn kho tối thiểu. Vui lòng nhập thêm hàng để tránh hết hàng.</h3>
                <hr>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Mã sản phẩm (SKU)</th>
                            <th>Số lượng tồn kho</th>
                            <th>Mức tồn kho tối thiểu</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockProducts as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>{{ $product->min_stock_level }}</td>
                                <td>
                                    <a href="{{ route('purchase-orders.create') }}?product_id={{ $product->id }}" class="btn btn-sm btn-primary">
                                        Nhập hàng
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-success" role="alert">
                Tất cả sản phẩm đều có số lượng tồn kho tiêu chuẩn.
            </div>
        @endif
    </div>
@endsection