<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Validation\ValidationException;

class TestManagementController extends Controller
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
            $validated['created_by'] = 1;

            if ($validated['active'] == 1) {
                Test::where('active', true)->update(['active' => false]);
            }

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
                'message' => 'An error occurred while creating the test.' .  $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function update(Request $request, Test $test, Redirector $redirector)
    {

        try {
            $validated = $request->validate([
                'title' => 'required|max:255'
            ]);


            $test->update($validated);

            return $redirector->route('test.index')->with([
                'message' => 'Test updated successfully',
                'type' => 'success'
            ]);

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while updating the test.' .  $e->getMessage(),
                'type' => 'error'
            ]);

        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while updating the test.' .  $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function destroy(test $test, Redirector $redirector){

    try {

        // check first if the test is active
        if(! $test->active){
            $test->delete();
        } else {
            return $redirector->route('test.index')->with([
                'message' => 'can not delete the active test',
                'type' => 'error'
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

    // Deactivate all other tests
    Test::where('id', '<>', $test->id)->update(['active' => false]);

    // Activate the current test
    $test->active = true;
    $test->save();

    return $redirector->route('test.index')->with([
        'message' => 'Test activation is switched successfully',
        'type' => 'success'
    ]);

}


}
