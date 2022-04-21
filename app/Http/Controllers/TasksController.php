<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userID = Auth::id();
        if($userID != null){
            $tasks = User::find($userID)->tasks;
        }
        if($tasks != null){
            return view('tasks.index',compact('tasks'));
        }
        return view('tasks.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate(
            ['todo' => 'required',]
        );

        $task = new Task;

        $task->todo = $request->todo;
        $task->status = 0;
        $task->owner = Auth::user()->name;

        $task->save();

        $task->users()->attach(Auth::id());

        return redirect()->route('tasks.index')
                        ->with('success','Task created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update task to done
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function makeDone($id)
    {
        Task::where('id', $id)->update(array('status' => '1'));

        return $this->index();
    }

    /**
     * Update task to done
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function share(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        User::where('name', $request->name)->tasks()->attach($id);

        return redirect()->route('tasks.index')
                        ->with('success','Task created successfully.');
    }
}
