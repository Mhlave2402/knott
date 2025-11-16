@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Wedding To-Do List
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Stay organized and on track with your wedding planning.
            </p>
        </div>
        <div class="text-right">
        </div>
    </div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="text-sm font-medium text-gray-500 truncate">Total Tasks</div>
                <div class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total'] }}</div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="text-sm font-medium text-gray-500 truncate">Completed</div>
                <div class="mt-1 text-3xl font-semibold text-green-600">{{ $stats['completed'] }}</div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="text-sm font-medium text-gray-500 truncate">Pending</div>
                <div class="mt-1 text-3xl font-semibold text-yellow-600">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg p-5">
                <div class="text-sm font-medium text-gray-500 truncate">Overdue</div>
                <div class="mt-1 text-3xl font-semibold text-red-600">{{ $stats['overdue'] }}</div>
            </div>
        </div>

        <!-- Add Task Form -->
        <div class="bg-white shadow rounded-lg mb-8">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Add a New Task</h3>
                <form action="{{ route('couple.todos.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700">Task Title</label>
                            <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                            <select name="priority" id="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                            </select>
                        </div>
                        <div class="col-span-1 md:col-span-3">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description (Optional)</label>
                            <textarea name="description" id="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm"></textarea>
                        </div>
                        <div>
                            <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date (Optional)</label>
                            <input type="date" name="due_date" id="due_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm">
                        </div>
                    </div>
                    <div class="mt-6 text-right">
                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 px-4 rounded">
                            Save Task
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Todo List -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Your Tasks</h3>
                    <form action="{{ route('couple.todos.suggestions') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-sm text-rose-600 hover:text-rose-900 font-medium">
                            Get Planning Suggestions
                        </button>
                    </form>
                </div>
                
                <div class="space-y-4">
                    @forelse ($todos as $todo)
                        <div class="flex items-center justify-between p-3 rounded-lg {{ $todo->is_completed ? 'bg-gray-100' : '' }}">
                            <div class="flex items-center">
                                <form method="POST" action="{{ route('couple.todos.toggle', $todo) }}" class="mr-4">
                                    @csrf
                                    @method('PATCH')
                                    <input type="checkbox" onchange="this.form.submit()" class="h-5 w-5 text-rose-600 border-gray-300 rounded focus:ring-rose-500" {{ $todo->is_completed ? 'checked' : '' }}>
                                </form>
                                <div>
                                    <p class="font-medium {{ $todo->is_completed ? 'line-through text-gray-500' : 'text-gray-900' }}">{{ $todo->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $todo->description }}</p>
                                    @if ($todo->due_date)
                                        <p class="text-xs text-gray-500 mt-1">
                                            Due: {{ $todo->due_date->format('M d, Y') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $todo->priority_color }}-100 text-{{ $todo->priority_color }}-800">
                                    {{ ucfirst($todo->priority) }}
                                </span>
                                <form action="{{ route('couple.todos.destroy', $todo) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 012 0v6a1 1 0 11-2 0V8z" clip-rule="evenodd"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10">
                            <p class="text-gray-500">You have no tasks yet. Add one above or get suggestions!</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-6">
                    {{ $todos->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
