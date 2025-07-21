<x-app-layout>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Grid Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

@php
    $type = session('success') ? 'success' : (session('error') ? 'error' : null);
    $message = session('success') ?? session('error');
@endphp

@if ($type && $message)
    <div 
        x-data="{ show: true }"
        x-init="setTimeout(() => show = false, 4000)"
        x-show="show"
        x-transition:leave="transition ease-in duration-500"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="mb-4 p-4 rounded-lg shadow-md border 
            {{ $type === 'success' ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' }}"
    >
        {{ $message }}
    </div>
@endif


    <h2 class="text-2xl font-bold mb-6 text-center text-white p-6">Products</h2>

    <!-- Search Bar -->
    <div class="max-w-2xl mx-auto mb-6">
        <form action="{{ route('products.index') }}" method="GET" class="flex items-center">
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
                   class="flex-grow p-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600 transition duration-200">
                Search
            </button>


            <select name="sortby" id="sortby" onchange="this.form.submit()"
                    class="ml-2 px-4 py-2 rounded-md bg-gray-200 text-gray-800">
                <option value="default" {{ request('sortby') === 'default' ? 'selected' : '' }}>Default</option>
                <option value="price_asc" {{ request('sortby') === 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                <option value="price_desc" {{ request('sortby') === 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
            </select>

            
        </form>
    </div>


    <!-- Product Grid -->
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
            @forelse($products as $product)
                <div class="bg-white border border-gray-200 rounded-md shadow p-4 flex flex-col">
                    <div class="h-24 flex justify-center items-center mb-2">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                             class="max-h-full object-contain" />
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900 text-center mb-1">
                        {{ $product->name }}
                    </h3>
                    <p class="text-xs text-gray-600 text-center mb-2">
                        {{ Str::limit($product->description, 60) }}
                    </p>
                    <div class="mt-auto text-center text-gray-800 font-bold">
                        ${{ $product->price }}
                    </div>
                       <a href="{{ route('products.Order', $product->id) }}"
                   class="block mt-2 text-center text-blue-500 hover:underline">
                    Order Now
                </a>
                </div>

             
            @empty
                <div class="col-span-full text-center text-gray-500">
                    No products found.
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $products->appends(request()->query())->links() }}
        </div>

    </div>

</body>
</html>


</x-app-layout>