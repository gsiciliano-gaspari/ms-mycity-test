@extends('app')
@section('title', $title)
@section('content')
    @can('create-user')
        <div class="text-center mb-3">
            <a href="{{ route('users.create') }}" class="{{ $bsClassButtons }}">
                <i class="bi bi-plus-circle"></i>
                Aggiungi un nuovo Utente
            </a>
        </div>
    @endcan
    <div class="row fw-bold border-bottom border-2 mb-3">
        <div class="col-1">
            ID
        </div>
        <div class="col-3">
            Nome e Cognome<br />
            <small>Username</small>
        </div>
        <div class="col-4">
            Email e Telefono
        </div>
        <div class="col-2">
            Ruoli
        </div>
    </div>
    @forelse ($users as $user)
        <div class="row border-bottom border-2">
            <div class="col-1">
                {{ $loop->iteration }}
            </div>
            <div class="col-3">
                {{ $user->name . ' ' . $user->surname }}<br />
                <small>{{ $user->username }}</small>
            </div>
            <div class="col-4">
                {{ $user->email }}<br>
                <small>{{ $user->phone }}</small>
            </div>
            <div class="col-2">
                @forelse ($user->getRoleNames() as $role)
                    <span class="badge bg-primary">
                        {{ $role }}
                    </span>
                @empty
                @endforelse
            </div>
            <div class="col-2">
                <form action="{{ route('users.destroy', $user->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <a href="{{ route('users.show', $user->id) }}" class=""><i class="bi bi-eye"></i></a>
                    @can('edit-user')
                        <a href="{{ route('users.edit', $user->id) }}" class=""><i class="bi bi-pencil-square"></i></a>
                    @endcan
                    @can('delete-user')
                        <button type="submit" class="btn btn-link m-0 p-0" onclick="return confirm('Vuoi cancellare questo Utente?');"><i class="bi bi-trash"></i></button>
                    @endcan
                </form>
            </div>
        </div>
    @empty
        <span class="text-danger">
            Nessun Utente trovato
        </span>
    @endforelse
    {{ $users->links() }}
@endsection
