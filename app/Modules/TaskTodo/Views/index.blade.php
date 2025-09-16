@extends('source::_layouts.body')

@section('content')
    <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-10">
        <div class="container mx-auto px-4 py-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <h1 class="text-xl font-bold text-blue-600 hidden lg:block">Task Todo</h1>
                </div>
                
                <div class="flex items-center justify-between lg:justify-end w-full max-w-md">
                    <div class="flex items-center space-x-2 lg:pr-5">
                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <span class="text-blue-600 font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                        </div>
                    </div>
                    
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition duration-200">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-4 py-8 mt-16" id="mainContent">
        <h1 class="text-xl lg:text-3xl font-bold text-gray-800 mb-5 lg:mb-0">Managemen Tugas</h1>
        <div class="flex justify-end items-end mb-6">
            <div class="flex space-x-2">
                <button id="toggleSearchBtn" class="md:hidden bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filters
                </button>
                <a href="{{ route('task-todos.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    + Tambah tugas baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div id="searchForm" class="bg-white p-4 rounded-lg shadow-md mb-6 md:block hidden">
            <form method="GET" action="{{ route('task-todos.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pencarian</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md" 
                            placeholder="Cari tugas...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ditugaskan Ke</label>
                        <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            <option value="">Semua Pengguna</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    </div>
                </div>
                <div class="mt-4 flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div class="mb-2 md:mb-0">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md">
                            Cari
                        </button>
                        <a href="{{ route('task-todos.index') }}" class="ml-2 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                            Reset
                        </a>
                    </div>
                    <div class="flex items-center w-full md:w-auto mt-2 md:mt-0">
                        <span class="text-sm text-gray-600 mr-2 whitespace-nowrap">Sort by:</span>
                        <select name="sort" onchange="this.form.submit()" class="w-full md:w-auto px-2 py-1 border border-gray-300 rounded-md">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Created Date</option>
                            <option value="start_date" {{ request('sort') == 'start_date' ? 'selected' : '' }}>Start Date</option>
                            <option value="end_date" {{ request('sort') == 'end_date' ? 'selected' : '' }}>End Date</option>
                        </select>
                        <select name="direction" onchange="this.form.submit()" class="w-full md:w-auto ml-2 px-2 py-1 border border-gray-300 rounded-md">
                            <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Descending</option>
                            <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tugas</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ditugaskan Ke</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Mulai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Akhir</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    @if (auth()->check() && Auth()->id() === $task->user->id)
                                        <div class="flex space-x-2">
                                            <a href="{{ route('task-todos.show', $task->id) }}" 
                                                class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-100 transition-colors duration-200"
                                                title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('task-todos.edit', $task->id) }}" 
                                                class="text-green-600 hover:text-green-900 p-1 rounded-full hover:bg-green-100 transition-colors duration-200"
                                                title="Edit Task">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                    class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-100 transition-colors duration-200"
                                                    onclick="confirmDelete('{{ $task->id }}', '{{ Str::limit($task->todo, 30) }}')"
                                                    title="Delete Task">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    @else
                                        <div class="flex space-x-2">
                                            <a href="{{ route('task-todos.show', $task->id) }}" 
                                                class="text-blue-600 hover:text-blue-900 p-1 rounded-full hover:bg-blue-100 transition-colors duration-200"
                                                title="View Details">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($task->todo, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $task->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $task->user->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $task->start_date->format('M d, Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $task->end_date->format('M d, Y') }}</div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No tasks found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @php
            $paginationLimit = $tasks->perPage();
        @endphp

        <div class="mt-4 flex flex-col md:flex-row items-center justify-between">
            <div class="text-sm text-gray-700 mb-4 md:mb-0">
                Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} results
            </div>
            <div class="bg-white px-4 py-3 rounded-lg shadow-md pagination-light {{ ($tasks->total() <= $paginationLimit) ? 'hidden' : '' }}">
                {{ $tasks->appends(request()->except('page'))->links() }}
            </div>
        </div>

        @if($tasks->total() < $paginationLimit && $tasks->total() > 0)
            <div class="mt-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Hasil pencarian hanya menampilkan {{ $tasks->total() }} data. 
                            <span class="font-medium">Coba tambahkan lebih banyak data atau kurangi kriteria filter untuk melihat pagination.</span>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($tasks->total() == 0)
            <div class="mt-4 bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Tidak ada data yang ditemukan. 
                            <span class="font-medium">Coba tambahkan data baru atau sesuaikan kriteria pencarian Anda.</span>
                        </p>
                        <div class="mt-2">
                            <a href="{{ route('task-todos.create') }}" class="text-sm font-medium text-yellow-700 hover:text-yellow-600 underline">
                                + Tambah Task Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-transparent bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4 transform transition-all duration-300 scale-95 opacity-0" id="deleteModalContent">
            <div class="p-6">
                <div class="flex items-center justify-center w-12 h-12 mx-auto bg-red-200 rounded-full mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Konfirmasi Hapus</h3>
                <p class="text-sm text-gray-500 text-center mb-6">
                    Apakah anda yakin ingin menghapus task "<span id="taskName" class="font-medium text-gray-900"></span>"?
                </p>
                <div class="flex justify-center space-x-3">
                    <button type="button" id="cancelDelete" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors duration-200">
                        Gajadi deh
                    </button>
                    <form id="deleteForm" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition-colors duration-200">
                            Hapus dong
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#toggleSearchBtn').click(function() {
                $('#searchForm').slideToggle(300);
                $(this).toggleClass('bg-blue-600 bg-blue-500');
            });
            
            setTimeout(function() {
                $('.bg-green-100, .bg-red-100').fadeOut(300);
            }, 5000);
            
            function handleFormVisibility() {
                if ($(window).width() < 768) {
                    $('#searchForm').addClass('hidden');
                    $('#toggleSearchBtn').removeClass('hidden');
                } else {
                    $('#searchForm').removeClass('hidden');
                    $('#toggleSearchBtn').addClass('hidden');
                }
            }
            
            handleFormVisibility();
            $(window).resize(handleFormVisibility);

            $('#cancelDelete').click(function() {
                closeModal();
            });

            $('#deleteModal').click(function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });
        });

        function confirmDelete(taskId, taskName) {
            $('#taskName').text(taskName);
            $('#deleteForm').attr('action', '/task-todos/destroy/' + taskId);
            
            $('#deleteModal').removeClass('hidden');
            $('#mainContent').addClass('blur-sm');
            $('header').addClass('blur-sm');
            
            setTimeout(() => {
                $('#deleteModalContent').removeClass('scale-95 opacity-0');
                $('#deleteModalContent').addClass('scale-100 opacity-100');
            }, 10);
        }

        function closeModal() {
            $('#deleteModalContent').removeClass('scale-100 opacity-100');
            $('#deleteModalContent').addClass('scale-95 opacity-0');
            
            setTimeout(() => {
                $('#deleteModal').addClass('hidden');
                $('#mainContent').removeClass('blur-sm');
                $('header').removeClass('blur-sm');
            }, 300);
        }
    </script>
@endsection

<style>
    .pagination-light .dark\:bg-gray-800 {
        background-color: white !important;
    }
    
    .pagination-light .dark\:text-gray-400 {
        color: #4a5568 !important;
    }
    
    .pagination-light .dark\:border-gray-700 {
        border-color: #e2e8f0 !important;
    }
    
    .pagination-light .dark\:bg-gray-700 {
        background-color: #f7fafc !important;
    }
    
    #searchForm {
        transition: all 0.3s ease;
    }
    
    @media (max-width: 767px) {
        #searchForm {
            position: relative;
            z-index: 5;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
    }
</style>