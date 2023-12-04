@extends('app')
@section('title', $title)
@section('content')
    <form action="{{ route('authenticate') }}" method="post">
        @csrf
        @foreach ($loginFields as $field => $fieldDetails)
            <div class="mb-3 row">
                <label for="{{ $field }}" class="{{ $bsClassFormLabels }}">
                    {{ $fieldDetails[1] }}
                    @if (isset($fieldDetails[2]) && $fieldDetails[2] == 'required')
                        <span class="text-danger">*</span>
                    @endif
                </label>
                <div class="col-md-6">
                    <input type="{{ $fieldDetails[0] }}" class="form-control @error('email') is-invalid @enderror" id="{{ $field }}" name="{{ $field }}" value="{{ old($field) }}">
                    @if ($errors->has($field))
                        <span class="text-danger">
                            {{ $errors->first($field) }}
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="text-center">
            <button type="submit" name="submit" class="{{  $bsClassButtons }}">
                <i class="bi bi-box-arrow-in-right"></i>
                Login
            </button>
        </div>
    </form>
@endsection
