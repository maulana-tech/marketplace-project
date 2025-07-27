<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Customer Reviews') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($testimonials->isEmpty())
                        <div class="text-center py-12">
                            <div class="text-gray-500 text-lg">
                                <p>You haven't received any reviews yet.</p>
                                <p class="text-sm mt-2">Reviews will appear here after customers complete their orders and leave feedback.</p>
                            </div>
                        </div>
                    @else
                        <!-- Summary Stats -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                            <div class="bg-blue-50 rounded-lg p-4">
                                <div class="text-2xl font-bold text-blue-600">{{ $testimonials->count() }}</div>
                                <div class="text-sm text-gray-600">Total Reviews</div>
                            </div>
                            <div class="bg-yellow-50 rounded-lg p-4">
                                <div class="text-2xl font-bold text-yellow-600">
                                    {{ number_format($testimonials->avg('rating'), 1) }}
                                </div>
                                <div class="text-sm text-gray-600">Average Rating</div>
                            </div>
                            <div class="bg-green-50 rounded-lg p-4">
                                <div class="text-2xl font-bold text-green-600">
                                    {{ $testimonials->where('rating', '>=', 4)->count() }}
                                </div>
                                <div class="text-sm text-gray-600">4+ Star Reviews</div>
                            </div>
                            <div class="bg-purple-50 rounded-lg p-4">
                                <div class="text-2xl font-bold text-purple-600">
                                    {{ $testimonials->where('created_at', '>=', now()->subMonth())->count() }}
                                </div>
                                <div class="text-sm text-gray-600">This Month</div>
                            </div>
                        </div>

                        <!-- Reviews List -->
                        <div class="space-y-6">
                            @foreach($testimonials as $testimonial)
                                <div class="border rounded-lg p-6 shadow-sm">
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center space-x-4">
                                            <div>
                                                <h3 class="text-lg font-semibold">{{ $testimonial->buyer->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ $testimonial->created_at->format('d M Y, H:i') }}</p>
                                            </div>
                                        </div>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $testimonial->rating)
                                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.392 2.46a1 1 0 00-.364 1.118l1.286 3.97c.3.921-.755 1.688-1.54 1.118l-3.392-2.46a1 1 0 00-1.176 0l-3.392 2.46c-.784.57-1.838-.197-1.539-1.118l1.286-3.97a1 1 0 00-.364-1.118L2.049 9.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                                                    </svg>
                                                @else
                                                    <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.392 2.46a1 1 0 00-.364 1.118l1.286 3.97c.3.921-.755 1.688-1.54 1.118l-3.392-2.46a1 1 0 00-1.176 0l-3.392 2.46c-.784.57-1.838-.197-1.539-1.118l1.286-3.97a1 1 0 00-.364-1.118L2.049 9.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                            <span class="ml-2 text-sm text-gray-600">({{ $testimonial->rating }}/5)</span>
                                        </div>
                                    </div>

                                    <div class="flex items-start space-x-4">
                                        <div class="flex-shrink-0">
                                            <img src="{{ Storage::url($testimonial->productOrder->product->cover) }}" 
                                                 alt="{{ $testimonial->productOrder->product->name }}" 
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        </div>
                                        <div class="flex-grow">
                                            <h4 class="font-medium text-base mb-2">{{ $testimonial->productOrder->product->name }}</h4>
                                            <div class="bg-gray-50 rounded-lg p-4 mb-3">
                                                <p class="text-gray-700">{{ $testimonial->comment }}</p>
                                            </div>
                                            <div class="flex space-x-4 text-sm text-gray-500">
                                                <span>Order #{{ $testimonial->productOrder->id }}</span>
                                                <span>Size: {{ $testimonial->productOrder->product->size }}</span>
                                                <span>Color: {{ $testimonial->productOrder->product->color }}</span>
                                                <span>Qty: {{ $testimonial->productOrder->quantity }}</span>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-sm font-medium text-gray-900">
                                                Rp {{ number_format($testimonial->productOrder->total_amount, 0, ',', '.') }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="mt-4 text-right">
                                        <a href="{{ route('front.details', $testimonial->productOrder->product->slug) }}" 
                                           class="text-blue-500 hover:underline text-sm">
                                            View Product
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $testimonials->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
