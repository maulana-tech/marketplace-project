@extends('front.layouts.app')
@section('title', 'About Us - SIA Marketplace')
@section('content')

<x-navbar/>

<!-- Hero Section -->
<header class="w-full pt-[74px] pb-[34px] bg-[url('{{asset('images/backgrounds/hero-image.png')}}')] bg-cover bg-no-repeat bg-center relative z-0">
    <div class="container max-w-[1130px] mx-auto flex flex-col items-center justify-center gap-[34px] z-10">
        <div class="flex flex-col gap-2 text-center w-fit mt-20 z-10">
            <h1 class="font-semibold text-[60px] leading-[130%]">About <br>SIA Marketplace</h1>
            <p class="text-lg text-belibang-grey">Your trusted destination for thrift shopping</p>
        </div>
    </div>
    <div class="w-full h-full absolute top-0 bg-gradient-to-b from-belibang-black/70 to-belibang-black z-0"></div>
</header>

<!-- Main Content -->
<div class="container max-w-[1130px] mx-auto px-4 py-16">
    <!-- Introduction -->
    <section class="mb-16">
        <div class="bg-[#181818] rounded-[20px] p-8 mb-8">
            <h2 class="font-semibold text-[32px] mb-6 bg-clip-text text-transparent bg-gradient-to-r from-[#B05CB0] to-[#FCB16B]">Welcome to SIA Marketplace</h2>
            <p class="mb-6 text-lg leading-relaxed text-belibang-grey">
                Welcome to our e-commerce platform, the ultimate destination for thrift shopping enthusiasts. We pride
                ourselves on offering a curated selection of high-quality preloved footwear, clothing, and accessories at
                unbeatable prices. Our mission is to make second-hand shopping a thrilling and sustainable experience.
            </p>
        </div>
    </section>

    <!-- Our Story -->
    <section class="mb-16">
        <div class="bg-[#181818] rounded-[20px] p-8">
            <h2 class="font-semibold text-[32px] mb-6">Our Story</h2>
            <p class="mb-6 text-lg leading-relaxed text-belibang-grey">
                Established in 2022, our online thrift store was born out of a passion for unique fashion finds and
                a commitment to environmental conservation. We believe in the power of second chances — giving new
                life to gently used items and reducing waste. What started as a small initiative has grown into a
                thriving marketplace connecting sellers and buyers who share our values.
            </p>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="mb-16">
        <div class="bg-[#181818] rounded-[20px] p-8">
            <h2 class="font-semibold text-[32px] mb-6">Why Choose SIA Marketplace?</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-[#2A2A2A] rounded-[12px] p-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#B05CB0] to-[#FCB16B] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">Diverse Selection</h3>
                    <p class="text-belibang-grey">From vintage sneakers to modern streetwear, our collection has something for everyone's style and budget.</p>
                </div>
                
                <div class="bg-[#2A2A2A] rounded-[12px] p-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#B05CB0] to-[#FCB16B] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">Affordable Prices</h3>
                    <p class="text-belibang-grey">Enjoy stylish picks without breaking the bank. Quality fashion at prices that make sense.</p>
                </div>
                
                <div class="bg-[#2A2A2A] rounded-[12px] p-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#B05CB0] to-[#FCB16B] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">Eco-Friendly Shopping</h3>
                    <p class="text-belibang-grey">By choosing second-hand, you're contributing to a more sustainable fashion industry and reducing waste.</p>
                </div>
                
                <div class="bg-[#2A2A2A] rounded-[12px] p-6">
                    <div class="w-12 h-12 bg-gradient-to-r from-[#B05CB0] to-[#FCB16B] rounded-full flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-xl mb-2">Community Focused</h3>
                    <p class="text-belibang-grey">Connect with like-minded individuals and be part of a community that values sustainability and style.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Community -->
    <section class="mb-16">
        <div class="bg-gradient-to-r from-[#B05CB0] to-[#FCB16B] rounded-[20px] p-8 text-center">
            <h2 class="font-semibold text-[32px] mb-6 text-white">Join Our Community</h2>
            <p class="mb-6 text-lg leading-relaxed text-white/90 max-w-3xl mx-auto">
                We're more than just a marketplace; we're a thriving community of fashion lovers and sustainability advocates. 
                Connect with us, share your thrift finds, and be part of a movement that values both style and environmental responsibility.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{route('front.index')}}" class="bg-white text-[#B05CB0] font-semibold px-8 py-3 rounded-full hover:bg-gray-100 transition-colors">
                    Start Shopping
                </a>
                <a href="{{route('register')}}" class="bg-transparent border-2 border-white text-white font-semibold px-8 py-3 rounded-full hover:bg-white hover:text-[#B05CB0] transition-colors">
                    Join as Seller
                </a>
            </div>
        </div>
    </section>

    <!-- Thank You -->
    <section>
        <div class="text-center">
            <p class="text-xl leading-relaxed text-belibang-grey">
                Thank you for choosing SIA Marketplace as your trusted source for thrifted treasures. <br>
                <span class="font-semibold bg-clip-text text-transparent bg-gradient-to-r from-[#B05CB0] to-[#FCB16B]">Happy thrifting!</span>
            </p>
        </div>
    </section>
</div>

<x-footer/>

@endsection
