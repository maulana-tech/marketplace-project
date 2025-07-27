@extends('front.layouts.app')
@section('title', 'SIA Marketplace')
@section('content')

<x-navbar/>

<header
    class="w-full pt-[74px] pb-[34px] bg-[url('{{asset('images/backgrounds/hero-image.png')}}')] bg-cover bg-no-repeat bg-center relative z-0">
    <div class="container max-w-[1130px] mx-auto flex flex-col items-center justify-center gap-[34px] z-10">
        <div class="flex flex-col gap-2 text-center w-fit mt-20 z-10">
            <h1 class="font-semibold text-[60px] leading-[130%]">Discover Premium<br>Footwear Collection</h1>
            <p class="text-lg text-belibang-grey">Step up your style with authentic branded shoes.</p>
        </div>
        <div class="flex w-full justify-center mb-[34px] z-10">
            <form action="{{route('front.search')}}" method="GET"
                class="group/search-bar p-[14px_18px] bg-belibang-darker-grey ring-1 ring-[#414141] hover:ring-[#888888] max-w-[560px] w-full rounded-full transition-all duration-300">
                <div class="relative text-left">
                    <button class="absolute inset-y-0 left-0 flex items-center">
                        <img src="{{asset('images/icons/search-normal.svg')}}" alt="icon">
                    </button>
                    <input name="keyword" type="text" id="searchInput"
                        class="bg-belibang-darker-grey w-full pl-[36px] focus:outline-none placeholder:text-[#595959] pr-9"
                        placeholder="Search for shoes, brands, or styles..." />
                    <input name="keyword" type="reset" id="resetButton"
                        class="close-button hidden w-[38px] h-[38px] flex shrink-0 bg-[url('{{asset('images/icons/close.svg')}}')] hover:bg-[url('{{asset('images/icons/close-white.svg')}}')] transition-all duration-300 appearance-none transform -translate-x-1/2 -translate-y-1/2 absolute top-1/2 -right-5"
                        value="">
                </div>
            </form>
        </div>
    </div>
    <div class="w-full h-full absolute top-0 bg-gradient-to-b from-belibang-black/70 to-belibang-black z-0"></div>
</header>

<section id="Category" class="container max-w-[1130px] mx-auto mb-[102px] flex flex-col gap-8">
    <h2 class="font-semibold text-[32px]">Category</h2>
    <div class="flex justify-between items-center">
        <a href="{{route('front.index')}}"
            class="group category-card w-fit h-fit p-[1px] rounded-2xl bg-img-transparent hover:bg-img-purple-to-orange transition-all duration-300">
            <div
                class="flex flex-col p-[18px] rounded-2xl w-[210px] bg-img-black-gradient group-active:bg-img-black transition-all duration-300">
                <div class="w-[58px] h-[58px] flex shrink-0 items-center justify-center">
                    <img src="{{asset('images/icons/cart.svg')}}" alt="icon">
                </div>
                <div class="px-[6px] flex flex-col text-left">
                    <p class="font-bold text-sm">All Products</p>
                    <p class="text-xs text-belibang-grey">All Shoe Brands</p>
                </div>
            </div>
        </a>

        @forelse($categories as $category)
        <a href="{{route('front.category', $category)}}"
            class="group category-card w-fit h-fit p-[1px] rounded-2xl bg-img-transparent hover:bg-img-purple-to-orange transition-all duration-300">
            <div
                class="flex flex-col p-[18px] rounded-2xl w-[210px] bg-img-black-gradient group-active:bg-img-black transition-all duration-300">
                <div class="w-[58px] h-[58px] flex shrink-0 items-center justify-center">
                    <img src="{{{asset($category->icon)}}}" alt="icon">
                </div>
                <div class="px-[6px] flex flex-col text-left">
                    <p class="font-bold text-sm">{{$category->name}}</p>
                    <p class="text-xs text-belibang-grey">Quality Footwear</p>
                </div>
            </div>
        </a>
        @empty
        @endforelse

    </div>
</section>

