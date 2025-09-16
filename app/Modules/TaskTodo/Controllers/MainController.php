<?php

namespace App\Modules\TaskTodo\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Modules\Auth\Models\User;
use App\Modules\TaskTodo\Models\Task;
use App\Modules\TaskTodo\Models\UserPosition;
use App\Modules\TaskTodo\Models\Position;

class MainController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Task::with('user', 'user.positions');

            // Pencarian berdasarkan keyword
            if ($request->has('search') && !empty($request->search)) {
                $search = strtolower($request->search);
                $query->where(function($q) use ($search) {
                    $q->whereRaw('LOWER(todo) LIKE ?', ['%' . $search . '%'])
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->whereRaw('LOWER(name) LIKE ?', ['%' . $search . '%'])
                            ->orWhereRaw('LOWER(email) LIKE ?', ['%' . $search . '%']);
                    });
                });
            }
            
            // Filter berdasarkan user
            if ($request->has('user_id') && !empty($request->user_id)) {
                $query->where('user_id', $request->user_id);
            }
            
            // Filter berdasarkan tanggal
            if ($request->has('start_date') && !empty($request->start_date)) {
                $query->whereDate('start_date', '>=', $request->start_date);
            }
            
            if ($request->has('end_date') && !empty($request->end_date)) {
                $query->whereDate('end_date', '<=', $request->end_date);
            }
            
            // Sorting
            $sortField = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            
            $query->orderBy($sortField, $sortDirection);
            
            $tasks = $query->paginate(10)->appends($request->all());
            $users = User::orderBy('name')->get();

            Log::channel('audit')->info('User viewed tasks list', [
                'user_id' => Auth::id(),
                'action' => 'view_tasks',
                'search_params' => $request->all()
            ]);

            return view('source::TaskTodo.Views.index', compact('tasks', 'users'));
        } catch (\Exception $e) {
            Log::channel('audit')->error('Error viewing tasks', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Failed to load tasks');
        }
    }

    public function create()
    {
        try {
            $users = User::orderBy('name')->get();

            Log::channel('audit')->info('User accessed task creation form', [
                'user_id' => Auth::id(),
                'action' => 'view_create_form',
            ]);

            return view('source::TaskTodo.Views.create', compact('users'));
        } catch (\Exception $e) {
            Log::channel('audit')->error('Error accessing creation form', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()->with('error', 'Failed to load form');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|uuid|exists:users,id',
                'todo' => 'required|string|max:1000',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date'
            ]);

            $task = Task::create($validated);

            Log::channel('audit')->info('Task created', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'action' => 'create_task',
            ]);

            return redirect()->route('task-todos.index')
                ->with('success', 'Task created successfully!');
        } catch (\Exception $e) {
            Log::channel('audit')->error('Error creating task', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create task');
        }
    }

    public function show($id)
    {
        try {
            $task = Task::with('user', 'user.positions')->findOrFail($id);

            Log::channel('audit')->info('User viewed task', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'action' => 'view_task',
            ]);

            return view('source::TaskTodo.Views.show', compact('task'));
        } catch (\Exception $e) {
            Log::channel('audit')->error('Error viewing task', [
                'user_id' => Auth::id(),
                'task_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('task-todos.index')
                ->with('error', 'Task not found');
        }
    }

    public function edit($id)
    {
        try {
            $task = Task::findOrFail($id);

            if (Auth()->check() && Auth()->id() !== $task->user->id) {
                return redirect()->route('task-todos.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengupdate data ini.');
            }

            $users = User::orderBy('name')->get();

            Log::channel('audit')->info('User accessed edit form', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'action' => 'view_edit_form',
            ]);

            return view('source::TaskTodo.Views.edit', compact('task', 'users'));
        } catch (\Exception $e) {
            Log::channel('audit')->error('Error accessing edit form', [
                'user_id' => Auth::id(),
                'task_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('task-todos.index')
                ->with('error', 'Task not found');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $task = Task::findOrFail($id);

            if (Auth()->check() && Auth()->id() !== $task->user->id) {
                return redirect()->route('task-todos.index')
                    ->with('error', 'Anda tidak memiliki akses untuk mengupdate data ini.');
            }
            
            $validated = $request->validate([
                'user_id' => 'required|uuid|exists:users,id',
                'todo' => 'required|string|max:1000',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date'
            ]);

            $oldData = $task->toArray();
            $task->update($validated);

            Log::channel('audit')->info('Task updated', [
                'user_id' => Auth::id(),
                'task_id' => $task->id,
                'action' => 'update_task',
                'old_data' => $oldData,
                'new_data' => $validated
            ]);

            return redirect()->route('task-todos.index')
                ->with('success', 'Task updated successfully!');
        } catch (\Exception $e) {
            Log::channel('audit')->error('Error updating task', [
                'user_id' => Auth::id(),
                'task_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update task');
        }
    }

    public function destroy($id)
    {
        try {
            $task = Task::findOrFail($id);
            if (Auth()->check() && Auth()->id() !== $task->user->id) {
                return redirect()->route('task-todos.index')
                    ->with('error', 'Anda tidak memiliki akses untuk menghapus data ini.');
            }

            $taskData = $task->toArray();
            $task->delete();

            Log::channel('audit')->info('Task deleted', [
                'user_id' => Auth::id(),
                'task_id' => $id,
                'action' => 'delete_task',
                'deleted_data' => $taskData
            ]);

            return redirect()->route('task-todos.index')
                ->with('success', 'Task deleted successfully!');
        } catch (\Exception $e) {
            Log::channel('audit')->error('Error deleting task', [
                'user_id' => Auth::id(),
                'task_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('task-todos.index')
                ->with('error', 'Failed to delete task');
        }
    }

    public function editProfile()
    {
        $user = Auth::user();
        $positions = DB::table('positions')->get();
        $userPositions = DB::table('user_positions')
            ->where('user_id', $user->id)
            ->pluck('position_id')
            ->toArray();

        return view('source::Auth.Views.profile', compact('user', 'positions', 'userPositions'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $passwordChanged = false;

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|min:3',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'positions' => 'nullable|array',
            'positions.*' => 'exists:positions,id',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed|different:current_password',
        ], [
            'name.required' => 'Nama harus diisi',
            'name.min' => 'Nama minimal 3 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'new_password.min' => 'Password baru minimal 8 karakter',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai',
            'new_password.different' => 'Password baru harus berbeda dengan password lama',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()
                    ->withErrors(['current_password' => 'Password lama tidak sesuai'])
                    ->withInput();
            }
            
            $passwordChanged = true;
        }

        DB::beginTransaction();

        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('new_password')) {
                $userData['password'] = Hash::make($request->new_password);
            }

            $user->update($userData);

            if ($request->has('positions')) {
                DB::table('user_positions')
                    ->where('user_id', $user->id)
                    ->delete();

                foreach ($request->positions as $positionId) {
                    DB::table('user_positions')->insert([
                        'id' => \Illuminate\Support\Str::uuid(),
                        'user_id' => $user->id,
                        'position_id' => $positionId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            DB::commit();

            Log::channel('audit')->info('Profile updated successfully', [
                'user_id' => $user->id,
                'action' => 'profile_update',
                'password_changed' => $passwordChanged,
                'ip_address' => $request->ip(),
            ]);

            if ($passwordChanged) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('login')
                    ->with('status', 'Profil berhasil diperbarui! Silakan login kembali dengan password baru Anda.');
            }

            return redirect()->route('profile')
                ->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::channel('audit')->error('Error updating profile', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'ip_address' => $request->ip(),
            ]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil.')
                ->withInput();
        }
    }
}