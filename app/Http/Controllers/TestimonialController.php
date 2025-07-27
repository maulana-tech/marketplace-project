<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\ProductOrder;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource for sellers.
     */
    public function index()
    {
        $testimonials = Testimonial::where('seller_id', Auth::id())
                            ->with(['buyer', 'productOrder.product'])
                            ->paginate(10);

        return view('admin.testimonials.index', [
            'testimonials' => $testimonials
        ]);
    }
    
    /**
     * Display a listing of testimonials for buyers.
     */
    public function buyerIndex()
    {
        $testimonials = Testimonial::where('buyer_id', Auth::id())
                            ->with(['seller', 'productOrder.product'])
                            ->orderBy('created_at', 'desc')
                            ->paginate(10);

        return view('buyer.testimonials.index', [
            'testimonials' => $testimonials
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = ProductOrder::with('product.creator')->findOrFail($orderId);
        
        // Check if order belongs to authenticated buyer
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if order is completed
        if ($order->status !== 'success') {
            return redirect()->back()->with('error', 'You can only review completed orders.');
        }
        
        // Check if testimonial already exists
        $existingTestimonial = Testimonial::where('product_order_id', $order->id)
                                         ->where('buyer_id', Auth::id())
                                         ->exists();
        
        if ($existingTestimonial) {
            return redirect()->back()->with('error', 'You have already reviewed this order.');
        }

        return view('buyer.testimonials.create', [
            'order' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:product_orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:65535'
        ]);
        
        $order = ProductOrder::findOrFail($request->order_id);
        
        // Check if order belongs to authenticated buyer
        if ($order->buyer_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        
        // Check if testimonial already exists
        $existingTestimonial = Testimonial::where('product_order_id', $order->id)
                                         ->where('buyer_id', Auth::id())
                                         ->exists();
        
        if ($existingTestimonial) {
            return redirect()->back()->with('error', 'You have already reviewed this order.');
        }

        Testimonial::create([
            'product_order_id' => $order->id,
            'buyer_id' => Auth::id(),
            'seller_id' => $order->product->creator_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('buyer.orders.stories')
                         ->with('success', 'Thank you for your review!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Testimonial $testimonial)
    {
        return view('testimonials.show', [
            'testimonial' => $testimonial
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('testimonials.edit', [
            'testimonial' => $testimonial
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:65535'
        ]);

        $testimonial->update($request->only(['rating', 'comment']));

        return redirect()->route('testimonials.index')
                         ->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('testimonials.index')
                         ->with('success', 'Testimonial deleted successfully!');
    }
}
