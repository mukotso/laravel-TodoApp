@extends('layouts.app')

@section('content')
    <div class="container justify-center p-5 md:px-52 mx-auto">
        <div class="">
            <h1
                class="
            md:text-5xl
            text-4xl
            py-5
            text-center text-green-600
            font-semibold
          "
            >
                Todo List App
            </h1>
        </div>
        <form class="search-bar mb-10" id="search">
          <label>Search Todo :</label>
          <input
            type="text"
            class="w-full p-3 mt-3 bg-green-50 outline-none"
            id="search-bar"
          />
        </form>
        <div>
            <form  action="{{route('todo.store')}}" method="post">
                @csrf
                <label class="dark:text-white">Add new todo : </label>
                <input
                    type="text"
                    class="w-full
              p-3
              mt-3
              outline-none
              border-b-2 border-green-600
              bg-transparent
              hover:bg-transparent
            "
                    name="todo"
                    id="add-new-todo"
                    required
                />
                <button
                    class="
              w-full
              bg-green-600
              h-12
              text-white
              font-medium
              mt-5
              transform
              hover:scale-95
              transition-all
              focus:outline-none
            "
                    type="submit"
                >
                    Add Todo
                </button>
            </form>
        </div>


        <div class="p-10 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-2 gap-5">
            <!--Card 1-->
            <div class=" w-full rounded overflow-hidden shadow-lg">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-3 mt-3">Todo :</div>
                    <div class="font-bold text-xl mb-3">Status : </div>
                    <div class="font-bold text-xl mb-3">Created at : </div>
                </div>
                <div class="px-6 pt-4 pb-2">
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Mark Completed</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Edit</span>
                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">Delete</span>
                </div>
            </div>





        </div>



    </div>
    </div>





@endsection
