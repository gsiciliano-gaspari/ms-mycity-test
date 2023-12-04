@extends('app')
@section('title', $title)
@section('content')
    @include('users.btn-back')
    @foreach ($userFields as $field => $fieldDetails)
        @if (!in_array($field, ['password', 'password_confirmation']))
            <div class="mb-3 row">
                <div class="{{ $bsClassFormLabels }}">
                    {{ $fieldDetails[1] }}
                </div>
                <div class="col-md-6 fs-4">
                    {{ $user->$field }}
                </div>
            </div>
        @endif
    @endforeach
    <div class="mb-3 row">
        <div class="{{ $bsClassFormLabels }}">
            <strong>
                Ruoli
            </strong>
        </div>
        <div class="col-md-6 fs-4">
            @forelse ($user->getRoleNames() as $role)
                <span class="badge bg-primary">
                    {{ $role }}
                </span>
            @empty
            @endforelse
        </div>
    </div>
@endsection
