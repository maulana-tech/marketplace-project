<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm p-10 sm:rounded-lg">
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

                <form method="POST" action="{{ route('admin.products.update', $product) }} "enctype="multipart/form-data">
                    @csrf
                    @method('PUT') 
                    <h1 class="text-indigo-950 text-3xl font-bold">Edit Product</h1>
                    <!-- Name -->
                    <div class="mt-4">
                        <x-input-label for="cover" :value="__('existing cover')" />
                        <img src="{{ Storage::url($product->cover) }}" class="h-[80px] w-auto " alt="">
                        <x-text-input id="cover" class="block mt-1 w-full" type="file" name="cover"  />
                        <x-input-error :messages="$errors->get('cover')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="path_file" :value="__('path_file')" />
                        <p>
                        {{ Storage::url($product->path_file) }}
                        </p>
                        <x-text-input id="path_file" class="block mt-1 w-full" type="file" name="path_file"  />
                        <x-input-error :messages="$errors->get('path_file')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input value="{{$product->name}}" id="name" class="block mt-1 w-full" type="text" name="name" 
                         required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="price" :value="__('price')" />
                        <x-text-input value="{{$product->price}}" id="price" class="block mt-1 w-full" type="number" 
                        name="price" required autofocus autocomplete="price" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="category" :value="__('category')" />
                        <select name="category_id" id="category" class="w-full py-3 pl-5 border">
                            <option value="{{$product->category->id}}" selected>{{$product->category->name}}</option>
                            <!-- perulangan  -->

                            @forelse ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                           
                            @empty
                            @endforelse

                        </select>
                        <x-input-error :messages="$errors->get('category')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="about" :value="__('about')" />
                        <textarea name="about" id="about" class="w-full py-3 pl-5 border"> {{$product->about}}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">

                        <x-primary-button class="ms-4">
                            {{ __('Update Product') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
