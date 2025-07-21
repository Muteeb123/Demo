<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Add New Task
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('tasks.store') }}" method="POST">
                    @csrf

                    {{-- Title --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1" for="title">Title</label>
                        <input type="text" name="title" id="title"
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                               required>
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label class="block text-gray-700 dark:text-gray-200 mb-1" for="description">Description</label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                                  required></textarea>
                    </div>

                    

                   @php
    $today = date('Y-m-d');
@endphp

{{-- Due Date --}}
<div class="mb-6">
    <label class="block text-gray-700 dark:text-gray-200 mb-1" for="due_date">Due Date</label>
    <input type="date" name="due_date" id="due_date"
           min="{{ $today }}"
           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
           required>
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
