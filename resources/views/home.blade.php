@extends('app')
@section('title', $title)
@section('content')
    @if ($message = Session::get('success'))
        <div class="alert alert-success col-md-6 offset-md-3">
            {{ $message }}
        </div>
    @endif
    @canany(['create-user', 'edit-user', 'delete-user'])
        <div class="text-center mb-3">
            <a href="{{ route('users.index') }}" class="{{ $bsClassButtons }}">
                <i class="bi bi-people"></i>
                Amministra gli utenti
            </a>
        </div>
    @endcanany
    </div>
    <div class="border-bottom mb-3">
        @foreach ($userFields as $field => $fieldDetails)
            <div class="mb-3 row">
                <div for="{{ $field }}" class="{{ $bsClassFormLabels }}">
                    {{ $fieldDetails[1] }}
                </div>
                <div class="col-md-6 fs-4">
                    {{ Auth::user()->$field }}
                </div>
            </div>
        @endforeach
    </div>
@endsection
