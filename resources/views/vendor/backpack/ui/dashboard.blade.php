@extends(backpack_view('blank'))

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