@extends('layouts.app')

@section('content')
<section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 col-xl-7">
          <div class="card rounded-3 justify-content-center align-items-center">
            <form method="get" action="{{ route('tasks.filter') }}">
                <div class="filters p-2">
                    <select name="category" id="category" class="custom-select">
                        <option selected>Select filter</option>
                        <option value="5">All</option>
                        <option value="6">Mine</option>
                        <option value="7">Shared</option>
                        <option value="8">Done</option>
                        <option value="9">In progres</option>
                        <option value="1">School</option>
                        <option value="2">Work</option>
                        <option value="3">Sport</option>
                        <option value="4">Family</option>
                    </select>
                    <button class="do-filter">Filter</button>
                </div>
            </form>
            <div class="card-body p-4 justify-content-center align-items-center">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
              <form method="post" action="{{ route('tasks.store') }}">
                @csrf
                <h1>New task</h1>
                 <div class="col-12 ">
                    <input type="text" name="todo" id="todo" class="form-control" placeholder="Enter a task here" />
                    <select name="category" id="category" class="custom-select">
                        <option value="-1" selected>Select category</option>
                        <option value="1">School</option>
                        <option value="2">Sport</option>
                        <option value="3">Work</option>
                        <option value="4">Family</option>
                      </select>
                    <button type="submit" class="btn btn-primary p-1">Save</button>
                </div>
              </form>
              <table class="table mb-4">
                <thead>
                  <tr>
                    <th scope="col">Owner</th>
                    <th scope="col">Todo item</th>
                    <th scope="col">Category</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @if ($tasks != null)
                        @foreach ($tasks as $task)
                        @if ($task->status == true)
                        <tr class="bg-success">
                        @else
                        <tr>
                        @endif
                        <td>{{$task->owner}}</td>
                        <td>{{$task->todo}}</td>
                        <td>{{$task->category->name}}</td>
                        @if ($task->status == true)
                            <td>Completed</td>
                        @else
                            <td>In progres</td>
                        @endif
                        <td>
                        @if(Auth::user()->name == $task->owner)
                            @if ($task->status != true)
                            <form name="makeTaskDone" id="makeTaskDone" method="post" action="/tasks/{{$task->id}}">
                                @csrf
                                <button type="submit" class="btn btn-success ms-1 p-1">Finished</button>
                            </form>
                            </td>
                            <td>
                                <form method="post" action="{{ url('tasks/share', $task->id) }}">
                                    @csrf
                                    <input type="text" name="name" id="name" class="form-control p-1" placeholder="Name to share" />
                                    <button type="submit" class="btn btn-warning p-1">Share</button>
                                </form>
                            @endif
                        @endif
                        </tr>
                    @endforeach
                  @endif
                </tbody>
            </table>
        </div>
        </div class="p-4 justify-content-center align-items-center">
            {{$tasks->links()}}
        </div>
      </div>
    </div>
  </section>
@endsection
