<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\School;

class PagesController extends Controller
{
    /**
     * Home page
     *
     * @return view
     */
    public function index()
    {
        return view('pages.index');
    }

    public function login() {
        return view('pages.login');
    }

    public function checkLogin(Request $request) {
        $school_code = $request->input('school_code');

        //$school_id = $request->input('school_id');
        // Αν στάλθηκε αναγνωριστικό
        if ($school_code) {
            $school = School::where('username', $school_code)->first();
            if (!$school) { // Αν δεν βρέθηκε το id δες μήπως συνδέθηκαν με τα στοιχεία του MySchool
                $school = School::where('code', $school_code)->first();
            }
            if ($school) {
                Auth::guard('school')->login($school);
                $request->session()->put('school_id', $school->id);
                $request->session()->put('school_name', $school->name);
                return redirect(route('report.index'));
            }
        }

        // Αλλιώς πήγαινε πάλι στο login
        return redirect(route('login'))->with('error', 'Δεν βρέθηκε ο χρήστης');
    }

    public function logout() {
        Auth::guard('school')->logout();
        session()->forget('school_id');
        session()->forget('school_name');
        return redirect(route('index'));
    }
}
