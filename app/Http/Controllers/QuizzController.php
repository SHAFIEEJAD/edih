<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Department;
use App\Models\Email;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Validation\ValidationException;


class QuizzController extends Controller
{
    public function index()
    {
        
        // Get the active test
        $activeTest = Test::where('active', true)->first();
        $departments = Department::all();
        // Get the emails related to the active test
        if ($activeTest) {     
        $emails = $activeTest->emails()->where('active', 1)->get();
        } else {
           $emails = collect(); // If no active test found, return an empty collection
       }

       return Inertia::render('index', [
        'test' => $activeTest,
        'emails' => $emails,
        'departments' => $departments
        ]);
    }

    public function store(Request $request, Redirector $redirector){
        try {
            
            $validated = $request->validate([
                'test_id' => 'required|exists:tests,id', // Validate if the test exists
                'department_id' => 'required|exists:departments,id', // Validate if the department exists
                'answers' => 'required|array|min:1', // At least one answer is required
                'answers.*.id' => 'required|exists:emails,id', // Validate if the email answer exists
                'answers.*.answer' => 'required|boolean|max:255', // Define the answer format
            ]);

            foreach ($validated['answers'] as $answerData) {
                Answer::create([
                    'dep_id' => 1,
                    'email_id' => $answerData['id'],
                    'answer' => $answerData['answer'],
                ]);
            }

            return $redirector->route('quiz');

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while Creating the user.' .  $e->getMessage(),
                'type' => 'error'
            ]);  
        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while creating the user.' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }


}
