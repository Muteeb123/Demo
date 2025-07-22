<x-app-layout>
    @php
        $type = session('success') ? 'success' : (session('error') ? 'error' : null);
        $message = session('success') ?? session('error');
    @endphp

    @if ($type && $message)
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
            x-transition:leave="transition ease-in duration-500" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="mb-6 p-4 rounded-md border-l-4 shadow-md
            {{ $type === 'success' ? 'bg-green-50 text-green-800 border-green-500' : 'bg-red-50 text-red-800 border-red-500' }}">
            {{ $message }}
        </div>
    @endif

    <div class="p-4">
        {{-- Filter Buttons --}}
        <div class="mb-4 flex justify-center gap-2">
            @foreach (['' => 'All', 'completed' => 'Completed', 'cancelled' => 'Cancelled', 'pending' => 'Pending'] as $status => $label)
                <a href="{{ route('orders.index', array_merge(request()->query(), ['status' => $status ?: null])) }}"
                    class="px-4 py-2 rounded-md {{ request('status') === $status ? 'bg-blue-700 text-white' : 'bg-gray-200 text-gray-800' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Search Form --}}
        <form action="{{ route('orders.index') }}" method="GET" class="flex items-center justify-center gap-2">
            <input type="text" name="search" placeholder="Search products..." value="{{ request('search') }}"
                class="w-1/3 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-300">

            @if (request()->has('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

            <select name="sortby" onchange="this.form.submit()" class="px-4 py-2 rounded-md bg-gray-200 text-gray-800">
                <option value="default" {{ request('sortby') === 'default' ? 'selected' : '' }}>Default</option>
                <option value="price_asc" {{ request('sortby') === 'price_asc' ? 'selected' : '' }}>Price (Low to High)
                </option>
                <option value="price_desc" {{ request('sortby') === 'price_desc' ? 'selected' : '' }}>Price (High to
                    Low)</option>
                <option value="newest" {{ request('sortby') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="oldest" {{ request('sortby') === 'oldest' ? 'selected' : '' }}>Oldest</option>
            </select>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Search
            </button>
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg m-4">
        <table
            class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200 divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700 text-xs font-semibold uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-3">Order ID</th>
                    <th class="px-6 py-3">Ordered By</th>
                    <th class="px-6 py-3">Product</th>
                    <th class="px-6 py-3">Price</th>
                    <th class="px-6 py-3">Qty</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-center" colspan="2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse ($orders as $order)
                    @php
                        $statusClass = match ($order->status) {
                            'pending' => 'bg-yellow-200 text-yellow-800',
                            'cancelled' => 'bg-red-200 text-red-800',
                            default => 'bg-green-200 text-green-800',
                        };
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">{{ $order->id }}</td>
                        <td class="px-6 py-4">{{ $order->user->name }}</td>
                        <td class="px-6 py-4">{{ $order->product->name }}</td>
                        <td class="px-6 py-4">${{ number_format($order->product->price, 2) }}</td>
                        <td class="px-6 py-4">{{ $order->quantity }}</td>
                        <td class="px-6 py-4">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center align-middle" colspan="2">
                            @if ($order->status === 'pending')
                                <div class="flex flex-col sm:flex-row items-center justify-center gap-2">
                                    {{-- Cancel/Reject Order --}}
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to {{ Auth::user()->is_admin ? 'reject' : 'cancel' }} this order?');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="bg-red-100 hover:bg-red-200 text-red-800 text-xs font-medium py-1 px-3 rounded-full transition">
                                            {{ Auth::user()->is_admin ? 'Reject Order' : 'Cancel Order' }}
                                        </button>
                                    </form>

                                    {{-- Mark as Delivered --}}
                                    @if (Auth::user()->is_admin)
                                        <form action="{{ route('orders.update', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Mark this order as delivered?');">
                                            @csrf
                                            @method('PUT')

                                            <input type="hidden" name="status" value="delivered">

                                            <button type="submit"
                                                class="bg-green-100 hover:bg-green-200 text-green-800 text-xs font-medium py-1 px-3 rounded-full transition">
                                                Mark as Delivered
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <span class="text-sm text-gray-500 italic">No action</span>
                            @endif
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-4 text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</x-app-layout>
