<x-app-layout>
    <div class="p-6 sm:p-10 bg-white dark:bg-gray-800 shadow-lg rounded-xl max-w-4xl mx-auto mt-10">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Left Side: Product Info -->
            <div class="text-center md:text-left">
                <img src="{{ $product->image }}" alt="{{ $product->name }}" class="mx-auto md:mx-0 rounded-lg shadow-md w-full max-h-72">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mt-4">{{ $product->name }}</h2>
                <p class="text-sm mt-2 text-gray-700 dark:text-gray-300">
                    Stock Available: 
                    <span id="stock-count" class="font-semibold">
                        {{ $product->stock > 0 ? $product->stock : 'Out of Stock' }}
                    </span>
                </p>
            </div>

            <!-- Right Side: Form -->
            <form method="POST" action="{{ route('products.PlaceOrder', $product) }}" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Address -->
                    <div class="col-span-1 md:col-span-2">
                        <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                        <input id="address" name="address" type="text" required
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                            value="{{ $userdetails->address ?? ''}}">
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                        <input id="phone_number" name="phone_number" type="text" required
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                            value="{{ $userdetails->phone_number   ?? ''}}">
                    </div>

                    <!-- City -->
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                        <input id="city" name="city" type="text" required
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                            value="{{$userdetails->city ?? ''}}">
                    </div>

                    <!-- State -->
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                        <input id="state" name="state" type="text" required
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                            value="{{ $userdetails->state ?? '' }}">
                    </div>

                    <!-- Country -->
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                        <input id="country" name="country" type="text" required
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                            value="{{ $userdetails->country ?? ''}}">
                    </div>

                    <!-- Postal Code -->
                    <div>
                        <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                        <input id="postal_code" name="postal_code" type="text" required
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                            value="{{ $userdetails->postal_code ?? ''}}">
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                        <input id="quantity" name="quantity" type="number" min="1" max="{{ $product->stock }}" 
                            {{ $product->stock == 0 ? 'disabled' : '' }} required
                            class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                            value=1>
                    </div>
                </div>

                <!-- Hidden User ID -->
                <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                <!-- Submit Button -->
                <div class="pt-4 text-center">
                    <button type="submit"
                        {{ $product->stock == 0 ? 'disabled' : '' }}
                        class="inline-flex items-center px-6 py-2 bg-indigo-600 dark:bg-indigo-500 text-white text-sm font-semibold rounded-lg shadow 
                        {{ $product->stock == 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-indigo-700 dark:hover:bg-indigo-600' }} transition duration-150 ease-in-out">
                        {{ $product->stock == 0 ? 'Out of Stock' : 'Place Order' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Prevent entering quantity greater than stock
        document.addEventListener('DOMContentLoaded', () => {
            const quantityInput = document.getElementById('quantity');
            const maxStock = parseInt(quantityInput.max);

            quantityInput?.addEventListener('input', () => {
                if (quantityInput.value > maxStock) {
                    quantityInput.value = maxStock;
                }
            });
        });
    </script>
</x-app-layout>
