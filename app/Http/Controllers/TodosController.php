<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Exception;
use App\Notifications\TodoCompletionNotification;

class TodosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $todos = Todo::where('user_id', Auth()->user()->id)
            ->orderBy('created_at', 'DESC')->paginate(4);
        foreach ($todos as $todo) {
            //date presenter
            $todo->present()->getCreatedAtAttribute($todo->created_at);
            $todo->present()->getCreatedAtAttribute($todo->updated_at);
        }
        return view('todos', compact('todos'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'todo' => ['required', 'string'],

        ]);
        $todo = new Todo();
        $todo->name = strtolower($request->todo);
        $todo->status = 'pending_completion';
        $todo->user_id = Auth()->user()->id;
        $todo->save();
        alert()->success('Todo added Successfully');

        return redirect()->back();
    }

    public function edit($id)
    {
        //find todo
        //add it to session
        //redirect back
        $todo = Todo::Find($id);
        session(['todo' => $todo]);
        alert()->success('Todo added Successfully');
        return redirect()->back();
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'todo' => ['required', 'string'],

        ]);
        $todo = Todo::Find($id);
        $todo->name = strtolower($request->todo);
        $todo->save();
        session()->forget('todo');
        alert()->success('Todo added Successfully');
        return redirect()->back();;
    }

    public function completeTodo($id)
    {
        // DATABASE transactions
        return DB::transaction(function () use ($id) {

            try {
                $todo = Todo::Find($id);
                $todo->status = 'completed';
                $todo->save();

                $details = [
                    'todo' => $todo->name,
                ];

                //Send success email
                $user = Auth()->User();
                //pass data to the notification
                $user->notify(new TodoCompletionNotification($details));

                alert()->success('Todo Completed  and email sent');
                return redirect()->back();
            } catch (Exception $ex) {
                DB::rollBack();
                alert()->error('An error occured Task completion failed')->persistent('OK');
                return redirect()->back();
            }
            //try atleat two times before failing
        }, 2);

    }

    public function destroy($id)
    {
        $todo = Todo::Find($id);
        $todo->delete();
        alert()->success('Todo deleted Successfully');
        return redirect()->back();
    }


    public function search(Request $request)
    {
        $this->validate($request, [
            'todo' => ['required', 'string'],
            ¬¬
        ]);
        $search = strtolower($request->search);
        $todos = Todo::where('user_id', Auth()->user()->id)
            ->where('name', 'LIKE', "%{$search}%")
            ->paginate(4);

        if ($todos->isEmpty()) {
            alert()->info('No Todo Found For the search');
        }

        return view('todos', compact('todos'));
    }
}
