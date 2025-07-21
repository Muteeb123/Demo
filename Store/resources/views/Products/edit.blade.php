<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        Edit Product
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('products.update',$product) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    {{-- Name --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1" for="title">Name</label>
                        <input type="text" name="name" id="name"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                             value = {{$product->name}}  required>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1" for="description">Description</label>
                        <textarea name="description" id="description" rows="4"
    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
    required>{{ old('description', $product->description) }}</textarea>

                    </div>

                    {{-- Price --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1" for="price">Price</label>
                        <input type="number" name="price" id="price" step="0.01"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                              value = {{$product->price}} required>
                    </div>

                    {{-- Stock --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1" for="stock">Stock</label>
                        <input type="number" name="stock" id="stock"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                              value = {{$product->stock}} required>
                    </div>
                    {{-- Image URL --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1" for="image">Image URL</label>
                        <input type="text" name="image" id="image"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               value = {{$product->image}} required>
                    </div>
                    {{-- Status --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1" for="is_active">Status</label>
                        <select name="is_active" id="is_active" value = {{$product->status}}
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

             

                    {{-- Submit --}}
                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                            Save Task
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
