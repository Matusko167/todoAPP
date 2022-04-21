@extends('layouts.app')

@section('content')
<section class="vh-100" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-lg-9 col-xl-7">
          <div class="card rounded-3">
            <div class="card-body p-4">
              <form method="post" action="/tasks">
                @csrf
                <h1>New task</h1>
                 <div class="col-12 ">
                    <input type="text" id="todo" class="form-control" placeholder="Enter a task here" />
                    <button type="submit" class="btn btn-primary p-1">Save</button>
                </div>
              </form>
              <table class="table mb-4">
                <thead>
                  <tr>
                    <th scope="col">Owner</th>
                    <th scope="col">Todo item</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @if ($tasks != null)
                    @foreach ($tasks as $task)
                  <tr>
                    <td>{{$task->owner}}</td>
                    <td>{{$task->todo}}</td>
                    @if ($task->status == true)
                        <td>Completed</td>
                    @else
                        <td>In progres</td>
                    @endif
                    <td>
                    @if(Auth::user()->name == $task->owner)
                      <button type="submit" class="btn btn-danger p-1">Delete</button>
                    @endif
                    @if ($task->status != true)
                    <form name="makeTaskDone" id="makeTaskDone" method="post" action="/tasks/{{$task->id}}">
                        @csrf
                         <button type="submit" class="btn btn-success ms-1 p-1">Finished</button>
                       </form>
                    </td>
                    @endif
                    <td>
                      @if(Auth::user()->name == $task->owner)
                        <form method="post" action="/tasks/share/{{$task->id}}">
                            @csrf
                            <input type="text" id="name" class="form-control p-1" placeholder="Name to share" />
                            <button type="submit" class="btn btn-warning p-1">Share</button>
                        </form>
                    @endif

                  </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
