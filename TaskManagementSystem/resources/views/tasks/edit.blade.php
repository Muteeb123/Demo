<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
            Edit Task
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                <input type="text" name="title" value="{{ $task->title }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring focus:ring-blue-500" required>
            </div>

            <div>
                <label for="description" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                <input type="text" name="description" value="{{ $task->description }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring focus:ring-blue-500" required>
            </div>

          

            <div>
                <label for="due_date" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">Due Date</label>
                <input type="date" name="due_date" value="{{ $task->due_date }}" class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring focus:ring-blue-500" required>
            </div>

            <div class="text-right">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold shadow transition duration-300">
                    Update Task
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
