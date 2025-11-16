<?php
namespace App\Http\Controllers\Couple;

use App\Http\Controllers\Controller;
use App\Models\WeddingTodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TodoController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $profile = Auth::user()->coupleProfile;
        
        if (!$profile) {
            return redirect()->route('couple.profile.create');
        }

        $todos = $profile->todos()->orderBy('is_completed')
                         ->orderBy('due_date')
                         ->orderBy('priority', 'desc')
                         ->paginate(20);
        
        $stats = [
            'total' => $profile->todos()->count(),
            'completed' => $profile->todos()->completed()->count(),
            'pending' => $profile->todos()->pending()->count(),
            'overdue' => $profile->todos()->overdue()->count(),
        ];

        return view('couple.todos.index', compact('profile', 'todos', 'stats'));
    }

    public function store(Request $request)
    {
        $profile = Auth::user()->coupleProfile;
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after:today',
        ]);

        $validated['sort_order'] = $profile->todos()->count() + 1;
        
        $profile->todos()->create($validated);

        return redirect()->route('couple.todos.index')
                        ->with('success', 'Task added successfully!');
    }

    public function update(Request $request, WeddingTodo $todo)
    {
        $this->authorize('update', $todo);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date',
            'is_completed' => 'boolean',
        ]);

        if (isset($validated['is_completed']) && $validated['is_completed'] && !$todo->is_completed) {
            $validated['completed_at'] = now();
        } elseif (isset($validated['is_completed']) && !$validated['is_completed']) {
            $validated['completed_at'] = null;
        }

        $todo->update($validated);

        return redirect()->route('couple.todos.index')
                        ->with('success', 'Task updated successfully!');
    }

    public function toggle(WeddingTodo $todo)
    {
        $this->authorize('update', $todo);
        
        $todo->update([
            'is_completed' => !$todo->is_completed,
            'completed_at' => !$todo->is_completed ? now() : null,
        ]);

        return redirect()->route('couple.todos.index')
                        ->with('success', 'Task status updated!');
    }

    public function destroy(WeddingTodo $todo)
    {
        $this->authorize('delete', $todo);
        
        $todo->delete();

        return redirect()->route('couple.todos.index')
                        ->with('success', 'Task deleted successfully!');
    }

    public function suggestions()
    {
        $profile = Auth::user()->coupleProfile;
        
        $suggestions = [
            ['title' => 'Book wedding venue', 'priority' => 'high', 'description' => 'Research and book your dream wedding venue'],
            ['title' => 'Hire wedding photographer', 'priority' => 'high', 'description' => 'Find and book a photographer for your special day'],
            ['title' => 'Send save the dates', 'priority' => 'medium', 'description' => 'Send save the date cards to your guests'],
            ['title' => 'Order wedding invitations', 'priority' => 'medium', 'description' => 'Design and order your wedding invitations'],
            ['title' => 'Book catering service', 'priority' => 'high', 'description' => 'Choose and book catering for your reception'],
            ['title' => 'Find wedding dress', 'priority' => 'high', 'description' => 'Shop for and purchase your wedding dress'],
            ['title' => 'Book wedding cake', 'priority' => 'medium', 'description' => 'Order your wedding cake from a bakery'],
            ['title' => 'Arrange flowers', 'priority' => 'medium', 'description' => 'Book florist for bridal bouquet and decorations'],
            ['title' => 'Plan honeymoon', 'priority' => 'low', 'description' => 'Research and book your honeymoon destination'],
            ['title' => 'Apply for marriage license', 'priority' => 'high', 'description' => 'Apply for your marriage license at local office'],
        ];

        foreach ($suggestions as $index => $suggestion) {
            $profile->todos()->create([
                'title' => $suggestion['title'],
                'description' => $suggestion['description'],
                'priority' => $suggestion['priority'],
                'sort_order' => $profile->todos()->count() + $index + 1,
            ]);
        }

        return redirect()->route('couple.todos.index')
                        ->with('success', 'Wedding planning suggestions added to your todo list!');
    }
}
