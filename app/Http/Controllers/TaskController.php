<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Order;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //dd('hello');
        //$user = User::where('id','1')->get()->first();

        $user = new User();
        $user->name = "zulfi khan";
        $user->email = "aliii@khan.com";
        $user->email_verified_at = now();
        $user->password = bcrypt("password");
        $user->save();

        $user->orders()->create([
            'qty' => 15,
            'total' => 154
        ]);
        dd($user->save());

        bcrypt('password');

        $tasks = Task::orderBy('id', 'asc')->get();
        //$tasks['abc'] = 'this is errors';
        return response()
            ->json($tasks, 200);
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        return response()
            ->json(['status' => true, 'message' => "Email sent successfully."]);

        dd('hi');
        dd($validated = $request->validated());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        dump($task);
        die;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task->task_name = $request->get('name');
        $task->save();
        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
