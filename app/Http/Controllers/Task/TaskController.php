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
        $userId = Auth::id();
        $allTasks = Task::findByUserId($userId);
        return view('tasks.allTasks', ['tasks' => $allTasks]);
    }
    public function deleteTask($taskId)
    {
        Task::deleteTask($taskId);
        $userId = Auth::id();
        $allTasks = Task::findByUserId($userId);
        return redirect()->route('tasks.allTasks')->with(['tasks' => $allTasks, 'success' => 'The task was successfully deleted!']);
    }
    public function updateTaskForm($taskId)
    {
        $task = Task::findTaskById($taskId);
        return view('tasks.updateTask', ['task' => $task]);
    }
    public function updateTaskStatus(Request $request, $taskId)
    {
        $status = $request->query('status');
        $task = Task::findOrFail($taskId);
        $task->status = $status;
        $task->save();
    }
    public function updateTask($taskId, Request $request)
    {
        $task = Task::findTaskById($taskId);
        $this->validatorTask($request->all())->validate();
        $task->update($request->all());
        $userId = Auth::id();
        $allTasks = Task::findByUserId($userId);
        return redirect()->route('tasks.allTasks')->with(['tasks' => $allTasks, 'success' => 'The task was successfully updated!']);
    }
    public function addTaskData(Request $request)
    {
        $this->validatorTask($request->all())->validate();
        $this->create($request->all());
        $userId = Auth::id();
        $allTasks = Task::findByUserId($userId);
        return redirect()->route('tasks.allTasks')->with(['tasks' => $allTasks, 'success' => 'The task was successfully added!']);
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
            'description' => ['required', 'string'],
        ], [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
        ]);
    }
}
