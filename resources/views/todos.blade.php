@extends('layouts.app')

@section('content')

    @include('sweet::alert');
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
        <form class="search-bar mb-10"  action="{{route('todo.search')}}" method="GET">

            <label>Search Todo :</label>
            <input
                type="text"
                class="w-full
              p-3
              mt-3
              outline-none
              border-b-2 border-green-600
              bg-gray-200

              hover:bg-transparent"
                id="search-bar"
                name="search"
                required
            />
            <button type="submit" class="bg-green-600 hover:bg-blue-500  font-semibold text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                SEARCH
            </button>
        </form>
        @if(session()->has('todo'))
            <div>
                <form  action="{{route('todo.update', session('todo')->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <label class="dark:text-white">EDIT TODO: </label>
                    <input
                        type="text"
                        class="w-full
              p-3
              mt-3
              outline-none
              border-b-2 border-green-600
              bg-gray-200
              hover:bg-transparent
            "
                        name="todo"
                        id="todo"
                        value="{{session('todo')->name}}"
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
                        UPDATE DETAILS
                    </button>
                </form>
            </div>


        @else
            <div>
                <form id="addForm" action="{{route('todo.store')}}" method="post">
                    @csrf
                    <label class="dark:text-white">ADD NEW TODO : </label>
                    <input
                        type="text"
                        class="w-full
              p-3
              mt-3
              outline-none
              border-b-2 border-green-600
              bg-gray-200

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


        @endif

<br>
        <br>

        @if (session('success'))
            <div
                class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4"
                role="alert">
                <div class="p-5 rounded-lg border border-green-400 bg-green-300 text-green-900">
                    <h2 class="font-bold text-xl pb-2">Congratulations!</h2>
                    <p class="pt-2">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif


</div>
<style>
    .grid{
        width:100%;
    }
</style>

        <div class="p-10 grid xs-grid-1   grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10">

            @foreach($todos as $todo)

            <div class="w-full rounded  shadow-lg bg-gray-300 hover:bg-green-600">
                <div class="px-6 py-4">
                    <div class="font-bold text-xl mb-3 mt-3">Todo : {{$todo->name}} </div>
                    <div class="font-bold text-xl mb-3">Status : {{$todo->status}}</div>
                    <div class="font-bold text-xl mb-3">Created at : {{date_format(new DateTime($todo->created_at), 'F j, Y, g:i a') }}</div>
                </div>
                <div class="px-6 pt-4 pb-2">

                    <div class="flex">
                        @if($todo->status!='completed')
                        <form method="get" action="{{ route('todo.complete', $todo->id) }}">
                            @csrf
                            <button type="submit" class="mb-4 bg-green-900 hover:bg-gray-200 hover:text-black  font-semibold text-white sm:py-2 sm:px-4 md:py-4 md:px-8 rounded">
                                MARK AS COMPLETE
                            </button>

                        </form>


                    <form method="get" action="{{ route('todo.edit', $todo->id) }}">
                        @csrf
                        <button type="submit" class=" ml-4 bg-blue-600 hover:bg-blue-500  font-semibold text-white sm:py-2 sm:px-4 md:py-4 md:px-8 border border-blue-500 hover:border-transparent rounded">
                            EDIT
                        </button>

                    </form>


                        <form method="post" action="{{ route('todo.destroy', $todo->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="  ml-4 bg-red-600 hover:bg-blue-500  font-semibold text-white sm:py-2 sm:px-4 md:py-4 md:px-8 border border-blue-500 hover:border-transparent rounded">
                                DELETE
                            </button>

                        </form>

                    @else
                        <button  class=" ml-4 bg-gray-900   font-bold text-white  py-10 px-16  rounded">
                            COMPLETED ON : {{ $todo->updated_at }}
                        </button>
                @endif
                </div>
                </div>
            </div>
            @endforeach




        </div>

        <div class="row">
            <div class="col-md-12">
                {{ $todos->links('pagination::tailwind') }}
            </div>
        </div>



    <footer class="bg-gray-100 text-center lg:text-left">


        <div class="text-center text-gray-700 p-4" style="background-color: rgba(0, 0, 0, 0.2);">
            © 2022 Copyright:
            <a class="text-gray-800" href="https://tailwind-elements.com/">TODO APP CHALLENGE</a>
        </div>
    </footer>



@endsection
