@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h2>{{ $event->event_title }}</h2>
                            </div>
                            <div class="col-6 text-right">
                                @if($current_user['role'] == 'admin' || $current_user['id'] == $event->user_id)
                                    <form class="d-inline-block" action="{{ route('event.destroy', ['event' => $event->event_id]) }}" method="post">
                                        <input class="btn btn-danger font-weight-bold" type="submit" value="Remove this event" />
                                        @method('delete')
                                        @csrf
                                    </form>
                                    <a href="{{ route('event.edit', ['event' => $event->event_id]) }}" class="btn btn-warning font-weight-bold">Edit this event</a>
                                @else
                                    @if($event->event_end_date > \Carbon\Carbon::now())
                                        <a class="btn btn-success text-white font-weight-bold">Join this event</a>
                                    @else
                                        <a class="btn btn-secondary font-weight-bold disabled">Event Ended</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="text-left border-bottom">
                            <span class="text-secondary border-bottom">{{ $event->event_start_date }}</span> To <span class="text-secondary border-bottom">{{ $event->event_end_date }}</span>
                            <span class="d-block">By : {{ $event->user->name }} {{ $event->user->last_name }}</span>
                        </div>
                        <div class="text-left pb-5 pt-2">
                            {{ $event->event_description }}
                        </div>
                    </div>
                    <div class="card-footer">
                        Views: {{ $event_views }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
