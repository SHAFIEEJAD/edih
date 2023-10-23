<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Routing\Redirector;
use Exception;
use Illuminate\Validation\ValidationException;

class EmailController extends Controller
{
    public function index()
    {
        $tests = Test::all(); 
        $emails = Email::paginate(10);
        return Inertia::render('admin/email/index', ['emails' => $emails, 'tests' => $tests]);
    }
    

    public function create()
    {
        $tests = Test::all(); 
        return inertia::render('admin/email/create', [
            'tests' => $tests, 
        ]);
    }

    public function store(Request $request, Redirector $redirector){
        try {

            $validated = $request->validate([
                'title' => 'required|max:255',
                'subject' => 'required',
                'body' => 'required',
                'test_id' => 'nullable|exists:tests,id',
                'sender_address' => 'required|array',
                'cc_addresses_list' => 'required|array',
                'cc_addresses_list.*' => 'required|array|size:2',
                'cc_addresses_list.*.name' => 'required|string',
                'cc_addresses_list.*.email' => 'required|email',
                'is_correct' => 'required|boolean',
                'active' => 'boolean',
            ]);

            
            $validated['created_by'] = auth()->user()->id;
            $validated['active'] = true;


            email::create($validated);

            return $redirector->route('email.index')->with([
                'message' => 'email created successfully',
                'type' => 'success'
            ]);

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while creating the email.' .  $e->getMessage(),
                'type' => 'error'
            ]);  
        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while creating the email.' .  $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }
    public function edit(email $email){

        $tests = Test::all();
        // $email_data = Email::get()->first(); 
        return inertia::render('admin/email/edit', [
            'email' => $email,
            'tests' => $tests, 
        ]);        
    }

    public function update(Request $request, Email $email, Redirector $redirector)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|max:255',
                'subject' => 'required',
                'body' => 'required',
                'test_id' => 'nullable|exists:tests,id',
                'sender_address' => 'required|array',
                'cc_addresses_list' => 'required|array',
                'cc_addresses_list.*' => 'required|array|size:2',
                'cc_addresses_list.*.name' => 'required|string',
                'cc_addresses_list.*.email' => 'required|email',
                'is_correct' => 'required|boolean',
                'active' => 'boolean',
            ]);

            $validated['active'] = true; // Assuming you want to set active to true on update

            $email->update($validated);

            return $redirector->route('email.index')->with([
                'message' => 'Email updated successfully',
                'type' => 'success'
            ]);

        } catch (ValidationException $e) {
            return back()->with([
                'message' => 'An error occurred while updating the email.' .  $e->getMessage(),
                'type' => 'error'
            ]);  
        } catch (Exception $e) {
            return back()->with([
                'message' => 'An error occurred while updating the email.' .  $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }

    public function destroy(email $email, Redirector $redirector)

    {

    try {
        $email->delete();
    } catch (\Exception $e) {
        return $redirector->route('email.index')->with([
            'message' => 'An error occurred while deleting the email.',
            'type' => 'error'
        ]);
    }
    return $redirector->route('email.index')->with([
        'message' => 'email deleted successfully',
        'type' => 'success'
    ]);

    }

    public function changeTest(Email $email, Test $test, Redirector $redirector)
    {
        try {
            // Check if the provided email and test exist
            if (!$email || !$test) {
                throw new \Exception('Email or Test not found.');
            }
    
            // Activate the current email
            $email->test_id = $test->id;
            $email->save();
    
            return $redirector->route('email.index')->with([
                'message' => 'Test has been switched successfully.',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            return $redirector->route('email.index')->with([
                'message' => 'An error occurred while switching test: ' . $e->getMessage(),
                'type' => 'error'
            ]);
        }
    }
    




}
