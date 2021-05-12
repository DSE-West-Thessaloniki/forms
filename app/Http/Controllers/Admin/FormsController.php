<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\User;
use App\Models\FormField;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class FormsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$forms = Form::all();
        $forms = Form::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.forms.index')->with('forms', $forms);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.forms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        // Create form
        $form =  new Form;
        $form->title = $request->input('title');
        $form->notes = $request->input('notes');
        $form->user_id = Auth::id();
        $form->save();

        $formfield = $request->input('field');
        foreach(array_keys($formfield) as $key) {
            $field = new FormField;
            $field->sort_id = $key;
            $field->title = $formfield[$key]['title'];
            $field->type = $formfield[$key]['type'];
            $field->listvalues = $formfield[$key]['values'] ?? '';
            $form->formfields()->save($field);
        }

        return redirect(route('admin.forms.index'))->with('success', 'Η φόρμα δημιουργήθηκε');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = Form::find($id);
        if ($form)
            return view('admin.forms.show')->with('form', $form);
        else
            return view('home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $form = Form::find($id);
        if ($form)
            return view('admin.forms.edit')->with('form', $form);
        else
            return view('home');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        // Update form
        $form = Form::find($id);
        $form->title = $request->input('title');
        $form->notes = $request->input('notes');
        $form->user_id = Auth::id();
        $form->save();

        // Check if we should delete fields
        $formfield = $request->input('field');
        $oldfields = $form->formfields;
        foreach($oldfields as $oldfield) {
            if (!array_key_exists($oldfield->id, $formfield)) {
                $oldfield->delete();
                #$field = $form->formfields()
                #            ->where('sort_id', $oldfield->sort_id)
                #            ->delete();
            }
        }

        // Update or add fields
        foreach(array_keys($formfield) as $key) {
            $field = $form->formfields()->firstOrNew(['id' => $key]);
            $field->sort_id = $key;
            $field->title = $formfield[$key]['title'];
            $field->type = $formfield[$key]['type'];
            $field->listvalues = $formfield[$key]['values'] ?? '';
            $form->formfields()->save($field);
        }

        return redirect(route('admin.forms.index'))->with('success', 'Η φόρμα ενημερώθηκε');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $form = Form::find($id);
        $form->formfields()->delete();
        $form->delete();

        return redirect(route('admin.forms.index'))->with('success', 'Η φόρμα διαγράφηκε');
    }
}