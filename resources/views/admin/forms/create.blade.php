@extends('layouts.app')

@section('content')
    <h1 class="text-center">Δημιουργίας φόρμας</h1>
    <form action="{{ route('admin.forms.store') }}" method="post">
        <vform-component></vform-component>

        <br/>
        <div class="col-md-10 d-flex justify-content-end">
            <button class="btn btn-primary" type="submit">Αποθήκευση</button>
        </div>
    </form>

@endsection