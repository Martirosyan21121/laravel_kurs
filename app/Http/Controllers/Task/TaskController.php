<?php

namespace App\Http\Controllers\Task;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function addTaskForm()
    {
        return view('tasks.addTask');
    }

    public function allTasks()
    {
        return view('tasks.allTasks');
    }

    public function addTaskData(Request $request)
    {
        $this->validatorTask($request->all())->validate();
        $this->create($request->all());
        $userId = Auth::id();
        return redirect()->route('tasks.allTasks', $userId)->with('success', 'The task successfully added!');
    }

    public function create(array $data)
    {
        return Task::saveTask([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => Auth::id()
        ]);
    }
    protected function validatorTask(array $data)
    {
        return Validator::make($data, [
            'title' => ['required', 'string'],
        ], [
            'title.required' => 'The title field is required.',
        ]);
    }
}
