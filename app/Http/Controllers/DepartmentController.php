<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Validation\ValidationException;


class DepartmentController extends Controller
{
    public function index()
    {
        
        $departments = Department::paginate(10); // Paginate with 10 departments per page
        return Inertia::render('admin/department/index', ['departments' => $departments]);
    }

    public function create(){
        return inertia::render('admin/department/create');
    }
    public function store(Request $request, Redirector $redirector){
        try {

            $validated= $request->validate([
                'name' => 'required|max:255|unique:departments',
            ]);
            $validated['created_by'] = auth()->user()->id;


            Department::create($validated);
            return $redirector->route('department.index')->with([
                'message' => 'department created successfully',
                'type' => 'success'
            ]);

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while Creating the department.' .  $e->getMessage(),
                'type' => 'error'
            ]);  
        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while creating the department.' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }
    public function update(Request $request, Department $department, Redirector $redirector)
    {
        // dd($request['title']);
        try {
            $validated = $request->validate([
                'name' => 'required|max:255'
            ]);


            $department->update($validated);

            return $redirector->route('department.index')->with([
                'message' => 'Test updated successfully',
                'type' => 'success'
            ]);

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while updating the department.' .  $e->getMessage(),
                'type' => 'error'
            ]);

        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while updating the department.' .  $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }



    public function destroy(department $department, Redirector $redirector)
    {

        try {
            $department->delete();
        } catch (\Exception $e) {
            return $redirector->route('department.index')->with([
                'message' => 'An error occurred while deleting the department.',
                'type' => 'error'
            ]);
        }
        return $redirector->route('department.index')->with([
            'message' => 'department deleted successfully',
            'type' => 'success'
        ]);

    }


}
