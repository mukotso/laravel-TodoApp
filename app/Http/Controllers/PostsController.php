<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->client = new Client();
    }

    public function index()
    {

        return view('posts.index');

    }

    public function getPosts()
    {
        $response = $this->client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
     return $response->getBody();

    }

    public function store(REQUEST $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'userId' => 'required'
        ]);
        $response = $this->client->request('POST', 'https://jsonplaceholder.typicode.com/posts', [
            'form_params' => [
                'title' => $request->title,
                'body' => $request->body,
                'userId' => $request->userId
            ]
        ]);
        return $response->getBody();
    }

    public function destroy($id)
    {
        $response = $this->client->request('DELETE', 'https://jsonplaceholder.typicode.com/posts/' . $id);
        return $response->getBody();
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
        ]);

        $response = $this->client->request('PUT', 'https://jsonplaceholder.typicode.com/posts/' . 1,
            [
                'form_params' => [
                    'title' => $request->title,
                    'body' => $request->body,
                ]
            ]
        );
        return $response->getBody();
    }


}
