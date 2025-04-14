@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Mes Notifications</h1>

    @foreach($notifications as $notification)
        <div class="alert alert-info">
            <p>{{ $notification->message }}</p>
            <small>{{ $notification->created_at->diffForHumans() }}</small>

            {{-- Si la notification n'est pas lue, tu peux la marquer comme lue --}}
            @if(is_null($notification->dateLecture))
                <form action="{{ route('notifications.marquerCommeLue', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">Marquer comme lue</button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection
