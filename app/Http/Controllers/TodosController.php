<?php

namespace App\Http\Controllers;

use App\Mail\TodoCompletion;
use App\Models\Todo;
use Illuminate\Http\Request;
use Exception;
use App\Notifications\TodoCompletionNotification;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

        return view('todos', compact('todos'));
    }

    public function store(Request $request)
    {

        $ifTodoContainsNumber = preg_match('/\d/', $request->todo);
        if ($ifTodoContainsNumber == 1) {
            return redirect()->back()->with('error','Todo should not contain numbers');

        }
        $this->validate($request, [
            'todo' => ['required', 'string'],
        ]);
        $todo = new Todo();
        $todo->name = strtolower($request->todo);
        $todo->status = 'pending_completion';
        $todo->user_id = Auth()->user()->id;
        $todo->save();
                
        return redirect()->back()->with('success','Todo Added successfully');
    }

    public function edit($id)
    {
        //find todo
        //add it to session
        //redirect back
        $todo = Todo::Find($id);
        session(['todo' => $todo]);
        return redirect()->back();
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'todo' => ['required', 'string'],

        ]);

        $ifTodoContainsNumber = preg_match('/\d/', $request->todo);
        if ($ifTodoContainsNumber == 1) {
            return redirect()->back()->with('error','Invalid Todo name...Todo should not contain numbers');

        }
        $todo = Todo::Find($id);
        $todo->name = strtolower($request->todo);
        $todo->save();
        session()->forget('todo');
        return redirect()->back()->with('success','Todo updated Successfully');
    }

    public function completeTodo($id)
    {
        // DATABASE transactions
        return DB::transaction(function () use ($id) {

            try {
                $todo = Todo::Find($id);
                $todo->status = 'completed';
                $todo->save();

                $user = Auth()->User();
                $details = [
                    'todo' => $todo->name,
                    'name' => $user->name,
                    'date' =>$todo->present()->getDateFormated($todo->updated_at)
                ];

                //Send success email

                //pass data to the notification
//                $user->notify(new TodoCompletionNotification($details));
                Mail::to($user->email)->send(new TodoCompletion($details));
                return redirect()->back()->with('success','Todo Completed and Email Sent  Successfully');
            } catch (Exception $ex) {
                DB::rollBack();
                return redirect()->back()->with('error','An error occured Task completion failed');;
            }
            //try atleat two times before failing
        }, 2);

    }

    public function destroy($id)
    {
        $todo = Todo::Find($id);
        $todo->delete();

        return redirect()->back()->with('success','Todo Deleted  Successfully');
    }


    public function search(Request $request)
    {

        $this->validate($request, [
            'search' => ['required', 'string'],
        ]);

        $search = strtolower($request->search);

        $todos = Todo::where('user_id', Auth()->user()->id)
            ->where('name', 'LIKE', "%{$search}%")
            ->paginate(4);

        if ($todos->isEmpty()) {
            return view('todos', compact('todos'))->with('error','No search result found for the search'.  $search);

        }else{
            return view('todos', compact('todos'));
        }


    }
}











