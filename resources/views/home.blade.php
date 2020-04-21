@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1 class="text-center">Event Manager Application</h1>
                <h3 class="text-center">3K+ events in a year</h3>
                <p class="text-center">Create an event with two clicks or attend events created by other users</p>
                <p class="text-center">
                    <a href="{{ route('event.index') }}" class="btn btn-info">
                        See all of events here
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
