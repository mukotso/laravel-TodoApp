@extends('layouts.app')

@section('content')
@include('sweet::alert')

<div id="addSearchtodo">
<div>
<h2 id="addTodo" >
    <i class="fa fa-plus"> </i> NEW TODO
</h2>
</div>
<div id="search">
    <h2>
        <i class="fa fa-search"> SEARCH</i>
    </h2>
</div>
</div>


    <main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10 hidden"  id="addTodoForm" >
        <div class="flex">
            <div class="w-full">
                <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                    <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                        {{ __('ADD NEW TODO') }}
                    </header>

                    <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" action="{{route('todo.store')}}" method="post">
                        @csrf

                        <div class="flex flex-wrap">

                            <textarea id="todo" type="text"
                                   class="form-input w-full" name="todo"
                                    rows="5" required  autofocus>
                            </textarea>

                        </div>


                        <div class="flex flex-wrap">
                            <button type="submit"
                                    class="w-full mb-5 select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                                <i class="fa fa-plus"> </i> SAVE
                            </button>
                        </div>
                    </form>

                </section>
            </div>
        </div>
    </main>

    <main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10 hidden" id="searchTodoForm" >
        <div class="flex">
            <div class="w-full">
                <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">
                    <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" action="{{route('todo.search')}}" method="GET"  >
                        @csrf

                        <div class="flex flex-wrap">
                            <input id="search" type="search"
                                   class="form-input w-full" name="search" placeholder="search"
                                   required  autofocus>
                        </div>


                        <div class="flex flex-wrap">
                            <button type="submit"
                                    class="w-full mb-5 select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                                <i class="fa fa-search"> </i> SEARCH
                            </button>
                        </div>
                    </form>

                </section>
            </div>
        </div>
    </main>

    @if(session()->has('todo'))
    <main class="sm:container sm:mx-auto sm:max-w-lg sm:mt-10 "  id="editTodoForm">
        <div class="flex">
            <div class="w-full">
                <section class="flex flex-col break-words bg-white sm:border-1 sm:rounded-md sm:shadow-sm sm:shadow-lg">

                    <header class="font-semibold bg-gray-200 text-gray-700 py-5 px-6 sm:py-6 sm:px-8 sm:rounded-t-md">
                        {{ __('EDIT TODO') }}
                    </header>

                    <form class="w-full px-6 space-y-6 sm:px-10 sm:space-y-8" action="{{route('todo.update', session('todo')->id)}}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-wrap">

                            <textarea id="todo" type="text"
                                      class="form-input w-full" name="todo"
                                       rows="5" required  autofocus>{{session('todo')->name}}</textarea>

                        </div>


                        <div class="flex flex-wrap">
                            <button type="submit"
                                    class="w-full mb-5 select-none font-bold whitespace-no-wrap p-3 rounded-lg text-base leading-normal no-underline text-gray-100 bg-blue-500 hover:bg-blue-700 sm:py-4">
                                <i class="fa fa-plus"> </i> UPDATE DETAILS
                            </button>
                        </div>
                    </form>

                </section>
            </div>
        </div>
    </main>
    @endif



</div>



@if (session('success'))
<div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
    <div class="p-5 rounded-lg border border-gre-400 bg-green-300 text-green-900">
        <h2 class="font-bold text-xl pb-2">SUCCESS!</h2>
        <h3 class="pt-2">
            {{ session('success') }}
        </h3>
    </div>
</div>

@elseif(session('error'))
<div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
    <div class="p-5 rounded-lg border bg-red-400 text-green-900">
        <h2 class="font-bold text-xl pb-2">ERROR</h2>
        <h3 class="pt-2">
            {{ session('error') }}
        </h3>
    </div>
</div>
@endif


</div>
<style>
    .grid {
        width: 100%;
    }

</style>

<div class="p-10 grid xs-grid-1   grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-10">
    @forelse($todos as $todo)

    <div class="w-full rounded  shadow-lg bg-gray-300 hover:bg-green-600">
        <div class="px-6 py-4">
            <div class="font-bold text-xl mb-3 mt-3">Todo : {{$todo->name}} </div>
            <div class="font-bold text-xl mb-3">Status : {{$todo->status}}</div>
            <div class="font-bold text-xl mb-3">Created at :
                {{date_format(new DateTime($todo->created_at), 'F j, Y, g:i a') }}</div>
        </div>
        <div class="px-6 pt-4 pb-2">

            <div class="flex">
                @if($todo->status!='completed')
                <form method="get" action="{{ route('todo.complete', $todo->id) }}">
                    @csrf
                    <button type="submit"
                        class=" bg-green-900 rounded py-4 px-4 hover:bg-green-200 text-white font-semibold">
                         COMPLETE
                    </button>
                </form>


                <form method="get" action="{{ route('todo.edit', $todo->id) }}">
                    @csrf
                    <button type="submit"
                        class="bg-blue-600 rounded py-4 px-4 hover:bg-green-900 text-white font-semibold ml-4">
                        <i class="fa fa-edit"></i>
                    </button>

                </form>
                <button type="submit" href="{{route('destroy.todo', $todo->id) }}"
                    class=" ml-4 delete-confirm bg-red-600 rounded py-4 px-4 hover:bg-red-900 text-white font-semibold">
                    <i class="fa fa-trash"></i>
                </button>
                @else
                <button class=" ml-4 bg-gray-900   font-bold text-white  py-10 px-16  rounded">
                    COMPlETED ON : {{$todo->present()->getDateFormated($todo->updated_at)}}
                </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <button  id="notodo" class=" w-full my-auto bg-gray-900   font-bold text-white  py-10 px-16  rounded">
        YOU HAVE NO TODO
    </button>
    @endforelse


</div>

<div class="container">
    {{ $todos->links('pagination::tailwind') }}

</div>






<script src="{{asset('/js/jquery-3.6.0.min.js')}}"></script>
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

        $("#addTodo").click(function () {
            $("#addTodoForm").show();
            $("#searchTodoForm").hide();
        });
        $("#search").click(function () {
            $("#searchTodoForm").show();
            $("#addTodoForm").hide();
        });



    });

</script>


@endsection
