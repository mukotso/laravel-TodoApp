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
                class="  w-1/3
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
            <button type="submit" class=" sm:w-1/2 md:w-1/6 bg-green-600 hover:bg-blue-500  font-semibold text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">
              <i class="fa fa-search"></i> SEARCH
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
                        class="w-1/3
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
              sm:w-1/2 md:w-1/6
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
                        class="w-1/3
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
              sm:w-1/2 md:w-1/6
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
                        <i class="fa fa-plus"> SAVE </i>
                    </button>
                </form>
            </div>


        @endif

<br>
        <br>

{{--        @if (session('success'))--}}
{{--            <div--}}
{{--                class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4"--}}
{{--                role="alert">--}}
{{--                <div class="p-5 rounded-lg border border-green-400 bg-green-300 text-green-900">--}}
{{--                    <h2 class="font-bold text-xl pb-2">Congratulations!</h2>--}}
{{--                    <p class="pt-2">--}}
{{--                        {{ session('success') }}--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}


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
                            <i class="fa fa-edit"></i>
                        </button>

                    </form>





                                <button type="submit"  href="{{route('destroy.todo', $todo->id) }}" class=" delete-confirm text-align-center  bg-red-600 hover:bg-blue-500  font-semibold text-white p-4 h-10 border border-blue-500 hover:border-transparent rounded">
                                    <i class="fa fa-trash"></i>
                                </button>




                    @else
                        <button  class=" ml-4 bg-gray-900   font-bold text-white  py-10 px-16  rounded">
                            COMPlETED ON : {{$todo->present()->getDateFormated($todo->updated_at)}}
                        </button>
                @endif
                </div>
                </div>
            </div>



            @endforeach


        </div>

        <div class="container">
                {{ $todos->links('pagination::tailwind') }}

        </div>






    <script src="{{asset('/js/jquery-3.3.1.min.js')}}"></script>
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.0.0/sweetalert.min.js"></script>--}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('.delete-confirm').on('click', function (event) {
                event.preventDefault();
                const url = $(this).attr('href');
                swal({
                    title: 'Confirm to delete?',
                    text: 'Are you sure you want to delete this todo?',
                    icon: 'warning',
                    buttons: ["CANCEL", "DELETE"],
                }).then(function (value) {
                    if (value) {
                        window.location.href = url;
                    }
                });
            });
        });


    </script>


@endsection
