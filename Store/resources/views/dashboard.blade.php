<x-app-layout>
    @php
        $type = session('success') ? 'success' : (session('error') ? 'error' : null);
        $message = session('success') ?? session('error');
    @endphp

    @if ($type && $message)
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="mb-4 p-4 rounded-lg shadow-md border 
            {{ $type === 'success' ? 'bg-green-100 text-green-800 border-green-300' : 'bg-red-100 text-red-800 border-red-300' }}">
            {{ $message }}
        </div>
    @endif

    <div class="py-12">

      
<div class="text-center mb-6">
    <div class="inline">

        {{-- Filter Buttons --}}
        <div class="mb-4 flex justify-center gap-2">
            <a href="{{ route('dashboard', array_merge(request()->query(), ['status' => null])) }}"
               class="px-4 py-2 rounded-md {{ request('status') === null ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-800' }}">
                All
            </a>
            <a href="{{ route('dashboard', array_merge(request()->query(), ['status' => 'active'])) }}"
               class="px-4 py-2 rounded-md {{ request('status') === 'active' ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-800' }}">
                Active
            </a>
            <a href="{{ route('dashboard', array_merge(request()->query(), ['status' => 'inactive'])) }}"
               class="px-4 py-2 rounded-md {{ request('status') === 'inactive' ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-800' }}">
                Inactive
            </a>

           
        </div>


        {{-- Search Form --}}
        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center justify-center gap-2">
            <input type="text" name="search" placeholder="Search products..."
                   value="{{ request('search') }}"
                   class="w-1/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300">

            {{-- Preserve status filter when searching --}}
            @if(request()->has('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

               <select name="sortby" id="sortby" onchange="this.form.submit()"
            class="px-4 py-2 rounded-md bg-gray-200 text-gray-800">
        <option value="default" {{ request('sortby') === 'default' ? 'selected' : '' }}>Default</option>
        <option value="name_asc" {{ request('sortby') === 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
        <option value="name_desc" {{ request('sortby') === 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
        <option value="price_asc" {{ request('sortby') === 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
        <option value="price_desc" {{ request('sortby') === 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
        </select>

            <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-200">
                Search
            </button>

            <a href="{{ route('products.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                Add New Product
            </a>
        </form>

    </div>
</div>

    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="px-4 py-2">Product ID</th>
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Price</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Status</th>
                    <th colspan="3" class="px-4 py-2 text-transparent">Buttons</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="border-b dark:border-gray-600">
                        <td class="px-4 py-2">{{ $product->id }}</td>

                        <td class="px-4 py-2">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="w-16 h-16 object-cover rounded" />
                        </td>

                        <td class="px-4 py-2">{{ $product->name }}</td>
                        <td class="px-4 py-2">{{ Str::limit($product->description, 60) }}</td>
                        <td class="px-4 py-2">${{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-2">{{ $product->stock }}</td>
                        <td class="px-4 py-2">
                            <span
                                class="px-2 py-1 rounded-full text-xs font-semibold text-white
        {{ $product->is_active ? 'bg-green-500 dark:bg-green-600' : 'bg-yellow-500 dark:bg-yellow-600' }}">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>

                        <td>
                            <button class="text-green-600 hover:text-green-800 py-2 px-5">
                                <a href="{{ route('products.edit', $product->id) }}">
                                    Edit
                                </a>
                            </button>
                        </td>

                        <td>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 py-2 px-5">
                                    Delete
                                </button>
                            </form>
                        </td>



                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $products->appends(request()->query())->links() }}
        </div>
    </div>

</x-app-layout>
