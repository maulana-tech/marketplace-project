<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden p-10 shadow-sm sm:rounded-lg flex flex-col gap-y-5">
                <a href="{{ route('admin.products.create') }}" class="w-fit rounded-full font-bold py-3 px-5 bg-indigo-900 text-white">
                    Add Product
                </a>
                 @forelse ($products as $product)
                    <div class="item-product flex flex flex-row justify-between items-center">
                    <img src="{{ Storage::url($product->cover) }}" class="h-[80px] w-auto " alt="">
                    <div>
                            <h3>Nama Product</h3>
                            <p>Categori Product</p>
                        </div>
                        <div>
                            <p>Rp 11000000</p>
                        </div>
                        <div class="flex flex-row gap-x-3">
                            <a href="#" class="rounded-full font-bold py-3 px-5 bg-indigo-500 text-white">
                                Edit
                            </a>
                            <a href="#" class="rounded-full font-bold py-3 px-5 bg-red-500 text-white">
                                Delete
                            </a>
                        </div>
                    </div>
                @empty
                    <p>Tidak ada product</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
