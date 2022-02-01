<?php

namespace App\Http\Controllers;
use App\Models\Todo;
use Illuminate\Http\Request;

use App\Notifications\TodoCompletionNotification;
class TodosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

        $todos=Todo::where('user_id', Auth()->user()->id)
            ->orderBy('created_at','DESC')->paginate(4);
        foreach($todos as $todo){
            $todo->present()-> getCreatedAtAttribute($todo->created_at);

        }


        return view('todos',compact('todos'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'todo' => ['required', 'string'],

        ]);
        $todo=new Todo();
        $todo->name=strtolower($request->todo);
        $todo->status='pending_completion';
        $todo->user_id=Auth()->user()->id;
        $todo->save();
        alert()->success('Todo added Successfully');

        return redirect()->back();
    }

    public function edit($id)
    {
        //find todo
        //add it to session
        //redirect back
        $todo=Todo::Find($id);
        session(['todo'=>$todo]);
        return redirect()->back();
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'todo' => ['required', 'string'],

        ]);
        $todo=Todo::Find($id);
        $todo->name=strtolower($request->todo);
        $todo->save();
        session()->forget('todo');

        return redirect()->back()->with('success','Todo updated succcessfully');;
    }

    public function completeTodo($id)
    {
        $todo=Todo::Find($id);
        $todo->status='completed';
        $todo->save();

        $details = [
            'todo' => $todo->name,
        ];

        //Send success email
        $user=Auth()->User();
        $user->notify(new TodoCompletionNotification($details));

        return redirect()->back()->with('success','Todo updated successfully and Email Sent');

    }

    public function destroy($id)
    {
        $todo=Todo::Find($id);
        $todo->delete();
        return redirect()->back();
    }



    public function search(Request $request){
        $this->validate($request, [
            'todo' => ['required', 'string'],

        ]);
        $search=strtolower($request->search);
        $todos=Todo::where('user_id', Auth()->user()->id)
            ->where('name', 'LIKE', "%{$search}%")
            ->paginate(4);

        return view('todos',compact('todos'));
    }
}
