<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index(){
        return inertia::render('admin/user/index');
    }
    public function create(){
        return inertia::render('admin/user/create');
    }
    public function store(Request $request){
        $validated= $request->validate([
            'username' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'passoword' => 'required'
        ]);
        User::create($validated);
        return Redirect::route('user.index');
    }
}
