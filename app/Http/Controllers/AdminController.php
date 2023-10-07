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
        $users = User::paginate(10); // Paginate with 10 users per page
        return Inertia::render('admin/user/index', ['users' => $users]);
    }

    public function create(){
        return inertia::render('admin/user/create');
    }
    public function store(Request $request, Redirector $redirector){
        try {

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
            return back()->withErrors($e->errors())->withInput();
        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while creating the user.',
                'type' => 'error'
            ]);
        }
    }
    public function edit(User $user)
    {
        $user_data = User::find($user['id']);
        return inertia::render('admin/user/edit', [
            'user' => $user_data,
        ]); 
    }
    public function update(Request $request, User $user, Redirector $redirector){
        try {

            $validated= $request->validate([
                'username' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|confirmed',
                'role' => 'required|numeric',
                'active' => 'boolean'
            ]);

            $user->update($validated);

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
                'message' => 'An error occurred while updating the user.',
                'type' => 'error'
            ]);
        }
    }

    public function destroy(User $user, Redirector $redirector)

    {
    // Authorization (Example, modify based on your requirements)
    // if (!auth()->user()->can('delete', $user)) {
    //     return response()->json(['message' => 'Unauthorized'], 403);
    // }

    try {
        $user->delete();
    } catch (\Exception $e) {
        return $redirector->route('user.index')->with([
            'message' => 'An error occurred while deleting the user.',
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
    // Check if the authenticated user is trying to activate themselves or a super admin
    // if (auth()->user()->id === $user->id || $user->role == 1 ) {
    if ( $user->role == 1 ) {
            return $redirector->route('user.index')->with([
            'message' => 'You do not have permission to perform this action.',
            'type' => 'error'
        ]);
    }

    // Proceed with activation logic
    $user->active = true;
    $user->save();

    return $redirector->route('user.index')->with([
        'message' => 'User activation is switched successfully',
        'type' => 'success'
    ]);

}


}
