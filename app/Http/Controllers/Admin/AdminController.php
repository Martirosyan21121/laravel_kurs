<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function showAdmin($id)
    {
        $admin = User::findOrFail($id);
        return view('admin.adminSinglePage', compact('admin'));
    }
    public function showAllUsers()
    {
        $allUsers = User::showAllUsers();
        return view('admin.allUsers', ['users' => $allUsers]);
    }
    public function updateUserByAdminForm($id)
    {
        $updateUser = User::findOrFail($id);
        return view('admin.updateUserByAdmin', ['user' => $updateUser]);
    }
    public function deactivateUserByAdmin($id)
    {
        Admin::deactivateUser($id);
        $allUsers = User::showAllUsersByStatus1();
        return view('admin.deactivateUsers', ['user' => $allUsers]);
    }
    public function updateUserData($id, Request $request)
    {
        $user = User::findOrFail($id);
        $this->validatorUpdate($request->all())->validate();
        $this->update($user->id, $request->all());
        $allUsers = User::all();
        return view('admin.allUsers' , ['users' => $allUsers])->with(['success' => 'The user data was successfully updated!']);
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

    protected function update(int $id, array $data)
    {
        $user = User::findOrFail($id);
        $user->fill($data);
        $user->save();
        return $user;
    }
}
