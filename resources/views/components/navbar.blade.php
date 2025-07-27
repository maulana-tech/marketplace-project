<nav class="w-full fixed top-0 bg-[#00000010] backdrop-blur-lg z-10">
        <div class="container max-w-[1130px] mx-auto flex items-center justify-between h-[74px]">
            <div class="flex items-center gap-[26px]">
                <a href="{{route('front.index')}}" class="flex w-[154px] shrink-0 items-center">
                    <img src="{{asset('images/logos/logo.svg')}}" alt="logo">
                </a>
                <ul class="flex gap-6 items-center">
                    <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                        <a href="{{route('front.index')}}">Home</a>
                    </li>
                    <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                        <a href="{{route('front.category', 1)}}">Reebok</a>
                    </li>
                    <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                        <a href="{{route('front.category', 2)}}">Nike</a>
                    </li>
                    <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                        <a href="{{route('front.category', 3)}}">Adidas</a>
                    </li>
                    <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                        <a href="{{route('front.category', 4)}}">New Balance</a>
                    </li>
                    @auth
                        @if(auth()->user()->role === 'pembeli')
                            <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                                <a href="{{ route('buyer.orders.stories') }}">Stories</a>
                            </li>
                        @else
                            <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                                <a href="{{ route('admin.product_orders.index') }}">Order History</a>
                            </li>
                        @endif
                    @else
                        <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                            <a href="{{ route('login') }}">Stories</a>
                        </li>
                    @endauth
                    <li class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">
                        <a href="{{route('front.about')}}">About</a>
                    </li>
                </ul>
            </div>
            <div class="flex gap-6 items-center">
                @guest
                <a href="{{route('login')}}" class="text-belibang-grey hover:text-belibang-light-grey transition-all duration-300">Log
                    in</a>
                <a href="{{route('register')}}"
                    class="p-[8px_16px] w-fit h-fit rounded-[12px] text-belibang-grey border border-belibang-dark-grey 
                    hover:bg-[#2A2A2A] hover:text-white transition-all duration-300">Sign
                    up</a>
                @endguest

                @auth
                <div class="relative">
                    <button id="user-menu-button" class="flex items-center gap-2 p-[8px_16px] w-fit h-fit rounded-[12px] text-belibang-grey border border-belibang-dark-grey hover:bg-[#2A2A2A] hover:text-white transition-all duration-300">
                        <span>{{ auth()->user()->name }}</span>
                        <img src="{{asset('images/icons/arrow-down.svg')}}" alt="icon" class="w-4 h-4">
                    </button>
                    <div id="user-dropdown" class="hidden absolute right-0 top-[52px] w-48 rounded-[20px] bg-[#1E1E1E] border border-[#414141] z-10 py-2">
                        @if(auth()->user()->role === 'pembeli')
                            <a href="{{ route('buyer.orders.index') }}" class="block px-4 py-2 text-white hover:bg-[#2A2A2A] transition-all duration-300">
                                My Orders
                            </a>
                            <a href="{{ route('buyer.testimonials.index') }}" class="block px-4 py-2 text-white hover:bg-[#2A2A2A] transition-all duration-300">
                                My Reviews
                            </a>
                        @else
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-white hover:bg-[#2A2A2A] transition-all duration-300">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-white hover:bg-[#2A2A2A] transition-all duration-300">
                                My Products
                            </a>
                            <a href="{{ route('admin.product_orders.index') }}" class="block px-4 py-2 text-white hover:bg-[#2A2A2A] transition-all duration-300">
                                My Transactions
                            </a>
                            <a href="{{ route('admin.testimonials.index') }}" class="block px-4 py-2 text-white hover:bg-[#2A2A2A] transition-all duration-300">
                                Customer Reviews
                            </a>
                        @endif
                        <hr class="border-[#414141] my-2">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-white hover:bg-[#2A2A2A] transition-all duration-300">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </div>
</nav>