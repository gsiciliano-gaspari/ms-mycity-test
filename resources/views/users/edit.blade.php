@extends('app')
@section('title', $title)
@section('content')
    @include('users.btn-back')
    <form action="{{ route('users.update', $user->id) }}" method="post">
        @csrf
        @method('PUT')
        @foreach ($userFields as $field => $fieldDetails)
            <div class="mb-3 row">
                <label for="{{ $field }}" class="{{ $bsClassFormLabels }}">
                    {{ $fieldDetails[1] }}
                    @if (isset($fieldDetails[2]) && $fieldDetails[2] == 'required')
                        <span class="text-danger">*</span>
                    @endif
                </label>
                <div class="col-md-6">
                    @if (in_array($field, ['password', 'password_confirmation']))
                        <input type="{{ $fieldDetails[0] }}" class="form-control @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}">
                    @else
                        <input type="{{ $fieldDetails[0] }}" class="form-control @error($field) is-invalid @enderror" id="{{ $field }}" name="{{ $field }}" value="{{ $user->$field }}">
                    @endif
                    @if (!in_array($field, ['password_confirmation']))
                        @if ($errors->has($field))
                            <span class="text-danger">{{ $errors->first($field) }}</span>
                        @endif
                    @endif
                </div>
            </div>
        @endforeach
        <div class="mb-3 row">
            <label for="roles" class="{{ $bsClassFormLabels }}">
                Ruoli
            </label>
            <div class="col-md-6">
                <select class="form-select @error('roles') is-invalid @enderror" multiple aria-label="Roles" id="roles" name="roles[]">
                    @forelse ($roles as $role)
                        @if ($role != 'Super Admin')
                            <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
                                {{ $role }}
                            </option>
                        @else
                            @if (Auth::user()->hasRole('Super Admin'))
                                <option value="{{ $role }}" {{ in_array($role, $userRoles ?? []) ? 'selected' : '' }}>
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
                <i class="bi bi-floppy-fill"></i>
                Aggiorna Utente
            </button>
        </div>
    </form>
@endsection
