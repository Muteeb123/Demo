
<x-app-layout>




<div class="p-6 sm:p-10 bg-white dark:bg-gray-800 shadow-lg rounded-xl max-w-2xl mx-auto mt-10">
    <header class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('Enter Details to Order') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
            {{ __("Please provide your personal information below.") }}
        </p>
    </header>

    <form method="POST" action="{{ route('products.PlaceOrder', $product) }}" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Address -->
            <div class="col-span-1 md:col-span-2">
                <label for="address" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address</label>
                <input id="address" name="address" type="text" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                    value="{{ old('address') }}">
            </div>

            <!-- Phone -->
            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number</label>
                <input id="phone_number" name="phone_number" type="text" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                    value="{{ old('phone_number') }}">
            </div>

            <!-- City -->
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300">City</label>
                <input id="city" name="city" type="text" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                    value="{{ old('city') }}">
            </div>

            <!-- State -->
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300">State</label>
                <input id="state" name="state" type="text" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                    value="{{ old('state') }}">
            </div>

            <!-- Country -->
            <div>
                <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                <input id="country" name="country" type="text" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                    value="{{ old('country') }}">
            </div>

            <!-- Postal Code -->
            <div>
                <label for="postal_code" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Postal Code</label>
                <input id="postal_code" name="postal_code" type="text" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                    value="{{ old('postal_code') }}">
            </div>


            <div>
            
                <label for = "Quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Quantity</label>
                <input id="quantity" name="quantity" type="number" required
                    class="mt-1 w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-sm"
                    value="{{ old('quantity') }}">  
            </div>
        </div>

        

        <!-- Hidden User ID -->
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">

        <!-- Submit Button -->
        <div class="pt-4 text-center">
            <button type="submit"
                class="inline-flex items-center px-6 py-2 bg-indigo-600 dark:bg-indigo-500 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-700 dark:hover:bg-indigo-600 transition duration-150 ease-in-out">
                Place Order
            </button>
        </div>
    </form>
</div>


</x-app-layout>