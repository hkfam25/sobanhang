<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'min_stock_level')->get();

        return view(('vendor/backpack/ui/dashboard'), [
            'lowStockProducts' => $lowStockProducts,
        ]);
    }
}