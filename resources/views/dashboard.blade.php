@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>You are logged in!<br>You can either create an event or see the list of events</p>
                    <a href="{{ route('event.index') }}" class="btn btn-primary">List Events</a>
                    <a href="{{ route('event.create') }}" class="btn btn-success">+ Create Event</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
