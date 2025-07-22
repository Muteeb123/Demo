<x-app-layout>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <title>Product Grid</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-[#f5f7fa] text-gray-800 min-h-screen">

        @php
            $type = session('success') ? 'success' : (session('error') ? 'error' : null);
            $message = session('success') ?? session('error');
        @endphp

        @if ($type && $message)
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-lg shadow-lg border text-sm font-medium
            {{ $type === 'success' ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' }}">
                {{ $message }}
            </div>
        @endif

        <!-- Page Header -->
        <header class="text-center py-10">
            <h2 class="text-3xl font-bold text-white">Our Featured Products</h2>
            <p class="mt-2 text-gray-500 text-sm">Browse and find the best products that suit your needs</p>
        </header>

        <!-- Search & Sort -->
        <div class="max-w-4xl mx-auto mb-8 px-4">

            <form action="{{ route('products.index') }}" method="GET" class="space-y-4" id="filterForm">


                 <div class="flex gap-4">
                    <input type="text" name="search" placeholder="Search products..."
                        value="{{ request('search') }}"
                        class="flex-grow px-4 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <button type="submit"
                        class="bg-blue-600 text-white px-6 py-2 rounded-md shadow hover:bg-blue-700 transition duration-200">
                        Search
                    </button>
                </div>


                {{-- 🔹 Filter Section --}}
                <div class="flex flex-wrap gap-4">
                    <select name="sortby" id="sortby" onchange="this.form.submit()"
                        class="px-4 py-2 rounded-md border border-gray-300 shadow-sm bg-white text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="default" {{ request('sortby') === 'default' ? 'selected' : '' }}>Sort</option>
                        <option value="price_asc" {{ request('sortby') === 'price_asc' ? 'selected' : '' }}>Price (Low
                            to High)</option>
                        <option value="price_desc" {{ request('sortby') === 'price_desc' ? 'selected' : '' }}>Price
                            (High to Low)</option>
                    </select>

                    <select name="filter_by" id="filter_by" onchange="toggleInputFields()"
                        class="px-4 py-2 rounded-md border border-gray-300 shadow-sm bg-white text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="default" {{ request('filter_by') === 'default' ? 'selected' : '' }}>Filter By
                        </option>
                        <option value="stock" {{ request('filter_by') === 'stock' ? 'selected' : '' }}>Available Stock
                        </option>
                        <option value="date" {{ request('filter_by') === 'date' ? 'selected' : '' }}>Date</option>
                        <option value="price" {{ request('filter_by') === 'price' ? 'selected' : '' }}>Price</option>
                    </select>

                    <select name="filter_operator" id="filter_operator" onchange="toggleInputFields()"
                        class="px-4 py-2 rounded-md border border-gray-300 shadow-sm bg-white text-gray-700 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <option value="default" {{ request('filter_operator') === 'default' ? 'selected' : '' }}>Filter
                        </option>
                        <option value="gt" {{ request('filter_operator') === 'gt' ? 'selected' : '' }}>Greater Than
                        </option>
                        <option value="lt" {{ request('filter_operator') === 'lt' ? 'selected' : '' }}>Less Than
                        </option>
                        <option value="eq" {{ request('filter_operator') === 'eq' ? 'selected' : '' }}>Equal To
                        </option>
                        <option value="lte" {{ request('filter_operator') === 'lte' ? 'selected' : '' }}>Less than Equal to
                        </option>
                        <option value="gte" {{ request('filter_operator') === 'gte' ? 'selected' : '' }}>Greater than Equal to
                        </option>
                        <option value="ran" {{ request('filter_operator') === 'ran' ? 'selected' : '' }}>Between
                        </option>
                    </select>

                    <div id="singleValueInput" class="{{ request('filter_operator') === 'ran' ? 'hidden' : '' }}">
                        <input type="number" id="filter_val" name="filter_value" value="{{ request('filter_value') }}"
                            placeholder="Enter Value"
                            class="px-4 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div id="rangeInputs"
                        class="flex gap-2 {{ request('filter_operator') === 'ran' ? '' : 'hidden' }}">
                        <input type="number" id ="filter_from" name="filter_from" value="{{ request('filter_from') }}"
                            placeholder="From"
                            class="px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                        <input type="number" id ="filter_to" name="filter_to" value="{{ request('filter_to') }}"
                            placeholder="To"
                            class="px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <div>
                        <button type="submit"
                            class="bg-gray-800 text-white px-4 py-2 rounded-md shadow hover:bg-gray-900 transition duration-200">
                            Apply Filter
                        </button>

                        <a href="{{ route('products.index') }}"
                            class="bg-gray-300 text-gray-800 px-6 py-2 rounded-md shadow hover:bg-gray-400 transition duration-200">
                            Clear 
                        </a>
                    </div>

                </div>

                {{-- 🔍 Search Section --}}
               
            </form>
        </div>


        <!-- Product Grid -->
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6">
                @forelse($products as $product)
                    <div
                        class="bg-yellow-100 border border-gray-200 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-4 flex flex-col">
                        <div class="h-32 flex justify-center items-center mb-3 ">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="max-h-full object-cover rounded" />
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 text-center mb-1">
                            {{ $product->name }}
                        </h3>
                        <p class="text-xs text-gray-600 text-center mb-3">
                            {{ Str::limit($product->description, 60) }}
                        </p>
                        <div class="text-center text-blue-600 font-bold text-sm mb-2">
                            ${{ $product->price }}
                        </div>

                        <p class="text-sm mt-2 text-blue-1000 dark:text-blue-800 text-center py-2">

                            <span id="stock-count" class="font-semibold">
                                {{ $product->stock > 0 ? 'In Stock: ' . $product->stock : 'Out of Stock' }}
                            </span>
                        </p>
                        <a href="{{ route('products.Order', $product->id) }}"
                            class="mt-auto inline-block text-center text-white bg-blue-600 hover:bg-blue-700 transition px-4 py-2 rounded-md text-sm">
                            Order Now
                        </a>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500">
                        No products found.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8 text-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>

    </body>
    <script>
        function toggleInputFields() {
            const operator = document.getElementById('filter_operator').value;
            const singleInput = document.getElementById('singleValueInput');
            const rangeInputs = document.getElementById('rangeInputs');
            const filter_by = document.getElementById('filter_by').value;

            if (filter_by === 'date') {
                document.getElementById('filter_val').type = 'date';
                document.getElementById('filter_from').type = 'date';
                document.getElementById('filter_to').type = 'date';

            } else {
                document.getElementById('filter_val').type = 'number';
                document.getElementById('filter_from').type = 'number';
                document.getElementById('filter_to').type = 'number';
                document.getElementById('filter_val').step = '0.01';
                document.getElementById('filter_from').step = '0.01';
                document.getElementById('filter_to').step = '0.01';
            }


            document.getElementById('filter_val').value = '';
            document.getElementById('filter_from').value = '';
            document.getElementById('filter_to').value = '';
            if (operator === 'ran') {
                singleInput.classList.add('hidden');
                rangeInputs.classList.remove('hidden');
            } else {
                singleInput.classList.remove('hidden');
                rangeInputs.classList.add('hidden');
            }
        }

        // Ensure correct input is shown on page load
        document.addEventListener('DOMContentLoaded', toggleInputFields);
    </script>

    </html>



</x-app-layout>
