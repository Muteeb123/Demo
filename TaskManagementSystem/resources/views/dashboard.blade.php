<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
       
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-gray-900 dark:text-gray-100 mb-4">
                    {{ auth()->user()->name }}, welcome to your dashboard!
                </div>

                {{-- Filter Buttons --}}
               

                {{-- Task Table --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700 dark:text-gray-200">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-100">
                            <tr>
                                <th class="px-4 py-2">ID</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Due Date</th> 
                                <th  colspan='3'class = "px-4 py-2 text-transparent"> Buttons</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tasks as $task)
                                <tr class="border-b dark:border-gray-600">
                                    <td class="px-4 py-2">{{ $task->id }}</td>
                                    <td class="px-4 py-2">{{ $task->title }}</td>
                                    <td class="px-4 py-2">{{ $task->description }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-xs
                                            {{ $task->status === 'completed' ? 'bg-green-300 dark:bg-green-600' : 'bg-yellow-300 dark:bg-yellow-600' }}">
                                            {{ ucfirst($task->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</td>

                                    <td>
                                         <button onclick="window.location='{{ route('tasks.edit',$task) }}'" class="text-green-600 hover:text-green-800 py-2 px-5">
                                          
                                        Edit
                                        </button>
                                        
                                    
                                    </td>
                                        <td>
                                        <button onclick="window.location='{{ route('tasks.destroy',$task) }}'" class="text-red-600 hover:text-red-800">
                                          
                                        Delete
                                        </button>
                                        
                                    
                                    </td>

                                    <td>
                                        <button onclick="window.location='{{ route('tasks.completed',$task) }}'" class="text-blue-600 hover:text-blue-800">
                                            Mark as completed
                                        </button>


                                    
                                    </td>
                                </tr>
                            {{-- pagination --}}
                             
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">No tasks found.</td>
                                </tr>
                            @endforelse
                              
                        </tbody>
                    </table>
                    <div>
                    
                    {{$tasks->links()}}
                    
                    
                    </div>
                </div>
                <div>
                
                    <button onclick="window.location='{{ route('tasks.create') }}'" class="mt-4 bg-transparent-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                        Add Task
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
