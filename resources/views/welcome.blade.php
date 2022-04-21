@extends('layouts.app')

@section('content')

    <div class="bg-image"
     style="background-image: url('https://mdbootstrap.com/img/Photos/Others/images/76.jpg');
            height: 100vh">
            @auth
            <div class="d-flex p-2 justify-content-center">
                <a type="button" class="btn btn-primary btn-lg" href="/tasks">TodoList</a>
            </div>
            @endauth
            @guest
            <div class="d-flex p-2 justify-content-center">
                <h1>Login or register to continue   </h1>
            </div>
            @endguest

</div>
@endsection
