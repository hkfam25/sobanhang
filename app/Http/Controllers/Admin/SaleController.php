<?php

namespace App\Http\Controllers\Admin;

use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SaleController
{
    public function index()
    {
        $sales = Sale::with('user')->latest()->paginate(15);
        return view('sales.index', compact('sales'));
    }

    public function show($id)
    {
        $sale = Sale::with(['items.product', 'user'])->findOrFail($id);
        return view('sales.show', compact('sale'));
    }
}