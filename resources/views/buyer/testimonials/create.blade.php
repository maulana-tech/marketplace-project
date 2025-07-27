<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Write Review') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Order Information -->
                    <div class="mb-8 bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold mb-4">Order Information</h3>
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
                                    <span>Order #{{ $order->id }}</span>
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
                    </div>

                    <!-- Review Form -->
                    <form method="POST" action="{{ route('buyer.testimonials.store') }}">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">

                        <div class="mb-6">
                            <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">
                                Rating *
                            </label>
                            <div class="flex items-center space-x-1" id="rating-container">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" 
                                            class="rating-star w-8 h-8 text-gray-300 hover:text-yellow-400 focus:outline-none"
                                            data-rating="{{ $i }}">
                                        <svg fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.97a1 1 0 00.95.69h4.18c.969 0 1.371 1.24.588 1.81l-3.392 2.46a1 1 0 00-.364 1.118l1.286 3.97c.3.921-.755 1.688-1.54 1.118l-3.392-2.46a1 1 0 00-1.176 0l-3.392 2.46c-.784.57-1.838-.197-1.539-1.118l1.286-3.97a1 1 0 00-.364-1.118L2.049 9.397c-.783-.57-.38-1.81.588-1.81h4.18a1 1 0 00.95-.69l1.286-3.97z"/>
                                        </svg>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                            @error('rating')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">
                                Your Review *
                            </label>
                            <textarea name="comment" 
                                      id="comment" 
                                      rows="5" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Share your experience with this product and seller..."
                                      required>{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-between items-center">
                            <a href="{{ route('buyer.orders.index') }}" 
                               class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                                Submit Review
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.rating-star');
            const ratingInput = document.getElementById('rating-input');
            let currentRating = parseInt(ratingInput.value) || 0;

            // Initialize stars based on old value
            updateStars(currentRating);

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    currentRating = parseInt(this.dataset.rating);
                    ratingInput.value = currentRating;
                    updateStars(currentRating);
                });

                star.addEventListener('mouseenter', function() {
                    const hoverRating = parseInt(this.dataset.rating);
                    updateStars(hoverRating);
                });
            });

            document.getElementById('rating-container').addEventListener('mouseleave', function() {
                updateStars(currentRating);
            });

            function updateStars(rating) {
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.classList.remove('text-gray-300');
                        star.classList.add('text-yellow-400');
                    } else {
                        star.classList.remove('text-yellow-400');
                        star.classList.add('text-gray-300');
                    }
                });
            }
        });
    </script>
</x-app-layout>
