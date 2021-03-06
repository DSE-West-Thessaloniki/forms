@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <div class="card-header">Φόρμες</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="btn-toolbar pb-2" role="toolbar">
                        <div class="btn-group mr-2">
                            <a class="btn btn-primary" href="{{ route('admin.form.create') }}">
                                @icon('fas fa-plus') Δημιουργία φόρμας
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Τίτλος</th>
                                    <th>Σημειώσεις</th>
                                    <th>Ημ. δημιουργίας</th>
                                    <th>Ημ. ενημέρωσης</th>
                                    <th>Χρήστης</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($forms as $form)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('admin.form.show', $form->id) }}">{{ $form->title }}</a></td>
                                        <td>{{ $form->notes }}</td>
                                        <td>{{ $form->created_at }}</td>
                                        <td>{{ $form->updated_at }}</td>
                                        <td>{{ $form->user->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.form.edit', $form->id) }}" class="btn btn-primary m-1">@icon('fas fa-edit') Επεξεργασία</a>
                                            <a href="{{ route('admin.form.data', $form) }}" class="btn btn-success m-1">@icon('fas fa-table') Δεδομένα</a>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.form.destroy', $form->id)}}" method="post" class="float-right">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger" type="submit">@icon('fas fa-trash-alt') Διαγραφή</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">Δεν βρέθηκαν φόρμες</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $forms->links() }} <!-- Σελιδοποίηση -->
            </div>
        </div>
    </div>
</div>
@endsection
