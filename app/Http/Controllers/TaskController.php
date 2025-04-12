<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::all();
        return response()->json(['task' =>  $tasks]);
    }


    public function store(Request $request)
    {
        $NewTask = Task::create($request->all());

        return response()->json(['task' =>  $NewTask]);
    }

    public function update(Request $request, $id)
    {
        $Task = Task::where('id', $request->id)->update([
            'title' => $request->title,
            'status' => $request->status,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['Response' =>  "Successfully updated"]);
    }

    public function destroy(Request $request)
    {
        Task::destroy($request->id);
        return response()->json(['Response' =>  "Successfully deleted"]);
    }
}
