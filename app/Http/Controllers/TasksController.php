<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Helpers\CollectionHelper;

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
        } else {
            $tasks = null;
        }
        $tasks = CollectionHelper::paginate($tasks, 10);
        return view('tasks.index',compact('tasks'));
    }

    public function filter(Request $request)
    {
        $request->validate([
            'category' => 'required'
        ]);
        $userID = Auth::id();
        if($userID != null){
        switch($request->category){
            case('1'):
                $tasks = User::find($userID)->tasks->where('category_id', 1);
                break;
            case('2'):
                $tasks = User::find($userID)->tasks->where('category_id', 2);
                break;
            case('3'):
                $tasks = User::find($userID)->tasks->where('category_id', 3);
                break;
            case('4'):
                $tasks = User::find($userID)->tasks->where('category_id', 4);
                break;
            case('5'):
                return $this->index();
            case('6'):
                $tasks = User::find($userID)->tasks->where('owner', Auth::user()->name);
                break;
            case('7'):
                $tasks = User::find($userID)->tasks->where('owner', '!=' , Auth::user()->name);
                break;
            case('8'):
                $tasks = User::find($userID)->tasks->where('status', true);
                break;
            case('9'):
                $tasks = User::find($userID)->tasks->where('status', false);
                break;
        }
        } else {
            $tasks = null;
        }
        return view('tasks.index',compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'todo' => 'required',
            'category' => 'required'
        ]);
        if($request->category == -1){
            return $this->index()->withErrors(['msg' => 'You did not enter a category!!!']);;
        }

        $task = new Task;

        $task->todo = $request->todo;
        $task->category_id = $request->category;
        $task->status = 0;
        $ownerName = Auth::user()->name;
        $task->owner = $ownerName;
        $task->save();

        $task->users()->attach(Auth::id($ownerName));

        return $this->index();
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
        $user = User::where('name', $request->name)->first();
        if($user != null){
            $task = $user->tasks()->where('task_id', $id)->first();
            if ($task == null) {
                $user->tasks()->attach($id);
            }
            return $this->index()->with('message', 'Share succes!!!');;
        } else {
            return $this->index()->withErrors(['msg' => 'User doesnt exist!!!']);;
        }

    }
}
