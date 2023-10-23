<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Department;
use App\Models\Email;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class DashboardController extends Controller
{
    public function index()
    {
        
        // Tests Data
        $testsCount = Test::count();
        $activeTest = Test::where('active', true)->first();
        $activeTestTitle = $activeTest ? $activeTest->title : null;
        
        // Emails Data
        $emailsCount = Email::count();
        $activeEmailsCount = $activeTest ? $activeTest->emails()->where('active', 1)->count() : 0;

        // Departments Data
        $departmentsCount = Department::count();

        // Answers Data
        $answersCount = Answer::count();
        $answersDepartmentsCount = Answer::distinct('dep_id')->count('dep_id');

        // Admins Data
        $admins_count = User::where('role', 2)->count();
        $content_managers_count = User::where('role', 3)->count();

    
       return Inertia::render('admin/dashboard', [
        'tests_count' => $testsCount,
        'active_test_title' => $activeTestTitle,

        'emails_count' => $emailsCount,
        'active_emails_count' => $activeEmailsCount,

        'departments_count' => $departmentsCount,

        'answers_count' => $answersCount,
        'answers_depmartments_count' => $answersDepartmentsCount,

        'admins_count' => $admins_count,
        'content_managers_count' => $content_managers_count
        ]);
    }


}
