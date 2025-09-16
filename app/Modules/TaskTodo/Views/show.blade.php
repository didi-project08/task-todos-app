@extends('source::_layouts.body')
@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Task Details</h1>
        <div class="flex space-x-2">
            <a href="{{ route('task-todos.edit', $task->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg transition duration-200">
                Edit
            </a>
            <a href="{{ route('task-todos.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                Back to List
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Task Information</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Description</label>
                        <p class="mt-1 text-gray-900 bg-gray-50 p-3 rounded">{{ $task->todo }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Assigned To</label>
                        <p class="mt-1 text-gray-900">{{ $task->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $task->user->email }}</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-lg font-semibold text-gray-700 mb-2">Timeline</h2>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Start Date</label>
                        <p class="mt-1 text-gray-900">{{ $task->start_date->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">End Date</label>
                        <p class="mt-1 text-gray-900">{{ $task->end_date->format('F d, Y') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600">Duration</label>
                        <p class="mt-1 text-gray-900">{{ $task->start_date->diffInDays($task->end_date) }} days</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Metadata</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-600">Created At</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $task->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600">Last Updated</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $task->updated_at->format('M d, Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection