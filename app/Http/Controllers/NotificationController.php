<?php
namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = Notification::where(function ($query) use ($user) {
            $query->where('scope', 'company')
                ->orWhere(function ($query) use ($user) {
                    $query->where('scope', 'department')
                        ->where('target_id', $user->department_id);
                })
                ->orWhere(function ($query) use ($user) {
                    $query->where('scope', 'team')
                        ->where('target_id', $user->team_id);
                });
        })->latest()->get();

        return view('employee.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('employee.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'scope' => 'required|in:company,department,team',
        ]);

        $target_id = null;

        if ($request->scope === 'department') {
            $target_id = Auth::user()->department_id;
        } elseif ($request->scope === 'team') {
            $target_id = Auth::user()->team_id;
        }

        Notification::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'message' => $request->message,
            'scope' => $request->scope,
            'target_id' => $target_id,
        ]);

        return redirect()->route('employee.notifications.index')->with('success', 'Notification posted successfully.');
    }

    public function latest()
{
    $user = auth()->user();
    $notifications = Notification::where('company_id', $user->company_id)
        ->where(function ($query) use ($user) {
            $query->whereNull('department_id')
                  ->orWhere('department_id', $user->department_id);
        })
        ->latest()
        ->take(5)
        ->get();

    return response()->json([
        'count' => $notifications->count(),
        'notifications' => $notifications->map(function ($n) {
            return [
                'id' => $n->id,
                'title' => $n->title,
                'message' => $n->message,
                'created_at' => $n->created_at->diffForHumans()
            ];
        })
    ]);
}

}
