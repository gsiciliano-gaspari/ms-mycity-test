@extends('app')
@section('title', $title)
@section('content')
    @include('users.btn-back')
    <form action="{{ route('users.store') }}" method="post">
        @csrf
        @foreach ($userFields as $field => $fieldDetails)
            <div class="mb-3 row">
                <label for="{{ $field }}" class="{{ $bsClassFormLabels }}">
                    {{ $fieldDetails[1] }}
                    @if (isset($fieldDetails[2]) && $fieldDetails[2] == 'required')
                        <span class="text-danger">*</span>
                    @endif
                </label>
                <div class="col-md-6">
                    <input type="{{ $fieldDetails[0] }}" class="form-control @error('{{ $field }}') is-invalid @enderror" id="{{ $field }}" name="{{ $field }}"
                        value="{{ old($field) }}">
                    @if ($errors->has($field))
                        <span class="text-danger">{{ $errors->first($field) }}</span>
                    @endif
                </div>
            </div>
        @endforeach
        <div class="mb-3 row">
            <label for="roles" class="col-md-4 col-form-label text-md-end text-start">Roles</label>
            <div class="col-md-6">
                <select class="form-select @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                    @forelse ($roles as $role)
                        @if ($role != 'Super Admin')
                            <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @else
                            @if (Auth::user()->hasRole('Super Admin'))
                                <option value="{{ $role }}" {{ in_array($role, old('roles') ?? []) ? 'selected' : '' }}>
                                    {{ $role }}
                                </option>
                            @endif
                        @endif
                    @empty
                    @endforelse
                </select>
                @if ($errors->has('roles'))
                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                @endif
            </div>
        </div>
        <div class="text-center">
            <button type="submit" name="submit" class="{{ $bsClassButtons }}">
                <i class="bi bi-plus-circle"></i>
                Aggiunti Utente
            </button>
        </div>
    </form>
@endsection
