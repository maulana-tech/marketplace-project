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
            'buyer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'quantity' => 'required|integer|min:1|max:' . $product->quantity,
            'proof' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'], 
        ]);

        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('payment_proofs', 'public');
            $validated['proof'] = $proofPath;
        }

        $totalAmount = $product->price * $validated['quantity'];

        $data = [
            'creator_id' => $product->creator_id,
            'buyer_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'total_price' => $totalAmount,
            'buyer_name' => $validated['buyer_name'],
            'buyer_phone' => $validated['phone'],
            'buyer_address' => $validated['address'],
            'status' => 'pending',
            'is_paid' => false,
            'proof' => $validated['proof'],
        ];

        DB::beginTransaction();
        try {
            $newOrder = ProductOrder::create($data);
            
            // Update product quantity
            $product->decrement('quantity', $validated['quantity']);

            DB::commit();

            return redirect()->route('buyer.orders.index')->with('success', 'Order placed successfully! Please wait for seller confirmation.');
        }
        catch (\Exception $e) {
            DB::rollBack();

            $error = ValidationException::withMessages([
                'system_error' => ['System error! ' . $e->getMessage()],
            ]);
            throw $error;
        }
    }
}
