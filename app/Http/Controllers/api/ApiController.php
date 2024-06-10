<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Task;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $this->validatorLogin($request->all())->validate();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json(['user' => $user], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function register(Request $request)
    {
        $this->validatorReg($request->all())->validate();
        $user = $this->create($request->all());
        Auth::login($user);
        return response()->json(['user' => $user], 201);
    }
    public function findUserByIdApi($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user) {
                return response()->json($user);
            } else {
                return response()->json(['error' => 'User not found'], 404);
            }
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'User not found',
                'user_id' => $id
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to find the user',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function updateUserByIdApi($id, Request $request)
    {
        try {
            $this->validatorUpdateApi($request->all())->validate();
            $this->update($request->all(), $id);
            $user = User::findOrFail($request['id']);
            return response()->json([$user, 'message' => 'User updated successfully'], 200);

        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'User not found',
                'user_id' => $id
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to update the user',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function tasks($id)
    {
        try {
            $tasks = Task::findByUserId($id);
            $user = User::findOrFail($id);
            return response()->json(['All tasks by user Id' => $tasks, 'user' => $user], 200);
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'User not found',
                'user_id' => $id
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to find the tasks',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function task($id)
    {
        try {
            $task = Task::findOrFail($id);
            return response($task, 200);
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'Task not found',
                'task id' => $id
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to find the task',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function taskDelete($id)
    {
        try {
            Task::findOrFail($id)->delete();
            return response()->json(['the task was deleted - with id ' => $id], 404);
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'Task not found',
                'task id' => $id
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to delete the task',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function addTask(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $this->validatorTask($request->all())->validate();
            $this->createTask($request->all(), $id);
            $allTasks = Task::findByUserId($id);
            return response()->json(['all Tasks by User Id ' => $user['id'], 'all Task' => $allTasks], 404);
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'User not found',
                'user_id' => $id
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to add task',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function updateTask(Request $request, $id)
    {
        try {
            $this->validatorTask($request->all())->validate();
            $this->updateTaskApi($request->all(), $id);
            $task = Task::findOrFail($request['id']);
            return response()->json(['Tasks was successfully updated by Id ' => $id, 'task' => $task, 'User Id' => $task['user_id']], 404);
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'Task not found',
                'task id' => $id
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to update task',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function allUsersData()
    {
        $user = User::all();
        return response()->json($user);
    }
    public function deleteUsers($id)
    {
        try {
            User::findOrFail($id)->delete();
            return response()->json(['The User delete -> by id ' => $id], 404);
        } catch (ModelNotFoundException) {
            return response()->json([
                'error' => 'User not found',
                'user_id' => $id
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to update task',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function addTaskByAdmin(Request $request, $Id)
    {
        try {
            $user = User::findOrFail($Id);
            $this->validatorTask($request->all())->validate();
            $this->createTask($request->all(), $Id);
            $allTasks = Task::findByUserId($Id);
            return response()->json(['all Tasks by User Id ' => $user['id'], 'all Task' => $allTasks], 404);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'User not found',
                'user_id' => $Id]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to update task',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function deactivateUser($Id)
    {
        try {
            $user = User::findOrFail($Id);
            Admin::deactivateUser($user['id']);
            return response()->json(['deactivate User by Id ' => $Id], 404);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'User not found',
                'user_id' => $Id]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to update task',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function activateUser($Id)
    {
        try {
            $user = User::findOrFail($Id);
            Admin::activateUser($user['id']);
            return response()->json(['activate User by Id ' => $Id], 404);
        } catch (ModelNotFoundException) {
            return response()->json(['error' => 'User not found',
                'user_id' => $Id]);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error occurred while trying to update task',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    protected function update(array $data, $id)
    {
        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();
        return $user;
    }
    protected function updateTaskApi(array $data, $id)
    {
        $task = Task::findOrFail($id);
        $task->fill($data);
        $task->save();
        return $task;
    }
    protected function validatorReg(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:5'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ], [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 5 characters.',
            'email.regex' => 'Please enter a valid email address.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one digit.',
        ]);
    }
    protected function validatorLogin(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email', 'regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/'],
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'],
        ], [
            'email.regex' => 'Please enter a valid email address.',
            'email.required' => 'The email field is required.',
            'email.exists' => 'Email not found.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.regex' => 'The password must contain at least one uppercase letter, one lowercase letter, and one digit.',
        ]);
    }
    protected function validatorUpdateApi(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255', 'min:5'],
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/'],
        ], [
            'name.required' => 'The name field is required.',
            'name.min' => 'The name must be at least 5 characters.',
            'email.regex' => 'Please enter a valid email address.',
            'email.required' => 'The email field is required.',
        ]);
    }
    public function createTask(array $data, $id)
    {
        return Task::saveTask([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => $id
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
