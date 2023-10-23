<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Validation\ValidationException;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::paginate(10); // Paginate with 10 tests per page
        return Inertia::render('admin/test/index', ['tests' => $tests]);
    }

    public function create(){
        return inertia::render('admin/test/create');
    }
    public function store(Request $request, Redirector $redirector){
        try {

            $validated= $request->validate([
                'title' => 'required|max:255|unique:tests',
                'active' => 'boolean'
            ]);
            $validated['created_by'] = auth()->user()->id;


            Test::create($validated);
            return $redirector->route('test.index')->with([
                'message' => 'test created successfully',
                'type' => 'success'
            ]);

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while creating the test.' .  $e->getMessage(),
                'type' => 'error'
            ]);  
        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while creating the test.',
                'type' => 'error'
            ]);
        }
    }
    public function edit(){
        
    }



    public function destroy(test $test, Redirector $redirector)
    {

        try {
            if(! $test->active){
                $test->delete();
            } else {
                return $redirector->route('test.index')->with([
                    'message' => 'can not delete the active test',
                    'type' => 'errot'
                ]);
            }
        } catch (\Exception $e) {
            return $redirector->route('test.index')->with([
                'message' => 'An error occurred while deleting the test.',
                'type' => 'error'
            ]);
        }
        return $redirector->route('test.index')->with([
            'message' => 'test deleted successfully',
            'type' => 'success'
        ]);

    }

    public function activate(test $test, Redirector $redirector)
    {
        // Check if the authenticated test is trying to activate themselves or a super admin
        // if (auth()->test()->id === $test->id || $test->role == 1 ) {
        if ( $test->role == 1 ) {
                return $redirector->route('test.index')->with([
                'message' => 'You do not have permission to perform this action.',
                'type' => 'error'
            ]);
        }

        // Proceed with activation logic
        $test->active = true;
        $test->save();

        return $redirector->route('test.index')->with([
            'message' => 'test activation is switched successfully',
            'type' => 'success'
        ]);

    }


}
