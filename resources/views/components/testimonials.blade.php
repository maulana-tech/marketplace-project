@php
    $testimonials = $testimonials ?? collect();
@endphp

<section id="Testimonial" class="mb-[102px] flex flex-col gap-8">
    <div class="container max-w-[1130px] mx-auto flex justify-between items-center">
        <h2 class="font-semibold text-[32px]">Customers Are Happy <br>With Our Products</h2>
        <div class="flex gap-[14px] items-center">
            <button class="btn-prev w-10 h-10 shrink-0 rounded-full overflow-hidden rotate-180">
                <img src="{{asset('/images/icons/circle-arrow-r.svg')}}" alt="icon">
            </button>
            <button class="btn-next w-10 h-10 shrink-0 rounded-full overflow-hidden">
                <img src="{{asset('/images/icons/circle-arrow-r.svg')}}" alt="icon">
            </button>
        </div>
    </div>
    <div class="w-full overflow-hidden">
        <div class="testi-carousel flex" style="width: max-content;">
            @php
                $testimonialItems = $testimonials->count() > 0 ? $testimonials : collect([
                    (object)['rating' => 5, 'comment' => 'Great quality shoes! Very comfortable and stylish. I love shopping here!', 'buyer' => (object)['name' => 'Sarah Lopez'], 'photo' => 'photo1.png'],
                    (object)['rating' => 5, 'comment' => 'Amazing service and fast delivery. The shoes fit perfectly!', 'buyer' => (object)['name' => 'Michael Chen'], 'photo' => 'photo2.png'],
                    (object)['rating' => 5, 'comment' => 'Excellent products and customer service. Highly recommended!', 'buyer' => (object)['name' => 'Emily Robinson'], 'photo' => 'photo1.png'],
                    (object)['rating' => 4, 'comment' => 'Love the variety of brands available. Great customer support too!', 'buyer' => (object)['name' => 'David Wilson'], 'photo' => 'photo2.png'],
                    (object)['rating' => 5, 'comment' => 'Best shoe store online! Fast shipping and authentic products.', 'buyer' => (object)['name' => 'Jessica Brown'], 'photo' => 'photo1.png']
                ]);
            @endphp
            
            <!-- First set of testimonials -->
            @foreach($testimonialItems as $testimonial)
                <div class="testimonial-card bg-[#181818] rounded-[20px] flex mr-5 w-[420px] min-h-[256px] shrink-0 overflow-hidden">
                    <div class="p-6 flex flex-col w-full gap-[42px] shrink-0 bg-[url('{{asset('/images/backgrounds/Testimonials-image.png')}}')] bg-contain bg-no-repeat bg-top">
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-[6px]">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <img src="{{asset('/images/icons/star.svg')}}" alt="star">
                                    @else
                                        <img src="{{asset('/images/icons/star.svg')}}" alt="star" class="opacity-30">
                                    @endif
                                @endfor
                            </div>
                            <p class="leading-[26px]">{{ $testimonial->comment }}</p>
                        </div>
                        <div class="flex gap-[14px] items-center">
                            <div class="w-12 h-12 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('/images/photos/' . ($testimonial->photo ?? 'photo1.png'))}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <div class="flex flex-col justify-center-center">
                                <p class="font-semibold text-left leading-[170%] bg-clip-text text-transparent bg-gradient-to-r from-[#B05CB0] to-[#FCB16B]">
                                    {{ $testimonial->buyer->name }}
                                </p>
                                <p class="font-semibold text-left text-xs text-belibang-grey">
                                    Verified Buyer
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Duplicate set for infinite effect -->
            @foreach($testimonialItems as $testimonial)
                <div class="testimonial-card bg-[#181818] rounded-[20px] flex mr-5 w-[420px] min-h-[256px] shrink-0 overflow-hidden">
                    <div class="p-6 flex flex-col w-full gap-[42px] shrink-0 bg-[url('{{asset('/images/backgrounds/Testimonials-image.png')}}')] bg-contain bg-no-repeat bg-top">
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-[6px]">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $testimonial->rating)
                                        <img src="{{asset('/images/icons/star.svg')}}" alt="star">
                                    @else
                                        <img src="{{asset('/images/icons/star.svg')}}" alt="star" class="opacity-30">
                                    @endif
                                @endfor
                            </div>
                            <p class="leading-[26px]">{{ $testimonial->comment }}</p>
                        </div>
                        <div class="flex gap-[14px] items-center">
                            <div class="w-12 h-12 flex shrink-0 rounded-full overflow-hidden">
                                <img src="{{asset('/images/photos/' . ($testimonial->photo ?? 'photo1.png'))}}" class="w-full h-full object-cover" alt="photo">
                            </div>
                            <div class="flex flex-col justify-center-center">
                                <p class="font-semibold text-left leading-[170%] bg-clip-text text-transparent bg-gradient-to-r from-[#B05CB0] to-[#FCB16B]">
                                    {{ $testimonial->buyer->name }}
                                </p>
                                <p class="font-semibold text-left text-xs text-belibang-grey">
                                    Verified Buyer
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
