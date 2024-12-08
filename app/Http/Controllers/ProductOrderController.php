<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $my_orders = ProductOrder::where('creator_id', Auth::id())->get();
        return view('admin.product_orders.index', [
            'my_orders' => $my_orders
        ]);
    }

    public function transactions()
    {
        //
        $my_transactions = ProductOrder::where('buyer_id', Auth::id())->get();
        return view('admin.product_orders.transactions', [
            'my_transactions' => $my_transactions
        ]);
    }

    public function transactions_details(ProductOrder $productOrder)
    {
        return view('admin.product_orders.transaction_details', [
            'order' => $productOrder
        ]);
    }

    public function download_file(ProductOrder $productOrder)
    {
        $user_id = Auth::id();
        $product_id = $productOrder->product_id;

        $paidTransactionExist = ProductOrder::where('buyer_id', $user_id)
        ->where('product_id', $product_id)
        ->where('is_paid', 1)
        ->first();

        if(!$paidTransactionExist) {
            session()->flash('error', 'You must pay for this download first');
            return redirect()->back();
        }

        $productDetails = Product::find($product_id);

        $filePath = $productDetails->path_file;

        if(!Storage::disk('public')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('public')->download($filePath);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductOrder $productOrder)
    {
        //
        return view('admin.product_orders.details', [
            'order' => $productOrder
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductOrder $productOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductOrder $productOrder)
    {
        //
        $productOrder->update(['is_paid' => true]);
        return redirect()->back()->with('message', 'Order has been marked as paid');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductOrder $productOrder)
    {
        //
    }
}
