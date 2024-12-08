<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg flex flex-col gap-y-5">

            @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="py-5 bg-red-500 text-white font-bold">
                                    {{ $error }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="flex flex-row justify-between items-center mb-5">
                    <h3 class="text-indigo-950 font-bold text-2xl">My Transactions</h3>
                </div>

                 @forelse ($my_transactions as $transaction)
                    <div class="item-product flex flex flex-row justify-between items-center">
                    <div class="flex flex-row items-center gap-x-5">
                        <img src="{{ Storage::url($transaction->product->cover) }}" class="rounded-2xl h-[100px] w-auto " alt="">
                        <div>
                            <h3 class="text-indigo-950 font-bold text-xl">{{ $transaction->product->name }}</h3>
                            <p class="text-slate-600 text-sm">{{ $transaction->product->category->name }}</p>
                            </div>
                    </div>
                    <div>
                        <p class="text-slate-600 text-sm">Total Price:</p>
                        <p class="text-indigo-950 font-bold text-xl">Rp {{ $transaction->total_price }}</p>
                    </div>
                    <div>
                        <p class="text-slate-600 text-sm">Status:</p>
                            @if($transaction->is_paid)
                            <span class="py-1 px-3 rounded-full bg-green-500 text-white font-bold text-sm">
                                SUCCESS
                            </span>
                            @else
                            <span class="py-1 px-3 rounded-full bg-yellow-500 text-white font-bold text-sm">
                                PENDING
                            </span>
                            @endif
                    </div>
                        <div class="flex flex-row gap-x-3">
                            <a href="{{ route('admin.product_orders.transactions.details', $transaction)}}" class="rounded-full font-bold py-3 px-5 bg-indigo-500 text-white">
                               View Details
                            </a>
                        </div>
                    </div>
                @empty
                    <p>Belum ada Transaksi anda tersedia</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
