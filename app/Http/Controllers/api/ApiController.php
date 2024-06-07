<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function showData()
    {
        $user = User::all();
        return response()->json($user);
    }

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
        $user = User::findOrFail($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function deleteUserByIdApi($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
            return response()->json([$user, 'message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    public function updateUserByIdApi($id, Request $request)
    {
        $this->validatorUpdateApi($request->all())->validate();
        $this->update($request->all(), $id);
        $user = User::findOrFail($request['id']);

        return response()->json([$user, 'message' => 'User updated successfully'], 200);
    }

    public function tasks($id)
    {
        $tasks = Task::findByUserId($id);
        $user = User::findOrFail($id);
        return response()->json(['All tasks by user Id' => $tasks, 'user' => $user], 200);
    }

    public function task($id)
    {
        $task = Task::findOrFail($id);
        return response($task,  200);
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
}