<section id="NewProduct" class="container max-w-[1130px] mx-auto mb-[102px] flex flex-col gap-8">
    <h2 class="font-semibold text-[32px]">New Product</h2>
    <div class="grid grid-cols-4 gap-[22px]">

        @forelse($products as $product)
            <div class="product-card flex flex-col rounded-[18px] bg-[#181818] overflow-hidden">
                <a href="{{route('front.details', $product->slug)}}" class="thumbnail w-full h-[180px] flex shrink-0 overflow-hidden relative">
                    <img src="{{Storage::url($product->cover)}}" class="w-full h-full object-cover" alt="thumbnail">
                    <p class="backdrop-blur bg-black/30 rounded-[4px] p-[4px_8px] absolute top-3 right-[14px] z-10">Rp
                        {{number_format($product->price)}}</p>
                </a>
                <div class="p-[10px_14px_12px] h-full flex flex-col justify-between gap-[14px]">
                    <div class="flex flex-col gap-1">
                        <a href="{{route('front.details', $product->slug)}}" class="font-semibold line-clamp-2 hover:line-clamp-none">{{$product->name}}</a>
                        <p
                            class="bg-[#2A2A2A] font-semibold text-xs text-belibang-grey rounded-[4px] p-[4px_6px] w-fit">
                            {{$product->category->name}}</p>
                    </div>
                    <div class="flex items-center gap-[6px]">
                        <div class="w-6 h-6 flex shrink-0 items-center justify-center rounded-full overflow-hidden">
                            <img src="{{Storage::url($product->creator->avatar)}}" class="w-full h-full object-cover" alt="logo">
                        </div>
                        <a href="" class="font-semibold text-xs text-belibang-grey">{{$product->creator->name}}</a>
                    </div>
                </div>
            </div>
        @empty
        @endforelse

    </div>
</section>

<x-testimonials/>

<x-footer/>


@endsection

@push('after-script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('.testi-carousel');
        const prevBtn = document.querySelector('.btn-prev');
        const nextBtn = document.querySelector('.btn-next');
        const cards = document.querySelectorAll('.testimonial-card');
        
        if (!carousel || cards.length === 0) return;
        
        const cardWidth = 420 + 20; // card width + margin
        const totalCards = cards.length;
        const originalCards = totalCards / 2; // Since we duplicated the cards
        let currentIndex = 0;
        let autoPlayInterval;
        let isTransitioning = false;
        
        // Set initial position to show first set
        carousel.style.transform = `translateX(0px)`;
        
        // Update carousel position
        function updateCarousel(animate = true) {
            if (isTransitioning && animate) return;
            
            const translateX = -(currentIndex * cardWidth);
            
            if (animate) {
                isTransitioning = true;
                carousel.style.transition = 'transform 0.6s ease-in-out';
                carousel.style.transform = `translateX(${translateX}px)`;
                
                setTimeout(() => {
                    // Check if we need to reset position for infinite effect
                    if (currentIndex >= originalCards) {
                        // Reset to beginning without animation
                        currentIndex = 0;
                        carousel.style.transition = 'none';
                        carousel.style.transform = `translateX(0px)`;
                    } else if (currentIndex < 0) {
                        // Reset to end without animation
                        currentIndex = originalCards - 1;
                        carousel.style.transition = 'none';
                        carousel.style.transform = `translateX(${-(currentIndex * cardWidth)}px)`;
                    }
                    
                    setTimeout(() => {
                        isTransitioning = false;
                    }, 50);
                }, 600);
            } else {
                carousel.style.transition = 'none';
                carousel.style.transform = `translateX(${translateX}px)`;
                isTransitioning = false;
            }
        }
        
        // Next slide
        function nextSlide() {
            currentIndex++;
            updateCarousel();
        }
        
        // Previous slide
        function prevSlide() {
            if (currentIndex === 0) {
                // Jump to the duplicate set at the end
                currentIndex = originalCards;
                updateCarousel(false);
                setTimeout(() => {
                    currentIndex = originalCards - 1;
                    updateCarousel();
                }, 50);
            } else {
                currentIndex--;
                updateCarousel();
            }
        }
        
        // Auto play
        function startAutoPlay() {
            autoPlayInterval = setInterval(nextSlide, 3000);
        }
        
        function stopAutoPlay() {
            clearInterval(autoPlayInterval);
        }
        
        // Event listeners
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                stopAutoPlay();
                nextSlide();
                setTimeout(startAutoPlay, 5000);
            });
        }
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                stopAutoPlay();
                prevSlide();
                setTimeout(startAutoPlay, 5000);
            });
        }
        
        // Pause on hover
        carousel.addEventListener('mouseenter', stopAutoPlay);
        carousel.addEventListener('mouseleave', startAutoPlay);
        
        // Start auto play
        startAutoPlay();
    });
</script>

<script>
    const searchInput = document.getElementById('searchInput');
    const resetButton = document.getElementById('resetButton');

    searchInput.addEventListener('input', function () {
        if (this.value.trim() !== '') {
            resetButton.classList.remove('hidden');
        } else {
            resetButton.classList.add('hidden');
        }
    });

    resetButton.addEventListener('click', function () {
        resetButton.classList.add('hidden');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuButton = document.getElementById('menu-button');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        menuButton.addEventListener('click', function () {
            dropdownMenu.classList.toggle('hidden');
        });

        // Close the dropdown menu when clicking outside of it
        document.addEventListener('click', function (event) {
            const isClickInside = menuButton.contains(event.target) || dropdownMenu.contains(event.target);
            if (!isClickInside) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>
@endpush