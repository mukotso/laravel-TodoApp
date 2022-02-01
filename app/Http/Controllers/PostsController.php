<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        alert()->success('welcome to posts');
    return  view('posts.index');

    }

    public function getPosts()
    {
        $response = Http::get('https://jsonplaceholder.typicode.com/posts');

        return $response->json();
    }

    public function store(REQUEST $request){
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'userId' => 'required'
        ]);
        $response=Http::post('https://jsonplaceholder.typicode.com/posts',$request->only('title', 'body', 'userId'));
        return response()->json(json_decode($response));
    }


}
