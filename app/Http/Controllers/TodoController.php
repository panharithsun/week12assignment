<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

use App\Models\Todo;

class TodoController extends Controller
{

    // public function __construct() {
    //     $this->middleware('auth:api');
    // }
    // //
    public function index() {

        $publicTodos = Todo::where('status', '=', 'public')->get();
        
        return response([
            'todos' => $publicTodos,
        ]);
    }

    public function get() {
        $todos = auth()->user()->todos()->get();

        return response([
            'todos' => $todos,
        ]);
    }

    public function create(Request $request) {
        $field = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:public,private',
        ]);

        $field['user_id'] = Auth::id();

        $todo = Todo::create($field);

        return response([
            'todo' => $todo,
        ]);
    }

    public function edit(Request $request, $id) {
        $field = $request->validate([
            'title' => 'string',
            'description' => 'string|max:1000',
            'status' => 'in:public,private'
        ]);

        $todo = Todo::find($id);
        
        if($todo->user_id === Auth::id()) {
            $todo->update($field);

            return response([
                'todo' => $todo,
            ], 200);
        } else {
            return response([
                'message' => 'cannot edit other user\'s todo'
            ]);
        }

        
    }

    public function delete($id) {
        $todo = Todo::find($id);
        $todo->delete();

        return response([
            'message' => $todo
        ], 200);
    }
}
