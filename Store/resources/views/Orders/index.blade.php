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

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                <tr>
                    <th class="px-4 py-2">Order ID</th>
                    <th class="px-4 py-2">Ordered By</th>
                    <th class="px-4 py-2">Product Name</th>
                    <th class="px-4 py-2">Item Price</th>
                    <th class="px-4 py-2">Quantity</th>
                    <th class="px-4 py-2">Total Price</th>
                    <th class="px-4 py-2">Status</th>
                    <th colspan="2" class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-b dark:border-gray-600">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->user->name }}</td>
                        <td class="px-4 py-2">{{ $order->product->name }}</td>
                        <td class="px-4 py-2">${{ number_format($order->product->price, 2) }}</td>
                        <td class="px-4 py-2">{{ $order->quantity }}</td>
                        <td class="px-4 py-2">${{ number_format($order->total_price, 2) }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold text-white
                                {{ $order->status === 'pending' ? 'bg-yellow-500 dark:bg-yellow-600' : 'bg-green-500 dark:bg-green-600' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('products.edit', $order->product->id) }}"
                                class="text-green-600 hover:text-green-800 py-2 px-5 inline-block">
                                Edit
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('products.destroy', $order->product->id) }}" method="POST"
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
                        <td colspan="9" class="text-center py-4">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>
