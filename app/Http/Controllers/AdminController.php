<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Validation\ValidationException;

class AdminController extends Controller
{
    public function index()
    {
        if(! auth()->user()->permissions['user_manage']){
            abort(403);
        }

        if(! auth()->user()->permissions['superadmin']){
            $users = User::whereNotIn('role', [1])->paginate(10);
        } else {
            $users = User::paginate(10); 
        }

        return Inertia::render('admin/user/index', ['users' => $users]);
    }

    public function create(){
        return inertia::render('admin/user/create');
    }
    public function store(Request $request, Redirector $redirector){
        try {

            if((!auth()->user()->permissions['user_manage']) || ($$request['role'] == 1)){
                abort(403);
            }

            $validated= $request->validate([
                'username' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'role' => 'required|numeric',
                'active' => 'boolean'
            ]);

            User::create($validated);
            return $redirector->route('user.index')->with([
                'message' => 'User created successfully',
                'type' => 'success'
            ]);

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while Creating the user.' .  $e->getMessage(),
                'type' => 'error'
            ]);  
        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while creating the user.',
                'type' => 'error'
            ]);
        }
    }
    public function edit(User $user)
    {
        if((! auth()->user()->permissions['user_manage']) || ($user['role'] == 1)){

            abort(403);

        } else {

            $user_data = User::find($user['id']);
            return inertia::render('admin/user/edit', [
                'user' => $user_data,
            ]);

        }

    }
    public function update(Request $request, User $user, Redirector $redirector){
        try {

            if((! auth()->user()->permissions['user_manage']) || ($request->input('role') == 1)){
                abort(403);
            }

            $rules = [
                'username' => 'required|max:255',
                'email' => 'required|email|unique:users,email,'. $user->id ,
                'role' => 'required|numeric',
                'active' => 'boolean',
                'change_password' => 'boolean',
            ];

            if ($request->input('change_password')) {
                $rules['password'] = 'required|confirmed';
            }
        
            $request->validate($rules);

            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $user->role = $request->input('role');
            $user->active = $request->input('active');
        
            if ($request->input('change_password')) {
                $user->password = bcrypt($request->input('password'));
            }
        
            $user->save();

            return $redirector->route('user.index')->with([
                'message' => 'User updated successfully',
                'type' => 'success'
            ]);

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while updating the user.' .  $e->getMessage(),
                'type' => 'error'
            ]);        
        
        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while updating the user.' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function destroy(User $user, Redirector $redirector)

    {
        try {
            if($user->role != 1){
                $user->delete();
            } else {
                abort(403);
            }

        } catch (\Exception $e) {
            return $redirector->route('user.index')->with([
                'message' => 'An error occurred while deleting the user.' . $e->getMessage() ,
                'type' => 'error'
            ]);
        }
        return $redirector->route('user.index')->with([
            'message' => 'User deleted successfully',
            'type' => 'success'
        ]);

    }

    public function activate(User $user, Redirector $redirector)
    {

        if ( $user->role == 1 ) {
                return $redirector->route('user.index')->with([
                'message' => 'You do not have permission to perform this action.',
                'type' => 'error'
            ]);
        }

        // Proceed with activation logic
        $user->active = ! $user->active;
        $user->save();

        return $redirector->route('user.index')->with([
            'message' => 'User activation is switched successfully',
            'type' => 'success'
        ]);

    }


}
