<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($orders->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-gray-500 text-lg">
                                <p>You haven't made any orders yet.</p>
                                <a href="{{ route('front.index') }}" class="text-blue-500 hover:underline mt-2 inline-block">
                                    Start Shopping
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="grid gap-6">
                            @foreach($orders as $order)
                                <div class="border rounded-lg p-6 shadow-sm">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold">Order #{{ $order->id }}</h3>
                                            <p class="text-gray-600">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                                @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($order->status === 'success') bg-green-100 text-green-800
                                                @else bg-red-100 text-red-800
                                                @endif">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <img src="{{ Storage::url($order->product->cover) }}" 
                                                 alt="{{ $order->product->name }}" 
                                                 class="w-20 h-20 object-cover rounded-lg">
                                        </div>
                                        <div class="flex-grow">
                                            <h4 class="font-medium text-lg">{{ $order->product->name }}</h4>
                                            <p class="text-gray-600">Seller: {{ $order->product->creator->name }}</p>
                                            <div class="flex space-x-4 text-sm text-gray-500 mt-1">
                                                <span>Size: {{ $order->product->size }}</span>
                                                <span>Color: {{ $order->product->color }}</span>
                                                <span>Qty: {{ $order->quantity }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-semibold">
                                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex justify-between items-center">
                                        <div class="flex space-x-3">
                                            @if($order->status === 'pending')
                                                <form action="{{ route('buyer.orders.cancel', $order) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 text-sm"
                                                            onclick="return confirm('Are you sure you want to cancel this order?')">
                                                        Cancel Order
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($order->status === 'success')
                                                @php
                                                    $hasTestimonial = $order->testimonials()->where('buyer_id', auth()->id())->exists();
                                                @endphp
                                                
                                                @if(!$hasTestimonial)
                                                    <a href="{{ route('buyer.testimonials.create', ['seller_id' => $order->product->creator->id, 'order_id' => $order->id]) }}"
                                                       class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">
                                                        Write Review
                                                    </a>
                                                @else
                                                    <span class="px-4 py-2 bg-gray-300 text-gray-600 rounded text-sm">
                                                        Review Submitted
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                        
                                        <a href="{{ route('front.details', $order->product->slug) }}" 
                                           class="text-blue-500 hover:underline text-sm">
                                            View Product
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $orders->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
