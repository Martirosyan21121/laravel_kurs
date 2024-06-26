<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\MyTestEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function home()
    {
        return view('home');
    }
    public function showRegistrationForm()
    {
        return view('user.register');
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.userSinglePage', compact('user'));
    }
    public function userSinglePage()
    {
        $userId = Auth::id();
        return redirect()->route('user.userSinglePage', $userId);
    }
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $user = $this->create($request->all());
        Auth::login($user);
//        Mail::to($user['email'])->send(new MyTestEmail($user['name'], $user['email'], $user['created_at']));
        return redirect()->route('user.userSinglePage', $user->id)->with('success', 'You are successfully registered!');
    }
    public function loginForm()
    {
        return view('user.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $this->validatorLogin($request->all())->validate();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userId = $user['id'];
            if ($user['status'] == 1){
                return view('user.deactivatePage');
            } else if (isset($user->type) && $user->type === 'ADMIN') {
                return redirect()->route('admin.adminSinglePage', $userId)->with('successLogin', 'You are successfully login in to admin page!');
            } else {
                return redirect()->route('user.userSinglePage', $userId)->with('successLogin', 'You are successfully login!');
            }
        }
        return back()->withErrors([
            'email' => 'Wrong email or password',
        ])->withInput($request->except('password'));
    }
    public function updateDataForm()
    {
        $user = Auth::user();
        return view('user.update', ['user' => $user])->with('successLogin', 'You are successfully login in to admin page!');
    }
    public function updateData(Request $request)
    {
        $userId = Auth::id();
        $this->validatorUpdate($request->all())->validate();
        $this->update($request->all());
        return redirect()->route('user.userSinglePage', $userId)->with('successUpdate', 'You are successfully update your account!');
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
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    protected function update(array $data)
    {
        $user = Auth::user();
        $user->fill($data);
        $user->save();
        return $user;
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('successLogout', 'You are successfully logged out!');
    }
}
