<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AccountDeactivate;
use App\Models\Admin;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function showAdmin($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.adminSinglePage', compact('admin'));
    }
    public function adminPage()
    {
        $admin = Auth::user();
        return view('admin.adminSinglePage', compact('admin'));
    }
    public function showAllUsers()
    {
        $allUsers = User::showAllUsers();
        return view('admin.allUsers', ['users' => $allUsers]);
    }

    public function showAllDeactivateUsers()
    {
        $allUsers = User::showAllUsersByStatus1();
        return view('admin.allDeactivateUsers', ['users' => $allUsers]);
    }

    public function updateUserByAdminForm($id)
    {
        $updateUser = User::findOrFail($id);
        return view('admin.updateUserByAdmin', ['user' => $updateUser]);
    }
    public function deactivateUserByAdmin($id)
    {
        Admin::deactivateUser($id);
        $user = User::findOrFail($id);
        $allUsers = User::showAllUsersByStatus1();
        Mail::to($user['email'])->send(new AccountDeactivate($user['email']));
        return redirect()->route('admin.allDeactivateUsersData', ['users' => $allUsers])->with(['success' => 'The user was successfully deactivated!']);
    }
    public function activateUserByAdmin($id)
    {
        Admin::activateUser($id);
        $allUsers = User::showAllUsersByStatus1();
        return redirect()->route('admin.allUsersData', ['users' => $allUsers])->with(['success' => 'The user was successfully activated!']);
    }
    public function deleteUserByAdmin($id)
    {
        User::findOrFail($id)->delete();
        $allUsers = User::showAllUsersByStatus1();
        return redirect()->route('admin.allDeactivateUsersData', ['users' => $allUsers])->with(['success' => 'The user was successfully deleted!']);
    }
    public function addUserByAdminForm()
    {
        return view('admin.registerUser');
    }

    public function addTaskByAdminForm($id)
    {
        return view('admin.addTaskForUser', compact('id'));
    }

    public function addUserByAdmin(Request $request)
    {
        $this->validator($request->all())->validate();
        $this->create($request->all());
        $allUsers = User::showAllUsers();
        return redirect()->route('admin.allUsersData', ['users' => $allUsers])->with(['success' => 'The user data was successfully added!']);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updateUserData($id, Request $request)
    {
        $user = User::findOrFail($id);
        $this->validatorUpdate($request->all())->validate();
        $this->update($user->id, $request->all());
        $allUsers = User::all();
        return redirect()->route('admin.allUsersData', ['users' => $allUsers])->with(['success' => 'The user data was successfully updated!']);
    }
    protected function validatorUpdate(array $data)
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
    protected function validator(array $data)
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
    protected function update(int $id, array $data)
    {
        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();
        return $user;
    }
    public function addTaskDataByAdmin(Request $request, $id)
    {
        $this->validatorTask($request->all())->validate();
        $this->createTask($request->all(), $id);
        $allUsers = User::showAllUsers();
        $user = User::findOrFail($id);
        return redirect()->route('admin.allUsersData', ['users' => $allUsers])
            ->with(['success' => 'The task data for` ' . $user['email'] . ' was successfully added ']);
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
