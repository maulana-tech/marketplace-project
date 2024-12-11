<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    //
    public function checkout(Product $product){
        return view('front.checkout', [
            'product' => $product
        ]);
    }

    public function store (Request $request, Product $product){
        //validasi agar pembeli tidak membeli produknya sendiri
        if($product->creator_id === Auth()->user()->id){
            $error = ValidationException::withMessages([
                'system_error' => ['You cannot buy your own product'] 
            ]);
            throw $error;
        }

        $validated = $request->validate([
           'proof' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
        ]);

        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('payment_proofs', 'public');
            $validated['proof'] = $proofPath;
        }

        $data = [
            'total_price' => $product->price,
            'is_paid' => false,
            'buyer_id' => Auth::id(), 
            'creator_id' => $product->creator_id,
            'product_id' => $product->id,
            'proof' => $validated['proof'],
        ];

        DB::beginTransaction();
        try {
            $newOrder = ProductOrder::firstOrCreate($data);

            DB::commit();

            return redirect()->route('admin.product_orders.transactions')->with('success', 'Successfully checkout !');
        }
        catch (\Exception $e) {
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error!' . $e->getMessage()],
            ]);
            throw $error;
        }
    }
}
